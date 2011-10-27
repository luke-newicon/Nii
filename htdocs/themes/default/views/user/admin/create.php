<?php
$form = $this->beginWidget('CActiveForm', array(
	'id' => 'add-user-form',
	'enableAjaxValidation' => false,
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
	),
	'focus' => array($model, 'name'),
	'errorMessageCssClass' => 'help-inline',
));
?>
	<fieldset>
		<div class="clearfix field">
			<?php echo $form->labelEx($model, 'username', array('class'=>'inFieldLabel')); ?>
			<div class="input">
				<?php echo $form->textField($model, 'username', array('size' => 30)); ?>
			</div>
			<?php echo $form->error($model, 'username'); ?>
		</div>
		<div class="clearfix field">
			<?php echo $form->labelEx($model, 'password', array('class'=>'inFieldLabel')); ?>
			<div class="input">
				<?php echo $form->passwordField($model, 'password', array('size' => 20, 'maxlength' => 128)); ?>
			</div>
			<?php echo $form->error($model, 'password'); ?>
		</div>
		<div class="clearfix field">
			<?php echo $form->labelEx($model, 'email', array('class'=>'inFieldLabel')); ?>
			<div class="input">
				<?php echo $form->textField($model, 'email', array('size' => 20, 'maxlength' => 128)); ?>
			</div>
			<?php echo $form->error($model, 'email'); ?>
		</div>
		<div class="clearfix field">
			<?php echo $form->labelEx($model, 'superuser'); ?>
			<div class="input">
				<?php echo $form->dropDownList($model, 'superuser', User::itemAlias('AdminStatus')); ?>
			</div>
			<?php echo $form->error($model, 'superuser'); ?>
		</div>
		<div class="clearfix field">
			<?php echo $form->labelEx($model, 'status'); ?>
			<div class="input">
				<?php echo $form->dropDownList($model, 'status', User::itemAlias('UserStatus')); ?>
			</div>
			<?php echo $form->error($model, 'status'); ?>
		</div>
	</fieldset>
<?php $this->endWidget(); ?>