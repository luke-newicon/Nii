<?php $this->pageTitle = Yii::app()->name . ' - All Contacts'; ?>
<div class="page-header">
	<h2>All Contacts</h2>
	<div class="action-buttons">
		<a class="btn primary" data-controls-modal="modal-contact-add" data-backdrop="static">Add a Contact</a>
	</div>
</div>
<?php
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'dataProvider' => $dataProvider,
	'filter' => $model,
	'id' => 'ContactAllGrid',
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
	'columns'=>$model->columns(Setting::visibleColumns('Contact')),
//	'columns' => array(
//		'name',
//		'city',
//		'county',
//		'email',
//	),
));