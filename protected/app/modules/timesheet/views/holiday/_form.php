
<?php $form=$this->beginWidget('NActiveForm', array(
	'id'=>'timesheet-holiday-form',
	'enableAjaxValidation'=>false,
	
)); ?>
	<p class="alert-message">Fields with <span class="required">*</span> are required.</p>
	<?php echo $model->hasErrors() ? '<p class="alert-massage danger">'.$form->errorSummary($model).'</p>' : ''; ?>
	<?php echo CHtml::hiddenField('timesheet-holiday-form[user_id]',$userId) ?>
	<fieldset>
		<?php echo $form->field($model, 'date_start'); ?>
		<?php echo $form->field($model, 'date_end'); ?>
		<?php echo $form->field($model, 'comment'); ?>
	</fieldset>
	<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'publishDate',
    // additional javascript options for the date picker plugin
    'options'=>array(
        'showAnim'=>'fold',
    ),
    'htmlOptions'=>array(
        'style'=>'height:20px;'
    ),
),true,true); ?>
<?php $this->endWidget(); ?>