<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'project-time-record-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
		<?php echo $form->hiddenField($model,'task_id',array('size'=>11,'maxlength'=>11)); ?>
	<div class="row">
		<?php // echo $form->labelEx($model,'time_started'); ?>
		<?php // echo $form->textField($model,'time_started'); ?>
		<?php // echo $form->error($model,'time_started'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_started'); ?>
		<?php $this->widget('application.widgets.forms.TimeAndDate',array('model'=>$model,'attribute'=>'time_started'));?>
		<?php echo $form->error($model,'time_started'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_finished'); ?>
		<?php $this->widget('application.widgets.forms.TimeAndDate',array('model'=>$model,'attribute'=>'time_finished'));?>
		<?php echo $form->error($model,'time_finished'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropdownlist($model,'type',$model->getTypes(true)); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save',array('class'=>'btn btnN')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->