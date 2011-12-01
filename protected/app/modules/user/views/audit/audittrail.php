<h2>Audit Trail</h2>
<?php 
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'id'=> 'AuditTrailGrid',
	'enableButtons'=>true,
//	'scopes' => array(
//		'items' => array(
//			'default' => 'All',
//		),
//	),
));