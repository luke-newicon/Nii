<?php
$formAction = $action=='edit' ? array($action, 'id'=>$model->id) : array($action);
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'donationForm',
	'action' => $formAction,
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
));
$modelName = get_class($model);
?>
<?php if ($model->hasErrors()) : ?>
	<div class="alert alert-block alert-error">
		<?php echo $form->errorSummary($model); ?>
	</div>
<?php elseif (!$model->id) : ?>
	<div class="alert alert-block alert-info">
		<p>This is where you can create a new donation.  Fill in all the required fields marked with a <span class="required">*</span>.</p>
		<p>Additional information can be added at any other time.</p>
	</div>
<?php endif; ?>
<fieldset>
	<?php echo $form->field($model, 'donation_amount'); ?>
	<div class="control-group">
		<?php echo $form->labelEx($model,'date_received') ?>
		<div class="controls">
			<?php $this->widget('nii.widgets.forms.DateInput', array('model' => $model, 'attribute' => 'date_received')); ?>
			<?php echo $form->error($model,'date_received'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($model,'contact_id') ?>
		<div class="controls">
			<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
					'name'=>'contactName',
					'value'=>$model->contactName,
					'source'=>$this->createUrl('/contact/autocomplete/contactList/type/Person/'),
					// additional javascript options for the autocomplete plugin
					'options'=>array(
							'showAnim'=>'fold',
					'change'=>'js:function(event, ui) {
						if (ui.item)
							$("#'.$modelName.'_contact_id").val(ui.item.id);
						else
							$("#'.$modelName.'_contact_id").val(null);
					}'
					),
				));
				echo $form->hiddenField($model, 'contact_id');
			?>
			<?php echo $form->error($model,'contact_id'); ?>
		</div>
	</div>
	<?php echo $form->field($model, 'giftaid', 'dropDownList', array('1'=>'Yes','0'=>'No'), array('prompt'=>'Select')); ?>
	<?php echo $form->field($model, 'type_id', 'dropDownList', HftDonationType::getTypesArray(), array('prompt'=>'Select')); ?>
	<div class="control-group">
		<?php echo $form->labelEx($model,'event_id') ?>
		<div class="controls">
			<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
					'name'=>'eventName',
					'value'=>$model->eventName,
					'source'=>$this->createUrl('/hft/autocomplete/eventList/type/Person/'),
					// additional javascript options for the autocomplete plugin
					'options'=>array(
							'showAnim'=>'fold',
					'change'=>'js:function(event, ui) {
						if (ui.item)
							$("#'.$modelName.'_event_id").val(ui.item.id);
						else
							$("#'.$modelName.'_event_id").val(null);
					}'
					),
				));
				echo $form->hiddenField($model, 'event_id');
			?>
			<?php echo $form->error($model,'event_id'); ?>
		</div>
	</div>
	<?php echo $form->field($model, 'thankyou_sent', 'checkBox'); ?>
	<?php echo $form->field($model, 'comment', 'textArea'); ?>
	<div class="form-actions">
		<?php $cancelUrl = ($model->id) ? array('donation/view','id'=>$model->id) : array('donation/index'); ?>
		<?php echo NHtml::submitButton('Save', array('class'=>'btn btn-primary')); ?>
		<?php echo NHtml::btnLink('Cancel', $cancelUrl, null, array('class'=>'btn cancel cancelButton')); ?>	
	</div>
</fieldset>
<?php $this->endWidget();