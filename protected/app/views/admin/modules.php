<?php


$modules = Yii::app()->niiModules;

foreach($modules as $name => $module){
	$data[] = array('name'=>$name);
}

$dataProvider = new CArrayDataProvider($data);

$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'name',
	),
));