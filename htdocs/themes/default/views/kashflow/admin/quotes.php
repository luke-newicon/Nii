<div class="page-header">
	<h2>Kashflow Quotes</h2>
</div>
<?php
$sort = new CSort;
$sort->attributes = array('InvoiceNumber', 'InvoiceDate');
$dataProvider = new CArrayDataProvider($quotes, array(
	'keyField' => 'InvoiceDBID',
	'pagination' => array(
		'pageSize' => '30',
	),
	'sort' => $sort,
));
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'id' => 'kashflow-quotes-grid',
	'dataProvider' => $dataProvider,
	'columns' => array(
		'InvoiceNumber',
		'EstimateCategory',
		'CustomerReference',
		'InvoiceDate',
	),
));