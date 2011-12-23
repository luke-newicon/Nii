<div class="page-header">
	<h2>Manage Design Templates</h2>
	<div class="action-buttons">
		<?php echo NHtml::link('Create a New Template', array('create'), array('class'=>'btn primary')); ?>
	</div>
</div>
<?php
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'dataProvider' => $dataProvider,
	'filter' => $model,
	'id' => 'ManageEmailTemplateGrid',
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