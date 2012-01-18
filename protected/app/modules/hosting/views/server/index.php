<div class="page-header">
	<h2>Servers</h2>
	<div class="action-buttons">
		<?php echo NHtml::link('Add a New Server', array('create'), array('class'=>'btn primary')); ?>
	</div>
</div>
<?php
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'dataProvider' => $dataProvider,
	'filter' => $model,
	'id' => 'HostingServersGrid',
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