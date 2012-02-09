<div class="page-header">
	<h1>Kashflow Suppliers</h1>
</div>
<?php
$sort = new CSort;
$sort->attributes = array('Name','Contact','Email','Telephone','Mobile');
$dataProvider = new CArrayDataProvider($suppliers,array(
	'keyField'=>'SupplierID',
	'pagination' => array(
		'pageSize' => '30',
	),
	'sort' => $sort,
));
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'id' => 'kashflow-suppliers-grid',
	'dataProvider' => $dataProvider,
	'columns' => array(
		'Name',
		'Contact',
		'Email' => array(
			'name' => 'Email',
			'type' => 'raw',
			'value' => 'CHtml::link($data->Email,\'mailto:\'.$data->Email)',
		),
		'Telephone',
		'Mobile',
	),
));