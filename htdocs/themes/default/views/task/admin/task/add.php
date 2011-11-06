<?php
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'add-task-form',
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
	<div class="field">
		<?php echo $form->labelEx($model, 'description'); ?>
		<div class="inputContainer">
			<div class="input">
				<?php echo $form->textarea($model, 'description'); ?>
			</div>
			<?php echo $form->error($model, 'description'); ?>
		</div>
	</div>
	<div class="line">
		<div class="field unit size1of2">
			<?php echo $form->labelEx($model, 'priority'); ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo $form->textField($model, 'priority'); ?>
				</div>
				<?php echo $form->error($model, 'priority'); ?>
			</div>
		</div>
		<div class="field lastUnit">
			<?php echo $form->labelEx($model, 'importance'); ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo $form->textField($model, 'importance'); ?>
				</div>
				<?php echo $form->error($model, 'importance'); ?>
			</div>
		</div>
	</div>
	<div class="line">
		<div class="field unit size1of2">
			<?php echo $form->labelEx($model, 'finish_date'); ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo $form->textField($model, 'finish_date'); ?>
				</div>
				<?php echo $form->error($model, 'finish_date'); ?>
			</div>
		</div>
		<div class="field lastUnit">
			<?php echo $form->labelEx($model, 'owner'); ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo $form->textField($model, 'owner'); ?>
				</div>
				<?php echo $form->error($model, 'owner'); ?>
			</div>
		</div>
	</div>
</fieldset>
<?php $this->endWidget(); ?>