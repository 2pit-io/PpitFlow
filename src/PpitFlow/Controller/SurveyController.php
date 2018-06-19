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

class SurveyController extends AbstractActionController
{
	public function fillAction()
	{
		// Retrieve the context and the parameters
		$context = Context::getCurrent();
		$description = Event::getDescription('survey');
		$id = $this->params()->fromRoute('id');
		$token = $this->params()->fromQuery('hash', null);
		$survey = $this->params()->fromQuery('survey');
		$locale = $this->params()->fromQuery('locale');
		$availableSkills = $context->getConfig('matching/skills');

		// Retrieve the account and the survey in progress and anthenticate
		$event = Event::get($id);
		$place = Place::get($event->place_id);
		if (!$locale) $locale = $event->locale;
		if (!$locale) $locale = $context->getLocale();
		if ($token != $event->authentication_token) return $this->redirect()->toRoute('landing/template2', ['place_identifier' => $place->identifier]);

		// Retrieve the content
		if ($context->getConfig('specificationMode') == 'config') $content = $context->getConfig($survey.'/'.$place->identifier);
		else $content = Config::get($place->identifier.'_'.$survey, 'identifier')->content;
		$steps = explode(',', $event->description);
		$step = reset($steps); // Get the first step in the list
		if (!$step) $step = 'steps'; // As a default, show the form 'steps' that allows the user to choose the steps he wants to follow
		$content['form'] = $content['forms'][$step];
		
		$viewData = array();
		foreach ($content['form']['inputs'] as $inputId => $options) {
			if (array_key_exists('definition', $options) && $options['definition'] == 'inline') $property = $options;
			else {
				$property = $description['properties'][$inputId];
				if ($property['definition'] != 'inline') $property = $context->getConfig($property['definition']);
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
			$data['status'] = 'completed';
			$data['place_id'] = $place->id;
			$data['account_id'] = $event->account_id;
			$data['category'] = $survey;
			$data['subcategory'] = $step;
			array_shift($steps); // Get the first step in the list
			$data['description'] = implode(',', $steps);
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
							if (array_key_exists($propertyId, $data) && $data[$propertyId]) {
								if ($viewData[$inputId.'-'.$entryId]) $data[$propertyId] .= ','.$entryId;
							}
							else $data[$propertyId] = $entryId;
						}
					}
					else $data[$propertyId] = $viewData[$propertyId];
				}
			}

			$event = Event::instanciate('survey');
			if (!$token) $token = md5(uniqid(rand(), true));
			$event->authentication_token = $token;
			$rc = $event->loadAndAdd($data, $description['properties']); // Duplicate the event for storing the current step's data 
			$id = $event->id;
			if ($event->description) return $this->redirect()->toRoute($this->getEvent()->getRouteMatch()->getMatchedRouteName(), ['id' => $id], array('query' => array('hash' => $token, 'survey' => $survey)));
			if (in_array($rc[0], ['200'])) $message = 'OK';
			else $error = $rc[1];
		}

		// Return the view
		$view = new ViewModel(array(
			'context' => $context,
			'locale' => $locale,
			'place_identifier' => $place->identifier,
			'id' => $id,
			'token' => $token,
			'survey' => $survey,
			'locale' => $locale,
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

	public function template1Action()
	{
		return $this->fillAction();
	}
}
