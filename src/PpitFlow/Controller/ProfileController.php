<?php
namespace PpitFlow\Controller;

use PpitCore\Form\CsrfForm;
use PpitCore\Model\Account;
use PpitCore\Model\Config;
use PpitCore\Model\Context;
use PpitCore\Model\Csrf;
use PpitCore\Model\Event;
use PpitCore\Model\Place;
use PpitCore\Model\Vcard;
use Zend\Http\Headers;
use Zend\Http\Request;
use Zend\Http\Response\Stream;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProfileController extends AbstractActionController
{	
	public function template1Action()
	{
		// Retrieve the context and the parameters
		$context = Context::getCurrent();
		$description = Account::getDescription('pbc');

		$instance_caption = $context->getInstance()->caption;
		$place_identifier = $this->params()->fromRoute('place_identifier');
		if ($place_identifier) $place = Place::get($place_identifier, 'identifier');
		else {
			$place = Place::get($context->getPlaceId());
			$place_identifier = $place->identifier;
		}
		$links = $context->getConfig('public/'.$instance_caption.'/links');
		$locale = $this->params()->fromQuery('locale');

		if ($context->getConfig('specificationMode') == 'config') $content = $context->getConfig('profile/'.$place_identifier);
		else $content = Config::get($place_identifier.'_profile', 'identifier')->content;

		if ($context->isAuthenticated()) $account = Account::get($context->getContactId(), 'contact_1_id');
		else {
			$account_id = $this->params()->fromRoute('account_id');
			if (!$account_id) {
				$account = Account::instanciate('generic');
				$account_identifier = 'test';
				if (!$locale) $locale = $context->getLocale();
			}
			else {
				$account = Account::get($account_id);
				$account_identifier = $account->identifier;
				if (!$locale) $locale = $account->locale;
				foreach($content['form']['features'] as $featureId => &$feature) {
					$event = Event::get('profile', $type, $feature['category'], 'category', $account->id, 'account_id');
					if ($event) $feature['value'] = $event->properties[$feature['property']];
				}
			}
		}

		$token = null;
		$id = $this->params()->fromRoute('id');
		$token = $this->params()->fromQuery('hash', null);
    	if ($token && $token != $account->authentication_token) return $this->redirect()->toRoute('landing/template2');

		$viewData = array();
		$viewData['account_id'] = $account->id;
		$viewData['photo_link_id'] = ($account->photo_link_id) ? $account->photo_link_id : 'no-photo.png';
		
		foreach ($content['form']['inputs'] as $inputId => $options) {
			if (array_key_exists('definition', $options) && $options['definition'] == 'inline') $property = $options;
			else {
				$property = $description['properties'][$inputId];
				if (array_key_exists('mandatory', $options)) $property['mandatory'] = $options['mandatory'];
				if (array_key_exists('updatable', $options)) $property['updatable'] = $options['updatable'];
			}
			if (array_key_exists('repository', $property)) $property['repository'] = $context->getConfig($property['repository']);
			if (!array_key_exists('mandatory', $property)) $property['mandatory'] = false;
			if (!array_key_exists('updatable', $property)) $property['updatable'] = true;
			if (!array_key_exists('placeholder', $property)) $property['placeholder'] = null;
			$content['form']['inputs'][$inputId] = $property;
			if (array_key_exists('property_id', $property)) $propertyId = $property['property_id'];
			else $propertyId = $inputId;
//			if ($id) {
				if ($inputId != $propertyId) $viewData[$inputId] = (in_array($property['value'], explode(',', $account->properties[$propertyId])) ? $property['value'] : null);
				else $viewData[$inputId] = $account->properties[$propertyId];
				$queryValue = $this->params()->fromQuery($inputId);
				if ($queryValue !== null) $viewData[$inputId] = $queryValue;
/*			}
			else $viewData[$inputId] = (array_key_exists('default', $property)) ? $property['default'] : null;*/
		}

		// Process the post data after input
		$message = $error = null;
		if ($this->request->isPost()) {
			$data = array();
			$data['status'] = 'interested';
			$data['place_id'] = $place->id;
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
					}
					elseif ($property['type'] == 'date') { // Workaround due to a bug in MDBootstrap that ignores formatSubmit
						$data[$propertyId] = substr($viewData[$propertyId], 6, 4).'-'.substr($viewData[$propertyId], 3, 2).'-'.substr($viewData[$propertyId], 0, 2);
					}
					else $data[$propertyId] = $viewData[$propertyId];

					if (array_key_exists('account_property', $property)) $accountData[$property['account_property']] = $data[$propertyId];
				}
			}
			$rc = $account->loadAndUpdate($data);

			if (in_array($rc[0], ['200'])) $message = 'OK';
			else $error = $rc;
		}

		// Return the view
		$view = new ViewModel(array(
			'context' => $context,
			'locale' => $locale,
			'id' => $id,
			'token' => $token,
			'template' => [],
			'links' => $links,
			'content' => $content,
			'viewData' => $viewData,
			'message' => $message,
			'error' => $error,
		));
		$view->setTerminal(true);
		return $view;
	}

	public function template2Action()
	{
		return $this->template1Action();
	}
	
	public function dashboardAction()
	{
		// Retrieve the context and the parameters
		$context = Context::getCurrent();
		$account = Account::get($context->getContactId(), 'contact_1_id');
		$requests = Event::getList('course_test', ['category' => 'test_request', 'subcategory' => 'requestor', 'account_id' => $account->id]);
		$content = array();
		$content['description'] = Event::getDescription('course_test');
		$content['description']['list'] = ['property_5' => [], 'caption' => [], 'property_3' => []];
		$content['data'] = array();
		foreach ($requests as $request) $content['data'][$request->id] = $request->getProperties();
		
		// Return the view
		$view = new ViewModel(array(
			'context' => $context,
			'content' => $content,
		));
		$view->setTerminal(true);
		return $view;
	}
	
	public function photoUploadAction()
	{
		$context = Context::getCurrent();
		$id = $this->params()->fromRoute('id');
		$account = Account::get($id);
		if ($account) {
			$photoPath = $this->request->getFiles()->toArray()['photo_path'];
			$account->contact_1->savePhoto($photoPath);
			$account->contact_1->photo_link_id = $account->contact_1_id.'.jpg';
			$account->contact_1->update(null);
			echo $account->contact_1->photo_link_id;
		}
		return $this->response;
	}
}
