<div class="page-header">
	<h2>Manage Saved Campaigns</h2>
	<div class="action-buttons">
		<?php echo NHtml::link('New Saved Campaign', array('create'), array('class'=>'btn primary')); ?>
<!--		<a class="btn primary" data-controls-modal="modal-contact-add" data-backdrop="static">Add a Contact</a>-->
	</div>
</div>
<?php
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'dataProvider' => $dataProvider,
	'filter' => $model,
	'id' => 'ManageEmailCampaignTemplatesGrid',
//	'scopes' => array(
//		'items' => array(
//			'default' => array(
//				'label'=>'All',
//			),
//		),
//	),
	
	'enableButtons'=>true,
	'enableCustomScopes'=>false,
	'scopes'=>array('enableCustomScopes'=>false),
)); ?>