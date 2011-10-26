<?php
$this->pageTitle=Yii::app()->name . ' - All Contacts';
?>
<h2>All Contacts</h2>
<?php 

$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'id'=> 'ContactAllGrid',
//	'scopes' => array(
//		'items' => array(
//			'default' => array(
//				'label'=>'All',
//			),
//		),
//	),
//	'enableButtons'=>true,
	//'columns'=>$model->columns(Setting::visibleColumns('Contact')),
	'columns' => array('name','city','county','email'),
));