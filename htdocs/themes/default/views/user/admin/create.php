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
		<div class="clearfix">
			<?php echo $form->labelEx($model, 'username'); ?>
			<div class="input">
				<?php echo $form->textField($model, 'username', array('size' => 30)); ?>
				<?php echo $form->error($model, 'username'); ?>
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
			<?php echo $form->labelEx($model, 'email'); ?>
			<div class="input">
				<?php echo $form->textField($model, 'email', array('size' => 20, 'maxlength' => 128)); ?>
				<?php echo $form->error($model, 'email'); ?>
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