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
		// application components
		'components'=>array(
			'db'=>array(
				'schemaCachingDuration' => 86400,
				'enableProfiling'=>false,
				'enableParamLogging'=>false,
			),
			'fileManager'=>array(
				'location'=>realpath("$base/files"),
			),
			// log errors to file runtime application.log
			'log'=>array(
				'class'=>'CLogRouter',
				'routes'=>array(
					array(
						'class'=>'CFileLogRoute',
						'levels'=>'error, warning'
					)
				),
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