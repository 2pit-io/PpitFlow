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
/*	public function homeAction()
	{
		$context = Context::getCurrent();
		$instance_caption = $context->getInstance()->caption;
		$place_identifier = $this->params()->fromRoute('place_identifier');
		if ($place_identifier) $place = Place::get($place_identifier, 'identifier');
		else {
			$place = Place::get($context->getPlaceId());
			$place_identifier = $place->identifier;
		}

		if ($context->getConfig('specificationMode') == 'config') $content = $context->getConfig('profile/'.$place_identifier);
		else $content = Config::get($place_identifier.'_profile', 'identifier')->content;
		$locale = $this->params()->fromQuery('locale');
		
		$account_id = $this->params()->fromRoute('account_id');
		$account = null;
		if ($account_id) {
			$account = Account::get($account_id);
			$charter_status = $account->getCharterStatus();
			$gtou_status = $account->getGtouStatus();
		}
		elseif ($context->isAuthenticated()) {
			$account = Account::get($context->getContactId(), 'contact_1_id');
			$charter_status = $account->getCharterStatus();
			$gtou_status = $account->getGtouStatus();
		}
		else {
			$account = Account::instanciate($context->getConfig('landing_account_type'));
			$charter_status = null;
			$gtou_status = null;
		}

		if (!$locale) if ($account) $locale = $account->locale; else $locale = $context->getLocale();

		$description = Event::getDescription('request');
		$viewData = array();
		$viewData['photo_link_id'] = ($account->photo_link_id) ? $account->photo_link_id : 'no-photo.png';
		
		$requests = Event::getList('request', []);
		$viewData['requests'] = array();
		foreach ($requests as $requestId => $request) $viewData['requests'][$requestId] = $request->getProperties();

		// Feed the layout
		$this->layout('/layout/flow-layout');
		$this->layout()->setVariables(array(
			'context' => $context,
			'place_identifier' => $place_identifier,
			'type' => $context->getConfig('landing_account_type'),
			'header' => $content['header'],
			'intro' => $content['intro'],
			'locale' => $locale,
			'photo_link_id' => ($account) ? $account->photo_link_id : null,
			'charter_status' => $charter_status,
			'gtou_status' => $gtou_status,
			'pageScripts' => 'ppit-flow/request/home-scripts',
			'tooltips' => $content['tooltips'],
			'message' => null,
			'error' => null,
		));
		
		$view = new ViewModel(array(
			'context' => $context,
			'locale' => $locale,
			'description' => $description,
			'viewData' => $viewData,
			'requests' => $requests,
			'content' => $content,
		));
		return $view;
	}*/

	public function dashboardAction()
	{
		// Retrieve the context and the parameters
		$context = Context::getCurrent();
		$requests = Event::getList('request', 'new,connected,realized,completed');
		$locale = $this->params()->fromQuery('locale');
		
		$content = array();
		$content['description'] = Event::getDescription('request');
		$content['description']['properties']['n_first']['labels'] = ['default' => 'Requestor', 'fr_FR' => 'Demandeur'];
		$content['description']['list'] = ['n_first' => [], 'property_5' => [], 'caption' => [], 'property_3' => []];
		$content['data'] = array();
		foreach ($requests as $request) $content['data'][$request->id] = $request->getProperties();

		// Return the view
		$view = new ViewModel(array(
			'context' => $context,
			'content' => $content,
			'locale' => $locale,
		));
		$view->setTerminal(true);
		return $view;
	}

	public function homeAction()
	{
		// Retrieve the context and the parameters
		$context = Context::getCurrent();
		$place = Place::get($context->getPlaceId());
		$place_identifier = $place->identifier;
		$myAccount = Account::get($context->getContactId(), 'contact_1_id');

		$skills = $this->params()->fromQuery('skills');
		if (!$skills) $requests = Event::getList('request', []);
		else {
			$requests = array();
			foreach (explode(',', $skills) as $skill) {
				$result = Event::getList('request', ['property_2' => $skill]);
				foreach ($result as $request_id => $request) {
					$requests[$request_id] = $request;
				}
			}
		}
		
		$locale = $this->params()->fromQuery('locale');

		// Retrieve the content
		$description = Event::getDescription('request');
		if ($context->getConfig('specificationMode') == 'config') $content = $context->getConfig('request/'.$place->identifier);
		else $content = Config::get($place->identifier.'_request', 'identifier')->content;

		// Card
		foreach ($content['card']['properties'] as $propertyId => $options) {
			if (array_key_exists('definition', $options) && $options['definition'] == 'inline') $property = $options;
			else {
				$property = $description['properties'][$propertyId];
				if ($property['definition'] != 'inline') $property = $context->getConfig($property['definition']);
				if (array_key_exists('labels', $options)) $property['labels'] = $options['labels'];
			}
			if (array_key_exists('repository', $property)) $property['repository'] = $context->getConfig($property['repository']);
			$content['card']['properties'][$propertyId] = $property;
		}
		
		$content['data'] = array();
		foreach ($requests as $request) {
			$content['data'][$request->id] = $request->getProperties();
			if (in_array($myAccount->id, explode(',', $request->matched_accounts))) $content['data'][$request->id]['amContributor'] = true;
			else $content['data'][$request->id]['amContributor'] = false;
		}

		// Return the view
		$view = new ViewModel(array(
			'context' => $context,
			'content' => $content,
			'locale' => $locale,
		));
		$view->setTerminal(true);
		return $view;
	}
	
	public function fillAction()
	{
		// Retrieve the context and the parameters
		$context = Context::getCurrent();
		$id = $this->params()->fromRoute('id');
		$availableSkills = $context->getConfig('matching/skills');
		$survey = 'request';
		$locale = $this->params()->fromQuery('locale');
		
		// Retrieve the account
		$account = Account::get($context->getContactId(), 'contact_1_id');
		$charter_status = $account->getCharterStatus();
		$gtou_status = $account->getGtouStatus();
		
		$place = Place::get($account->place_id);
		$place_identifier = $place->identifier;
		$profile = Vcard::get($account->contact_1_id);
		if (!$locale) $locale = $profile->locale;
		
		if ($id) $event = Event::get($id);
		else $event = Event::instanciate('request');
		$description = Event::getDescription($event->type);
		
		// Retrieve the content
		if ($context->getConfig('specificationMode') == 'config') $content = $context->getConfig($survey.'/'.$place->identifier);
		else $content = Config::get($place->identifier.'_'.$survey, 'identifier')->content;
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
						$data[$propertyId] = ($viewData[$propertyId]) ? substr($viewData[$propertyId], 6, 4).'-'.substr($viewData[$propertyId], 3, 2).'-'.substr($viewData[$propertyId], 0, 2) : null;
					}
					else $data[$propertyId] = $viewData[$propertyId];

					if (array_key_exists('account_property', $property)) $accountData[$property['account_property']] = $data[$propertyId];
				}
			}
			if ($id) $rc = $event->loadAndUpdate($data, $description['properties']);
			else $rc = $event->loadAndAdd($data, $description['properties']);
			if (in_array($rc[0], ['200'])) return $this->redirect()->toRoute('request/detail', ['id' => $event->id], ['query' => ['message' => 'OK']]);
			else $error = $rc[1];
		}
		
		// Feed the layout
		$this->layout('/layout/flow-layout');
		$this->layout()->setVariables(array(
			'context' => $context,
			'place_identifier' => $place_identifier,
			'panel' => $this->params()->fromQuery('panel', null),
			'token' => $this->params()->fromQuery('hash', null),
			'type' => $context->getConfig('landing_account_type'),
			'header' => $content['header'],
			'intro' => $content['intro'],
			'form' => $content['form'],
			'tooltips' => $content['tooltips'],
			'examples' => $content['examples'],
			'footer' => $content['footer'],
			'locale' => $locale,
			'photo_link_id' => ($account) ? $account->photo_link_id : null,
			'charter_status' => $charter_status,
			'gtou_status' => $gtou_status,
			'pageScripts' => 'ppit-flow/request/fill-scripts',
			'tooltips' => $content['tooltips'],
			'message' => null,
			'error' => null,
		));
		
		// Return the view
		$view = new ViewModel(array(
			'context' => $context,
			'id' => $id,
			'locale' => $locale,
			'event' => $event,
			'content' => $content,
			'viewData' => $viewData,
			'message' => $message,
			'error' => $error,
			'availableSkills' => $availableSkills,
		));
		return $view;
	}

	public function detailAction()
	{
		// Retrieve the context and the parameters
		$context = Context::getCurrent();
		$id = $this->params()->fromRoute('id');
		$availableSkills = $context->getConfig('matching/skills');
		$survey = 'request';
		$locale = $this->params()->fromQuery('locale');
		$message = $this->params()->fromQuery('message');
		
		// Retrieve the context account and place
		$myAccount = Account::get($context->getContactId(), 'contact_1_id');
		$charter_status = $myAccount->getCharterStatus();
		$gtou_status = $myAccount->getGtouStatus();
		$place = Place::get($myAccount->place_id);
		$place_identifier = $place->identifier;

		// Retrieve the request, the owner profile and the matched accounts
		$request = Event::get($id);
		$account = Account::get($request->account_id);
		
		// Discriminate between the mode 'requestor' (consultation of a request of mine) and the mode 'public' (requests from others)
		if ($request->account_id == $myAccount->id) $mode = 'requestor';
		else $mode = 'public';
		
		// Retrieve the request description according to its type
		$description = Event::getDescription($request->type);
	
		// Retrieve the content
		if ($context->getConfig('specificationMode') == 'config') $content = $context->getConfig($survey.'/'.$place->identifier);
		else $content = Config::get($place->identifier.'_'.$survey, 'identifier')->content;
		if (!array_key_exists('options', $content['detail'])) $content['detail']['options'] = array();
		
		$viewData = array('status' => $request->status);
	
		// Form
		foreach ($content['detail']['properties'] as $inputId => $options) {
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
			$content['detail']['properties'][$inputId] = $property;
			if (array_key_exists('property_id', $property)) $propertyId = $property['property_id'];
			else $propertyId = $inputId;
			if ($id) {
				if ($inputId != $propertyId) $viewData[$inputId] = (in_array($property['value'], explode(',', $request->properties[$propertyId])) ? $property['value'] : null);
				elseif (array_key_exists($propertyId, $request->properties)) $viewData[$inputId] = $request->properties[$propertyId];
				$queryValue = $this->params()->fromQuery($inputId);
				if ($queryValue !== null) $viewData[$inputId] = $queryValue;
			}
			else $viewData[$inputId] = (array_key_exists('default', $property)) ? $property['default'] : null;
		}

		if ($mode == 'requestor') {
			$actions = array();
			if ($viewData['status'] == 'new') {
				$actions['update'] = $content['detail']['requestor_actions']['update'];
				$actions['cancel'] = $content['detail']['requestor_actions']['cancel'];
				$actions['complete'] = $content['detail']['requestor_actions']['complete'];
				$content['detail']['title'] = $content['detail']['title']['requestor'][$request->status];
			}
			else if ($viewData['status'] == 'connected') {
				$actions['complete'] = $content['detail']['requestor_actions']['complete'];
				$content['detail']['title'] = $content['detail']['title']['requestor'][$request->status];
			}
			else if ($viewData['status'] == 'realized') {
				$requestorFeedbackGiven = true;
				$contributorFeedbackGiven = true;
				if (!array_key_exists($request->account_id, $request->feedbacks)) $content['detail']['title'] = $content['detail']['title']['requestor']['requestor_feedback'];
				else $content['detail']['title'] = $content['detail']['title']['requestor']['contributor_feedback'];
			}
			else if ($viewData['status'] == 'completed') {
				$content['detail']['title'] = $content['detail']['title']['requestor'][$request->status];
				$actions['consult_feedback'] = $content['detail']['public_actions']['consult_feedback'];
			}
			$content['detail']['requestor_actions'] = $actions;
		}
		else { // Public mode
			$actions = array();
			if (!in_array($myAccount->id, explode(',', $request->matched_accounts))) {
				$content['detail']['title'] = $content['detail']['title']['public']['new'];
				$actions['propose'] = $content['detail']['public_actions']['propose'];
			}
			else {
				if ($request->status == 'realized') {
					if ($request->matching_log[$myAccount->id]['action'] == 'accept') {
						$content['detail']['title'] = $content['detail']['title']['public']['contributor_feedback'];
						$actions['feedback'] = $content['detail']['public_actions']['feedback'];
					}
					elseif ($request->matching_log[$myAccount->id]['action'] == 'give_feedback') {
						$content['detail']['title'] = $content['detail']['title']['public']['requestor_feedback'];
					}
					elseif ($request->matching_log[$myAccount->id]['action'] == 'receive_feedback') {
						$content['detail']['title'] = $content['detail']['title']['public']['contributor_feedback'];
						$actions['feedback'] = $content['detail']['public_actions']['feedback'];
					}
				}
				elseif ($request->status == 'completed') {
					$content['detail']['title'] = $content['detail']['title']['public']['completed'];
					$actions['consult_feedback'] = $content['detail']['public_actions']['consult_feedback'];
				}
				else {
					$content['detail']['title'] = $content['detail']['title']['public']['linked'];
				}
			}
			$content['detail']['public_actions'] = $actions;
		}
				
		// Matched Accounts
		foreach ($content['matched_accounts']['properties'] as $propertyId => $options) {
			if (array_key_exists('definition', $options) && $options['definition'] == 'inline') $property = $options;
			else {
				$property = $description['properties'][$propertyId];
				if ($property['definition'] != 'inline') $property = $context->getConfig($property['definition']);
				if (array_key_exists('labels', $options)) $property['labels'] = $options['labels'];
			}
			$content['matched_accounts']['properties'][$propertyId] = $property;
		}
		
		$matchedAccounts = array();
		if ($request->matched_accounts) {
			foreach (explode(',', $request->matched_accounts) as $matchedId) {
				$matchedAccounts[$matchedId] = Account::get($matchedId)->properties;
			}
		}
		$viewData['matched_accounts'] = $matchedAccounts;
		$viewData['matching_log'] = $request->matching_log;
		
		// Feed the layout
		$this->layout('/layout/flow-layout');
		$this->layout()->setVariables(array(
			'context' => $context,
			'place_identifier' => $place_identifier,
			'panel' => $this->params()->fromQuery('panel', null),
			'token' => $this->params()->fromQuery('hash', null),
			'account_id' => $account->id,
			'my_account_id' => $myAccount->id,
			'id' => $id,
			'status' => $request->status,
			'mode' => $mode,
			'type' => $context->getConfig('landing_account_type'),
			'header' => $content['header'],
			'intro' => $content['intro'],
			'detail' => $content['detail'],
			'tooltips' => $content['tooltips'],
			'examples' => $content['examples'],
			'footer' => $content['footer'],
			'locale' => $locale,
			'photo_link_id' => ($account) ? $account->photo_link_id : null,
			'charter_status' => $charter_status,
			'gtou_status' => $gtou_status,
			'pageScripts' => 'ppit-flow/request/detail-scripts',
			'tooltips' => $content['tooltips'],
			'message' => $message,
			'error' => null,
		));
	
		// Return the view
		$view = new ViewModel(array(
			'context' => $context,
			'id' => $id,
			'status' => $request->status,
			'mode' => $mode,
			'locale' => $locale,
			'content' => $content,
			'viewData' => $viewData,
			'availableSkills' => $availableSkills,
		));
		return $view;
	}

	public function accountListAction()
	{
		// Retrieve the context and the parameters
		$context = Context::getCurrent();
		$id = $this->params()->fromRoute('id');
	
		// Retrieve the context account and place
		$myAccount = Account::get($context->getContactId(), 'contact_1_id');
		$place = Place::get($myAccount->place_id);
		$place_identifier = $place->identifier;
	
		// Retrieve the request, the owner profile and the matched accounts
		$request = Event::get($id);
		$account = Account::get($request->account_id);
	
		// Retrieve the request description according to its type
		$description = Event::getDescription($request->type);
	
		// Retrieve the content
		if ($context->getConfig('specificationMode') == 'config') $content = $context->getConfig('request/'.$place->identifier);
		else $content = Config::get($place->identifier.'_request', 'identifier')->content;
	
		// Matched Accounts
		foreach ($content['matched_accounts']['properties'] as $propertyId => $options) {
			if (array_key_exists('definition', $options) && $options['definition'] == 'inline') $property = $options;
			else {
				$property = $description['properties'][$propertyId];
				if ($property['definition'] != 'inline') $property = $context->getConfig($property['definition']);
				if (array_key_exists('labels', $options)) $property['labels'] = $options['labels'];
			}
			$content['matched_accounts']['properties'][$propertyId] = $property;
		}
	
		$matchedAccounts = array();
		if ($request->matched_accounts) {
			foreach (explode(',', $request->matched_accounts) as $matchedId) {
				$matchedAccounts[$matchedId] = Account::get($matchedId)->properties;
			}
		}
		$viewData = array(
			'owner_id' => $myAccount->id,
			'request_status' => $request->status,
			'matched_accounts' => $matchedAccounts,
			'matching_log' => $request->matching_log,
			'feedbacks' => $request->feedbacks,
		);
		
		// Return the view
		$view = new ViewModel(array(
			'context' => $context,
			'id' => $id,
			'request' => $request,
			'content' => $content,
			'viewData' => $viewData,
		));
		$view->setTerminal(true);
		return $view;
	}
	
	public function contactAction()
	{
		// Retrieve the context and the parameters
		$context = Context::getCurrent();
		$place = Place::get($context->getPlaceId());
		$place_identifier = $place->identifier;
		$id = $this->params()->fromRoute('id');
		$request = Event::get($id);
		$locale = $this->params()->fromQuery('locale');

		// Retrieve the accounts to link this request with
		$otherAccounts = explode(',', $this->params()->fromQuery('accounts'));
		
		// Atomicity
		$connection = Event::getTable()->getAdapter()->getDriver()->getConnection();
		$connection->beginTransaction();
		try {
		
			// Mark the other account as matched in the request
			if ($request->matched_accounts) $matchedAccounts = explode(',', $request->matched_accounts);
			else $matchedAccounts = array();
			foreach ($otherAccounts as $account_id) {
				if (!in_array($account_id, $matchedAccounts)) $matchedAccounts[] = $account_id;
				$request->matched_accounts = implode(',', $matchedAccounts);
				$entry = array(
					'user_id' => $context->getUserId(),
					'n_fn' => $context->getFormatedName(),
					'action' => 'request/contact',
				);
				if (array_key_exists($account_id, $request->matching_log)) {
					$request->matching_log[$account_id]['log'][date('Y-m-d H:i:s')] = $entry;
				}
				else {
					$request->matching_log[$account_id] = array(
						'action' => 'contact',
						'date' => Date('Y-m-d'),
						'log' => array(date('Y-m-d H:i:s') => $entry),
					);
				}
			}
			$rc = $request->update(null);
			if ($rc != 'OK') {
				$connection->rollback();
				$this->response->setStatusCode('500');
				return $this->response;
			}

			// Mark the other account as matched in the owner's account
			$account = Account::get($request->account_id);
	
			if ($account->property_2) $matchedAccounts = explode(',', $account->property_2);
			else $matchedAccounts = array();
			foreach ($otherAccounts as $account_id) {
				if (!in_array($account_id, $matchedAccounts)) $matchedAccounts[] = $account_id;
				$account->property_2 = implode(',', $matchedAccounts);
				$rc = $account->update(null);
				if ($rc != 'OK') {
					$connection->rollback();
					$this->response->setStatusCode('500');
					return $this->response;
				}
			}
			$connection->commit();
			$this->response->setStatusCode('200');
		}
		catch (\Exception $e) {
			$connection->rollback();
			$this->response->setStatusCode('500');
		}
		return $this->response;
	}

	public function abandonAction()
	{
		// Retrieve the context and the parameters
		$context = Context::getCurrent();
		$place = Place::get($context->getPlaceId());
		$place_identifier = $place->identifier;
		$id = $this->params()->fromRoute('id');
		$request = Event::get($id);
		$locale = $this->params()->fromQuery('locale');
		
		// Atomicity
		$connection = Event::getTable()->getAdapter()->getDriver()->getConnection();
		$connection->beginTransaction();
		try {
			
			// Retrieve the accounts to abandon
			$otherAccounts = explode(',', $this->params()->fromQuery('accounts'));
		
			// Mark the other account as unmatched in the request
			if ($request->matched_accounts) $matchedAccounts = explode(',', $request->matched_accounts);
			else $matchedAccounts = array();
			$keys = array();
			foreach ($matchedAccounts as $item) $keys[$item] = null;
			foreach ($otherAccounts as $account_id) {
				if (array_key_exists($account_id, $keys)) unset($keys[$account_id]);
				$matchedAccounts = array();
				foreach ($keys as $item => $unused) $matchedAccounts[] = $item;
				$request->matched_accounts = implode(',', $matchedAccounts);
				$entry = array(
					'user_id' => $context->getUserId(),
					'n_fn' => $context->getFormatedName(),
					'action' => 'request/abandon',
				);
				$request->matching_log[$account_id]['log'][date('Y-m-d H:i:s')] = $entry;
			}
			$rc = $request->update(null);
			if ($rc != 'OK') {
				$connection->rollback();
				$this->response->setStatusCode('500');
				return $this->response;
			}
	
			// Mark the other account as unmatched in my account
			$account = Account::get($request->account_id);
			if ($account->property_2) {
				$matchedAccounts = explode(',', $account->property_2);
				foreach ($otherAccounts as $other_id) {
					if (in_array($other_id, $matchedAccounts)) {
						$requests = Event::getList('request', ['account_id' => $account->id], '-update_time', null);
						$accountIsMatched = false;
						foreach ($requests as $reqId => $req) {
							if ($reqId != $id) { // Previously processed
								$requestMatchedAccounts = explode(',', $req->matched_accounts);
								if (array_key_exists($other_id, $requestMatchedAccounts)) $accountIsMatched = true;
							}
						}
						if (!$accountIsMatched) {
							$matchedAccounts = array();
							foreach(explode(',', $account->property_2) as $item) {
								if ($item != $other_id) $matchedAccounts[] = $item;
							}
							$account->property_2 = implode(',', $matchedAccounts);
							$rc = $account->update(null);
							if ($rc != 'OK') {
								$connection->rollback();
								$this->response->setStatusCode('500');
								return $this->response;
							}
						}
					}
				}
			}
			$connection->commit();
			$this->response->setStatusCode('200');
		}
		catch (\Exception $e) {
			$connection->rollback();
			$this->response->setStatusCode('500');
		}
		return $this->response;
	}

	public function acceptAction()
	{
		// Retrieve the context and the parameters
		$context = Context::getCurrent();
		$place = Place::get($context->getPlaceId());
		$place_identifier = $place->identifier;
		$id = $this->params()->fromRoute('id');
		$request = Event::get($id);
		$locale = $this->params()->fromQuery('locale');
	
		// Atomicity
		$connection = Event::getTable()->getAdapter()->getDriver()->getConnection();
		$connection->beginTransaction();
		try {
				
			// Retrieve the accounts to abandon
			$otherAccounts = explode(',', $this->params()->fromQuery('accounts'));
	
			// Change the account status in the request matching log
			if ($request->matched_accounts) $matchedAccounts = explode(',', $request->matched_accounts);
			else $matchedAccounts = array();
			foreach ($otherAccounts as $account_id) {
				$request->matched_accounts = implode(',', $matchedAccounts);
				$entry = array(
					'user_id' => $context->getUserId(),
					'n_fn' => $context->getFormatedName(),
					'action' => 'request/accept',
				);
				$request->matching_log[$account_id]['log'][date('Y-m-d H:i:s')] = $entry;
				$request->matching_log[$account_id]['action'] = 'accept';
				$request->matching_log[$account_id]['date'] = Date('Y-m-d');
			}
			$rc = $request->update(null);
			if ($rc != 'OK') {
				$connection->rollback();
				$this->response->setStatusCode('500');
				return $this->response;
			}

			$connection->commit();
			$this->response->setStatusCode('200');
		}
		catch (\Exception $e) {
			$connection->rollback();
			$this->response->setStatusCode('500');
		}
		return $this->response;
	}
	
	public function declineAction()
	{
		// Retrieve the context and the parameters
		$context = Context::getCurrent();
		$place = Place::get($context->getPlaceId());
		$place_identifier = $place->identifier;
		$id = $this->params()->fromRoute('id');
		$request = Event::get($id);
		$locale = $this->params()->fromQuery('locale');
		
		// Atomicity
		$connection = Event::getTable()->getAdapter()->getDriver()->getConnection();
		$connection->beginTransaction();
		try {
			
			// Retrieve the accounts to abandon
			$otherAccounts = explode(',', $this->params()->fromQuery('accounts'));
		
			// Mark the other account as unmatched in the request
			if ($request->matched_accounts) $matchedAccounts = explode(',', $request->matched_accounts);
			else $matchedAccounts = array();
			$keys = array();
			foreach ($matchedAccounts as $item) $keys[$item] = null;
			foreach ($otherAccounts as $account_id) {
				if (array_key_exists($account_id, $keys)) unset($keys[$account_id]);
				$matchedAccounts = array();
				foreach ($keys as $item => $unused) $matchedAccounts[] = $item;
				$request->matched_accounts = implode(',', $matchedAccounts);
				$entry = array(
					'user_id' => $context->getUserId(),
					'n_fn' => $context->getFormatedName(),
					'action' => 'request/decline',
				);
				$request->matching_log[$account_id]['log'][date('Y-m-d H:i:s')] = $entry;
				$request->matching_log[$account_id]['action'] = 'decline';
				$request->matching_log[$account_id]['date'] = Date('Y-m-d');
			}
			$rc = $request->update(null);
			if ($rc != 'OK') {
				$connection->rollback();
				$this->response->setStatusCode('500');
				return $this->response;
			}
	
			// Mark the other account as unmatched in my account
			$account = Account::get($request->account_id);
			if ($account->property_2) {
				$matchedAccounts = explode(',', $account->property_2);
				foreach ($otherAccounts as $other_id) {
					if (in_array($other_id, $matchedAccounts)) {
						$requests = Event::getList('request', ['account_id' => $account->id], '-update_time', null);
						$accountIsMatched = false;
						foreach ($requests as $reqId => $req) {
							if ($reqId != $id) { // Previously processed
								$requestMatchedAccounts = explode(',', $req->matched_accounts);
								if (array_key_exists($other_id, $requestMatchedAccounts)) $accountIsMatched = true;
							}
						}
						if (!$accountIsMatched) {
							$matchedAccounts = array();
							foreach(explode(',', $account->property_2) as $item) {
								if ($item != $other_id) $matchedAccounts[] = $item;
							}
							$account->property_2 = implode(',', $matchedAccounts);
							$rc = $account->update(null);
							if ($rc != 'OK') {
								$connection->rollback();
								$this->response->setStatusCode('500');
								return $this->response;
							}
						}
					}
				}
			}
			$connection->commit();
			$this->response->setStatusCode('200');
		}
		catch (\Exception $e) {
			$connection->rollback();
			$this->response->setStatusCode('500');
		}
		return $this->response;
	}
	
	public function completeAction()
	{
		$context = Context::getCurrent();
		$id = $this->params()->fromRoute('id');
		$request = Event::get($id);
		if (!$request) {
			$this->response->setStatusCode('400');
			return $this->response;
		}
		$request->status = 'realized';
		$request->update(null);
		$this->response->setStatusCode('200');
		return $this->response;
	}

	public function proposeAction()
	{
		$context = Context::getCurrent();
		$id = $this->params()->fromRoute('id');
		$account_id = $this->params()->fromQuery('account_id');

		$request = Event::get($id);
		if (!$request) {
			$this->response->setStatusCode('400');
			return $this->response;
		}

		// Atomicity
		$connection = Event::getTable()->getAdapter()->getDriver()->getConnection();
		$connection->beginTransaction();
		try {

			// Retrieve the accounts who propose
			$otherAccounts = explode(',', $this->params()->fromQuery('accounts'));

			// Mark the other accounts as matched in the request
			if ($request->matched_accounts) $matchedAccounts = explode(',', $request->matched_accounts);
			else $matchedAccounts = array();
			foreach ($otherAccounts as $account_id) {
				if (!in_array($account_id, $matchedAccounts)) $matchedAccounts[] = $account_id;
				$request->matched_accounts = implode(',', $matchedAccounts);
				$entry = array(
					'user_id' => $context->getUserId(),
					'n_fn' => $context->getFormatedName(),
					'action' => 'request/propose',
				);
				if (array_key_exists($account_id, $request->matching_log)) {
					$request->matching_log[$account_id]['log'][date('Y-m-d H:i:s')] = $entry;
				}
				else {
					$request->matching_log[$account_id] = ['log' => [date('Y-m-d H:i:s') => $entry]];
				}
				$request->matching_log[$account_id]['action'] = 'propose';
				$request->matching_log[$account_id]['date'] = Date('Y-m-d');
			}

			// Mark the request as connected
			$request->status = 'connected';
			$rc = $request->update(null);
			if ($rc != 'OK') {
				$connection->rollback();
				$this->response->setStatusCode('500');
				return $this->response;
			}

			// Mark the other account as matched in the owner's account
			$account = Account::get($request->account_id);
			if ($account->property_2) $matchedAccounts = explode(',', $account->property_2);
			else $matchedAccounts = array();
			foreach ($otherAccounts as $account_id) {
				if (!in_array($account_id, $matchedAccounts)) $matchedAccounts[] = $account_id;
				$account->property_2 = implode(',', $matchedAccounts);
				$rc = $account->update(null);
				if ($rc != 'OK') {
					$connection->rollback();
					$this->response->setStatusCode('500');
					return $this->response;
				}
			}
			$connection->commit();
			$this->response->setStatusCode('200');
			return $this->response;
		}
		catch (\Exception $e) {
			$connection->rollback();
			$this->response->setStatusCode('500');
			return $this->response;
		}
	}

	// Feedback
	public function feedbackAction()
	{
		// Retrieve the context and parameters
		$context = Context::getCurrent();
		$id = $this->params()->fromRoute('id');
		$locale = $this->params()->fromQuery('locale');
		$place = Place::get($context->getPlaceId());
		$place_identifier = $place->identifier;
		$account = Account::get($context->getContactId(), 'contact_1_id');
		$contributor_id = $this->params()->fromQuery('contributor');
		$request = Event::get($id);
		if (!$request) {
			$this->response->setStatusCode('400');
			return $this->response;
		}
		$feedback = (array_key_exists($account->id, $request->feedbacks)) ? $request->feedbacks[$account->id] : array();

		// Retrieve the content
		if ($context->getConfig('specificationMode') == 'config') $content = $context->getConfig('request/'.$place->identifier);
		else $content = Config::get($place->identifier.'_request', 'identifier')->content;

		// Discriminate between the mode 'requestor' (consultation of a request of mine) and the mode 'public' (requests from others)
		if ($request->account_id == $account->id) $mode = 'requestor';
		else $mode = 'public';
		
		$viewData = array();
		
		// Form
		$inputs = array();
		foreach ($content['feedback']['inputs'] as $inputId => $options) {
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
			if ($property['type'] == 'html' && array_key_exists('params', $property)) {
				$arguments = array();
				foreach ($property['params'] as $paramId) $arguments[$paramId] = $request->properties[$paramId];
				$text = array();
				foreach ($property['text'] as $locale => $localized) $text[$locale] = vsprintf($localized, $arguments);
				$property['text'] = $text;
			}
			if (array_key_exists('repository', $property)) $property['repository'] = $context->getConfig($property['repository']);
			if (!array_key_exists('mandatory', $property)) $property['mandatory'] = false;
			if (!array_key_exists('updatable', $property)) $property['updatable'] = true;
			if (!array_key_exists('placeholder', $property)) $property['placeholder'] = null;
  			if (!array_key_exists('mode', $property) || $property['mode'] == $mode) {
				$inputs[$inputId] = $property;
  			}
			if (array_key_exists('property_id', $property)) $propertyId = $property['property_id'];
			else $propertyId = $inputId;
			if ($id && array_key_exists($propertyId, $feedback)) $viewData[$inputId] = $feedback[$propertyId];
			else $viewData[$inputId] = (array_key_exists('default', $property)) ? $property['default'] : null;
		}
		$content['feedback']['inputs'] = $inputs;

		if ($mode == 'requestor') {
			$content['feedback']['title'] = $content['feedback']['title']['requestor']['new'];
		}
		else { // Public mode
			$content['feedback']['title'] = $content['feedback']['title']['public']['new'];
		}
		
		// Process the post data after input
		$message = $error = null;
		if ($this->request->isPost()) {
					
			// Atomicity
			$connection = Event::getTable()->getAdapter()->getDriver()->getConnection();
			$connection->beginTransaction();
			try {
		
				if ($mode == 'requestor') {

					// The contributor received a feedback 
					$entry = array(
						'user_id' => $context->getUserId(),
						'n_fn' => $context->getFormatedName(),
						'action' => 'request/feedback',
					);
					if (array_key_exists($contributor_id, $request->matching_log)) {
						$request->matching_log[$contributor_id]['log'][date('Y-m-d H:i:s')] = $entry;
					}
					else {
						$request->matching_log[$contributor_id] = ['log' => [date('Y-m-d H:i:s') => $entry]];
					}
					$request->matching_log[$contributor_id]['action'] = 'receive_feedback';
					$request->matching_log[$contributor_id]['date'] = Date('Y-m-d');

					// Log the feedback
					$request->feedbacks[$account->id] = array(
						$contributor_id => array(
							'private_comment' => $this->getRequest()->getPost('private_comment'),
							'platform_benefit' => $this->getRequest()->getPost('platform_benefit'),
							'platform_satisfaction' => $this->getRequest()->getPost('platform_satisfaction'),
							'platform_accessibility' => $this->getRequest()->getPost('platform_accessibility'),
							'platform_comment' => $this->getRequest()->getPost('platform_comment'),
							'community_comment' => $this->getRequest()->getPost('community_comment')
						),
					);
				}
				else {
				
					// The contributor gave a feedback 
					$entry = array(
						'user_id' => $context->getUserId(),
						'n_fn' => $context->getFormatedName(),
						'action' => 'request/feedback',
					);
					if (array_key_exists($account->id, $request->matching_log)) {
						$request->matching_log[$account->id]['log'][date('Y-m-d H:i:s')] = $entry;
					}
					else {
						$request->matching_log[$account->id] = ['log' => [date('Y-m-d H:i:s') => $entry]];
					}
					$request->matching_log[$account->id]['action'] = 'give_feedback';
					$request->matching_log[$account->id]['date'] = Date('Y-m-d');

					// Log the feedback
					$request->feedbacks[$account->id] = array(
						$request->account_id => array(
							'private_comment' => $this->getRequest()->getPost('private_comment'),
							'platform_benefit' => $this->getRequest()->getPost('platform_benefit'),
							'platform_satisfaction' => $this->getRequest()->getPost('platform_satisfaction'),
							'platform_accessibility' => $this->getRequest()->getPost('platform_accessibility'),
							'platform_comment' => $this->getRequest()->getPost('platform_comment'),
							'community_comment' => $this->getRequest()->getPost('community_comment')
						),
					);
				}
				
				// Mark the request as completed if all the stakeholders (requestor and contributors gave their feedback)
				$completed = true;
				if (!array_key_exists($request->account_id, $request->feedbacks)) $completed = false;
				foreach (explode(',', $request->matched_accounts) as $otherAccountId) {
					if (!array_key_exists($otherAccountId, $request->feedbacks)) $completed = false;
				}
				if ($completed) $request->status = 'completed';
				
				$rc = $request->update(null);
				if ($rc != 'OK') {
					$connection->rollback();
					$error = $rc;
				}
				
				$connection->commit();
				$message = 'OK';
			}
			catch (\Exception $e) {
				$connection->rollback();
				$error = 'technical';
			}
		}
		
		// Feed the layout
		$this->layout('/layout/flow-layout');
		$this->layout()->setVariables(array(
			'context' => $context,
			'place_identifier' => $place_identifier,
			'panel' => $this->params()->fromQuery('panel', null),
			'token' => $this->params()->fromQuery('hash', null),
			'type' => $context->getConfig('landing_account_type'),
			'header' => $content['header'],
			'intro' => $content['intro'],
			'form' => $content['feedback'],
			'footer' => $content['footer'],
			'locale' => $locale,
			'charter_status' => $charter_status = $account->getCharterStatus(),
			'gtou_status' => $account->getGtouStatus(),
			'photo_link_id' => $account->photo_link_id,
			'pageScripts' => 'ppit-flow/request/feedback-scripts',
			'tooltips' => $content['tooltips'],
			'message' => $message,
			'error' => $error,
		));
		
		// Return the view
		$view = new ViewModel(array(
			'context' => $context,
			'id' => $id,
			'contributor_id' => $contributor_id,
			'locale' => $locale,
			'event' => $request,
			'content' => $content,
			'viewData' => $viewData,
			'message' => $message,
			'error' => $error,
		));
		return $view;
	}

	public function consultFeedbackAction()
	{
		// Retrieve the context and the parameters
		$context = Context::getCurrent();
		$place = Place::get($context->getPlaceId());
		$place_identifier = $place->identifier;
		$id = $this->params()->fromRoute('id');
		$request = Event::get($id);
		$myAccount = Account::get($context->getContactId(), 'contact_1_id');
		$locale = $this->params()->fromQuery('locale');
				
		// Retrieve the accounts for the feedback givers
		$myReceivedFeedbacks = array();
		foreach ($request->feedbacks as $giver_id => $receivers) {
			foreach ($receivers as $receiver_id => $feedback) {
				if ($receiver_id == $myAccount->id) {
					$receiver = Account::get($receiver_id);
					$myReceivedFeedbacks[] = array(
						'n_fn' => $receiver->n_fn,
						'text' => $feedback['private_comment'],
					);
				}
			}
		}

		// Return the view
		$view = new ViewModel(array(
			'context' => $context,
			'id' => $id,
			'locale' => $locale,
			'request' => $request,
			'myReceivedFeedbacks' => $myReceivedFeedbacks,
		));
		$view->setTerminal(true);
		return $view;
	}
	
	public function cancelAction()
	{
		$context = Context::getCurrent();
		$id = $this->params()->fromRoute('id');
		$request = Event::get($id);
		if (!$request) {
			$this->response->setStatusCode('400');
			return $this->response;
		}
		$request->status = 'canceled';
		$request->update(null);
		$this->response->setStatusCode('200');
		return $this->response;
	}
/*	
	public function addToBasketAction()
	{
		// Retrieve the context and the parameters
		$context = Context::getCurrent();
		$place = Place::get($context->getPlaceId());
		$place_identifier = $place->identifier;
		$profile = Vcard::get($context->getContactId());
		$locale = $this->params()->fromQuery('locale');
		$id = $this->params()->fromRoute('id');
		if (!array_key_exists('request_basket', $profile->specifications)) $profile->specifications['request_basket'] = array();
		$profile->specifications['request_basket'][$id] = array();
		$profile->update(null);
		return $this->response;
	}
	
	public function removeFromBasketAction()
	{
		// Retrieve the context and the parameters
		$context = Context::getCurrent();
		$place = Place::get($context->getPlaceId());
		$place_identifier = $place->identifier;
		$profile = Vcard::get($context->getContactId());
		$locale = $this->params()->fromQuery('locale');
		$id = $this->params()->fromRoute('id');
		if (!array_key_exists('request_basket', $profile->specifications)) $profile->specifications['request_basket'] = array();
		unset($profile->specifications['request_basket'][$id]);
		$profile->update(null);
		return $this->response;
	}*/
}
