<?php
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'add-user-form',
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
		'inputContainer'=>'.clearfix'
	),
	'focus' => array($model, 'name'),
	'errorMessageCssClass' => 'help-inline',
));
?>
	<fieldset>
		<div class="clearfix">
			<?php echo $form->labelEx($model, 'first_name'); ?>
			<div class="input">
				<?php echo $form->textField($model, 'first_name'); ?>
				<?php echo $form->error($model, 'first_name'); ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo $form->labelEx($model, 'last_name'); ?>
			<div class="input">
				<?php echo $form->textField($model, 'last_name'); ?>
				<?php echo $form->error($model, 'last_name'); ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo $form->labelEx($model, 'email'); ?>
			<div class="input">
				<?php echo $form->textField($model, 'email', array('size' => 20, 'maxlength' => 128)); ?>
				<?php echo $form->error($model, 'email'); ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo $form->labelEx($model, 'password'); ?>
			<div class="input">
				<?php echo $form->passwordField($model, 'password', array('size' => 20, 'maxlength' => 128)); ?>
				<?php echo $form->error($model, 'password'); ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo $form->labelEx($model, 'verifyPassword'); ?>
			<div class="input">
				<?php echo $form->passwordField($model, 'verifyPassword', array('size' => 20, 'maxlength' => 128)); ?>
				<?php echo $form->error($model, 'verifyPassword'); ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo $form->labelEx($model, 'superuser'); ?>
			<div class="input">
				<?php echo $form->dropDownList($model, 'superuser', User::itemAlias('AdminStatus')); ?>
				<?php echo $form->error($model, 'superuser'); ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo $form->labelEx($model, 'status'); ?>
			<div class="input">
				<?php echo $form->dropDownList($model, 'status', User::itemAlias('UserStatus')); ?>
				<?php echo $form->error($model, 'status'); ?>
			</div>
		</div>
	</fieldset>
<?php $this->endWidget(); ?>