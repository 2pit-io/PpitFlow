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
					'close' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/close[/:type][/:id]',
							'defaults' => array('action' => 'close'),
						),
					),
					'open' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/open[/:type][/:id]',
							'defaults' => array('action' => 'open'),
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
					'update' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/update[/:account_id]',
							'defaults' => array('action' => 'update'),
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
				array('route' => 'flowEvent/fill', 'roles' => array('user')),
				array('route' => 'flowEvent/contact', 'roles' => array('user')),
				array('route' => 'flowEvent/abandon', 'roles' => array('user')),
				array('route' => 'flowEvent/propose', 'roles' => array('user')),
				array('route' => 'flowEvent/accept', 'roles' => array('user')),
				array('route' => 'flowEvent/decline', 'roles' => array('user')),
				array('route' => 'flowEvent/close', 'roles' => array('user')),
				array('route' => 'flowEvent/open', 'roles' => array('user')),
				array('route' => 'flowEvent/feedback', 'roles' => array('user')),
				array('route' => 'flowEvent/complete', 'roles' => array('user')),
				array('route' => 'flowEvent/consultFeedback', 'roles' => array('user')),
				array('route' => 'flowEvent/cancel', 'roles' => array('user')),
				
				array('route' => 'profile', 'roles' => array('user')),
				array('route' => 'profile/index', 'roles' => array('user')),
				array('route' => 'profile/home', 'roles' => array('user')),
				array('route' => 'profile/list', 'roles' => array('user')),
				array('route' => 'profile/detail', 'roles' => array('user')),
				array('route' => 'profile/update', 'roles' => array('user')),
				array('route' => 'profile/template1', 'roles' => array('user')),
				array('route' => 'profile/template2', 'roles' => array('user')),
				array('route' => 'profile/profile', 'roles' => array('user')),
				array('route' => 'profile/contact', 'roles' => array('user')),
				array('route' => 'profile/removeContact', 'roles' => array('user')),
				array('route' => 'profile/dashboard', 'roles' => array('user')),
				array('route' => 'profile/photoUpload', 'roles' => array('user')),
				
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

	'ppit_roles' => array(
		'ambassador' => array(
			'route' => 'place',
			'show' => true,
			'labels' => array(
				'en_US' => 'Ambassador',
				'fr_FR' => 'Ambassadeur',
			)
		),
		'contributor' => array(
			'route' => 'place',
			'show' => true,
			'labels' => array(
				'en_US' => 'Contributor',
				'fr_FR' => 'Contributeur',
			)
		),
	),
	
	// Account Pro bono corpo
	
	'core_account/pbc/property/status' => array(
		'definition' => 'inline',
		'type' => 'select',
		'modalities' => array(
			'suspect' => array('en_US' => 'Suspect (landing page)', 'fr_FR' => 'Suspect (landing page)'),
			'new' => array('en_US' => 'New', 'fr_FR' => 'Nouveau'),
			'interested' => array('en_US' => 'Interested', 'fr_FR' => 'Intéressé'),
			'registered' => array('en_US' => 'Registered', 'fr_FR' => 'Enregistré'),
			'active' => array('en_US' => 'Active', 'fr_FR' => 'Actif'),
			'gone' => array('en_US' => 'Gone', 'fr_FR' => 'Parti'),
		),
		'labels' => array(
			'en_US' => 'Status',
			'fr_FR' => 'Statut',
		),
		'perspectives' => array(
			'contact' => array('suspect', 'new', 'registered', 'interested', 'active', 'gone'),
			'account' => array('registered', 'active'),
		),
	),
	
	'core_account/pbc/property/origine' => array(
		'definition' => 'inline',
		'type' => 'select',
		'modalities' => array(
			'outcoming' => array('en_US' => 'Pro bono corpo call', 'fr_FR' => 'Appel Pro bono corpo'),
			'e_mailing' => array('en_US' => 'Mailing Pro bono corpo', 'fr_FR' => 'Mailing Pro bono corpo'),
			'cooptation' => array('en_US' => 'Referal', 'fr_FR' => 'Recommendation'),
			'event' => array('en_US' => 'Event', 'fr_FR' => 'Événement'),
			'social_network' => array('en_US' => 'Jive/SBC', 'fr_FR' => 'Jive/SBC'),
			'subscription' => array('en_US' => 'Pro bono corpo site', 'fr_FR' => 'Site Pro bono corpo'),
			'other' => array('en_US' => 'Other', 'fr_FR' => 'Autre'),
		),
		'labels' => array(
			'en_US' => 'Origine',
			'fr_FR' => 'Origine',
		),
	),
	
	'core_account/pbc/property/property_1' => array(
		'definition' => 'inline',
		'type' => 'multiselect',
		'modalities' => array(
			'contributor' => ['default' => 'Contributor', 'fr_FR' => 'Contributeur'],
			'requestor' => ['default' => 'Requestor', 'fr_FR' => 'Demandeur'],
		),
		'labels' => ['default' => 'Role']
	),
	
	'core_account/pbc/property/property_2' => array(
		'definition' => 'inline',
		'type' => 'input',
		'labels' => array(
			'en_US' => 'Matched accounts',
			'fr_FR' => 'Comptes connectés',
		),
	),
	
	'core_account/pbc/property/profile_tiny_1' => array(
		'definition' => 'inline',
		'type' => 'input',
		'labels' => ['default' => 'Service', 'fr_FR' => 'Service'],
	),
	
	'core_account/pbc/property/profile_tiny_2' => array(
		'definition' => 'inline',
		'type' => 'multiselect',
		'modalities' => ['definition' => 'matching/skills'],
		'labels' => ['default' => 'Compétences par mots-clés'],
	),
	
	'core_account/pbc/property/profile_tiny_3' => array(
		'definition' => 'inline',
		'type' => 'input',
		'labels' => ['default' => 'Skills in text', 'fr_FR' => 'Compétences texte libre'],
	),
	
	'core_account/pbc/property/profile_tiny_4' => array(
		'definition' => 'inline',
		'type' => 'input',
		'labels' => ['default' => 'Location', 'fr_FR' => 'Localisation'],
	),
	
	'core_account/pbc/property/profile_tiny_5' => array(
		'definition' => 'inline',
		'type' => 'input',
		'labels' => ['default' => 'Personal catcher', 'fr_FR' => 'Accroche personnelle'],
	),
	
	'core_account/pbc/property/completeness' => array(
		'definition' => 'inline',
		'type' => 'computed',
		'modalities' => array(
			'0_not_completed' => ['default' => 'Not completed', 'fr_FR' => 'Non renseigné'],
			'1_minimum' => ['default' => 'Minimum', 'fr_FR' => 'Minimal'],
			'2_intermediary' => ['default' => 'Intermediary', 'fr_FR' => 'Intermédiaire'],
			'3_completed' => ['default' => 'Completed', 'fr_FR' => 'Complété'],
		),
		'function' => '\PpitFlow\Model\AccountPbc::computeCompleteness',
		'labels' => array(
			'en_US' => 'Profile completeness',
			'fr_FR' => 'Complétude du profil',
		),
	),
	
	'core_account/pbc' => array(
		'properties' => array(
			'status', 'place_id', 'contact_1_id', 'n_first', 'n_last', 'n_fn', 'email', 'tel_work', 'next_meeting_date', 'origine', 'contact_history', 'locale',
			'property_1', 'property_2',
			'profile_tiny_1', 'profile_tiny_2', 'profile_tiny_3', 'profile_tiny_4', 'profile_tiny_5',
			'json_property_1', 'json_property_2', 'json_property_3', 'json_property_4', 'json_property_5',
			'comment_1', 'comment_2', 'comment_3', 'comment_4', 'update_time',
			'completeness',
		),
		'acl' => array(
			'place_id' => array('application' => 'p-pit-admin', 'category' => 'place_id'),
		),
		'order' => 'n_fn',
	),
	
	'core_account/search/pbc' => array(
		'properties' => array(
			'place_id' => [],
			'status' => ['multiple' => true],
			'property_1' => [],
			'profile_tiny_1' => [],
			'profile_tiny_2' => [],
			'profile_tiny_3' => [],
			'profile_tiny_4' => [],
			'n_fn' => [],
			'email' => [],
			'next_meeting_date' => [],
			'origine' => [],
			'locale' => [],
		),
	),
	
	'core_account/list/pbc' => array(
		'properties' => array(
			'status' => array(
				'background-color' => array(
					'LightGreen' => ['status' => 'new'],
					'LightSalmon' => ['status' => 'interested'],
					'LightBlue' => ['status' => 'candidate'],
					'LightGrey' => ['status' => 'gone'],
				)
			),
			'completeness' => [],
			'n_fn' => [],
			'email' => [],
			'property_1' => [],
			'profile_tiny_1' => [],
			'profile_tiny_2' => [],
			'profile_tiny_3' => [],
			'profile_tiny_4' => [],
			'origine' => [],
			'next_meeting_date' => [],
		),
	),
	
	'core_account/detail/pbc' => array(
		'title' => array('en_US' => 'Contributor detail', 'fr_FR' => 'Détail du contributeur'),
		'displayAudit' => true,
		'tabs' => array(
		),
	),
	
	'core_account/update/pbc' => array(
		'place_id' => ['mandatory' => false],
		'status' => ['mandatory' => true],
		'n_first' => ['mandatory' => true],
		'n_last' => ['mandatory' => true],
		'email' => ['mandatory' => false],
		'tel_work' => ['mandatory' => false],
		'property_1' => ['mandatory' => false],
		'profile_tiny_1' => ['mandatory' => false],
		'profile_tiny_2' => ['mandatory' => false],
		'profile_tiny_3' => ['mandatory' => false],
		'profile_tiny_4' => ['mandatory' => false],
		'profile_tiny_5' => ['mandatory' => false],
		'property_2' => ['readonly' => true],
		'origine' => ['mandatory' => false],
		'next_meeting_date' => ['mandatory' => false],
		'contact_history' => ['mandatory' => false],
		'locale' => ['mandatory' => false],
	),
	
	'core_account/updateContact/pbc' => array(
	),
	
	'core_account/groupUpdate/pbc' => array(
		'status' => [],
		'next_meeting_date' => [],
	),
	
	'core_account/export/pbc' => array(
		'place_id' => [],
		'status' => [],
		'completeness' => [],
		'n_first' => [],
		'n_last' => [],
		'email' => [],
		'property_1' => [],
		'profile_tiny_2' => [],
		//		'json_property_1' => [],
		'profile_tiny_3' => [],
		'profile_tiny_4' => [],
		'profile_tiny_5' => [],
		'origine' => [],
		'next_meeting_date' => [],
		'contact_history' => [],
		'locale' => [],
	),
	
	'core_account/pbc/property/json_property_2' => array(
		'definition' => 'inline',
		'type' => 'multiselect',
		'modalities' => array(
			'en' => ['default' => 'English', 'fr_FR' => 'Anglais'],
			'fr' => ['default' => 'French', 'fr_FR' => 'Français'],
			'ro' => ['default' => 'Romanian', 'fr_FR' => 'Roumain'],
		),
		'labels' => ['default' => 'Langues']
	),
	
	'core_account/indexCard/pbc' => array(
		'title' => array('en_US' => 'Client index card', 'fr_FR' => 'Fiche client'),
		'header' => array(
			'place_id' => null,
			'status' => null,
			'origine' => null,
		),
		'1st-column' => array(
			'title' => 'title_1',
			'rows' => array(
				'n_title' => [],
				'n_first' => [],
				'n_last' => [],
				'email' => [],
				'tel_work' => [],
				'tel_cell' => [],
				'adr_street' => [],
				'adr_extended' => [],
				'adr_post_office_box' => [],
				'adr_zip' => [],
				'adr_city' => [],
				'adr_state' => [],
				'adr_country' => [],
			),
		),
		'2nd-column' => array(
			'title' => 'title_2',
			'rows' => array(
			),
		),
		'pdfDetailStyle' => '
<style>
table.note-report {
	font-size: 1em;
	border: 1px solid gray;
}
table.note-report th {
	color: #FFF;
	font-weight: bold;
	text-align: center;
	vertical-align: center;
	border: 1px solid gray;
	background-color: #006169;
}
	
table.note-report td {
	color: #666;
	border: 1px solid gray;
}
</style>
',
	),
	
	// Event

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
			'innovation' => ['default' => 'Innovation', 'fr_FR' => 'Innovation'],
			'team_building' => ['default' => 'Team building', 'fr_FR' => 'Team building'],
		),
		'values' => array(
			'information' => 1,
			'pro_bono_day' => 2,
			'innovation' => 3,
			'team_building' => 4,
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

	// Request
	
	'event/request/property/status' => array(
		'definition' => 'inline',
		'type' => 'select',
		'modalities' => array(
			'new' => array('en_US' => 'New', 'fr_FR' => 'Nouveau'),
			'connected' => array('en_US' => 'Matching initiated', 'fr_FR' => 'Contact amorcé'),
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
	
	'event/request/property/account_id' => array(
		'definition' => 'inline',
		'type' => 'select',
		'account_type' => 'pbc',
		'labels' => array(
			'en_US' => 'Owner account',
			'fr_FR' => 'Compte propriétaire',
		),
	),
	
	'event/request/property/account_status' => array(
		'definition' => 'core_account/pbc/property/status',
		'labels' => array(
			'en_US' => 'Account status',
			'fr_FR' => 'Statut du compte',
		),
	),
	
	'event/request/property/caption' => array(
		'definition' => 'inline',
		'type' => 'input',
		'labels' => array(
			'en_US' => 'Request title',
			'fr_FR' => 'Titre de la demande',
		),
	),
	
	'event/request/property/matched_accounts' => array(
		'definition' => 'inline',
		'type' => 'multiselect',
		'account_type' => 'pbc',
		'labels' => array(
			'en_US' => 'Matched accounts',
			'fr_FR' => 'Comptes connectés',
		),
	),
	
	'event/request/property/property_1' => array(
		'definition' => 'inline',
		'type' => 'input',
		'labels' => array(
			'en_US' => 'Skills',
			'fr_FR' => 'Compétences',
		),
	),
	
	'event/request/property/property_2' => array(
		'definition' => 'inline',
		'type' => 'multiselect',
		'modalities' => ['definition' => 'matching/skills'],
		'labels' => array(
			'en_US' => 'Keyword skills',
			'fr_FR' => 'Compétences mot-clés',
		),
	),
	
	'event/request/property/property_3' => array(
		'definition' => 'inline',
		'type' => 'select',
		'modalities' => array(
			'information' => ['default' => 'Informations', 'fr_FR' => 'Informations'],
			'connecting' => ['default' => 'Connecting', 'fr_FR' => 'Mise en relation'],
			'expert_opinion' => ['default' => 'Expert d\'opinion', 'fr_FR' => 'Avis d’Expert'],
			'solution_building' => ['default' => 'Solution building', 'fr_FR' => 'Construction de solution'],
			'troubleshooting' => ['default' => 'Troubleshooting', 'fr_FR' => 'Dépannage'],
			'do_not_know' => ['default' => 'I don\'t know', 'fr_FR' => 'Je ne sais pas'],
		),
		'labels' => array(
			'en_US' => 'Request type',
			'fr_FR' => 'Type de demande',
		),
	),
	
	'event/request/property/property_4' => array(
		'definition' => 'inline',
		'type' => 'input',
		'labels' => array(
			'default' => 'Targeted contributors',
			'fr_FR' => 'Contributeurs ciblés',
		),
	),
	
	'event/request/property/property_5' => array(
		'definition' => 'inline',
		'type' => 'date',
		'labels' => array(
			'default' => 'Execution begin',
			'fr_FR' => 'Début d\'intervention',
		),
	),
	
	'event/request/property/property_6' => array(
		'definition' => 'inline',
		'type' => 'input',
		'labels' => array(
			'default' => 'Estimated contribution duration',
			'fr_FR' => 'Durée estimée de contribution',
		),
	),
	
	'event/request/property/property_7' => array(
		'definition' => 'inline',
		'type' => 'input',
		'labels' => array(
			'default' => 'Contribution location',
			'fr_FR' => 'Localisation de la contribution',
		),
	),
	
	'event/request/property/property_24' => array(
		'definition' => 'inline',
		'type' => 'textarea',
		'labels' => array(
			'default' => 'Context and objectives',
			'fr_FR' => 'Contexte et objectifs',
		),
	),
	
	'event/request/property/property_25' => array(
		'definition' => 'inline',
		'type' => 'textarea',
		'labels' => array(
			'default' => 'Description of the need',
			'fr_FR' => 'Détail du besoin',
		),
	),
	
	'event/request/property/property_26' => array(
		'definition' => 'inline',
		'type' => 'textarea',
		'labels' => array(
			'default' => 'Other logistic constraints',
			'fr_FR' => 'Autres contraintes logistiques',
		),
	),
	
	'event/request/property/update_time' => array(
		'definition' => 'inline',
		'type' => 'datetime',
		'labels' => array(
			'en_US' => 'Update time',
			'fr_FR' => 'Heure de mise à jour',
		),
	),
	
	'event/request' => array(
		'statuses' => array(),
		'dimensions' => array(),
		'indicators' => array(),
		'properties' => array(
			'status', 'type', 'place_id', 'place_caption', 'account_id', 'n_fn', 'n_first', 'n_last', 'email', 'locale', 'category', 'subcategory', 'identifier', 'caption', 'description',
			'begin_date', 'end_date', 'day_of_week', 'day_of_month', 'exception_1', 'exception_2', 'exception_3', 'exception_4', 'begin_time', 'end_time', 'time_zone', 'location', 'latitude', 'longitude',
			'matched_accounts', 'matching_log', 'feedbacks', 'value', 'comments',
			'property_1', 'property_2', 'property_3', 'property_4', 'property_5', 'property_6', 'property_7',
			'property_24', 'property_25', 'property_26',
			'account_status', 'account_property_1', 'account_property_2', 'account_property_3', 'account_property_4', 'account_property_5', 'account_property_6', 'account_property_7', 'account_property_8', 'account_property_9', 'account_property_10', 'account_property_11', 'account_property_12', 'account_property_13', 'account_property_14', 'account_property_15', 'account_property_16',
			'update_time'
		),
		'options' => [],
	),
	
	'event/search/request' => array(
		'title' => array('default' => 'Requests', 'fr_FR' => 'Demandes'),
		'todoTitle' => array('default' => 'current', 'fr_FR' => 'en cours'),
		'searchTitle' => array('default' => 'search', 'fr_FR' => 'recherche'),
		'properties' => array(
			'status' => ['multiple' => true],
			'account_id' => [],
			'caption' => [],
			'property_2' => [],
			'property_5' => [],
			'matched_accounts' => [],
		),
	),
	
	'event/list/request' => array(
		'status' => [],
		'account_id' => [],
		'matched_accounts' => [],
		'update_time' => [],
		'caption' => [],
		'property_2' => [],
		'property_3' => [],
		'property_4' => [],
		'property_5' => [],
		'property_6' => [],
		'property_7' => [],
	),
	
	'event/update/request' => array(
		'status' => ['mandatory' => true],
		'account_id' => ['mandatory' => true],
		'caption' => [],
		'property_24' => [],
		'property_25' => [],
		'property_2' => [],
		'property_3' => [],
		'property_4' => [],
		'property_5' => [],
		'property_6' => [],
		'property_7' => [],
		'property_26' => [],
		'matched_accounts' => [],
	),
	
	'event/export/request' => array(
		'status' => 'A',
		'account_id' => 'B',
		'matched_accounts' => 'C',
		'caption' => 'D',
		'property_24' => 'E',
		'property_25' => 'F',
		'property_2' => 'G',
		'property_3' => 'H',
		'property_4' => 'I',
		'property_5' => 'J',
		'property_6' => 'K',
		'property_7' => 'L',
		'property_26' => 'M',
		'matching_log' => 'N',
		'feedbacks' => 'O',
	),
	
	// Landing page
	
	'landing/generic' => array(
		'header' => array(
			'title' => ['default' => 'ProBonoCorpo - Skills', 'fr_FR' => 'ProBonoCorpo - Compétences'],
			'description' => array(
				'default' => 'Besoin occasionnel d\'expertise et/ou prêt à consacrer du temps pour aider un projet ? ProBonoCorpo valorise le savoir-faire et le service.',
				'fr_FR' => 'Occasionnel need for expertise and/or ready to give time and help a project? ProBonoCorpo makes value with the know-how and service spirit.',
			),
			'analytics-id' => 'UA-82264844-4',
			'campaign' => '1er sondage',
			'style' => array(
				'navbar' => 'background-color: transparent;',
				'topNavCollapse' => 'background-color: #ffffff;',
			),
			'navbar' => array(
				'class' => 'navbar navbar-expand-lg fixed-top scrolling-navbar navbar-black',
				'account' => true,
				'collapse' => false,
			),
			'logo' => array(
				'href' => 'landing/template2',
				'params' => ['place_identifier' => 'probonocorpo'],
				'src' => '/logos/probonocorpo/PBC-logo-web-fleur.png',
				'height' => 40,
				'alt' => 'probonocorpo logo',
			),
			'intro_height' => '100%',
			'background_image' => array(
				'mask' => '',
				'src' => ['default' => '/img/probonocorpo/groupe-en.jpg', 'fr_FR' => '/img/probonocorpo/groupe.jpg'],
				'class' => 'img-fluid',
				'alt' => 'Collaboration',
			),
			'locales' => ['fr_FR' => 'FR', 'en_US' => 'EN'],
		),
		'intro' => array(
			array(
				'type' => 'h4',
				'class' => 'd-flex justify-content-center text-responsive',
				'text' => array(
					'default' => '<span class="h4-responsive font-bold mb-2">LET\'S SHARE OUR SKILLS!</span>', 
					'fr_FR' => '<span class="h4-responsive font-bold mb-2">PARTAGEZ VOS TALENTS !</span>',
				),
			),
			array(
				'type' => 'div',
				'button' => ['id' => 'a_survey', 'href' => '#descr', 'class' => 'btn btn-outline-secondary'], 
				'text' => array(
					'default' => 'Discover',
					'fr_FR' => 'Découvrir',
				),
			),
			array('type' => 'br', 'class' => 'hr-light'),
			array('type' => 'br', 'class' => 'hr-light'),
			array('type' => 'br', 'class' => 'hr-light'),
			array('type' => 'br', 'class' => 'hr-light'),
			array('type' => 'br', 'class' => 'hr-light'),
			array('type' => 'br', 'class' => 'hr-light'),
		),
		'presentation' => array(
			array(
				'type' => 'feature-box',
				'margin' => false,
				'rows' => array(
					'columns' => array(
						array(
							'column-class' => 'col-md-12',
							'paragraphs' => array(
								array(
									'type' => 'h2',
									'class' => 'section-heading h2-responsive text-center text-uppercase grey-text',
									'text' => array(
										'default' => 'Probono corpo makes collaboration and mutual aid easier',
										'fr_FR' => 'Probono corpo facilite la collaboration et l’entraide',
									),
								),
							),
						),
						array(
							'column-class' => 'col-lg-12',
							'paragraphs' => array(
								array(
									'class' => 'px-3 py-3',
									'style' => 'background-color: #98BD29',
									'type' => 'div',
									'text' => array(
										'default' => '
<!-- Category -->
<!-- Post title -->
<h2 class="section-heading h2-responsive my-4 text-center text-uppercase font-weight-bold" style="color: #FFF;">The challenges for the business</h2>
<!-- Excerpt -->
<h5 class="h5-responsive my-3"><span style="color: #007837;"><i class="fa fa-check pr-2"></i></span>Share and pass on the skills</h5>
<h5 class="h5-responsive my-3"><span style="color: #007837;"><i class="fa fa-check pr-2"></i></span>Quickly mobilize resources that fit the need</h5>
<h5 class="h5-responsive my-3"><span style="color: #007837;"><i class="fa fa-check pr-2"></i></span>Help engagement with an agile and innovative organization</h5>
', 
										'fr_FR' => '
<!-- Category -->
<!-- Post title -->
<h2 class="section-heading h2-responsive my-4 text-center text-uppercase font-weight-bold" style="color: #FFF;">Les challenges pour l’entreprise</h2>
<!-- Excerpt -->
<h5 class="h5-responsive my-3"><span style="color: #007837;"><i class="fa fa-check pr-2"></i></span>Partager et transmettre les compétences</h5>
<h5 class="h5-responsive my-3"><span style="color: #007837;"><i class="fa fa-check pr-2"></i></span>Mobiliser rapidement des ressources au plus près des besoins</h5>
<h5 class="h5-responsive my-3"><span style="color: #007837;"><i class="fa fa-check pr-2"></i></span>Favoriser l’engagement par une organisation agile et innovante</h5>
',
									),
								),
							),
						),
					),
				),
			),
		),
		'form' => array(
			'introduction' => [],
			'inputs' => array(
				'property_1_contributor' => ['definition' => 'inline', 'type' => 'checkbox', 'class' => 'col-md-3', 'property_id' => 'property_1', 'value' => 'contributor', 'labels' => ['default' => 'Contributor', 'fr_FR' => 'Contributeur']],
				'property_1_requestor' => ['definition' => 'inline', 'type' => 'checkbox', 'class' => 'col-md-3', 'property_id' => 'property_1', 'value' => 'requestor', 'labels' => ['default' => 'Requestor', 'fr_FR' => 'Demandeur']],
				'email' => ['mandatory' => true, 'updatable' => false],
			),
			'submit' => array(
				'class' => 'btn btn-light-blue btn-rounded',
				'labels' => ['default' => 'Submit', 'fr_FR' => 'Soumettre'],
			),
		),
		'contact_section' => array(
			'location' => ['label' => ['default' => 'Paris, France']],
			'email' => ['label' => ['default' => 'contact@2pit.io']],
		),
		'footer' => array(
			'links' => array(
				'column_1' => array(
					'title' => ['default' => 'Resources', 'fr_FR' => 'Ressources'],
					'list' => array(
					),
				)
			),
			'copyright' => array(
				'class' => 'footer-copyright py-3 text-center container-fluid',
				'html' => ['default' => '© 2018 Copyright: <a href="https://github.com/2pit-io/PpitCore/blob/master/license.txt"> 2pit.io </a>&nbsp;&nbsp;|&nbsp;&nbsp;Graphism <a href="https://illustration-lopresti.com" target="_blank">illustration-lopresti.com</a>'],
			),
		),
	),
	
	// Profile
	
	'profile/generic' => array(
		'intro' => array(
		),
		'form' => array(
			'incentive' => array(
				array(
					'type' => 'p',
					'class' => 'section-description text-warning',
					'text' => array(
						'default' => 'We invite you to declare at least one skill or a short personal sentence for a start. You can come back on your profile and complete after.',
						'fr_FR' => 'Nous t’invitons à saisir au moins une compétence ou une petite phrase pour commencer. Tu pourras revenir sur ton profil pour compléter ensuite.',
					),
				),
			),
			'inputs' => array(
				'n_first' => ['class' => 'col-md-6', 'focused' => true],
				'n_last' => ['class' => 'col-md-6'],
				'email' => ['class' => 'col-md-6', 'protected' => true],
				'tel_work' => ['class' => 'col-md-6', 'protected' => true],
				'locale' => ['class' => 'col-md-6'],
				'tiny_1' => ['class' => 'col-md-6', 'definition' => 'inline', 'type' => 'input', 'labels' => ['default' => 'Service', 'fr_FR' => 'Service']],
				'tiny_4' => ['class' => 'col-md-6', 'definition' => 'inline', 'type' => 'input', 'labels' => ['default' => 'Location', 'fr_FR' => 'Localisation']],
				'tiny_3' => ['feature' => 'skill', 'class' => 'col-md-6', 'definition' => 'inline', 'type' => 'keywords', 'labels' => ['default' => 'My skills / wishes', 'fr_FR' => 'Que souhaitez-vous partager (compétences / appétences)'], 'placeholder' => ['default' => 'Ex. finance, design thinking, video editing...', 'fr_FR' => 'Ex. finance, design thinking, montage vidéo...']],
				'tiny_2' => ['feature' => 'keyword_skill', 'class' => 'col-md-12', 'definition' => 'inline', 'type' => 'chips', 'repository' => 'matching/skills', 'trigger' => 'tiny_3'],
				'tiny_5' => ['class' => 'col-md-12', 'definition' => 'inline', 'type' => 'input', 'labels' => ['default' => 'A personal catcher typical of you', 'fr_FR' => 'Une accroche personnelle ou une citation qui vous caractérise']],
			),
			'update' => array(
				'class' => 'btn btn-light-blue btn-rounded',
				'labels' => ['default' => 'Update the file', 'fr_FR' => 'Modifier la fiche'],
			),
			'submit' => array(
				'class' => 'btn btn-light-blue btn-rounded',
				'labels' => ['default' => 'Register', 'fr_FR' => 'Enregistrer'],
			),
			'legal' => array(
				array(
					'type' => 'p',
					'class' => 'section-description',
					'text' => array(
						'default' => 'The informations provided here will not be communicated to anyone. They will never been communicated to third-parts without your agreement. For more information, contact us on <a href="mailto:contact@2pit.io?subject=Request for informations about data privacy in Pro Bono Corpo">contact@2pit.io</a>.',
						'fr_FR' => 'Les informations saisies sont uniquement destinées à améliorer la mise en relation. Elles ne peuvent en aucun cas être communiquées à des tiers sans votre consentement. Pour en savoir plus, consultez nous sur <a href="mailto:contact@2pit.io?subject=Demande d\'informations sur la protection des données dans Pro Bono Corpo">contact@2pit.io</a>.',
					),
				),
			),
		),
		'detail' => array(
			'introduction' => array(
			),
			'properties' => array(
				'n_first' => ['class' => 'col-md-6', 'focused' => true],
				'n_last' => ['class' => 'col-md-6'],
				'email' => ['class' => 'col-md-6', 'protected' => true],
				'tel_work' => ['class' => 'col-md-6', 'protected' => true],
				'tiny_1' => ['class' => 'col-md-6', 'definition' => 'inline', 'type' => 'input', 'labels' => ['default' => 'Service', 'fr_FR' => 'Service']],
				'tiny_4' => ['class' => 'col-md-6', 'definition' => 'inline', 'type' => 'input', 'labels' => ['default' => 'Location', 'fr_FR' => 'Localisation']],
				'tiny_3' => ['feature' => 'skill', 'class' => 'col-md-6', 'definition' => 'inline', 'type' => 'keywords', 'labels' => ['default' => 'My skills / wishes', 'fr_FR' => 'Que souhaitez-vous partager (compétences / appétences)'], 'placeholder' => ['default' => 'Ex. finance, design thinking, video editing...', 'fr_FR' => 'Ex. finance, design thinking, montage vidéo...']],
				'tiny_2' => ['feature' => 'keyword_skill', 'class' => 'col-md-12', 'definition' => 'inline', 'type' => 'chips', 'repository' => 'matching/skills', 'trigger' => 'tiny_3'],
			),
			'actions' => array(
				'contact' => ['labels' => ['default' => 'Contact', 'fr_FR' => 'Contacter']],
				'abandon' => ['labels' => ['default' => 'Abandon the contact', 'fr_FR' => 'Abandonner le contact']],
				'accept' => ['labels' => ['default' => 'Accept the proposal', 'fr_FR' => 'Accepter la proposition']],
				'decline' => ['labels' => ['default' => 'Decline the proposal', 'fr_FR' => 'Décliner la proposition']],
				'feedback' => ['labels' => ['default' => 'Give a feedback', 'fr_FR' => 'Donner un feedback']],
			),
			'legal' => array(
			),
		),
		'list' => array(
			'properties' => array(
				'email' => ['protected' => true],
				'tel_work' => ['protected' => true],
				'profile_tiny_1' => ['labels' => ['default' => 'Service', 'fr_FR' => 'Service']],
				'profile_tiny_4' => ['labels' => ['default' => 'Location', 'fr_FR' => 'Localisation']],
				'profile_tiny_3' => ['definition' => 'inline', 'type' => 'input', 'labels' => ['default' => 'My skills / wishes', 'fr_FR' => 'Compétences / appétences']],
				'profile_tiny_2' => ['definition' => 'inline', 'type' => 'chips', 'repository' => 'matching/skills'],
			),
		),
		'contact_section' => array(
			'location' => ['label' => ['default' => 'Paris, France']],
			'email' => ['label' => ['default' => 'contact@2pit.io']],
		),
	
		'tooltips' => array(
			'#photo_upload' => ['data-placement' => 'right', 'title' => ['default' => 'You can upload your photo by clicking in this place', 'fr_FR' => 'Vous pouvez télécharger votre photo en cliquant sur cet emplacement']],
			'#property_3' => ['data-placement' => 'right', 'title' => ['default' => 'Type a few character and choose some keywords. You can also input in free text', 'fr_FR' => 'Saisissez quelques caractères et choisissez dans la liste. Vous pouvez également saisir en texte libre']],
		),
		'footer' => array(
			'links' => array(
				'column_1' => array(
					'title' => ['default' => 'Resources', 'fr_FR' => 'Ressources'],
					'list' => array(
						'charter' => array(
							'href' => ['route' => 'instance/charter'],
							'target' => 'modal',
							'data-target' => 'modalShowCharterForm',
							'content_id' => 'show_charter_content',
							'html' => ['default' => 'Charter', 'fr_FR' => 'Charte'],
						),
						'generalTermsOfUse' => array(
							'href' => ['route' => 'instance/generalTermsOfUse'],
							'target' => 'modal',
							'data-target' => 'modalShowGtouForm',
							'content_id' => 'show_gtou_content',
							'html' => ['default' => 'General Terms Of Use', 'fr_FR' => 'Conditions Générales d’Utilisation'],
						),
					),
				)
			),
			'copyright' => array(
				'class' => 'footer-copyright py-3 text-center container-fluid',
				'html' => ['default' => '© 2018 Copyright: <a href="https://github.com/2pit-io/PpitCore/blob/master/license.txt"> 2pit.io </a>'],
			),
		),
	),
	
	// Flow Events
	
	'event/generic' => array(
		'header' => array(
			'title' => ['default' => 'ProBonoCorpo - Events', 'fr_FR' => 'ProBonoCorpo - Evénements'],
			'description' => ['default' => 'Subscribe to events and organize your own ones', 'fr_FR' => 'Inscrits-toi aux événements et organize les tiens'],
			'style' => array(
				'navbar' => 'background-color: transparent;',
				'topNavCollapse' => 'background-color: #ffffff;',
			),
			'navbar' => array(
				'class' => 'navbar navbar-expand-lg fixed-top scrolling-navbar navbar-black',
				'account' => true,
				'collapse' => false,
			),
			'logo' => array(
				'href' => 'home',
				'params' => [],
				'src' => '/logos/probonocorpo/PBC-logo-web-fleur.png',
				'height' => 40,
				'alt' => 'Pro bono corpo logo',
			),
			'intro_height' => '65%',
			'background_image' => array(
				'mask' => 'rgba-stylish-light',
				'src' => ['default' => '/img/probonocorpo/bulles.png'],
				'class' => 'img-fluid',
				'alt' => 'Mountains',
			),
		),
	
		'index' => array(
			'navbar' => array(
				'publicMode' => ['type' => 'mode', 'value' => 'Public', 'labels' => ['default' => 'All the events', 'fr_FR' => 'Tous les événements']],
				'ownerMode' => ['type' => 'mode', 'value' => 'Owner', 'labels' => ['default' => 'My events', 'fr_FR' => 'Mes événements']],
				'contributorMode' => ['type' => 'mode', 'value' => 'Contributor', 'labels' => ['default' => 'My participations', 'fr_FR' => 'Mes participations']],
				'skills' => ['type' => 'search', 'property' => 'property_2', 'labels' => ['default' => 'Keywords', 'fr_FR' => 'Mots clés']],
				'new' => ['type' => 'new', 'labels' => ['default' => 'New event', 'fr_FR' => 'Nouvel événement']],
			)
		),
	
		'intro' => array(
		),
	
		'card' => array(
			'roles' => array(
				'requestor' => ['labels' => ['default' => 'I am organizer', 'fr_FR' => 'Je suis organisateur']],
				'contributor' => ['labels' => ['default' => 'I participate', 'fr_FR' => 'Je participe']],
			),
			'display' => array(
				'type' => 'image',
				'class' => array(
					'information' => 'fa fa-question-circle fa-2x green-text',
					'pro_bono_day' => 'fa fa-hands-helping fa-2x blue-text',
					'innovation' => 'fa fa-tablet-alt fa-2x orange-text',
					'team_building' => 'fa fa-users fa-2x grey-text',
				),
			),
			'properties' => array(
				'category' => ['definition' => 'event/event/property/property_3', 'labels' => ['default' => 'Type', 'fr_FR' => 'Type']],
				'property_2' => ['feature' => 'keyword_skill', 'class' => 'col-md-12', 'definition' => 'inline', 'type' => 'chips', 'repository' => 'matching/skills', 'trigger' => 'property_1'],
				'begin_date' => ['definition' => 'event/event/property/begin_date'],
				'begin_time' => ['definition' => 'event/event/property/begin_time'],
				'location' => ['definition' => 'event/event/property/location'],
			),
		),
	
		'status' => array(
			'new' => ['labels' => ['default' => 'Subscription in progress', 'fr_FR' => 'Inscriptions en cours'], 'value' => 25, 'color' => 'bg-danger'],
			'connected' => ['labels' => ['default' => 'Subscription closed', 'fr_FR' => 'Inscriptions closes'], 'value'  => 50, 'color' => 'bg-info'],
			'realized' => ['labels' => ['default' => 'Is currently happening', 'fr_FR' => 'A lieu en ce moment'], 'value' => 75, 'color' => 'bg-warning'],
			'completed' => ['labels' => ['default' => 'Completed', 'fr_FR' => 'Terminé'], 'value' => 100, 'color' => 'bg-success'],
		),
	
		'actions' => array(
			'Owner' => array(
				'update' => ['icon' => 'edit', 'labels' => ['default' => 'Update', 'fr_FR' => 'Modifier']],
				'cancel' => ['icon' => 'trash-alt', 'labels' => ['default' => 'Cancel', 'fr_FR' => 'Annuler']],
				'close' => ['icon' => 'eye-slash',  'labels' => ['default' => 'Close registration', 'fr_FR' => 'Fermer les inscriptions']],
				'open' => ['icon' => 'eye',  'labels' => ['default' => 'Open registration', 'fr_FR' => 'Ouvrir les inscriptions']],
				'complete' => ['icon' => 'check-square',  'labels' => ['default' => 'Complete', 'fr_FR' => 'Terminer']],
				'consultFeedback' => ['labels' => ['default' => 'Consult the feedbacks', 'fr_FR' => 'Consulter les feedbacks']],
			),
			'Contributor' => array(
				'feedback' => ['icon' => 'comments', 'labels' => ['default' => 'Giving a feedback', 'fr_FR' => 'Donner un feedback']],
				'consultFeedback' => ['labels' => ['default' => 'Consult the feedback', 'fr_FR' => 'Consulter le feedback']],
			),
			'Matching' => array(
				'contact' => ['icon' => 'handshake', 'labels' => ['default' => 'Contact', 'fr_FR' => 'Contacter']],
				'abandon' => ['icon' => 'trash-alt', 'labels' => ['default' => 'Abandon my selection', 'fr_FR' => 'Abandonner ma sélection']],
				'accept' => ['icon' => 'thumbs-up', 'labels' => ['default' => 'Accept the subscription', 'fr_FR' => 'Accepter son inscription']],
				'decline' => ['icon' => 'thumbs-down', 'labels' => ['default' => 'Decline the subscription', 'fr_FR' => 'Décliner son inscription']],
				'feedback' => ['icon' => 'comments', 'labels' => ['default' => 'Give a feedback', 'fr_FR' => 'Donner un feedback']],
			),
			'Public' => array(
				'propose' => ['icon' => 'hand-point-up', 'labels' => ['default' => 'Propose my participation', 'fr_FR' => 'Proposer ma participation']],
			),
		),
	
		'form' => array(
			'title' => ['default' => 'Organize a new event', 'fr_FR' => 'Organiser un nouvel évènement'],
			'options' => array(
				'examples' => true,
			),
			'introduction' => array(
			),
			'inputs' => array(
				'caption' => ['class' => 'col-md-6', 'definition' => 'event/event/property/caption', 'mandatory' => true],
				'caption_example' => ['class' => 'col-md-6 grey-text', 'definition' => 'inline', 'type' => 'html', 'updatable' => false],
				'category' => ['class' => 'col-md-6', 'definition' => 'event/event/property/category', 'mandatory' => true],
				'category_example' => ['class' => 'col-md-6 grey-text', 'definition' => 'inline', 'type' => 'html', 'updatable' => false],
				'description' => ['class' => 'col-md-6', 'definition' => 'event/event/property/description', 'mandatory' => true, 'rows' => 6],
				'description_example' => ['class' => 'col-md-6 grey-text', 'definition' => 'inline', 'type' => 'html', 'updatable' => false],
				'property_1' => ['feature' => 'skill', 'class' => 'col-md-6', 'definition' => 'inline', 'type' => 'keywords', 'labels' => ['default' => 'Expected skills', 'fr_FR' => 'Compétences attendues'], 'placeholder' => ['default' => 'Ex. finance, design thinking, video editing...', 'fr_FR' => 'Ex. finance, design thinking, montage vidéo...']],
				'property_1_example' => ['class' => 'col-md-6 grey-text', 'definition' => 'inline', 'type' => 'html', 'updatable' => false],
				'property_2' => ['feature' => 'keyword_skill', 'class' => 'col-md-6', 'definition' => 'inline', 'type' => 'chips', 'repository' => 'matching/skills', 'trigger' => 'property_1'],
				['definition' => 'inline', 'type' => 'empty'],
				'begin_date' => ['class' => 'col-md-6', 'definition' => 'event/event/property/begin_date', 'mandatory' => true],
				'begin_time' => ['class' => 'col-md-6', 'definition' => 'event/event/property/begin_time', 'mandatory' => true],
				'end_date' => ['class' => 'col-md-6', 'definition' => 'event/event/property/end_date'],
				'end_time' => ['class' => 'col-md-6', 'definition' => 'event/event/property/end_time'],
				'location' => ['class' => 'col-md-6', 'definition' => 'event/event/property/location', 'mandatory' => true],
				['definition' => 'inline', 'type' => 'empty'],
				'property_3' => ['class' => 'col-md-6', 'definition' => 'event/event/property/property_3', 'rows' => 4],
				'property_3_example' => ['class' => 'col-md-6 grey-text', 'definition' => 'inline', 'type' => 'html', 'updatable' => false],
				'property_20' => ['class' => 'col-md-6', 'definition' => 'event/event/property/property_3', 'rows' => 4],
				'property_20_example' => ['class' => 'col-md-6 grey-text', 'definition' => 'inline', 'type' => 'html', 'updatable' => false],
			),
			'submit' => array(
				'class' => 'btn btn-light-blue btn-rounded',
				'labels' => ['default' => 'Submit', 'fr_FR' => 'Soumettre'],
			),
			'legal' => array(
				array(
					'type' => 'p',
					'class' => 'section-description',
					'text' => array(
						'default' => 'The informations provided here serve only the event organization. They will never been communicated to third-parts without your agreement. For more information, contact us on <a href="mailto:contact@2pit.io?subject=Request for informations about data privacy in Pro Bono Corpo">contact@2pit.io</a>.',
						'fr_FR' => 'Les informations saisies sont uniquement destinées à l’organisation de l’événement. Elles ne peuvent en aucun cas être communiquées à des tiers sans votre consentement. Pour en savoir plus, consultez nous sur <a href="mailto:contact@2pit.io?subject=Demande d’informations sur la protection des données dans Pro Bono Corpo">contact@2pit.io</a>.',
					),
				),
			),
		),
	
		'detail' => array(
			'background' => 'indigo',
			'title' => array(
				'detail' => ['default' => 'Event detail', 'fr_FR' => 'Détail de l’événement'],
				'Owner' => array(
					'new' => ['default' => 'Managing your event', 'fr_FR' => 'Gérer votre événement'],
					'connected' => ['default' => 'Managing your event', 'fr_FR' => 'Gérer votre événement'],
					'realized' => ['default' => 'This request is waiting for a feedback', 'fr_FR' => 'Cette demande est en attente de feedback'],
					'requestor_feedback' => ['default' => 'At least one participant on this event is waiting for a feedback from your side.<br>Please check each from the participant’s panel', 'fr_FR' => 'Au moins un participant à cet événement attend un feedback de votre part.<br>Veuillez vérifier chacun d’entre eux depuis le panneau des participants.'],
					'contributor_feedback' => ['default' => 'This event is waiting for feedback.<br>You will be notified at soon as it is available.', 'fr_FR' => 'Cet événement est en attente de feedback participant.<br>Vous serez notifié dès qu’il sera disponible.'],
					'completed' => ['default' => 'This event is over', 'fr_FR' => 'Cet événement est terminé'],
				),
				'Contributor' => array(
					'new' => ['default' => 'Wishing to participate to this event?', 'fr_FR' => 'Envie de participer à cet événement ?'],
					'linked' => ['default' => 'The organizer is notified of your subscription request', 'fr_FR' => 'L’organisateur est notifié votre demande d’inscription'],
					'contributor_feedback' => ['default' => 'This event is waiting for a feedback from your side', 'fr_FR' => 'Cet événement est en attente de feedback de votre part'],
					'requestor_feedback' => ['default' => 'This event is waiting for a feedback from the organizer’s side', 'fr_FR' => 'Cet événement est en attente de feedback de la part de l’organisateur'],
					'completed' => ['default' => 'This event is over. Thank you for your participation', 'fr_FR' => 'Cet événement est terminé. Merci de votre participation'],
				),
				'Public' => array(
					'new' => ['default' => 'Wishing to participate to this event?', 'fr_FR' => 'Envie de participer à cet événement ?'],
					'linked' => ['default' => 'The organizer is notified of your subscription request', 'fr_FR' => 'L’organisateur est notifié de votre demande d’inscription'],
					'contributor_feedback' => ['default' => 'This event is waiting for a feedback from your side', 'fr_FR' => 'Cet événement est en attente de feedback de votre part'],
					'requestor_feedback' => ['default' => 'This event is waiting for a feedback from the organizer’s side', 'fr_FR' => 'Cet événement est en attente de feedback de la part de l’organisateur'],
					'completed' => ['default' => 'This event is over', 'fr_FR' => 'Cet événement est terminé'],
				),
			),
			'introduction' => array(
			),
			'properties' => array(
				'caption' => ['class' => 'col-md-12', 'definition' => 'event/event/property/caption', 'mandatory' => true],
				'category' => ['class' => 'col-md-12', 'definition' => 'event/event/property/category', 'mandatory' => true],
				'description' => ['class' => 'col-md-12', 'definition' => 'event/event/property/description', 'mandatory' => true, 'rows' => 8],
				'property_1' => ['feature' => 'skill', 'class' => 'col-md-12', 'definition' => 'inline', 'type' => 'keywords', 'labels' => ['default' => 'Expected skills', 'fr_FR' => 'Compétences attendues'], 'placeholder' => ['default' => 'Ex. finance, design thinking, video editing...', 'fr_FR' => 'Ex. finance, design thinking, montage vidéo...']],
				'property_2' => ['feature' => 'keyword_skill', 'class' => 'col-md-12', 'definition' => 'inline', 'type' => 'chips', 'repository' => 'matching/skills', 'trigger' => 'property_1'],
				'begin_date' => ['class' => 'col-md-6', 'definition' => 'event/event/property/begin_date', 'mandatory' => true],
				'begin_time' => ['class' => 'col-md-6', 'definition' => 'event/event/property/begin_time', 'mandatory' => true],
				'end_date' => ['class' => 'col-md-6', 'definition' => 'event/event/property/end_date'],
				'end_time' => ['class' => 'col-md-6', 'definition' => 'event/event/property/end_time'],
				'location' => ['class' => 'col-md-12', 'definition' => 'event/event/property/location'],
				'property_3' => ['class' => 'col-md-12', 'definition' => 'event/event/property/property_3'],
				'property_20' => ['class' => 'col-md-12', 'definition' => 'event/event/property/property_20'],
			),
			'legal' => array(
				array(
					'type' => 'p',
					'class' => 'section-description',
					'text' => array(
						'default' => 'The informations provided here serve only the event organization. They will never been communicated to third-parts without your agreement. For more information, contact us on <a href="mailto:contact@2pit.io?subject=Request for informations about data privacy in Pro Bono Corpo">contact@2pit.io</a>.',
						'fr_FR' => 'Les informations saisies sont uniquement destinées à l’organisation de l’événement. Elles ne peuvent en aucun cas être communiquées à des tiers sans votre consentement. Pour en savoir plus, consultez nous sur <a href="mailto:contact@2pit.io?subject=Demande d’informations sur la protection des données dans Pro Bono Corpo">contact@2pit.io</a>.',
					),
				),
			),
		),
	
		'profile' => array(
			'title' => array(
				'Owner' => ['default' => 'Matching profiles', 'fr_FR' => 'Profils correspondants'],
				'Public' => ['default' => 'Requestor profile', 'fr_FR' => 'Profil de l’organisateur'],
			),
		),
	
		'matched_accounts' => array(
			'title' => ['default' => 'Possible attendees', 'fr_FR' => 'Participants potentiels'],
			'contact_subject' => ['default' => 'probono corpo - Opportunity to participate', 'fr_FR' => 'probono corpo - Opportunité de participation'],
			'properties' => array(
				'n_fn' => [],
				'email' => [],
			),
		),
	
		'rewards' => array(
			'brand' => 'Innocoin',
			'balance' => array(
				'goal' => ['labels' => ['default' => 'Goal', 'fr_FR' => 'Objectif']],
				'earned' => ['labels' => ['default' => 'Earned', 'fr_FR' => 'Gagné']],
				'spent' => ['labels' => ['default' => 'Spent', 'fr_FR' => 'Dépensé']],
			),
		),
		
		'feedback' => array(
			'title' => array(
				'requestor' => array(
					'new' => ['default' => 'Giving a feedback', 'fr_FR' => 'Donner un feedback'],
				),
				'contributor' => array(
					'new' => ['default' => 'Giving a feedback', 'fr_FR' => 'Donner un feedback'],
				),
			),
			'introduction' => array(
			),
			'inputs' => array(
				['mode' => 'requestor', 'definition' => 'inline', 'class' => 'col-md-12 grey-text font-weight-bold', 'type' => 'html', 'markup' => 'p', 'text' => ['default' => 'You submitted via <em>proBono corpo</em> the following request: <em>%s</em>', 'fr_FR' => 'Tu as fait via <em>proBono corpo</em> la demande suivante : <em>%s</em>'], 'params' => array('caption')],
				['mode' => 'public', 'definition' => 'inline', 'class' => 'col-md-12 grey-text font-weight-bold', 'type' => 'html', 'markup' => 'p', 'text' => ['default' => 'You gave of a helping hand via <em>proBono corpo</em> for the following request: <em>%s</em>', 'fr_FR' => 'Tu as donné un coup de main via <em>proBono corpo</em> pour la demande suivante : <em>%s</em>'], 'params' => array('caption')],
				['definition' => 'inline', 'class' => 'col-md-12 grey-text font-weight-bold', 'type' => 'html', 'markup' => 'p', 'text' => ['default' => 'Conversely, can you help us by giving a feedback?', 'fr_FR' => 'A ton tour, peux-tu nous aider en donnant ton feedback ?']],
				['definition' => 'inline', 'class' => 'col-md-12 grey-text font-weight-bold my-3', 'type' => 'html', 'markup' => 'h5', 'text' => ['default' => 'Feedback to your interlocutor (only visible to him/her)', 'fr_FR' => 'Feedback pour ton interlocuteur (visible uniquement de lui/elle)']],
				'private_comment' => ['definition' => 'inline', 'property_id' => 'private_comment', 'class' => 'col-md-12', 'type' => 'textarea', 'rows' => 4, 'labels' => ['default' => 'What do you want to share ex-post?', 'fr_FR' => 'Que souhaites-tu partager à postériori ?']],
				['definition' => 'inline', 'class' => 'col-md-12 grey-text font-weight-bold my-3', 'type' => 'html', 'markup' => 'h5', 'text' => ['default' => 'Feedback only to the <em>probono corpo</em> team (not visible to anyone else)', 'fr_FR' => 'Feedback pour l’équipe ProBono Corpo uniquement (ne sera visible de personne d’autre)']],
				'platform_benefit' => ['definition' => 'inline', 'property_id' => 'platform_benefit', 'class' => 'col-md-12', 'type' => 'textarea', 'rows' => 4, 'labels' => ['default' => 'What did you learned from this experience (from your request / proposition to contribute, to the completed helping hand:', 'fr_FR' => 'Qu’est-ce que tu as retiré de cette expérience (de ta demande / proposition de contribution au coup de main réalisé) :']],
				['definition' => 'inline', 'class' => 'col-md-12 grey-text font-weight-bold', 'type' => 'html', 'markup' => 'p', 'text' => ['default' => 'On a scale of 1 to 10, how would you evaluate?', 'fr_FR' => 'Sur une échelle de 0 à 10, comment noterais-tu ?']],
				'platform_satisfaction' => ['definition' => 'inline', 'property_id' => 'platform_satisfaction', 'class' => 'col-md-12', 'type' => 'radio-inline', 'radio-values' => ['0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10], 'labels' => ['default' => 'Your satisfaction of this experience (0: unsatisfied, 10: Great!)?', 'fr_FR' => 'Ta satisfaction de l’expérience (0 : insatisfait, 10 : Waouh!) ?']],
				'platform_accessibility' => ['definition' => 'inline', 'property_id' => 'platform_accessibility', 'type' => 'radio-inline', 'radio-values' => ['0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10], 'labels' => ['default' => 'The accessibility of the request (0: course too complicated, 10: Completely fluent, it only took me a short time)?', 'fr_FR' => 'Ton ressenti pour accéder à la demande : (0 : parcours trop compliqué, 10 : parfaitement fluide, ça ne m’a pris qu’un instant) ?']],
				'platform_comment' => ['definition' => 'inline', 'property_id' => 'platform_comment', 'class' => 'col-md-12', 'type' => 'textarea', 'rows' => 4, 'labels' => ['default' => 'Feel free to leave any comment helping us to enhance your experience', 'fr_FR' => 'N’hésites pas à nous laisser tout commentaire qui pourrait nous aider à améliorer ton expérience']],
				['definition' => 'inline', 'class' => 'col-md-12 grey-text font-weight-bold', 'type' => 'html', 'markup' => 'h5', 'text' => ['default' => 'Feedback to the whole community (can be use as a testimonial)', 'fr_FR' => 'Feedback à l’ensemble de la communauté (peut être utilisé en témoignage)']],
				'community_comment' => ['definition' => 'inline', 'property_id' => 'community_comment', 'class' => 'col-md-12', 'type' => 'textarea', 'rows' => 4, 'labels' => ['default' => 'Which testimonial of your experience would you share with the community?', 'fr_FR' => 'Quel témoignage souhaites tu faire de ton expérience pour la partager avec la communauté ?']],
				['definition' => 'inline', 'class' => 'col-md-12 grey-text font-weight-bold', 'type' => 'html', 'markup' => 'p', 'text' => ['default' => 'Thank you for helping. Feel free to come back and contribute or post requests again', 'fr_FR' => 'Merci pour ta participation. N’hésite-pas à revenir contribuer ou faire de nouvelles demandes.']],
			),
			'requestorActions' => array(
			),
			'contributorActions' => array(
			),
			'legal' => array(
				array(
					'type' => 'p',
					'class' => 'section-description',
					'text' => array(
						'default' => 'The informations provided here serve only the event organization. They will never been communicated to third-parts without your agreement. For more information, contact us on <a href="mailto:contact@2pit.io?subject=Request for informations about data privacy in Pro Bono Corpo">contact@2pit.io</a>.',
						'fr_FR' => 'Les informations saisies sont uniquement destinées à l’organisation de l’événement. Elles ne peuvent en aucun cas être communiquées à des tiers sans votre consentement. Pour en savoir plus, consultez nous sur <a href="mailto:contact@2pit.io?subject=Demande d’informations sur la protection des données dans Pro Bono Corpo">contact@2pit.io</a>.',
					),
				),
			),
		),
	
		'tooltips' => array(
			'#property_1' => ['data-placement' => 'right', 'title' => ['default' => 'Type a few character and choose some keywords. You can also input in free text', 'fr_FR' => 'Saisissez quelques caractères et choisissez dans la liste. Vous pouvez également saisir en texte libre']],
			'.pending_contact' => ['data-placement' => 'right', 'data-html' => true, 'title' => ['default' => 'The participant subscrived more than 5 days ago', 'fr_FR' => 'Le participant s’est inscrit depuis plus de 5 jours']],
		),
	
		'examples' => array(
			array(
				'caption_example' => array(
					'default' => '<p class="font-weight-bold">Exemple à titre purement informatif</p><p>Journée annuelle de l’échange de compétences en mode pro bono</p>',
				),
				'description_example' => array(
					'default' => '<p class="font-weight-bold">Exemple</p><p>Venez le temps d’une journée faire connaître vos savoirs-faire, les exercer en rendant service à un collègue.<br>Réciproquement ce sera pour vous l’occasion d’obtenir de l’aide pour un besoin immédiat et sans réponse évidente pour vous...</p>',
				),
				'property_1_example' => array(
					'default' => '<p class="font-weight-bold">Exemple informatif</p><p>Venez avec vos savoir-faires quels qu’ils soient...</p>',
				),
				'property_3_example' => array(
					'default' => '<p class="font-weight-bold">Exemple</p><p>Tous collaborateurs et/ou managers</p>',
				),
				'property_20_example' => array(
					'default' => '<p class="font-weight-bold">Exemple</p>L’événement a lieu à la salle de créativité',
				),
			),
			array(
				'caption_example' => array(
					'default' => '<p class="font-weight-bold">Exemple à titre purement informatif</p><p>Séance ouverte d’entraînement au pitch</p>',
				),
				'description_example' => array(
					'default' => '<p class="font-weight-bold">Exemple</p><p>Envie de vous entraîner à pitcher ? Inscrivez-vous ! c’est ludique et bienveillant car tous les participants viennent pour apprendre. Il y aura un coach qui saura vous donner de vrais conseils pratiques pour gagner rapidement en aisance dans cet exercice.</p>',
				),
				'property_1_example' => array(
					'default' => '<p class="font-weight-bold">Exemple informatif</p><p>Pas de compétence particulière requise...</p>',
				),
				'property_3_example' => array(
					'default' => '<p class="font-weight-bold">Exemple</p><p>Tous collaborateurs intéressés par l’innovation au sens large</p>',
				),
				'property_20_example' => array(
					'default' => '<p class="font-weight-bold">Exemple</p>L’événement a lieu au plateau des Dunes',
				),
			),
		),
		'footer' => array(
			'links' => array(
				'column_1' => array(
					'title' => ['default' => 'Resources', 'fr_FR' => 'Ressources'],
					'list' => array(
						'charter' => array(
							'href' => ['route' => 'instance/charter'],
							'target' => 'modal',
							'data-target' => 'modalShowCharterForm',
							'content_id' => 'show_charter_content',
							'html' => ['default' => 'Charter', 'fr_FR' => 'Charte'],
						),
						'generalTermsOfUse' => array(
							'href' => ['route' => 'instance/generalTermsOfUse'],
							'target' => 'modal',
							'data-target' => 'modalShowGtouForm',
							'content_id' => 'show_gtou_content',
							'html' => ['default' => 'General Terms Of Use', 'fr_FR' => 'Conditions Générales d’Utilisation'],
						),
					),
				)
			),
			'copyright' => array(
				'class' => 'footer-copyright py-3 text-center container-fluid',
				'html' => ['default' => '© 2018 Copyright: <a href="https://github.com/2pit-io/PpitCore/blob/master/license.txt">2pit.io</a>'],
			),
		),
	),

	// FLow Request
	
	'request/generic' => array(
		'header' => array(
			'title' => ['default' => 'ProBonoCorpo - Requests', 'fr_FR' => 'ProBonoCorpo - Demandes'],
			'description' => ['default' => 'Describe your request for a perfect matching with the skill offer', 'fr_FR' => 'Décris ta demande pour un matching parfait avec l’offre de compétences'],
			'style' => array(
				'navbar' => 'background-color: transparent;',
				'topNavCollapse' => 'background-color: #ffffff;',
			),
			'navbar' => array(
				'class' => 'navbar navbar-expand-lg fixed-top scrolling-navbar navbar-black',
				'account' => true,
				'collapse' => false,
			),
			'logo' => array(
				'href' => 'home',
				'params' => [],
				'src' => '/logos/probonocorpo/PBC-logo-web-fleur.png',
				'height' => 40,
				'alt' => 'Pro bono corpo logo',
			),
			'intro_height' => '65%',
			'background_image' => array(
				'mask' => 'rgba-stylish-light',
				'src' => ['default' => '/img/probonocorpo/bulles.png'],
				'class' => 'img-fluid',
				'alt' => 'Mountains',
			),
		),

		'index' => array(
			'navbar' => array(
				'publicMode' => ['type' => 'mode', 'value' => 'Public', 'labels' => ['default' => 'Current', 'fr_FR' => 'En cours']],
				'skills' => ['type' => 'search', 'property' => 'property_2', 'labels' => ['default' => 'Keywords', 'fr_FR' => 'Mots clés']],
				'ownerMode' => ['type' => 'mode', 'value' => 'Owner', 'labels' => ['default' => 'My requests', 'fr_FR' => 'Mes demandes']],
				'contributorMode' => ['type' => 'mode', 'value' => 'Contributor', 'labels' => ['default' => 'My contributions', 'fr_FR' => 'Mes contributions']],
				'new' => ['type' => 'new', 'labels' => ['default' => 'New request', 'fr_FR' => 'Nouvelle demande']],
			)
		),	
		
		'intro' => array(
		),

		'card' => array(
			'roles' => array(
				'requestor' => ['labels' => ['default' => 'I am requestor', 'fr_FR' => 'Je suis demandeur']],
				'contributor' => ['labels' => ['default' => 'I am connected', 'fr_FR' => 'Je suis mis en relation']],
			),
			'display' => array(
				'type' => 'avatar',
			),
			'properties' => array(
				'property_3' => ['definition' => 'event/request/property/property_3', 'labels' => ['default' => 'Type', 'fr_FR' => 'Type']],
				'property_2' => ['feature' => 'keyword_skill', 'class' => 'col-md-12', 'definition' => 'inline', 'type' => 'chips', 'repository' => 'matching/skills', 'trigger' => 'property_1'],
				'property_7' => ['definition' => 'event/request/property/property_7', 'labels' => ['default' => 'Location', 'fr_FR' => 'Localisation']],
			),
		),

		'status' => array(
			'new' => ['labels' => ['default' => 'To provide for', 'fr_FR' => 'A pourvoir'], 'value' => 25, 'color' => 'bg-danger'],
			'connected' => ['labels' => ['default' => 'Connected', 'fr_FR' => 'Relation établie'], 'value'  => 50, 'color' => 'bg-info'],
			'realized' => ['labels' => ['default' => 'Realized', 'fr_FR' => 'Réalisée'], 'value' => 75, 'color' => 'bg-warning'],
			'completed' => ['labels' => ['default' => 'Completed', 'fr_FR' => 'Terminée'], 'value' => 100, 'color' => 'bg-success'],
		),
		
		'actions' => array(
			'Owner' => array(
				'update' => ['icon' => 'edit', 'labels' => ['default' => 'Update', 'fr_FR' => 'Modifier']],
				'cancel' => ['icon' => 'trash-alt', 'labels' => ['default' => 'Cancel', 'fr_FR' => 'Annuler']],
				'close' => ['icon' => 'eye-slash',  'labels' => ['default' => 'Mask', 'fr_FR' => 'Masquer']],
				'open' => ['icon' => 'eye',  'labels' => ['default' => 'Unmask', 'fr_FR' => 'Rendre visible']],
				'complete' => ['icon' => 'check-square',  'labels' => ['default' => 'Complete', 'fr_FR' => 'Terminer']],
				'consultFeedback' => ['labels' => ['default' => 'Consult the feedbacks', 'fr_FR' => 'Consulter les feedbacks']],
			),
			'Contributor' => array(
				'feedback' => ['icon' => 'comments', 'labels' => ['default' => 'Giving a feedback', 'fr_FR' => 'Donner un feedback']],
				'consultFeedback' => ['labels' => ['default' => 'Consult the feedback', 'fr_FR' => 'Consulter le feedback']],
			),
			'Matching' => array(
				'contact' => ['icon' => 'handshake', 'labels' => ['default' => 'Contact', 'fr_FR' => 'Contacter']],
				'abandon' => ['icon' => 'trash-alt', 'labels' => ['default' => 'Abandon my selection', 'fr_FR' => 'Abandonner ma sélection']],
				'accept' => ['icon' => 'thumbs-up', 'labels' => ['default' => 'Accept the proposal', 'fr_FR' => 'Accepter sa proposition']],
				'decline' => ['icon' => 'thumbs-down', 'labels' => ['default' => 'Decline the proposal', 'fr_FR' => 'Décliner sa proposition']],
				'feedback' => ['icon' => 'comments', 'labels' => ['default' => 'Give a feedback', 'fr_FR' => 'Donner un feedback']],
			),
			'Public' => array(
				'propose' => ['icon' => 'hand-point-up', 'labels' => ['default' => 'Propose my contribution', 'fr_FR' => 'Proposer ma contribution']],
			),
		),

		'form' => array(
			'title' => ['default' => 'Submit/update a request', 'fr_FR' => 'Créer/modifier une demande'],
			'options' => array(
				'examples' => true,
			),
			'introduction' => array(
			),
			'inputs' => array(
				'caption' => ['class' => 'col-md-6', 'definition' => 'event/request/property/caption', 'mandatory' => true],
				'caption_example' => ['class' => 'col-md-6 grey-text', 'definition' => 'inline', 'type' => 'html', 'updatable' => false],
				'property_24' => ['class' => 'col-md-6', 'definition' => 'event/request/property/property_24', 'mandatory' => true, 'rows' => 6],
				'property_24_example' => ['class' => 'col-md-6 grey-text', 'definition' => 'inline', 'type' => 'html', 'updatable' => false],
				'property_25' => ['class' => 'col-md-6', 'definition' => 'event/request/property/property_25', 'mandatory' => true, 'rows' => 8],
				'property_25_example' => ['class' => 'col-md-6 grey-text', 'definition' => 'inline', 'type' => 'html', 'updatable' => false],
				'property_3' => ['class' => 'col-md-6', 'definition' => 'event/request/property/property_3', 'mandatory' => true],
				'property_3_example' => ['class' => 'col-md-6 grey-text', 'definition' => 'inline', 'type' => 'html', 'updatable' => false],
				'property_1' => ['feature' => 'skill', 'class' => 'col-md-6', 'definition' => 'inline', 'type' => 'keywords', 'labels' => ['default' => 'Expected skills', 'fr_FR' => 'Compétences attendues'], 'placeholder' => ['default' => 'Ex. finance, design thinking, video editing...', 'fr_FR' => 'Ex. finance, design thinking, montage vidéo...']],
				'property_1_example' => ['class' => 'col-md-6 grey-text', 'definition' => 'inline', 'type' => 'html', 'updatable' => false],
				'property_2' => ['feature' => 'keyword_skill', 'class' => 'col-md-6', 'definition' => 'inline', 'type' => 'chips', 'repository' => 'matching/skills', 'trigger' => 'property_1'],
				['definition' => 'inline', 'type' => 'empty'],
				'property_4' => ['class' => 'col-md-6', 'definition' => 'event/request/property/property_4'],
				'property_4_example' => ['class' => 'col-md-6 grey-text', 'definition' => 'inline', 'type' => 'html', 'updatable' => false],
				'property_5' => ['class' => 'col-md-6', 'definition' => 'event/request/property/property_5'],
				['definition' => 'inline', 'type' => 'empty'],
				'property_6' => ['class' => 'col-md-6', 'definition' => 'event/request/property/property_6'],
				['definition' => 'inline', 'type' => 'empty'],
				'property_7' => ['class' => 'col-md-6', 'definition' => 'event/request/property/property_7'],
				['definition' => 'inline', 'type' => 'empty'],
				'property_26' => ['class' => 'col-md-6', 'definition' => 'inline', 'type' => 'textarea', 'rows' => 4, 'labels' => ['default' => 'Other logistic constraints', 'fr_FR' => 'Autres contraintes logistiques']],
				'property_26_example' => ['class' => 'col-md-6 grey-text', 'definition' => 'inline', 'type' => 'html', 'updatable' => false],
			),
			'submit' => array(
				'class' => 'btn btn-light-blue btn-rounded',
				'labels' => ['default' => 'Submit', 'fr_FR' => 'Soumettre'],
			),
			'legal' => array(
				array(
					'type' => 'p',
					'class' => 'section-description',
					'text' => array(
						'default' => 'The informations provided here will not be communicated to anyone. They will never been communicated to third-parts without your agreement. For more information, contact us on <a href="mailto:contact@2pit.io?subject=Request for informations about data privacy in Pro Bono Corpo">contact@2pit.io</a>.',
						'fr_FR' => 'Les informations saisies sont uniquement destinées à améliorer la mise en relation. Elles ne peuvent en aucun cas être communiquées à des tiers sans votre consentement. Pour en savoir plus, consultez nous sur <a href="mailto:contact@2pit.io?subject=Demande d’informations sur la protection des données dans Pro Bono Corpo">contact@2pit.io</a>.',
					),
				),
			),
		),
		
		'detail' => array(
			'background' => 'blue',
			'title' => array(
				'detail' => ['default' => 'Request detail', 'fr_FR' => 'Détail de la demande'],
				'Owner' => array(
					'new' => ['default' => 'Managing your request', 'fr_FR' => 'Gérer votre demande'],
					'connected' => ['default' => 'Managing your request', 'fr_FR' => 'Gérer votre demande'],
					'realized' => ['default' => 'This request is waiting for a feedback', 'fr_FR' => 'Cette demande est en attente de feedback'],
					'requestor_feedback' => ['default' => 'At least one contributor on this request is waiting for a feedback from your side.<br>Please check each from the contributor’s panel', 'fr_FR' => 'Au moins un contributeur à cette demande attend un feedback de votre part.<br>Veuillez vérifier chacun d’entre eux depuis le panneau des contributeurs.'],
					'contributor_feedback' => ['default' => 'This request is waiting for feedback.<br>You will be notified at soon as it is available.', 'fr_FR' => 'Cette demande est en attente de feedback contributeur.<br>Vous serez notifié dès qu’il sera disponible.'],
					'completed' => ['default' => 'This request is over', 'fr_FR' => 'Cette demande est terminée'],
				),
				'Contributor' => array(
					'new' => ['default' => 'Wishing to contribute to this request?', 'fr_FR' => 'Envie de contribuer à cette demande ?'],
					'linked' => ['default' => 'The requestor will contact you following your proposal', 'fr_FR' => 'Suite à votre proposition le demandeur va vous contacter'],
					'contributor_feedback' => ['default' => 'This contribution is waiting for a feedback from your side', 'fr_FR' => 'Cette contribution est en attente de feedback de votre part'],
					'requestor_feedback' => ['default' => 'This request is waiting for a feedback from the requestor’s side', 'fr_FR' => 'Cette demande est en attente de feedback de la part du demandeur'],
					'completed' => ['default' => 'This request is over. Thank you for your contribution', 'fr_FR' => 'Cette demande est terminée. Merci de votre contribution'],
				),
				'Public' => array(
					'new' => ['default' => 'Wishing to contribute to this request?', 'fr_FR' => 'Envie de contribuer à cette demande ?'],
					'linked' => ['default' => 'The requestor will contact you following your proposal', 'fr_FR' => 'Suite à votre proposition le demandeur va vous contacter'],
//					'realization' => ['default' => 'The realisation of this request is in progress', 'fr_FR' => 'Cette demande est en cours de réalisation'],
					'contributor_feedback' => ['default' => 'This contribution is waiting for a feedback from your side', 'fr_FR' => 'Cette contribution est en attente de feedback de votre part'],
					'requestor_feedback' => ['default' => 'This request is waiting for a feedback from the requestor’s side', 'fr_FR' => 'Cette demande est en attente de feedback de la part du demandeur'],
					'completed' => ['default' => 'This request is over', 'fr_FR' => 'Cette demande est terminée'],
				),
			),
			'introduction' => array(
			),
			'properties' => array(
				'caption' => ['class' => 'col-md-12', 'definition' => 'event/request/property/caption', 'mandatory' => true],
				'property_24' => ['class' => 'col-md-12', 'definition' => 'event/request/property/property_24', 'mandatory' => true, 'rows' => 6],
				'property_25' => ['class' => 'col-md-12', 'definition' => 'event/request/property/property_25', 'mandatory' => true, 'rows' => 8],
				'property_3' => ['class' => 'col-md-12', 'definition' => 'event/request/property/property_3', 'mandatory' => true],
				'property_1' => ['feature' => 'skill', 'class' => 'col-md-12', 'definition' => 'inline', 'type' => 'keywords', 'labels' => ['default' => 'Expected skills', 'fr_FR' => 'Compétences attendues'], 'placeholder' => ['default' => 'Ex. finance, design thinking, video editing...', 'fr_FR' => 'Ex. finance, design thinking, montage vidéo...']],
				'property_2' => ['feature' => 'keyword_skill', 'class' => 'col-md-12', 'definition' => 'inline', 'type' => 'chips', 'repository' => 'matching/skills', 'trigger' => 'property_1'],
				'property_4' => ['class' => 'col-md-12', 'definition' => 'event/request/property/property_4'],
				'property_5' => ['class' => 'col-md-12', 'definition' => 'event/request/property/property_5'],
				'property_6' => ['class' => 'col-md-12', 'definition' => 'event/request/property/property_6'],
				'property_7' => ['class' => 'col-md-12', 'definition' => 'event/request/property/property_7'],
				'property_26' => ['class' => 'col-md-12', 'definition' => 'inline', 'type' => 'textarea', 'rows' => 4, 'labels' => ['default' => 'Other logistic constraints', 'fr_FR' => 'Autres contraintes logistiques']],
			),
			'legal' => array(
				array(
					'type' => 'p',
					'class' => 'section-description',
					'text' => array(
						'default' => 'For more information, contact us on <a href="mailto:contact@2pit.io">contact@2pit.io</a>.',
						'fr_FR' => 'Proposer sa contribution constitue un engagement moral de votre part vis-à-vis du demandeur qui s’engage de son côté à vous donner rapidement une réponse, positive ou non. Pour en savoir plus, consultez nous sur <a href="mailto:contact@2pit.io">contact@2pit.io</a>.',
					),
				),
			),
		),
	
		'profile' => array(
			'title' => array(
				'Owner' => ['default' => 'Matching profiles', 'fr_FR' => 'Profils correspondants'],
				'Public' => ['default' => 'Requestor profile', 'fr_FR' => 'Profil du demandeur'],
			),
		),

		'matched_accounts' => array(
			'title' => ['default' => 'Possible contributors', 'fr_FR' => 'Contributeurs potentiels'],
			'contact_subject' => ['default' => 'probono corpo - Opportunity to contribute', 'fr_FR' => 'probono corpo - Opportunité de contribution'],
			'properties' => array(
				'n_fn' => [],
				'email' => [],
			),
		),

		'feedback' => array(
			'title' => array(
				'requestor' => array(
					'new' => ['default' => 'Giving a feedback', 'fr_FR' => 'Donner un feedback'],
				),
				'contributor' => array(
					'new' => ['default' => 'Giving a feedback', 'fr_FR' => 'Donner un feedback'],
				),
			),
			'introduction' => array(
			),
			'inputs' => array(
				['mode' => 'requestor', 'definition' => 'inline', 'class' => 'col-md-12 grey-text font-weight-bold', 'type' => 'html', 'markup' => 'p', 'text' => ['default' => 'You submitted via <em>proBono corpo</em> the following request: <em>%s</em>', 'fr_FR' => 'Tu as fait via <em>proBono corpo</em> la demande suivante : <em>%s</em>'], 'params' => array('caption')],
				['mode' => 'public', 'definition' => 'inline', 'class' => 'col-md-12 grey-text font-weight-bold', 'type' => 'html', 'markup' => 'p', 'text' => ['default' => 'You gave of a helping hand via <em>proBono corpo</em> for the following request: <em>%s</em>', 'fr_FR' => 'Tu as donné un coup de main via <em>proBono corpo</em> pour la demande suivante : <em>%s</em>'], 'params' => array('caption')],
				['definition' => 'inline', 'class' => 'col-md-12 grey-text font-weight-bold', 'type' => 'html', 'markup' => 'p', 'text' => ['default' => 'Conversely, can you help us by giving a feedback?', 'fr_FR' => 'A ton tour, peux-tu nous aider en donnant ton feedback ?']],
				['definition' => 'inline', 'class' => 'col-md-12 grey-text font-weight-bold my-3', 'type' => 'html', 'markup' => 'h5', 'text' => ['default' => 'Feedback to your interlocutor (only visible to him/her)', 'fr_FR' => 'Feedback pour ton interlocuteur (visible uniquement de lui/elle)']],
				'private_comment' => ['definition' => 'inline', 'property_id' => 'private_comment', 'class' => 'col-md-12', 'type' => 'textarea', 'rows' => 4, 'labels' => ['default' => 'What do you want to share ex-post?', 'fr_FR' => 'Que souhaites-tu partager à postériori ?']],
				['definition' => 'inline', 'class' => 'col-md-12 grey-text font-weight-bold my-3', 'type' => 'html', 'markup' => 'h5', 'text' => ['default' => 'Feedback only to the <em>probono corpo</em> team (not visible to anyone else)', 'fr_FR' => 'Feedback pour l’équipe ProBono Corpo uniquement (ne sera visible de personne d’autre)']],
				'platform_benefit' => ['definition' => 'inline', 'property_id' => 'platform_benefit', 'class' => 'col-md-12', 'type' => 'textarea', 'rows' => 4, 'labels' => ['default' => 'What did you learned from this experience (from your request / proposition to contribute, to the completed helping hand:', 'fr_FR' => 'Qu’est-ce que tu as retiré de cette expérience (de ta demande / proposition de contribution au coup de main réalisé) :']],
				['definition' => 'inline', 'class' => 'col-md-12 grey-text font-weight-bold', 'type' => 'html', 'markup' => 'p', 'text' => ['default' => 'On a scale of 1 to 10, how would you evaluate?', 'fr_FR' => 'Sur une échelle de 0 à 10, comment noterais-tu ?']],
				'platform_satisfaction' => ['definition' => 'inline', 'property_id' => 'platform_satisfaction', 'class' => 'col-md-12', 'type' => 'radio-inline', 'radio-values' => ['0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10], 'labels' => ['default' => 'Your satisfaction of this experience (0: unsatisfied, 10: Great!)?', 'fr_FR' => 'Ta satisfaction de l’expérience (0 : insatisfait, 10 : Waouh!) ?']],
				'platform_accessibility' => ['definition' => 'inline', 'property_id' => 'platform_accessibility', 'type' => 'radio-inline', 'radio-values' => ['0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10], 'labels' => ['default' => 'The accessibility of the request (0: course too complicated, 10: Completely fluent, it only took me a short time)?', 'fr_FR' => 'Ton ressenti pour accéder à la demande : (0 : parcours trop compliqué, 10 : parfaitement fluide, ça ne m’a pris qu’un instant) ?']],
				'platform_comment' => ['definition' => 'inline', 'property_id' => 'platform_comment', 'class' => 'col-md-12', 'type' => 'textarea', 'rows' => 4, 'labels' => ['default' => 'Feel free to leave any comment helping us to enhance your experience', 'fr_FR' => 'N’hésites pas à nous laisser tout commentaire qui pourrait nous aider à améliorer ton expérience']],
				['definition' => 'inline', 'class' => 'col-md-12 grey-text font-weight-bold', 'type' => 'html', 'markup' => 'h5', 'text' => ['default' => 'Feedback to the whole community (can be use as a testimonial)', 'fr_FR' => 'Feedback à l’ensemble de la communauté (peut être utilisé en témoignage)']],
				'community_comment' => ['definition' => 'inline', 'property_id' => 'community_comment', 'class' => 'col-md-12', 'type' => 'textarea', 'rows' => 4, 'labels' => ['default' => 'Which testimonial of your experience would you share with the community?', 'fr_FR' => 'Quel témoignage souhaites tu faire de ton expérience pour la partager avec la communauté ?']],
				['definition' => 'inline', 'class' => 'col-md-12 grey-text font-weight-bold', 'type' => 'html', 'markup' => 'p', 'text' => ['default' => 'Thank you for helping. Feel free to come back and contribute or post requests again', 'fr_FR' => 'Merci pour ta participation. N’hésite-pas à revenir contribuer ou faire de nouvelles demandes.']],
			),
			'requestorActions' => array(
			),
			'contributorActions' => array(
			),
			'legal' => array(
				array(
					'type' => 'p',
					'class' => 'section-description',
					'text' => array(
						'default' => 'For more information, contact us on <a href="mailto:contact@2pit.io?subject=Request for informations about data privacy in Pro Bono Corpo">contact@2pit.io</a>.',
						'fr_FR' => 'Donner un feedback constitue un engagement moral de votre part vis-à-vis de votre interlocuteur qui s’engage de son côté à vous en donner rapidement un également. Pour en savoir plus, consultez nous sur <a href="mailto:contact@2pit.io?subject=Demande d’informations sur la protection des données dans Pro Bono Corpo">contact@2pit.io</a>.',
					),
				),
			),
		),
		
		'tooltips' => array(
			'#photo_upload' => ['data-placement' => 'right', 'title' => ['default' => 'You can upload your photo by clicking in this place', 'fr_FR' => 'Vous pouvez télécharger votre photo en cliquant sur cet emplacement']],
			'#property_1' => ['data-placement' => 'right', 'title' => ['default' => 'Type a few character and choose some keywords. You can also input in free text', 'fr_FR' => 'Saisissez quelques caractères et choisissez dans la liste. Vous pouvez également saisir en texte libre']],
			'#property_3' => ['data-placement' => 'right', 'data-html' => true, 'title' => ['default' => '<ul style="text-align: left"><li>Besoin d’infos, de connaissances pointues, de mise en relation</li><li>Besoin d’Expertise</li><li>Besoin de Solutions personnalisée</li><li>Besoin de diagnostic</li><li>Besoin de montée en compétences</li><li>Besoin d’intégrer une ressource à temps partiel</li><li>Besoin de produire un Livrable</li><li>...</li></ul>']],
			'.pending_contact' => ['data-placement' => 'right', 'data-html' => true, 'title' => ['default' => 'The contributor proposed to contribute more than 5 days ago', 'fr_FR' => 'Le contributeur s’est proposé pour contribuer depuis plus de 5 jours']],
		),
		
		'examples' => array(
			array(
				'caption_example' => array(
					'default' => '<p class="font-weight-bold">Exemple à titre purement informatif</p><p>Journée d’intégration pour les alternants</p>',
				),
				'property_24_example' => array(
					'default' => '<p class="font-weight-bold">Exemple</p><p><em>Les alternants ne sont pas toujours accueillis dans les meilleures conditions.<br>Les managers n’ont pas beaucoup de temps, et chacun se débrouille de son côté.<br>Il faudrait mutualiser l’accueil pour la centaine de personnes attendue en septembre et profiter pour faire un atelier Code de conduite.</em></p>',
				),
				'property_25_example' => array(
					'default' => '<p class="font-weight-bold">Exemple</p><em>J’aurai besoin d’aide pour concevoir et organiser les 4 demi-journées en trouvant des contributeurs  pour présenter le Groupe (son organisation et ses valeurs) et les trucs et astuces (Ce qu’il faut savoir quand on arrive).<br>L’animation doit être sympa pour que les alternants aient une bonne expérience collaborateur en arrivant à la SG.</em>',
				),
				'property_1_example' => array(
					'default' => '<p class="font-weight-bold">Exemple informatif</p><p>Animation, présentation, coaching...</p>',
				),
				'property_4_example' => array(
					'default' => '<p class="font-weight-bold">Exemple</p><p>Tuteurs / Mentors souhaitant transmettre leur savoir – Jeunes embauchés / anciens Alternants</p>',
				),
				'property_26_example' => array(
					'default' => '<p class="font-weight-bold">Exemple</p>1 jour par semaine à répartir sur 3 semaines',
				),
			),
			array(
				'caption_example' => array(
					'default' => '<p class="font-weight-bold">Exemple à titre purement informatif</p><p>Ateliers coding sur Scratch pour IT4Girls</p>',
				),
				'property_24_example' => array(
					'default' => '<p class="font-weight-bold">Exemple à titre purement informatif</p><p>La startup IT4Girls organise des ateliers de coding sur scratch pour les jeunes filles à partir de 7 ans dans l’optique de ramener de la mixité au sein des équipes IT.</p>',
				),
				'property_3_example' => array(
					'default' => '<p class="font-weight-bold">Exemple</p><p>Animation</p>',
				),
				'property_25_example' => array(
					'default' => '<p class="font-weight-bold">Exemple</p>IT4Girls recherche des animatrices/animateurs pour co-animer les ateliers de coding, les mercredi après-midi, ou tous les jours pendant les vacances. Les ateliers sont d’une durée de 1h30 suivi d’un gouter avec les enfants.<br>Les candidat(e)s auront la possibilité d’assister à un atelier pour voir comment cela se passe et d’être formé(e)s à scratch.<br>En fonction de leur disponibilité, les animatrices / animateurs, pourront s’inscrire pour l’animation aux ateliers qui seront proposés.',
				),
				'property_1_example' => array(
					'default' => '<p class="font-weight-bold">Exemple informatif</p><p>Etre à l’aise avec les enfants ainsi que dans l’animation, le BAFA est un plus.</p>',
				),
				'property_4_example' => array(
					'default' => '<p class="font-weight-bold">Exemple</p><p>Une appétence à l’IT, même sans connaissance avancé est suffisant.</p>',
				),
				'property_26_example' => array(
					'default' => '<p class="font-weight-bold">Exemple</p>Les mercredis après-midi, tous les jours pendant les congés scolaires, en fonction des disponibilités.<br>Localisation : La Défense, les Dunes, Paris<br>Estimation de la charge : 1h30 à 2h par atelier + 15 minutes de préparation (prise de connaissance du jeu).',
				),
			),
		),
		'footer' => array(
			'links' => array(
				'column_1' => array(
					'title' => ['default' => 'Resources', 'fr_FR' => 'Ressources'],
					'list' => array(
						'charter' => array(
							'href' => ['route' => 'instance/charter'],
							'target' => 'modal',
							'data-target' => 'modalShowCharterForm',
							'content_id' => 'show_charter_content',
							'html' => ['default' => 'Charter', 'fr_FR' => 'Charte'],
						),
						'generalTermsOfUse' => array(
							'href' => ['route' => 'instance/generalTermsOfUse'],
							'target' => 'modal',
							'data-target' => 'modalShowGtouForm',
							'content_id' => 'show_gtou_content',
							'html' => ['default' => 'General Terms Of Use', 'fr_FR' => 'Conditions Générales d’Utilisation'],
						),
					),
				)
			),
			'copyright' => array(
				'class' => 'footer-copyright py-3 text-center container-fluid',
				'html' => ['default' => '© 2018 Copyright: <a href="https://github.com/2pit-io/PpitCore/blob/master/license.txt"> 2pit.io </a>'],
			),
		),
	),
);
