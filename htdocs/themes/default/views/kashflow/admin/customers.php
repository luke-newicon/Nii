<div class="page-header">
	<h2>Kashflow Customers</h2>
</div>
<?php
$sort = new CSort;
$sort->attributes = array('Name','Contact','Email','Telephone','Mobile');
$dataProvider = new CArrayDataProvider($customers,array(
	'keyField'=>'CustomerID',
	'pagination' => array(
		'pageSize' => '30',
	),
	'sort' => $sort,
));
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'id' => 'kashflow-customers-grid',
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