<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'YiiHeart',

	// preloading 'log' component
	'preload'=>array('log','booster'),

	// path aliases
    'aliases' => array(
    	'booster' => realpath(__DIR__ . '/../extensions/yiibooster'), // change if necessary
    	'phpexcel' => realpath(__DIR__ . '/../vendor/phpexcel'), // change if necessary
    ),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.rights.*', 
		'application.modules.rights.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths' => array('ext.giiheart'),
		),
		'rights'=>array( 
			'superuserName'=>'admin', // Name of the role with super user privileges. 
			'authenticatedName'=>'Authenticated', // Name of the authenticated user role. 
			'userClass'=>'Admin',// Name of the user model class.
			'userIdColumn'=>'id', // Name of the user id column in the database. 
			'userNameColumn'=>'username', // Name of the user name column in the database. 
			'enableBizRule'=>true, // Whether to enable authorization item business rules. 
			'enableBizRuleData'=>false, // Whether to enable data for business rules. 
			'displayDescription'=>true, // Whether to use item description instead of name. 
			'flashSuccessKey'=>'RightsSuccess', // Key to use for setting success flash messages. 
			'flashErrorKey'=>'RightsError', // Key to use for setting error flash messages. 
			'install'=>false, // Whether to install rights. 'baseUrl'=>'/rights', // Base URL for Rights. Change if module is nested. 
			'layout'=>'rights.views.layouts.main', // Layout to use for displaying Rights. 
			'appLayout'=>'application.views.layouts.main', // Application layout. 
			'cssFile'=>'rights.css', // Style sheet file to use for Rights. 
			'debug'=>false, // Whether to enable debug mode. 
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'class'=>'RWebUser',
		),
		'authManager' => array(
			'class'=>'RDbAuthManager',
			'connectionID'=>'db',
            		'itemTable'=>'tb_authitem',
			'itemChildTable'=>'tb_authitemchild',
			'assignmentTable'=>'tb_authassignment',
			'rightsTable'=>'tb_rights',
	    ),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'urlSuffix' => '/',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=yiiheart',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'booster' => array(
		    'class' => 'booster.components.Bootstrap',
		    //'responsiveCss'=>false,
		    'fontAwesomeCss'=> true,
		    'minify'=>true,
		),		
        'request'=>array(
            'enableCsrfValidation'=>true,
            'enableCookieValidation'=>true,
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);
