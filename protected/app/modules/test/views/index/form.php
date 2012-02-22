<div class="page-header">
	<h1>Test Form</h1>
</div>
<?php $form = $this->beginWidget('nii.widgets.NActiveForm', array(
	'id' => 'test-contact-form',
)); ?>

	<?php echo $form->field($model, 'name') ?>
	<?php echo $form->field($model, 'extra.comments') ?>

<?php $this->endWidget() ?>