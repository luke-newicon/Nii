<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'project-action-assigned-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'issue_id'); ?>
		<?php echo $form->textField($model,'issue_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'issue_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'project_role'); ?>
		<?php echo $form->textField($model,'project_role',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'project_role'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'added'); ?>
		<?php echo $form->textField($model,'added'); ?>
		<?php echo $form->error($model,'added'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'assigned_by'); ?>
		<?php echo $form->textField($model,'assigned_by'); ?>
		<?php echo $form->error($model,'assigned_by'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->