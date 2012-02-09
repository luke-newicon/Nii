<?php $this->pageTitle = Yii::app()->name . ' - Categories'; ?>
<div class="page-header">
	<h1>Categories</h1>
</div>
<?php
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'dataProvider' => $dataProvider,
	'filter' => $model,
	'id' => 'CategoryAllGrid',
//	'scopes' => array(
//		'items' => array(
//			'default' => array(
//				'label'=>'All',
//			),
//		),
//	),
	
	//'ajaxUpdate' => '#ContactAllGrid_c3',
	'enableButtons'=>true,
	'enableCustomScopes'=>false,
//	'columns'=>$model->columns(Setting::visibleColumns('Contact')),
));