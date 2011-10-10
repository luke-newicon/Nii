<?php

//require_once (dirname(__FILE__).'/../yii/yii.php');
require_once (dirname(__FILE__).'/../protected/app/Yii.php');
// set environment * new Environment('PRODUCTION'); (override mode)
$env = new Environment(); 

//$env->showDebug();

if ($env->hasLocalConfig)
	Yii::createWebApplication($env->config)->run();
else
	Yii::createWebApplication($env->config)->goToInstall();


/**
 * debug print functionn
 * @param mixed $debugObj
 */
function dp($debugObj){	echo '<pre>'.CHtml::encode(print_r($debugObj,true)).'</pre>'; }