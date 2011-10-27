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
		<div class="clearfix field">
			<?php echo $form->labelEx($model, 'first_name', array('class'=>'inFieldLabel')); ?>
			<div class="input">
				<?php echo $form->textField($model, 'first_name'); ?>
			</div>
			<?php echo $form->error($model, 'first_name'); ?>
		</div>
		<div class="clearfix field">
			<?php echo $form->labelEx($model, 'last_name', array('class'=>'inFieldLabel')); ?>
			<div class="input">
				<?php echo $form->textField($model, 'last_name'); ?>
			</div>
			<?php echo $form->error($model, 'last_name'); ?>
		</div>
		<div class="clearfix field">
			<?php echo $form->labelEx($model, 'email', array('class'=>'inFieldLabel')); ?>
			<div class="input">
				<?php echo $form->textField($model, 'email', array('size' => 20, 'maxlength' => 128)); ?>
			</div>
			<?php echo $form->error($model, 'email'); ?>
		</div>
		<div class="clearfix field">
			<?php echo $form->labelEx($model, 'password', array('class'=>'inFieldLabel')); ?>
			<div class="input">
				<?php echo $form->passwordField($model, 'password', array('size' => 20, 'maxlength' => 128)); ?>
			</div>
			<?php echo $form->error($model, 'password'); ?>
		</div>
		<div class="clearfix field">
			<?php echo $form->labelEx($model, 'verifyPassword', array('class'=>'inFieldLabel')); ?>
			<div class="input">
				<?php echo $form->passwordField($model, 'verifyPassword', array('size' => 20, 'maxlength' => 128)); ?>
			</div>
			<?php echo $form->error($model, 'verifyPassword'); ?>
		</div>
		<div class="clearfix field">
			<?php echo $form->labelEx($model, 'superuser', array('class'=>'inFieldLabel')); ?>
			<div class="input">
				<?php echo $form->dropDownList($model, 'superuser', User::itemAlias('AdminStatus')); ?>
			</div>
			<?php echo $form->error($model, 'superuser'); ?>
		</div>
		<div class="clearfix field">
			<?php echo $form->labelEx($model, 'status', array('class'=>'inFieldLabel')); ?>
			<div class="input">
				<?php echo $form->dropDownList($model, 'status', User::itemAlias('UserStatus')); ?>
			</div>
			<?php echo $form->error($model, 'status'); ?>
		</div>
	</fieldset>
<?php $this->endWidget(); ?>