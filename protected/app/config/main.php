<?php

// define variables to mimic alias paths, we can not access Yii::getPathOfAlias yet.
// these variables are availiable in the other config files.
$public = realpath(dirname(dirname(dirname(dirname(__FILE__)))));
$base = realpath(dirname($public));
$htdocs = realpath("$public/htdocs");
$app = realpath("$public/protected/app");
$modules = realpath("$public/protected/app/modules");
$nii = realpath("$modules/nii");

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	// Set yiiPath (relative to Environment.php)
	'yiiPath' => realpath(dirname(__FILE__) . '/../../../yii/yii.php'),
	'yiitPath' => realpath(dirname(__FILE__) . '/../../../yii/yiit.php'),
	// Set YII_DEBUG and YII_TRACE_LEVEL flags
	'yiiDebug' => true,
	'yiiTraceLevel' => 0,
	'yiiSetPathOfAlias' => array(
		'base' => $base,
		'public' => $public,
		'htdocs' => $htdocs,
		'app' => $app,
		'modules' => $modules,
		'nii' => $nii,
	),
	// This is the main Web application configuration. Any writable
	// CWebApplication properties can be configured here.
	'config' => array(
		'basePath' => $app,
		'sourceLanguage' => 'en',
		'domain' => false,
		'hostname' => 'local.newicon.org',
		// preloading 'log' component
		'preload' => array('log', 'NFileManager'),
		// autoloading model and component classes
		'defaultController' => 'admin',
		'import' => array(
			'application.models.*',
			'application.components.*',
			'ext.*',
			'application.modules.nii.components.*',
			'application.modules.nii.widgets.*',
			'application.vendors.*',
			'application.vendors.FirePHPCore.*',
			'application.widgets.*',
			'application.modules.user.models.*',
			'application.modules.user.components.*',
			'application.extensions.bootstrap.components.*',
		),
		'theme' => 'default',
		'modulePath' => $modules,
		'modules' => array(
			'nii',
			'user' => array(
				'registrationCaptcha' => false,
				'termsRequired' => false,
				'returnUrl' => array('/admin'),
				'sendActivationMail' => true,
				'activeAfterRegister' => true,
				'usernameRequired' => false,
				'showUsernameField' => false
			),
			'admin'
		),
		// application components
		'components' => array(
			'menus' => array(
				'class' => 'NMenuManager',
			),
			'bootstrap'=>array(
				'class' => 'Bootstrap',
			),
			'settings'=>array(
				'class' => 'NSettings',
			),
			'user' => array(
				'class' => 'NWebUser',
				// enable cookie-based authentication
				'allowAutoLogin' => true,
				'loginUrl' => array("/user/account/login"),
			),
			'authManager' => array(
				'class' => 'CDbAuthManager',
				'connectionID' => 'db',
				'assignmentTable' => 'auth_assignment',
				'itemChildTable' => 'auth_item_child',
				'itemTable' => 'auth_item',
				'defaultRoles' => array('authenticated', 'guest'),
			),
			// uncomment the following to enable URLs in path-format
			'urlManager' => array(
				'urlFormat' => 'path',
				'rules' => array(
					'<controller:\w+>/<id:\d+>' => '<controller>/view',
					'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
					'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
				),
				'showScriptName' => false,
			),

			'errorHandler' => array(
				'class' => 'NErrorHandler',
				// Default error action
				'errorAction' => 'error',
			),
			'image' => array(
				'class' => 'nii.components.NImage',
				// GD or ImageMagick
				'driver' => 'GD',
				// ImageMagick setup path
				'params' => array('directory' => '/Applications/XAMPP/xamppfiles/bin'),
				// An array of different sizes which can be reffered to throughout the program
				'types' => array(
					'grid' => array(
						'resize' => array('width' => 150, 'height' => 150, 'master' => 'width', 'scale' => 'down')
					),
					'grid-thumbnail-person' => array(
						'resize' => array('width' => 24, 'height' => 24, 'master' => 'width', 'scale' => 'down'),
						'noimage' => realpath("$htdocs/images/blank-profile.jpg"),
					),
					'grid-thumbnail-organisation' => array(
						'resize' => array('width' => 24, 'height' => 24, 'master' => 'width', 'scale' => 'down'),
						'noimage' => realpath("$htdocs/images/blank-profile-org.jpg"),
					),
					'profile-main-person' => array(
						'resize' => array('width' => 145, 'height' => 180, 'master' => 'width', 'scale' => 'down')
					),
					'profile-main-organisation' => array(
						'resize' => array('width' => 145, 'height' => 180, 'master' => 'width', 'scale' => 'down'),
						'noimage' => realpath("$htdocs/images/blank-profile-org.jpg"),
					),
					'profile-menu' => array(
						'resize' => array('width' => 40, 'height' => 40, 'master' => 'max', 'scale' => 'down')
					),
					'note-thumbnail' => array(
						'resize' => array('width' => 48, 'height' => 48, 'master' => 'width', 'scale' => 'down')
					),
				),
				'notFoundImage' => realpath("$htdocs/images/blank-profile.jpg"),
			),
			'cache' => array(
				'class' => 'CFileCache',
			),
			'fileManager' => array(
				'class' => 'NFileManager',
				'location' => realpath($public."/../files/uploads"),
				'locationIsAbsolute' => true,
				'defaultCategory' => 'attachments',
				'categories' => array(
					'attachments' => 'attachments',
					'profile_photos' => 'profile_photos',
					'logos' => 'logos',
				),
			),
			'sprite' => array(
				'class' => 'nii.components.sprite.NSprite',
				'imageFolderPath'=>array(
					realpath($app.'/sprite'),
				),
			),
			'widgetFactory' => array(
				'widgets' => array(
					'NGridView' => array(
						'template' => "{scopes}\n{buttons}<div class='grid-top-summary'>{summary} {pager}</div>{items}\n{pager}",
					),
					'CGridView' => array(
						'template' => "<div class='grid-top-summary'>{summary} {pager}</div>{items}\n{pager}",
						'summaryText' => "Displaying {start}-{end} of {count} results",
					),
					'NScopeList' => array(
						'htmlOptions' => array(
							'class' => 'scopes',
						),
					//					'displayCurrentScopeDescription'=>false,
					//					'separator' => false,
					//					'displayScopesCount'=>false,
					),
					'CLinkPager' => array(
						'header' => '',
					),
				),
			),
		),
	)
);