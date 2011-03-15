<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'project-time-record-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'date_of_work'); ?>
		<?php echo $form->textField($model,'date_of_work'); ?>
		<?php echo $form->error($model,'date_of_work'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_spent'); ?>
		<?php echo $form->textField($model,'time_spent',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'time_spent'); ?>
	</div>
		<?php echo $form->hiddenField($model,'task_id',array('size'=>11,'maxlength'=>11)); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'added'); ?>
		<?php echo $form->textField($model,'added'); ?>
		<?php echo $form->error($model,'added'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'added_by'); ?>
		<?php echo $form->textField($model,'added_by'); ?>
		<?php echo $form->error($model,'added_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->