<?php $this->pageTitle = Yii::app()->name . ' - All Contacts'; ?>
<div class="page-header">
	<h1>All Contacts</h1>
	<div class="action-buttons">
		<?php echo NHtml::link('Add a Person', CHtml::normalizeUrl(array('/contact/admin/create/type/Person')), array('class'=>'btn btn-primary')); ?>
		<?php echo NHtml::link('Add an Organisation', CHtml::normalizeUrl(array('/contact/admin/create/type/Organisation')), array('class'=>'btn btn-primary')); ?>
	</div>
</div>
<?php
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'dataProvider' => $dataProvider,
	'filter' => $model,
	'id' => 'ContactAllGrid',
	'scopes' => true,
	'enableButtons'=>true,
	'enableCustomScopes'=>true,
	'enableBulkActions'=>true,
)); ?>
<div id="createContactDialog"></div>