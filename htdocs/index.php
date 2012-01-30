<?php

require_once (dirname(__FILE__) . '/../protected/app/config/Environment.php');
// set environment * new Environment('PRODUCTION'); (override mode)
$env = new Environment();

Yii::createWebApplication($env->config)->run();

/**
 * debug print functionn
 * TODO: move into a generic function file
 * @param mixed $debugObj
 */
function dp($debugObj) {
    echo '<pre>' . CHtml::encode(print_r($debugObj, true)) . '</pre>';
}