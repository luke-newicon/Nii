<?php
$formAction = $action == 'edit' ? array($action, 'id' => $model->id) : array($action);
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'eventForm',
	'action' => $formAction,
	'enableAjaxValidation' => false,
	'enableClientValidation' => true,
));

$modelName = get_class($model);
?>
<?php if ($model->hasErrors()) : ?>
	<div class="alert alert-block alert-error">
		<?php echo $form->errorSummary($model); ?>
	</div>
<?php elseif (!$model->id) : ?>
	<div class="alert alert-block alert-info">
		<p>This is where you can create a new event.  Fill in all the required fields marked with a <span class="required">*</span>.</p>
		<p>Additional information can be added at any other time.</p>
	</div>
<?php endif; ?>
<fieldset>
	<?php echo $form->field($model, 'name'); ?>
	<div class="control-group">
		<?php echo $form->labelEx($model, 'start_date', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php $this->widget('nii.widgets.forms.DateInput', array('model' => $model, 'attribute' => 'start_date')); ?>
			<?php echo $form->error($model, 'start_date'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($model, 'end_date', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php $this->widget('nii.widgets.forms.DateInput', array('model' => $model, 'attribute' => 'end_date')); ?>
			<?php echo $form->error($model, 'end_date'); ?>
		</div>
	</div>
	<?php echo $form->field($model, 'organiser_type_id', 'dropDownList', HftEventOrganiserType::getTypesArray(), array('prompt' => 'select...')); ?>
	<?php echo $form->field($model, 'organiser_name'); ?>
	<?php echo $form->field($model, 'description', 'textArea', null, array('rows' => '4', 'class' => 'span9')); ?>
	<div class="form-actions">
		<?php echo NHtml::submitButton('Save', array('class' => 'btn btn-primary')); ?>
		<?php echo NHtml::btnLink('Cancel', (($model->id) ? array('event/view', 'id' => $model->id) : array('event/index')), null, array('class' => 'btn')); ?>
	</div>
</fieldset>
<?php
$this->endWidget();