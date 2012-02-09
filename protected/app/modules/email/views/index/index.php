<div class="page-header">
	<h1>Email Campaigns</h1>
	<div class="action-buttons">
		<?php echo NHtml::link('Create a New Email', array('create'), array('class'=>'btn btn-primary')); ?>
	</div>
</div>
<?php
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'dataProvider' => $dataProvider,
	'filter' => $model,
	'id' => 'ManageEmailCampaignsGrid',
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