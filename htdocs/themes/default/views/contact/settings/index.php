<?php
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'contact-setting-form',
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
	),
	'htmlOptions' => array('class' => 'float'),
));
?>
<div class="page-header">
	<h3>Contact Settings</h3>
</div>
<?php echo $form->errorSummary($model,'<p><strong>Please fix the following input errors:</strong></p>',null,array('class'=>'errorSummary alert-message block-message error')); ?>
<fieldset>
	<div class="field">
		<?php echo $form->labelEx($model, 'menu_label'); ?>
		<div class="inputContainer">
			<div class="input xlarge">
				<?php echo $form->textField($model, 'menu_label'); ?>
			</div>
			<?php echo $form->error($model, 'menu_label'); ?>
		</div>
	</div>
	<div class="actions">
		<input id="settings-general-save" type="submit" class="btn primary" value="Save" />
	</div>
</fieldset>
<?php $this->endWidget(); ?>