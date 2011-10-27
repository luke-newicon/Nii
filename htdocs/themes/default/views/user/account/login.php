<?php $this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Login"); ?>
<?php
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'login-user-form',
	'enableAjaxValidation' => false,
	'enableClientValidation' => false,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
		'inputContainer'=>'.clearfix'
	),
	'focus' => array($model, 'name'),
));
?>
<div class="alert-message block-message info">Please enter your details below to login to the system.</div>
<fieldset>
	<div class="clearfix field">
		<?php echo $form->labelEx($model, 'username'); ?>
		<div class="inputContainer">
			<div class="input">
				<?php echo $form->textField($model, 'username'); ?>
			</div>
			<?php echo $form->error($model, 'username'); ?>
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
		<div class="checkbox">
			<?php echo $form->checkBox($model, 'rememberMe', array('class' => 'inputInline')); ?>
			<?php echo $form->labelEx($model, 'rememberMe'); ?>
		</div>
	</div>
	<?php echo CHtml::link(UserModule::t("Lost Password?"), Yii::app()->getModule('user')->recoveryUrl); ?>
	<input type="submit" class="hide" />
</fieldset>
<?php $this->endWidget(); ?>