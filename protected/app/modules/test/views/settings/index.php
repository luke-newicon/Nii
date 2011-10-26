<?php
$config = array(
	'id' => 'TestSettingForm',
	'elements' => Yii::app()->getModule('test')->settings(),
	'buttons' => array(
		'save'=>array(
            'type'=>'submit',
            'label'=>'Save',
        ),
	),
);
$form = new CForm($config, $model);
echo $form;