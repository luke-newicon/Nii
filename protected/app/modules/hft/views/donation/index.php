<?php $this->pageTitle = Yii::app()->name . ' - Donations'; ?>
<div class="page-header">
	<h2>Donations</h2>
	<div class="action-buttons">
		<?php echo NHtml::link('Add a Donation', array('create'), array('class'=>'btn primary')); ?>
<!--		<a class="btn primary" data-controls-modal="modal-contact-add" data-backdrop="static">Add a Contact</a>-->
	</div>
</div>
<?php
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'dataProvider' => $dataProvider,
	'filter' => $model,
	'id' => 'DonationAllGrid',
	'scopes' => array(
		'items' => array(
			'default' => array(
				'label'=>'All',
			),
		),
	),
	
	//'ajaxUpdate' => '#ContactAllGrid_c3',
	'enableButtons'=>true,
	'enableCustomScopes'=>false,
//	'columns'=>$model->columns(Setting::visibleColumns('Contact')),
));