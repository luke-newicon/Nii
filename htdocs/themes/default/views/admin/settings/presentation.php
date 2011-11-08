<?php
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'settings-presentation-form',
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
	),
	'htmlOptions' => array('class' => 'float'),
));
?>
<div class="page-header">
	<h3>Presentation Settings</h3>
	<div class="action-buttons"></div>
</div>
<fieldset>
	<div class="field">
		<?php echo $form->labelEx($model, 'logo'); ?>
		<div class="inputContainer">
			<div class="input large">
				<?php echo $form->textField($model, 'logo'); ?>
			</div>
			<?php echo $form->error($model, 'logo'); ?>
		</div>
	</div>
	<div class="field">
		<?php echo $form->checkBox($model, 'menuAppname'); ?>
		<label>Show application name in menu bar.</label>
		<?php echo $form->error($model, 'menuAppname'); ?>
	</div>
	<div class="actions">
		<input id="settings-presentation-save-2" type="submit" class="btn primary" value="Save" />
	</div>
</fieldset>
<?php $this->endWidget(); ?>