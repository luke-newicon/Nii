<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'project-task-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'project_id',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'estimated_time'); ?>
		<?php echo $form->textField($model,'estimated_time'); ?>
		<?php echo $form->error($model,'estimated_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'out_of_scope'); ?>
		<?php echo $form->textField($model,'out_of_scope'); ?>
		<?php echo $form->error($model,'out_of_scope'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'assigned_user'); ?>
		<?php echo $form->textField($model,'assigned_user'); ?>
		<?php echo $form->error($model,'assigned_user'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sprint_id'); ?>
		<?php echo $form->textField($model,'sprint_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'sprint_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->