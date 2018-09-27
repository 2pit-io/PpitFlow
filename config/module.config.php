<?php
/**
 * 2pit V1.0 (https://github.com/2pit/Flux)
 *
 * @link      https://github.com/2pit/Flux
 * @copyright Copyright (c) 2018 Bruno Lartillot
 * @license   https://github.com/2pit/Flux/blob/master/license.txt GNU-GPL license
 */

return array (
	'controllers' => array(
		'invokables' => array(
			'PpitFlow\Controller\Event' => 'PpitFlow\Controller\EventController',
			'PpitFlow\Controller\Landing' => 'PpitFlow\Controller\LandingController',
			'PpitFlow\Controller\Profile' => 'PpitFlow\Controller\ProfileController',
//			'PpitFlow\Controller\Request' => 'PpitFlow\Controller\RequestController',
			'PpitFlow\Controller\Survey' => 'PpitFlow\Controller\SurveyController',
		),
	),
	
	'router' => array(
		'routes' => array(
			'flowEvent' => array(
				'type'    => 'literal',
				'options' => array(
					'route'    => '/flow-event',
					'constraints' => ['id' => '[0-9]*'],
					'defaults' => array(
						'controller' => 'PpitFlow\Controller\Event',
						'action'     => 'index',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'index' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/index[/:type]',
							'defaults' => array(
								'action' => 'index',
							),
						),
					),
					'list' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/list[/:type]',
							'defaults' => array(
								'action' => 'list',
							),
						),
					),
					'detail' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/detail[/:type][/:id]',
							'defaults' => array('action' => 'detail'),
						),
					),
					'update' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/update[/:id]',
							'defaults' => array('action' => 'update'),
						),
					),
/*					'accountList' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/account-list[/:id]',
							'defaults' => array('action' => 'accountList'),
						),
					),*/
					'fill' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/fill[/:type][/:id]',
							'defaults' => array('action' => 'fill'),
						),
					),
					'contact' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/contact[/:type][/:id]',
							'defaults' => array('action' => 'contact'),
						),
					),
					'propose' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/propose[/:type][/:id]',
							'defaults' => array('action' => 'propose'),
						),
					),
					'accept' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/accept[/:type][/:id]',
							'defaults' => array('action' => 'accept'),
						),
					),
					'decline' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/decline[/:type][/:id]',
							'defaults' => array('action' => 'decline'),
						),
					),
					'feedback' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/feedback[/:type][/:id]',
							'defaults' => array('action' => 'feedback'),
						),
					),
					'abandon' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/abandon[/:type][/:id]',
							'defaults' => array('action' => 'abandon'),
						),
					),
					'complete' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/complete[/:type][/:id]',
							'defaults' => array('action' => 'complete'),
						),
					),
					'consultFeedback' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/consult-feedback[/:type][/:id]',
							'defaults' => array('action' => 'consultFeedback'),
						),
					),
					'cancel' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/cancel[/:type][/:id]',
							'defaults' => array('action' => 'cancel'),
						),
					),
				),
			),
			'landing' => array(
				'type'    => 'literal',
				'options' => array(
					'route'    => '/landing',
					'defaults' => array(
						'controller' => 'PpitFlow\Controller\Landing',
						'action'     => 'template1',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'template1' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/template1[/:place_identifier][/:id]',
							'defaults' => array('action' => 'template1'),
						),
					),
					'template2' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/template2[/:place_identifier][/:id]',
							'defaults' => array('action' => 'template2'),
						),
					),
					'test' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/test',
							'defaults' => array('action' => 'test'),
						),
					),
				),
			),
			'profile' => array(
				'type'    => 'literal',
				'options' => array(
					'route'    => '/profile',
					'defaults' => array(
						'controller' => 'PpitFlow\Controller\Profile',
						'action'     => 'index',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'index' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/index[/:place_identifier][/:account_id]',
							'defaults' => array('action' => 'index'),
						),
					),
					'home' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/home[/:place_identifier][/:account_id]',
							'defaults' => array('action' => 'home'),
						),
					),
					'list' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/list[/:request_id]',
							'defaults' => array('action' => 'list'),
						),
					),
					'detail' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/detail[/:request_id][/:account_id]',
							'defaults' => array('action' => 'detail'),
						),
					),
					'template1' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/template1[/:place_identifier][/:account_id]',
							'defaults' => array('action' => 'template1'),
						),
					),
					'template2' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/template2[/:place_identifier][/:account_id]',
							'defaults' => array('action' => 'template2'),
						),
					),
					'profile' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/profile[/:account_id]',
							'defaults' => array(
								'action' => 'profile',
							),
						),
					),
					'contact' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/contact[/:account_id]',
							'defaults' => array(
								'action' => 'contact',
							),
						),
					),
					'removeContact' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/remove-contact[/:account_id]',
							'defaults' => array(
								'action' => 'removeContact',
							),
						),
					),
					'dashboard' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/dashboard',
							'defaults' => array(
								'action' => 'dashboard',
							),
						),
					),
					'photoUpload' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/photo-upload[/:id]',
							'constraints' => ['id' => '[0-9]*'],
							'defaults' => array(
								'action' => 'photoUpload',
							),
						),
					),
				),
			),
/*			'request' => array(
				'type'    => 'literal',
				'options' => array(
					'route'    => '/request',
					'constraints' => ['id' => '[0-9]*'],
					'defaults' => array(
						'controller' => 'PpitFlow\Controller\Request',
						'action'     => 'index',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'index' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/index',
							'defaults' => array(
								'action' => 'index',
							),
						),
					),
					'list' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/list',
							'defaults' => array(
								'action' => 'list',
							),
						),
					),
					'home' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/home',
							'defaults' => array('action' => 'home'),
						),
					),
					'dashboard' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/dashboard',
							'defaults' => array('action' => 'dashboard'),
						),
					),
					'detail' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/detail[/:id]',
							'defaults' => array('action' => 'detail'),
						),
					),
					'detailv2' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/detailv2[/:id]',
							'defaults' => array('action' => 'detailv2'),
						),
					),
					'update' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/update[/:id]',
							'defaults' => array('action' => 'update'),
						),
					),
					'accountList' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/account-list[/:id]',
							'defaults' => array('action' => 'accountList'),
						),
					),
					'fill' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/fill[/:id]',
							'defaults' => array('action' => 'fill'),
						),
					),
					'contact' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/contact[/:id]',
							'defaults' => array('action' => 'contact'),
						),
					),
					'propose' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/propose[/:id]',
							'defaults' => array('action' => 'propose'),
						),
					),
					'accept' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/accept[/:id]',
							'defaults' => array('action' => 'accept'),
						),
					),
					'decline' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/decline[/:id]',
							'defaults' => array('action' => 'decline'),
						),
					),
					'feedback' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/feedback[/:id]',
							'defaults' => array('action' => 'feedback'),
						),
					),
					'abandon' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/abandon[/:id]',
							'defaults' => array('action' => 'abandon'),
						),
					),
					'complete' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/complete[/:id]',
							'defaults' => array('action' => 'complete'),
						),
					),
					'consultFeedback' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/consult-feedback[/:id]',
							'defaults' => array('action' => 'consultFeedback'),
						),
					),
					'cancel' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/cancel[/:id]',
							'defaults' => array('action' => 'cancel'),
						),
					),
				),
			),*/
			'survey' => array(
				'type'    => 'literal',
				'options' => array(
					'route'    => '/survey',
					'defaults' => array(
						'controller' => 'PpitFlow\Controller\Survey',
						'action'     => 'fill',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'fill' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/fill[/:id]',
							'defaults' => array('action' => 'fill'),
						),
					),
					'template1' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/template1[/:id]',
							'defaults' => array('action' => 'template1'),
						),
					),
					'template2' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/template2[/:id]',
							'defaults' => array('action' => 'template2'),
						),
					),
					'selectTest' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/select-test[/:place_identifier]',
							'defaults' => array(
								'action' => 'selectTest',
							),
						),
					),
					'inviteToTest' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/invite-to-test[/:place_identifier]',
							'defaults' => array(
								'action' => 'inviteToTest',
							),
						),
					),
					'newRequest' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/new-request[/:id]',
							'defaults' => array(
								'action' => 'newRequest',
							),
						),
					),
					'patch' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/patch',
							'defaults' => array(
								'action' => 'patch',
							),
						),
					),
				),
			),
		),
	),

	'bjyauthorize' => array(
		// Guard listeners to be attached to the application event manager
		'guards' => array(
			'BjyAuthorize\Guard\Route' => array(				
				array('route' => 'landing/template1', 'roles' => array('guest')),
				array('route' => 'landing/template2', 'roles' => array('guest')),
				array('route' => 'landing/test', 'roles' => array('guest')),

				array('route' => 'flowEvent', 'roles' => array('user')),
				array('route' => 'flowEvent/index', 'roles' => array('user')),
				array('route' => 'flowEvent/list', 'roles' => array('user')),
				array('route' => 'flowEvent/detail', 'roles' => array('user')),
				array('route' => 'flowEvent/update', 'roles' => array('user')),
//				array('route' => 'flowEvent/accountList', 'roles' => array('user')),
				array('route' => 'flowEvent/fill', 'roles' => array('user')),
				array('route' => 'flowEvent/contact', 'roles' => array('user')),
				array('route' => 'flowEvent/abandon', 'roles' => array('user')),
				array('route' => 'flowEvent/complete', 'roles' => array('user')),
				array('route' => 'flowEvent/propose', 'roles' => array('user')),
				array('route' => 'flowEvent/accept', 'roles' => array('user')),
				array('route' => 'flowEvent/decline', 'roles' => array('user')),
				array('route' => 'flowEvent/feedback', 'roles' => array('user')),
				array('route' => 'flowEvent/consultFeedback', 'roles' => array('user')),
				array('route' => 'flowEvent/cancel', 'roles' => array('user')),
				
				array('route' => 'profile', 'roles' => array('user')),
				array('route' => 'profile/index', 'roles' => array('user')),
				array('route' => 'profile/home', 'roles' => array('user')),
				array('route' => 'profile/list', 'roles' => array('user')),
				array('route' => 'profile/detail', 'roles' => array('user')),
				array('route' => 'profile/template1', 'roles' => array('user')),
				array('route' => 'profile/template2', 'roles' => array('user')),
				array('route' => 'profile/profile', 'roles' => array('user')),
				array('route' => 'profile/contact', 'roles' => array('user')),
				array('route' => 'profile/removeContact', 'roles' => array('user')),
				array('route' => 'profile/dashboard', 'roles' => array('user')),
				array('route' => 'profile/photoUpload', 'roles' => array('user')),
/*
				array('route' => 'request', 'roles' => array('user')),
				array('route' => 'request/index', 'roles' => array('user')),
				array('route' => 'request/list', 'roles' => array('user')),
				array('route' => 'request/home', 'roles' => array('user')),
				array('route' => 'request/dashboard', 'roles' => array('user')),
				array('route' => 'request/detail', 'roles' => array('user')),
				array('route' => 'request/detailv2', 'roles' => array('user')),
				array('route' => 'request/update', 'roles' => array('user')),
				array('route' => 'request/accountList', 'roles' => array('user')),
				array('route' => 'request/fill', 'roles' => array('user')),
				array('route' => 'request/contact', 'roles' => array('user')),
				array('route' => 'request/abandon', 'roles' => array('user')),
				array('route' => 'request/complete', 'roles' => array('user')),
				array('route' => 'request/propose', 'roles' => array('user')),
				array('route' => 'request/accept', 'roles' => array('user')),
				array('route' => 'request/decline', 'roles' => array('user')),
				array('route' => 'request/feedback', 'roles' => array('user')),
				array('route' => 'request/consultFeedback', 'roles' => array('user')),
				array('route' => 'request/cancel', 'roles' => array('user')),*/
				
				array('route' => 'survey/fill', 'roles' => array('guest')),
				array('route' => 'survey/template1', 'roles' => array('guest')),
				array('route' => 'survey/template2', 'roles' => array('guest')),
				array('route' => 'survey/selectTest', 'roles' => array('operational_management', 'sales_manager', 'manager')),
				array('route' => 'survey/inviteToTest', 'roles' => array('operational_management', 'sales_manager', 'manager')),
				array('route' => 'survey/newRequest', 'roles' => array('user')),
				array('route' => 'survey/patch', 'roles' => array('admin')),
			),
		),
	),

	'view_manager' => array(
		'strategies' => array(
			'ViewJsonStrategy',
		),
		'display_not_found_reason' => true,
		'display_exceptions'       => true,
		'doctype'                  => 'HTML5',       // On défini notre doctype
		'not_found_template'       => 'error/404',   // On indique la page 404
		'exception_template'       => 'error/index', // On indique la page en cas d'exception
		'template_map' => array(
			'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
		),
		'template_path_stack' => array(
			'ppit-flow' => __DIR__ . '/../view',
		),
	),
	
	'translator' => array(
		'locale' => 'fr_FR',
		'translation_file_patterns' => array(
			array(
				'type'     => 'phparray',
				'base_dir' => __DIR__ . '/../language',
				'pattern'  => '%s.php',
				'text_domain' => 'ppit-flow'
			),
			array(
				'type' => 'phpArray',
				'base_dir' => './vendor/zendframework/zendframework/resources/languages/',
				'pattern'  => 'fr/Zend_Validate.php',
			),
		),
	),

	'ppitApplications' => array(
		'frontOffice' => array(
			'labels' => array('fr_FR' => 'Front office', 'en_US' => 'Front office'),
			'url' => 'flowEvent',
		),
	),
	
	'landing_account_type' => 'generic',
	
	'matching/skills' => array(
		'blockchain' => ['labels' => ['default' => 'Blockchain'], 'color' => 'aqua-gradient'],
		'brainstorming' => ['labels' => ['default' => 'Brainstorming'], 'color' => 'purple-gradient'],
		'bi' => ['labels' => ['default' => 'Business Intelligence'], 'color' => 'aqua-gradient'],
		'business_model' => ['labels' => ['default' => 'Business Model'], 'color' => 'blue-gradient'],
		'coaching' => ['labels' => ['default' => 'Coaching'], 'color' => 'purple-gradient'],
		'communication' => ['labels' => ['default' => 'Communication'], 'color' => 'purple-gradient'],
		'crypto' => ['labels' => ['default' => 'Crypto'], 'color' => 'aqua-gradient'],
		'data_scientist' => ['labels' => ['default' => 'Data scientist'], 'color' => 'aqua-gradient'],
		'design_thinking' => ['labels' => ['default' => 'Design thinking'], 'color' => 'blue-gradient'],
		'web_dev' => ['labels' => ['default' => 'Web development'], 'color' => 'aqua-gradient'],
		'facilitation' => ['labels' => ['default' => 'Facilitation'], 'color' => 'peach-gradient'],
		'feedback' => ['labels' => ['default' => 'Feedback'], 'color' => 'peach-gradient'],
		'training' => ['labels' => ['default' => 'Training', 'fr_FR' => 'Formation'], 'color' => 'purple-gradient'],
		'gdpr' => ['labels' => ['default' => 'GDPR'], 'color' => 'blue-gradient'],
		'project_management' => ['labels' => ['default' => 'Project management', 'fr_FR' => 'Gestion de projet'], 'color' => 'purple-gradient'],
		'graphics' => ['labels' => ['default' => 'Graphics', 'fr_FR' => 'Graphisme'], 'color' => 'aqua-gradient'],
		'kyc' => ['labels' => ['default' => 'KYC'], 'color' => 'blue-gradient'],
		'lean_startup' => ['labels' => ['default' => 'Lean startup'], 'color' => 'purple-gradient'],
		'connecting' => ['labels' => ['default' => 'Connecting', 'fr_FR' => 'Mise en relation'], 'color' => 'peach-gradient'],
		'critical_eye' => ['labels' => ['default' => 'Critical eye', 'fr_FR' => 'Oeil critique'], 'color' => 'peach-gradient'],
		'optimization' => ['labels' => ['default' => 'Optimization', 'fr_FR' => 'Optimisation'], 'color' => 'blue-gradient'],
		'process' => ['labels' => ['default' => 'Process', 'fr_FR' => 'Processus'], 'color' => 'purple-gradient'],
		'pitch' => ['labels' => ['default' => 'Pitch'], 'color' => 'purple-gradient'],
		'python' => ['labels' => ['default' => 'Python'], 'color' => 'aqua-gradient'],
		'it_security' => ['labels' => ['default' => 'IT security', 'fr_FR' => 'Sécurité IT'], 'color' => 'aqua-gradient'],
		'statistics' => ['labels' => ['default' => 'Statistics', 'fr_FR' => 'Statistique'], 'color' => 'aqua-gradient'],
		'application_testing' => ['labels' => ['default' => 'Application testing', 'fr_FR' => 'Tests d\'application'], 'color' => 'aqua-gradient'],
		'ux_design' => ['labels' => ['default' => 'UX Design'], 'color' => 'purple-gradient'],
		'vba' => ['labels' => ['default' => 'VBA'], 'color' => 'aqua-gradient'],
		'legal' => ['labels' => ['default' => 'Legal', 'fr_FR' => 'Juridique'], 'color' => 'blue-gradient'],
		'surveys' => ['labels' => ['default' => 'Surveys', 'fr_FR' => 'Sondages'], 'color' => 'purple-gradient'],
		'marketing' => ['labels' => ['default' => 'Marketing'], 'color' => 'purple-gradient'],
		'customer_relationship' => ['labels' => ['default' => 'Customer relationship', 'fr_FR' => 'Relation client'], 'color' => 'purple-gradient'],
		'labour_sociology' => ['labels' => ['default' => 'Sociology of labour', 'fr_FR' => 'Sociologie du travail'], 'color' => 'blue-gradient'],
		'hr' => ['labels' => ['default' => 'Human resources', 'fr_FR' => 'Ressources humaines'], 'color' => 'blue-gradient'],
		'team_mangement' => ['labels' => ['default' => 'Team management', 'fr_FR' => 'Management d\'équipes'], 'color' => 'purple-gradient'],
		'agility' => ['labels' => ['default' => 'Agility', 'fr_FR' => 'Agilité'], 'color' => 'purple-gradient'],
		'training_engineering' => ['labels' => ['default' => 'Training engineering', 'fr_FR' => 'Ingénierie de formation'], 'color' => 'blue-gradient'],
	),

	// Request

	'event/event/property/status' => array(
		'definition' => 'inline',
		'type' => 'select',
		'modalities' => array(
			'new' => array('en_US' => 'New', 'fr_FR' => 'Nouveau'),
			'connected' => array('en_US' => 'Organized', 'fr_FR' => 'Organisé'),
			'realized' => array('en_US' => 'Realized', 'fr_FR' => 'Réalisé'),
			'completed' => array('en_US' => 'Completed', 'fr_FR' => 'Finalisé'),
			'canceled' => array('en_US' => 'Canceled', 'fr_FR' => 'Annulé'),
		),
		'labels' => array(
			'en_US' => 'Status',
			'fr_FR' => 'Statut',
		),
		'perspectives' => array(
			'generic' => array('new', 'connected', 'realized', 'completed', 'canceled'),
		),
	),

	'event/event/property/category' => array(
		'definition' => 'inline',
		'type' => 'select',
		'modalities' => array(
			'information' => ['default' => 'Informations', 'fr_FR' => 'Informations'],
			'pro_bono_day' => ['default' => 'Pro bono day', 'fr_FR' => 'Pro bono day'],
			'innovation' => ['default' => 'Innovation', 'fr_FR' => 'Inovation'],
			'team_building' => ['default' => 'Team building', 'fr_FR' => 'Team building'],
		),
		'labels' => array(
			'en_US' => 'Event type',
			'fr_FR' => 'Type d’événement',
		),
	),
	
	'event/event/property/account_id' => array(
		'definition' => 'inline',
		'type' => 'select',
		'account_type' => 'pbc',
		'labels' => array(
			'en_US' => 'Owner account',
			'fr_FR' => 'Compte propriétaire',
		),
	),

	'event/event/property/account_status' => array(
		'definition' => 'core_account/generic/property/status',
		'labels' => array(
			'en_US' => 'Account status',
			'fr_FR' => 'Statut du compte',
		),
	),
	
	'event/event/property/caption' => array(
		'definition' => 'inline',
		'type' => 'input',
		'labels' => array(
			'en_US' => 'Event title',
			'fr_FR' => 'Titre de l’évènement',
		),
	),

	'event/event/property/matched_accounts' => array(
		'definition' => 'inline',
		'type' => 'multiselect',
		'account_type' => 'generic',
		'labels' => array(
			'en_US' => 'Matched accounts',
			'fr_FR' => 'Comptes connectés',
		),
	),
	
	'event/event/property/property_1' => array(
		'definition' => 'inline',
		'type' => 'input',
		'labels' => array(
			'en_US' => 'Skills',
			'fr_FR' => 'Compétences',
		),
	),
	
	'event/event/property/property_2' => array(
		'definition' => 'inline',
		'type' => 'multiselect',
		'modalities' => ['definition' => 'matching/skills'],
		'labels' => array(
			'en_US' => 'Keyword skills',
			'fr_FR' => 'Compétences mot-clés',
		),
	),
	
	'event/event/property/property_3' => array(
		'definition' => 'inline',
		'type' => 'input',
		'labels' => array(
			'default' => 'Targeted participants',
			'fr_FR' => 'Participants ciblés',
		),
	),

	'event/event/property/property_20' => array(
		'definition' => 'inline',
		'type' => 'input',
		'labels' => array(
			'default' => 'Logistic constraints',
			'fr_FR' => 'Contraintes logistiques',
		),
	),
	
	'event/event/property/update_time' => array(
		'definition' => 'inline',
		'type' => 'datetime',
		'labels' => array(
			'en_US' => 'Update time',
			'fr_FR' => 'Heure de mise à jour',
		),
	),
	
	'event/event' => array(
		'statuses' => array(),
		'dimensions' => array(),
		'indicators' => array(),
		'properties' => array(
			'status', 'type', 'place_id', 'place_caption', 'account_id', 'n_fn', 'n_first', 'n_last', 'email', 'category', 'subcategory', 'identifier', 'caption', 'description',
			'begin_date', 'end_date', 'day_of_week', 'day_of_month', 'exception_1', 'exception_2', 'exception_3', 'exception_4', 'begin_time', 'end_time', 'time_zone', 'location', 'latitude', 'longitude',
			'matched_accounts', 'matching_log', 'rewards', 'feedbacks', 'value', 'comments',
			'property_1', 'property_2', 'property_3', 'property_20',
			'account_status', 'account_property_1', 'account_property_2', 'account_property_3', 'account_property_4', 'account_property_5', 'account_property_6', 'account_property_7', 'account_property_8', 'account_property_9', 'account_property_10', 'account_property_11', 'account_property_12', 'account_property_13', 'account_property_14', 'account_property_15', 'account_property_16',
			'update_time'
		),
		'options' => [],
	),
	
	'event/search/event' => array(
		'title' => array('default' => 'Events', 'fr_FR' => 'Événements'),
		'todoTitle' => array('default' => 'current', 'fr_FR' => 'en cours'),
		'searchTitle' => array('default' => 'search', 'fr_FR' => 'recherche'),
		'properties' => array(
			'status' => ['multiple' => true],
			'account_id' => [],
			'caption' => [],
			'category' => [],
			'begin_date' => [],
			'location' => [],
			'property_2' => [],
			'matched_accounts' => [],
		),
	),
	
	'event/list/event' => array(
		'status' => [],
		'account_id' => [],
		'matched_accounts' => [],
		'update_time' => [],
		'caption' => [],
		'category' => [],
		'begin_date' => [],
		'end_date' => [],
		'location' => [],
	),
	
	'event/update/event' => array(
		'status' => ['mandatory' => true],
		'account_id' => ['mandatory' => true],
		'caption' => [],
		'category' => [],
		'begin_date' => [],
		'end_date' => [],
		'begin_time' => [],
		'end_time' => [],
		'location' => [],
		'description' => [],
		'property_1' => [],
		'property_2' => [],
		'property_3' => [],
		'property_20' => [],
		'matched_accounts' => [],
	),
	
	'event/export/event' => array(
		'status' => 'A',
		'account_id' => 'B',
		'matched_accounts' => 'C',
		'caption' => 'D',
		'category' => 'E',
		'begin_date' => 'F',
		'end_date' => 'G',
		'begin_time' => 'H',
		'end_time' => 'I',
		'location' => 'J',
		'description' => 'K',
		'property_1' => 'L',
		'property_2' => 'M',
		'property_3' => 'N',
		'property_20' => 'O',
		'matching_log' => 'P',
		'rewards' => 'Q',
		'feedbacks' => 'R',
	),
);
