<?php

/**
 * Development configuration
 * Usage:
 * - Local website
 * - Local DB
 * - Show all details on each error
 * - Gii module enabled
 */

return array(

	// Set YII_DEBUG and YII_TRACE_LEVEL flags
	'yiiDebug' => true,
	'yiiTraceLevel' => 3,
	
	'yiiSetPathOfAlias' => array(
		// uncomment the following to define a path alias
		//'local' => 'path/to/local-folder'
	),

	// This is the specific Web application configuration for this mode.
	// Supplied config elements will be merged into the main config array.
	'config' => array(
//		settings for domain specific apps
//		'hostname'=>'local.newicon.org',
//		'bannedSubDomains'=>array(
//			'www','hotspot','static'
//		),
//		
//		'domainDbHostname' => 'localhost',
//		'domainDbPrefix'=>'hotspot_',
//		'domainDb'=>array(
//			'username' => 'root',
//			'password' => '',
//			// 'schemaCachingDuration' => 3600,
//			'enableProfiling' => true,
//			'enableParamLogging' => true,
//		),
		
		'modules'=>array(
			'gii'=>array(
				'class'=>'system.gii.GiiModule',
				'password'=>'bonsan',
				// If removed, Gii defaults to localhost only. Edit carefully to taste.
				'ipFilters'=>array('127.0.0.1','::1'),
				'generatorPaths'=>array(
					'ext.gtc',   // Gii Template Collection
				),
			),
		),
		'components'=>array(
			
//			'db'=>array(
//				'emulatePrepare' => true,
//				// the next person who changes this section will get shot in the face!
//				// you can make specific config changes by putting a config.php file above the root 
//				// so it IS NOT GITTED!
////				'username' => 'root',
////				'password' => '',
////				'charset' => 'utf8',
////				'tablePrefix' =>'',
//				'schemaCachingDuration' => 3600,
//				'enableProfiling'=>true,
//				'enableParamLogging'=>true,
//			),
			'log'=>array(
				'class'=>'CLogRouter',
				'routes'=>array(
					array(
						'class'=>'CFileLogRoute',
						'categories'=>'error'
					),
					array(
						'class'=>'CWebLogRoute',
						'categories'=>'error, trace',
						'showInFireBug'=>true,
					),
					array(
						'class'=>'NProfileLogRoute',
					),
				),
			),
		)
	),
);