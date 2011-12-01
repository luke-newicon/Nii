<div class="page-header">
	<h2>Audit Trail</h2>
</div>
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