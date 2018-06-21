<?php
namespace PpitFlow\Controller;

use PpitCore\Form\CsrfForm;
use PpitCore\Model\Account;
use PpitCore\Model\Config;
use PpitCore\Model\Context;
use PpitCore\Model\Csrf;
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

		$token = null;
		$id = $this->params()->fromRoute('id');
		$token = $this->params()->fromQuery('hash', null);
    	if ($token && $token != $account->authentication_token) return $this->redirect()->toRoute('landing/template2');

		$viewData = array();
		foreach ($content['form']['inputs'] as $inputId => $options) {
			if (array_key_exists('definition', $options) && $options['definition'] == 'inline') $property = $options;
			else {
				$property = $context->getConfig('core_account/generic/property/'.$inputId);
				if ($property['definition'] != 'inline') $property = $context->getConfig($property['definition']);
				if (array_key_exists('mandatory', $options)) $property['mandatory'] = $options['mandatory'];
				if (array_key_exists('updatable', $options)) $property['updatable'] = $options['updatable'];
			}
			if (!array_key_exists('mandatory', $property)) $property['mandatory'] = false;
			if (!array_key_exists('updatable', $property)) $property['updatable'] = true;
			if (!array_key_exists('placeholder', $property)) $property['placeholder'] = null;
			$content['form']['inputs'][$inputId] = $property;
			if (array_key_exists('property_id', $property)) $propertyId = $property['property_id'];
			else $propertyId = $inputId;
			if ($id) {
				if ($inputId != $propertyId) $viewData[$inputId] = (in_array($property['value'], explode(',', $account->properties[$propertyId])) ? $property['value'] : null);
				else $viewData[$inputId] = $account->properties[$propertyId];
				$queryValue = $this->params()->fromQuery($inputId);
				if ($queryValue !== null) $viewData[$inputId] = $queryValue;
			}
			else $viewData[$inputId] = (array_key_exists('default', $property)) ? $property['default'] : null;
		}
		
		// Process the post data after input
		$message = $error = null;
		if ($this->request->isPost()) {
			$data = array();
			$data['status'] = 'interested';
			$data['place_id'] = $place->id;
			$data['callback_date'] = date('Y-m-d');
			foreach ($content['form']['inputs'] as $inputId => $property) {
				if (!$id || $property['updatable']) {
					$viewData[$inputId] = $this->request->getPost($inputId);
					if (array_key_exists('property_id', $property)) $propertyId = $property['property_id'];
					else $propertyId = $inputId;
					
					if (array_key_exists($propertyId, $data) && $data[$propertyId]) {
						if ($viewData[$inputId]) $data[$propertyId] .= ','.$viewData[$inputId];
					}
					else $data[$propertyId] = $viewData[$inputId];
				}
			}
			$data['contact_history'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2).', from '.$_SERVER['HTTP_REFERER'].', with '.$_SERVER['HTTP_USER_AGENT'].' filled landing page\'s form';

			if ($id) {
				$data['origine'] = 'e_mailing';
				$rc = $account->loadAndUpdate($data);
			}
			else {
				$data['origine'] = 'subscription';
				$rc = $account->loadAndAdd($data);
			}
			if (in_array($rc[0], ['200'])) $message = 'OK';
			else $error = $rc;
		}
		else {
			if ($id && $account->status == 'new') {
				$data['status'] = 'suspect';
				$data['callback_date'] = date('Y-m-d');
				$rc = $account->loadAndUpdate($data);
			}
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
