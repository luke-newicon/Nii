<?php
define('DS',DIRECTORY_SEPARATOR);
// uncomment the following to define a path alias
 Yii::setPathOfAlias('modules',dirname(__FILE__).DS.'..'.DS.'..'.DS.'modules');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DS.'..',
	'name'=>'Projects!',

	// preloading 'log' component
	'preload'=>array('log','nii'),



	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.*',
		'application.validators.*',
		'application.Nii',
		'modules.user.models.*',
        'modules.user.components.*',

	),
	'theme'=>'classic',

	'modulePath'=>dirname(__FILE__).'/../../modules',
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'bonsan',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'crm',
		'kashflow',
		'user',
	),

	// application components
	'components'=>array(
		'nii'=>array(
			'class'=>'Nii'
		),

		'user'=>array(
			'class'=>'NWebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl' => array('/users/login'),
			
		),
		'components'=>array(
			'authManager'=>array(
				'class'=>'CDbAuthManager',
				'defaultRoles'=>array('authenticated', 'guest'),
			),
		),
		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'http://<company:\w+>.<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'http://<company:\w+>.<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'http://<company:\w+>.<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
			'showScriptName'=>false,
		),

//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
		// uncomment the following to use a MySQL database

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=project_manager',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'tablePrefix' =>'',
			//'schemaCachingDuration' => 3600,
			'enableProfiling'=>true,
			'enableParamLogging'=>true,
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
				),
				array(
					'class'=>'CWebLogRoute',
					'categories'=>'system.db.CDbCommand',
					'showInFireBug'=>true,
				),
			),
		),
		'cache' => array(
			'class' => 'CFileCache',
		),
		
		'viewRenderer'=>array(
            'class'=>'CPradoViewRenderer',
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);