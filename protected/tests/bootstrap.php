<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../../yii/yii.php';
$nii=dirname(__FILE__).'/../../protected/app/Nii.php';


// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
require_once($nii);

// change the following paths if necessary
$yiit=dirname(__FILE__).'/../../yii/yiit.php';
$config=dirname(__FILE__).'/../app/config/test.php';
$rootConf = dirname(__FILE__).'/../../../config.php';

if(file_exists($rootConf)){
	$rootConf = require $rootConf;
	$config = require $config;
	$config = CMap::mergeArray($config, $rootConf);
}

require_once($yiit);
require_once(dirname(__FILE__).'/WebTestCase.php');

Yii::createApplication('Nii',$config);