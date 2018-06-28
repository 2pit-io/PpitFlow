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
			'PpitFlow\Controller\Landing' => 'PpitFlow\Controller\LandingController',
			'PpitFlow\Controller\Profile' => 'PpitFlow\Controller\ProfileController',
			'PpitFlow\Controller\Survey' => 'PpitFlow\Controller\SurveyController',
		),
	),
	
	'router' => array(
		'routes' => array(
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
				),
			),
			'profile' => array(
				'type'    => 'literal',
				'options' => array(
					'route'    => '/profile',
					'defaults' => array(
						'controller' => 'PpitFlow\Controller\Profile',
						'action'     => 'template1',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
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
				
				array('route' => 'profile/template1', 'roles' => array('guest')),
				array('route' => 'profile/template2', 'roles' => array('guest')),
				array('route' => 'profile/photoUpload', 'roles' => array('user')),
				
				array('route' => 'survey/fill', 'roles' => array('guest')),
				array('route' => 'survey/template1', 'roles' => array('guest')),
				array('route' => 'survey/template2', 'roles' => array('guest')),
				array('route' => 'survey/selectTest', 'roles' => array('operational_management', 'sales_manager', 'manager')),
				array('route' => 'survey/inviteToTest', 'roles' => array('operational_management', 'sales_manager', 'manager')),
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
);
