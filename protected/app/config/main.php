<?php


// uncomment the following to define a path alias
//Yii::setPathOfAlias('modules',dirname(__FILE__).DS.'..'.DS.'..'.DS.'modules');
Yii::setPathOfAlias('base',    dirname(dirname(dirname(dirname(__FILE__)))));
Yii::setPathOfAlias('app',     Yii::getPathOfAlias('base.protected.app'));
Yii::setPathOfAlias('modules', Yii::getPathOfAlias('base.protected.modules'));
Yii::setPathOfAlias('nii',     Yii::getPathOfAlias('modules.nii'));
$JQUERY_THEMEURL = rtrim(dirname($_SERVER['SCRIPT_NAME']),'/').'/css/jqueryui';
$JQUERY_THEME = 'nii';

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>Yii::getPathOfAlias('app'),
	'name'=>'Newicon',
	'domain'=>true,
	'timezone'=>'Europe/London',
	'hostname'=>'local.ape-project.org',
	// preloading 'log' component
	'preload'=>array('log','NFileManager'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.*',
		'modules.nii.components.*',
		'modules.nii.widgets.*',
		'application.validators.*',
		'application.vendors.*',
		'application.vendors.FirePHPCore.*',
		'application.widgets.*',
		'modules.user.models.*',
        'modules.user.components.*',
	),
	'theme'=>'nii',

	'modulePath'=>Yii::getPathOfAlias('modules'),
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'bonsan',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths'=>array(
				'ext.gtc',   // Gii Template Collection
			),
		),
		//'crm',
		//'kashflow',
		//'email',
		'user'=>array(
			'registrationCaptcha'=>false,
			'termsRequired'=>false,
			'returnUrl'=>array('/project/index/index'),
			'profileUrl'=>array('/project/index/index')
		),
		'project',
		//'hosting',
		//'account',
		//'payment',
		'dev'=>array(
			'modules'=>array('kanban')
		),
		'nii'
	),

	// application components
	'components'=>array(
		'sprite'=>array(
			'class'=>'nii.components.sprite.NSprite',
			'imageFolderPath'=>array(
				Yii::getPathOfAlias('modules.project.images')
			)
		),
		'user'=>array(
			'class'=>'NWebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl' => array("/user/account/login"),
			//'returnUrl'=>''
		),
		'authManager'=>array(
			'class'=>'CDbAuthManager',
			'connectionID'=>'db',
			'assignmentTable'=>'auth_assignment',
			'itemChildTable'=>'auth_item_child',
			'itemTable'=>'auth_item',
			'defaultRoles'=>array('authenticated', 'guest'),
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'login'=>'/user/account/login',
				'logout'=>'/user/account/logout'
			),
			'showScriptName'=>false,
		),

//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
		// uncomment the following to use a MySQL database

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=nii',
			'emulatePrepare' => true,
			// the next person who changes this section will get shot in the face!
			// you can make specific config changes by putting a config.php file above the root 
			// so it IS NOT GITTED!
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
		'image'=>array(
          'class'=>'nii.components.NImage',
            // GD or ImageMagick
            'driver'=>'GD',
            // ImageMagick setup path
            'params'=>array('directory'=>'/Applications/XAMPP/xamppfiles/bin'),
			// An array of different sizes which can be reffered to throughout the program
			'types'=>array(
				'grid'=>array(
					'resize' => array('width'=>150, 'height'=>150, 'master'=>'width', 'scale'=>'down')
				),
				'project-drop-down'=>array(
					'resize' => array('width'=>24, 'height'=>24, 'master'=>'max', 'scale'=>'down')
				),
				'project-drop-down-32'=>array(
					'resize' => array('width'=>32, 'height'=>32, 'master'=>'max', 'scale'=>'down')
				),
				'project-drop-down-48'=>array(
					'resize' => array('width'=>48, 'height'=>48, 'master'=>'max', 'scale'=>'down')
				),
				'project-drop-down-48-crop'=>array(
					'resize' => array('width'=>48, 'height'=>48, 'master'=>'width', 'scale'=>'down'),
					'crop' => array('width'=>48, 'height'=>48, 'top'=>'top', 'left'=>'center')
				),
				'project-drop-down-16'=>array(
					'resize' => array('width'=>16, 'height'=>16, 'master'=>'max', 'scale'=>'down')
				),
			),
			'notFoundImage'=>Yii::getPathOfAlias('base.images.newicon').'.png',
        ),
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
                    'class'=>'CProfileLogRoute',
					'showInFireBug'=>true,
                ),
			),
		),
		'cache' => array(
			'class' => 'CFileCache',
		),

		// enables theme based JQueryUI's
        'widgetFactory' => array(
            'widgets' => array(
                'CJuiAutoComplete' => array(
                    'themeUrl' => $JQUERY_THEMEURL,
                    'theme' => $JQUERY_THEME,
                ),
                'CJuiDialog' => array(
                    'themeUrl' => $JQUERY_THEMEURL,
                    'theme' => $JQUERY_THEME,
                ),
                'CJuiWidget' => array(
                    'themeUrl' => $JQUERY_THEMEURL,
                    'theme' => $JQUERY_THEME,
                ),
				'CJuiInputWidget' => array(
                    'themeUrl' => $JQUERY_THEMEURL,
                    'theme' => $JQUERY_THEME,
                ),
				'CJuiTabs' => array(
                    'themeUrl' => $JQUERY_THEMEURL,
                    'theme' => $JQUERY_THEME,
                ),
				'CJuiWidget' => array(
                    'themeUrl' => $JQUERY_THEMEURL,
                    'theme' => $JQUERY_THEME,
                ),
				'CJuiButton' => array(
                    'themeUrl' => $JQUERY_THEMEURL,
                    'theme' => $JQUERY_THEME,
                ),
				'CJuiDatePicker' => array(
                    'themeUrl' => $JQUERY_THEMEURL,
                    'theme' => $JQUERY_THEME,
                ),
			)
		),
		'fileManager'=>array(
			'class'=>'NFileManager',
			'location'=>Yii::getPathOfAlias('base.protected.app.runtime'),
			'locationIsAbsolute'=>true,
			'defaultCategory' => 'attachments',
			'categories' => array(
					'attachments' => 'attachments',
					'profile_photos' => 'profile_photos',
					'logos' => 'logos',
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);