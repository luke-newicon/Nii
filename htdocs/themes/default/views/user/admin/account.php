<?php
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'user-account-form',
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
		'inputContainer' => '.clearfix'
	),
	'focus' => array($model, 'name'),
));
?>
<fieldset>
	<div class="clearfix field">
		<?php echo $form->labelEx($model, 'first_name'); ?>
		<div class="inputContainer">
			<div class="input">
				<?php echo $form->textField($model, 'first_name'); ?>
			</div>
			<?php echo $form->error($model, 'first_name'); ?>
		</div>
	</div>
	<div class="clearfix field">
		<?php echo $form->labelEx($model, 'last_name'); ?>
		<div class="inputContainer">
			<div class="input">
				<?php echo $form->textField($model, 'last_name'); ?>
			</div>
			<?php echo $form->error($model, 'last_name'); ?>
		</div>
	</div>
	<div class="clearfix field">
		<?php echo $form->labelEx($model, 'email'); ?>
		<div class="inputContainer">
			<div class="input">
				<?php echo $form->textField($model, 'email'); ?>
			</div>
			<?php echo $form->error($model, 'email'); ?>
		</div>
	</div>
	<div class="clearfix field">
		<?php echo $form->labelEx($model, 'password'); ?>
		<div class="inputContainer">
			<div class="input">
				<?php echo $form->passwordField($model, 'password'); ?>
			</div>
			<?php echo $form->error($model, 'password'); ?>
		</div>
	</div>
	<div class="clearfix field">
		<?php echo $form->labelEx($model, 'verifyPassword'); ?>
		<div class="inputContainer">
			<div class="input">
				<?php echo $form->passwordField($model, 'verifyPassword'); ?>
			</div>
			<?php echo $form->error($model, 'verifyPassword'); ?>
		</div>
	</div>
</fieldset>
<?php $this->endWidget(); ?>