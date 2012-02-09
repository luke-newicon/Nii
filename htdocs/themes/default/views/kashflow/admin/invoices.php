<div class="page-header">
	<h1>Kashflow Invoices</h1>
</div>
<?php
$sort = new CSort;
$sort->attributes = array('InvoiceNumber', 'InvoiceDate');
$dataProvider = new CArrayDataProvider($invoices, array(
	'keyField' => 'InvoiceDBID',
	'pagination' => array(
		'pageSize' => '30',
	),
	'sort' => $sort,
));
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'id' => 'kashflow-invoices-grid',
	'dataProvider' => $dataProvider,
	'columns' => array(
		'InvoiceNumber',
		'CustomerReference',
		'InvoiceDate',
	),
));