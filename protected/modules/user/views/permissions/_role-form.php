<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'authitem',
	'enableAjaxValidation'=>true,
	'focus'=>array($model,'name'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'name'); ?>
		<?php echo CHtml::hiddenField('roleOldName', $model->name); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
	<?php echo CHtml::hiddenField('roleScenario', $model->getScenario()); ?>
<?php $this->endWidget(); ?>
</div>