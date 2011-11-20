<?php
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'kashflow-setting-form',
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
	),
	'htmlOptions' => array('class' => 'float'),
));
?>
<div class="page-header">
	<h3>Kashflow Settings</h3>
	<div class="action-buttons"></div>
</div>
<fieldset>
	<div class="field">
		<?php echo $form->labelEx($model, 'username'); ?>
		<div class="inputContainer">
			<div class="input xlarge">
				<?php echo $form->textField($model, 'username'); ?>
			</div>
			<?php echo $form->error($model, 'username'); ?>
		</div>
	</div>
	<div class="field">
		<?php echo $form->labelEx($model, 'password'); ?>
		<div class="inputContainer">
			<div class="input xlarge">
				<?php echo $form->passwordField($model, 'password'); ?>
			</div>
			<?php echo $form->error($model, 'password'); ?>
		</div>
	</div>
	<div class="field">
		<?php echo $form->checkBox($model, 'show_menu'); ?>
		<label>Show Kashflow in main menu.</label>
		<?php echo $form->error($model, 'show_menu'); ?>
	</div>
	<div class="actions">
		<input id="settings-general-save" type="submit" class="btn primary" value="Save" />
	</div>
</fieldset>
<?php $this->endWidget(); ?>