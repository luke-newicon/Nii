<?php
$formAction = $action == 'edit' ? array($action, 'id' => $model->id) : array($action);
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'donationForm',
	'action' => $formAction,
	'enableAjaxValidation' => false,
	'enableClientValidation' => true,
));
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
	<?php echo $form->field($model, 'date_received', 'dateField'); ?>
	
	<?php echo $form->beginField($model, 'contact_id'); ?>
		<?php echo $form->autoComplete($model, 'contact_id', $this->createUrl('/contact/autocomplete/contactList/type/Person/'), 'contactName'); ?>
	<?php echo $form->endField($model, 'contact_id'); ?>
	
	<?php echo $form->field($model, 'giftaid', 'dropDownList', array('1' => 'Yes', '0' => 'No'), array('prompt' => 'Select')); ?>
	<?php echo $form->field($model, 'type_id', 'dropDownList', HftDonationType::getTypesArray(), array('prompt' => 'Select')); ?>
	
	<?php echo $form->beginField($model, 'event_id'); ?>
		<?php echo $form->autoComplete($model, 'event_id', $this->createUrl('/hft/autocomplete/eventList/type/Person/'), 'eventName'); ?>
	<?php echo $form->endField($model, 'event_id'); ?>
	
	<?php echo $form->field($model, 'thankyou_sent', 'checkBox'); ?>
	<?php echo $form->field($model, 'comment', 'textArea', null, array('class' => 'span9')); ?>
	<div class="form-actions">
		<?php $cancelUrl = ($model->id) ? array('donation/view', 'id' => $model->id) : array('donation/index'); ?>
		<?php echo NHtml::submitButton('Save', array('class' => 'btn btn-primary')); ?>
		<?php echo NHtml::btnLink('Cancel', $cancelUrl, null, array('class' => 'btn cancel cancelButton')); ?>	
	</div>
</fieldset>
<?php
$this->endWidget();