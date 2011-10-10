<?php

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(

	// Set YII_DEBUG and YII_TRACE_LEVEL flags
	'yiiDebug' => false,
	'yiiTraceLevel' => 0,

	// Static function Yii::setPathOfAlias()
	'yiiSetPathOfAlias' => array(
		// uncomment the following to define a path alias
		//'local' => 'path/to/local-folder'
	),

	// This is the main Web application configuration. Any writable
	// CWebApplication properties can be configured here.
	'config' => array(
		'hostname'=>'hotspot-app.com',
		'bannedSubDomains'=>array(
			'www','hotspot','static'
		),
		
		'domainDbHostname' => 'localhost',
		'domainDbPrefix'=>'hotspot_',
		'domainDb'=>array(
			'username' => 'newicon',
			'password' => 'bonsan',
			'schemaCachingDuration' => 3600,
			'enableProfiling' => true,
			'enableParamLogging' => true,
		),

		// application components
		'components'=>array(
			'db'=>array(
				'connectionString' => 'mysql:host=localhost;dbname=hotspot',
				'emulatePrepare' => true,
				// the next person who changes this section will get shot in the face!
				// you can make specific config changes by putting a config.php file above the root 
				// so it IS NOT GITTED!
				'username' => 'newicon',
				'password' => 'bonsan',
				'charset' => 'utf8',
				'tablePrefix' =>'',
				'schemaCachingDuration' => 3600,
				'enableProfiling'=>false,
				'enableParamLogging'=>false,
			),
			'fileManager'=>array(
				'location'=>Yii::getPathOfAlias('domain.uploads'),
			),
		),

		// application-level parameters that can be accessed
		// using Yii::app()->params['paramName']
		'params'=>array(
			// this is used in contact page
			'adminEmail'=>'webmaster@example.com',
		),
	)
);