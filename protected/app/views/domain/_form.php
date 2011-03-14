<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'hosting-domain-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'domain'); ?>
		<?php echo $form->textField($model,'domain',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'domain'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'registered_date'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
			'model'=>$model,
			'attribute'=>'registered_date'
		));?>
		<?php echo $form->error($model,'registered_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'expires_date'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
			'model'=>$model,
			'attribute'=>'expires_date',
			'options'=>array(
				'showAnim'=>'fold',
			),
		));?>
		<?php echo $form->error($model,'expires_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'registered_with'); ?>
		<?php echo $form->textField($model,'registered_with',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'registered_with'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_id'); ?>
		<?php //CHtml::activeDropDownList($model, $attribute, $data) ?>
		<?php echo $form->dropDownList($model,'contact_id',$this->getContactList()); ?>
		<?php echo $form->error($model,'contact_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->