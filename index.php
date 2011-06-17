<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/yii/yii.php';
$nii=dirname(__FILE__).'/protected/modules/nii/Nii.php';
$config=dirname(__FILE__).'/protected/app/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
require_once($nii);

$rootConf = dirname(__FILE__).'/../config.php';
if(file_exists($rootConf)){
	 $rootConf = require $rootConf;
	$config = require $config;
	//unset($config['components']['db']);
	$config = CMap::mergeArray($config, $rootConf);
}
Yii::createApplication('Nii',$config)->run();
/**
 * debug print functionn
 * @param mixed $debugObj
 */
function dp($debugObj){	echo '<pre>'.CHtml::encode(print_r($debugObj,true)).'</pre>'; }