<?php

require_once (dirname(__FILE__) . '/../protected/app/config/Environment.php');
// set environment * new Environment('PRODUCTION'); (override mode)
$env = new Environment();

if ($env->hasLocalConfig)
    Yii::createWebApplication($env->config)->run();
else
    Yii::createWebApplication($env->config)->goToInstall();

/**
 * debug print functionn
 * TODO: move into a generic function file
 * @param mixed $debugObj
 */
function dp($debugObj) {
    echo '<pre>' . CHtml::encode(print_r($debugObj, true)) . '</pre>';
}