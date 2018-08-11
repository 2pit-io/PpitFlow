<?php
namespace PpitFlow\Controller;

use PpitContact\Model\ContactMessage;
use PpitCore\Form\CsrfForm;
use PpitCore\Model\Account;
use PpitCore\Model\Config;
use PpitCore\Model\Context;
use PpitCore\Model\Csrf;
use PpitCore\Model\Event;
use PpitCore\Model\GroupAccount;
use PpitCore\Model\Place;
use PpitCore\Model\Vcard;
use Zend\Http\Headers;
use Zend\Http\Request;
use Zend\Http\Response\Stream;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RequestController extends AbstractActionController
{
	public function fillAction()
	{
		// Retrieve the context and the parameters
		$context = Context::getCurrent();
		$id = $this->params()->fromRoute('id');
		$availableSkills = $context->getConfig('matching/skills');
		$survey = 'test_request';
		$locale = $this->params()->fromQuery('locale');
		
		// Retrieve the account
		$account = Account::get($context->getContactId(), 'contact_1_id');
		$place = Place::get($account->place_id);
		$profile = Vcard::get($account->contact_1_id);
		if (!$locale) $locale = $profile->locale;
		
		if ($id) $event = Event::get($id);
		else $event = Event::instanciate('request');
		$description = Event::getDescription($event->type);
		
		// Retrieve the content
		if ($context->getConfig('specificationMode') == 'config') $content = $context->getConfig($survey.'/'.$place->identifier);
		else $content = Config::get($place->identifier.'_'.$survey, 'identifier')->content;
		$content['form'] = $content['forms']['requestor'];
		if (!array_key_exists('options', $content['form'])) $content['form']['options'] = array();
		if (!array_key_exists('examples', $content['form']['options'])) $content['form']['options']['examples'] = false;
		
		$viewData = array();
		$viewData['account_id'] = $account->id;
		$viewData['photo_link_id'] = ($profile->photo_link_id) ? $profile->photo_link_id : 'no-photo.png';
		
		// Form
		foreach ($content['form']['inputs'] as $inputId => $options) {
			if (array_key_exists('definition', $options) && $options['definition'] == 'inline') $property = $options;
			else {
				$property = $description['properties'][$inputId];
				if ($property['definition'] != 'inline') $property = $context->getConfig($property['definition']);
				if (array_key_exists('mandatory', $options)) $property['mandatory'] = $options['mandatory'];
				if (array_key_exists('updatable', $options)) $property['updatable'] = $options['updatable'];
				if (array_key_exists('rows', $options)) $property['rows'] = $options['rows'];
				if (array_key_exists('class', $options)) $property['class'] = $options['class'];
				if (array_key_exists('labels', $options)) $property['labels'] = $options['labels'];
			}
			if (array_key_exists('repository', $property)) $property['repository'] = $context->getConfig($property['repository']);
			if (!array_key_exists('mandatory', $property)) $property['mandatory'] = false;
			if (!array_key_exists('updatable', $property)) $property['updatable'] = true;
			if (!array_key_exists('placeholder', $property)) $property['placeholder'] = null;
			$content['form']['inputs'][$inputId] = $property;
			if (array_key_exists('property_id', $property)) $propertyId = $property['property_id'];
			else $propertyId = $inputId;
			if ($id) {
				if ($inputId != $propertyId) $viewData[$inputId] = (in_array($property['value'], explode(',', $event->properties[$propertyId])) ? $property['value'] : null);
				elseif (array_key_exists($propertyId, $event->properties)) $viewData[$inputId] = $event->properties[$propertyId];
				$queryValue = $this->params()->fromQuery($inputId);
				if ($queryValue !== null) $viewData[$inputId] = $queryValue;
			}
			else $viewData[$inputId] = (array_key_exists('default', $property)) ? $property['default'] : null;
		}
		
		// Process the post data after input
		$message = $error = null;
		if ($this->request->isPost()) {
			$data = array();
			$data['place_id'] = $place->id;
			$data['account_id'] = $account->id;
			
			foreach ($content['form']['inputs'] as $inputId => $property) {
				if (array_key_exists('property_id', $property)) $propertyId = $property['property_id'];
				else $propertyId = $inputId;
				if (!$id || $property['updatable']) {
					$viewData[$propertyId] = $this->request->getPost($propertyId);
					$viewData[$inputId] = $this->request->getPost($inputId);

					if ($property['type'] == 'checkbox') {
						if (array_key_exists($propertyId, $data) && $data[$propertyId]) {
							if ($viewData[$inputId]) $data[$propertyId] .= ','.$viewData[$inputId];
						}
						else $data[$propertyId] = $viewData[$inputId];
					}
					elseif ($property['type'] == 'chips') {
						$data[$propertyId] = '';
						foreach ($property['repository'] as $entryId => $unused) {
							$viewData[$inputId.'-'.$entryId] = $this->request->getPost($inputId.'-'.$entryId);
							if ($viewData[$inputId.'-'.$entryId]) {
								if (array_key_exists($propertyId, $data) && $data[$propertyId]) $data[$propertyId] .= ','.$entryId;
								else $data[$propertyId] = $entryId;
							}
						}
						$viewData[$propertyId] = $data[$propertyId]; // Updating the data to display in the confirmation form
					}
					elseif ($property['type'] == 'date') { // Workaround due to a bug in MDBootstrap that ignores formatSubmit
						$data[$propertyId] = substr($viewData[$propertyId], 6, 4).'-'.substr($viewData[$propertyId], 3, 2).'-'.substr($viewData[$propertyId], 0, 2);
					}
					else $data[$propertyId] = $viewData[$propertyId];

					if (array_key_exists('account_property', $property)) $accountData[$property['account_property']] = $data[$propertyId];
				}
			}

			if ($id) $rc = $event->loadAndUpdate($data, $description['properties']);
			else $rc = $event->loadAndAdd($data, $description['properties']);
			if (in_array($rc[0], ['200'])) $message = 'OK';
			else $error = $rc[1];
		}

		// Return the view
		$view = new ViewModel(array(
			'context' => $context,
			'id' => $id,
			'locale' => $locale,
			'type' => $context->getConfig('landing_account_type'),
			'place_identifier' => $place->identifier,
			'event' => $event,
			'template' => [],
			'content' => $content,
			'viewData' => $viewData,
			'message' => $message,
			'error' => $error,
			'availableSkills' => $availableSkills,
		));
		$view->setTerminal(true);
		return $view;
	}
}
