<?php


$modules = Yii::app()->niiModules;

foreach($modules as $id => $module){
	$data[] = array(
		'id' => $id,
		'name'=>$module->name,
		'description' => $module->description,
		'version' => $module->version,
		'state' => true,
	);
}

$dataProvider = new CArrayDataProvider($data);

$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'name',
		'description',
		'version',
		array(
			'name' => 'state',
			'type' => 'raw',
			'htmlOptions' => array('width'=>'100','align'=>'center'),
			'value' => 'CHtml::dropDownList("state",$data["state"], array("disabled","active"))',
		),
	),
));