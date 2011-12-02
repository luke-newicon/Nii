<?php $this->pageTitle = Yii::app()->name . ' - All Contacts'; ?>
<div class="page-header">
	<h2>All Contacts</h2>
	<div class="action-buttons">
		<?php //echo NHtml::link('Add a Contact', '#', array('class'=>'btn primary', 'onclick' => $model->createContactDialog())); ?>
		<?php echo NHtml::link('Add a Person', CHtml::normalizeUrl(array('/contact/admin/create/type/Person')), array('class'=>'btn primary')); ?>
		<?php echo NHtml::link('Add an Organisation', CHtml::normalizeUrl(array('/contact/admin/create/type/Organisation')), array('class'=>'btn primary')); ?>
<!--		<a class="btn primary" data-controls-modal="modal-contact-add" data-backdrop="static">Add a Contact</a>-->
	</div>
</div>
<?php
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'dataProvider' => $dataProvider,
	'filter' => $model,
	'id' => 'ContactAllGrid',
	'enableButtons'=>true,
	'enableCustomScopes'=>true,
)); ?>
<div id="createContactDialog"></div>