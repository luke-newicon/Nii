<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/yii/yii.php';
$config=dirname(__FILE__).'/protected/app/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);

$rootConf = dirname(__FILE__).'../config.php';
if(file_exists($rootConf)){
	unset($config['components']['db']);
	$config = CMap::mergeArray($config, $rootConf);
}
Yii::createWebApplication($config)->run();

/**
 * debug print functionn
 * @param mixed $debugObj
 */
function dp($debugObj){	echo '<pre>'.print_r($debugObj,true).'</pre>'; }