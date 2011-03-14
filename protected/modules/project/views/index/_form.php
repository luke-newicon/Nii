<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'project-project-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'code'); ?>
		<?php echo $form->textField($model,'code',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'completion_date'); ?>
		<?php echo $form->textField($model,'completion_date'); ?>
		<?php echo $form->error($model,'completion_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'estimated_time'); ?>
		<?php echo $form->textField($model,'estimated_time'); ?>
		<?php echo $form->error($model,'estimated_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tree_lft'); ?>
		<?php echo $form->textField($model,'tree_lft'); ?>
		<?php echo $form->error($model,'tree_lft'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tree_rgt'); ?>
		<?php echo $form->textField($model,'tree_rgt'); ?>
		<?php echo $form->error($model,'tree_rgt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tree_level'); ?>
		<?php echo $form->textField($model,'tree_level'); ?>
		<?php echo $form->error($model,'tree_level'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->