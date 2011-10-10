<div class="form">

<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'focus'=>array($model,'name'),
)); ?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'username'); ?>
		<?php echo CHtml::activeTextField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo CHtml::error($model,'username'); ?>
	</div>

	<?php if($model->isNewRecord): ?>
	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'password'); ?>
		<?php echo CHtml::activePasswordField($model,'password',array('size'=>20,'maxlength'=>128)); ?>
		<?php echo CHtml::error($model,'password'); ?>
	</div>
	<?php endif; ?>

	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'email'); ?>
		<?php echo CHtml::activeTextField($model,'email',array('size'=>20,'maxlength'=>128)); ?>
		<?php echo CHtml::error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'superuser'); ?>
		<?php echo CHtml::activeDropDownList($model,'superuser',User::itemAlias('AdminStatus')); ?>
		<?php echo CHtml::error($model,'superuser'); ?>
	</div>

	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'status'); ?>
		<?php echo CHtml::activeDropDownList($model,'status',User::itemAlias('UserStatus')); ?>
		<?php echo CHtml::error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->