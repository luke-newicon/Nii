<?php
$form = $this->beginWidget('NActiveForm', array(
		'id' => 'studentForm',
		'enableAjaxValidation' => false,
		'enableClientValidation' => true,
		'htmlOptions' => array('class' => 'float'),
	));
?>
<div class="page-header">
	<h3>Presentation Settings</h3>
	<div class="action-buttons">
		<input id="settings-presentation-save" type="submit" class="btn primary" value="Save" />
	</div>
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
		<?php echo $form->labelEx($model, 'color'); ?>
		<div class="inputContainer">
			<div class="input large">
				<?php echo $form->textField($model, 'color'); ?>
			</div>
			<?php echo $form->error($model, 'color'); ?>
		</div>
	</div>
	<div class="field">
		<?php echo $form->labelEx($model, 'background'); ?>
		<div class="inputContainer">
			<div class="input large">
				<?php echo $form->textField($model, 'background'); ?>
			</div>
			<?php echo $form->error($model, 'background'); ?>
		</div>
	</div>
	<div class="actions">
		<input id="settings-presentation-save-2" type="submit" class="btn primary" value="Save" />
	</div>
</fieldset>
<?php $this->endWidget(); ?>