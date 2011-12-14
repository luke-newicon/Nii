<div class="page-header">
	<h3>Contacts</h3>
	<div class="action-buttons">
		<?php echo NHtml::link('Add a Contact', array('addContact'), array('class'=>'btn primary')); ?>
<!--		<a class="btn primary" data-controls-modal="modal-contact-add" data-backdrop="static">Add a Contact</a>-->
	</div>
</div>
<?php
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'dataProvider' => $dataProvider,
	'filter' => $model,
	'id' => 'ContactGroupContactsGrid',
	'enableButtons'=>true,
	'enableCustomScopes'=>false,
)); ?>