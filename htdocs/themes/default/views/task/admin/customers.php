<?php $this->pageTitle = Yii::app()->name . ' - Customers'; ?>
<div class="page-header">
	<h1>Customers</h1>
	<div class="action-buttons">
		<?php echo NHtml::link('Add a Customer', '#', array('class'=>'btn primary')); ?>
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