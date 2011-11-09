<?php
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'settings-general-form',
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
	),
	'htmlOptions' => array('class' => 'float'),
));
?>
<div class="page-header">
	<h3>General Settings</h3>
	<div class="action-buttons"></div>
</div>
<fieldset>
	<div class="field">
		<?php echo $form->labelEx($model, 'appname'); ?>
		<div class="inputContainer">
			<div class="input xlarge">
				<?php echo $form->textField($model, 'appname'); ?>
			</div>
			<?php echo $form->error($model, 'appname'); ?>
		</div>
	</div>
	<div class="actions">
		<input id="settings-general-save" type="submit" class="btn primary" value="Save" />
	</div>
</fieldset>
<?php $this->endWidget(); ?>