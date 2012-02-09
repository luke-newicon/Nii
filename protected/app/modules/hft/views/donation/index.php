<?php $this->pageTitle = Yii::app()->name . ' - Donations'; ?>
<div class="page-header">
	<h1>Donations</h1>
	<div class="action-buttons">
		<?php echo NHtml::link('Add a Donation', array('create'), array('class'=>'btn btn-primary')); ?>
	</div>
</div>
<?php
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'dataProvider' => $dataProvider,
	'filter' => $model,
	'id' => 'DonationAllGrid',
	'scopes' => true,
	//'ajaxUpdate' => '#ContactAllGrid_c3',
	'enableButtons'=>true,
	'enableCustomScopes'=>true,
//	'columns'=>$model->columns(Setting::visibleColumns('Contact')),
));