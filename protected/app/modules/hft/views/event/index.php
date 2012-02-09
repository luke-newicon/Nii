<?php $this->pageTitle = Yii::app()->name . ' - Events'; ?>
<div class="page-header">
	<h1>Events</h1>
	<div class="action-buttons">
		<?php echo NHtml::link('Add an Event', array('create'), array('class'=>'btn btn-primary')); ?>
	</div>
</div>
<?php
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'dataProvider' => $dataProvider,
	'filter' => $model,
	'id' => 'EventAllGrid',
//	'scopes' => array(
//		'items' => array(
//			'default' => array(
//				'label'=>'All',
//			),
//		),
//	),
	
	//'ajaxUpdate' => '#ContactAllGrid_c3',
	'enableButtons'=>true,
	'enableCustomScopes'=>true,
	'scopes'=>true,
//	'columns'=>$model->columns(Setting::visibleColumns('Contact')),
)); ?>