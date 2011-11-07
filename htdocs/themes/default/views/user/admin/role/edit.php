<?php
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'add-role-form',
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
	),
	'focus' => array($model, 'name'),
));
?>
<fieldset>
	<div class="field">
		<?php echo $form->labelEx($model, 'name'); ?>
		<div class="inputContainer">
			<div class="input">
				<?php echo $form->textField($model, 'name'); ?>
			</div>
			<?php echo $form->error($model, 'name'); ?>
		</div>
	</div>
</fieldset>
<?php $this->endWidget(); ?>