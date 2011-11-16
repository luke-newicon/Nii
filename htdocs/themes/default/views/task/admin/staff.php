<?php $this->pageTitle = Yii::app()->name . ' - Staff'; ?>
<div class="page-header">
	<h2>Staff</h2>
	<div class="action-buttons">
		<?php echo NHtml::link('Add a Staff Member', '#', array('class'=>'btn primary')); ?>
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