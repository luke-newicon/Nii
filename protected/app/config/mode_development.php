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
		'modules'=>array(
			'gii'=>array(
				'class'=>'system.gii.GiiModule',
				'password'=>'bonsan',
				// If removed, Gii defaults to localhost only. Edit carefully to taste.
				'ipFilters'=>array('127.0.0.1','::1'),
				'generatorPaths'=>array(
					'ext.gtc',   // Gii Template Collection
					'ext.bootstrap.gii',
				),
			),
//			'dev'=>array(
//				'modules'=>array('kanban')
//			),
		),
		'components'=>array(
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
			// development mode we want to profile the database and have debug options
			'db'=>array(
				'enableProfiling'=>true,
				'enableParamLogging'=>true,
			),
		)
	),
);