<?php $this->pageTitle = Yii::app()->name . ' - Suppliers'; ?>
<div class="page-header">
	<h1>Suppliers</h1>
	<div class="action-buttons">
		<?php echo NHtml::link('Add a Supplier', '#', array('class'=>'btn primary')); ?>
	</div>
</div>
<?php
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'dataProvider' => $dataProvider,
	'filter' => $model,
	'id' => 'CustomersGrid',
	'enableButtons'=>true,
	'enableCustomScopes'=>false,
	'scopes'=>array(
		'enableCustomScopes'=>false
	),
));