<?php $this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Login"); ?>
<?php
	$form = $this->beginWidget('NActiveForm', array(
		'id' => 'login-user-form',
		'enableAjaxValidation' => false,
		'enableClientValidation' => false,
		'focus' => array($model, 'username'),
	));
?>
<div class="modal hide<?php echo $model->hasErrors() ? '' : ' fade' ?>" id="modal-login-user">
	<div class="modal-header">
		<h3>Welcome to <?php echo Yii::app()->name ?></h3>
	</div>
	<div class="modal-body">
		<?php if($model->hasErrors()) : ?>
			<div class="alert alert-block alert-error">
				<p>Sorry the login information is incorrect. Please try again.</p>
			</div>
		<?php else : ?>
			<div class="alert alert-block alert-info">
				<p>Please enter your details below to login to the system.</p>
			</div>
		<?php endif; ?>
		<fieldset>
			<?php echo $form->field($model, 'username'); ?>
			<?php echo $form->field($model, 'password', 'passwordField'); ?>
			<div class="control-group">
				<div class="controls">
					<?php echo $form->checkBoxField($model, 'rememberMe'); ?>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="modal-footer">
		<?php echo CHtml::submitButton(UserModule::t("Login"),array('class'=>'btn btn-primary')); ?>
		<?php if(Yii::app()->getModule('user')->enableGoogleAuth): ?>
			<a class="btn" href="<?php echo NHtml::url('/user/account/loginGoogle'); ?>" >Google</a>
		<?php endif; ?>
		<a id="password-recovery" class="btn pull-left" href="<?php echo CHtml::normalizeUrl(Yii::app()->getModule('user')->recoveryUrl) ?>">Password Recovery</a>
	</div>
</div>
<?php $this->endWidget(); ?>
<script>
	jQuery(function($){
		$('#modal-login-user.hide').modal({backdrop:'static',show:true});
		
		<?php if($model->hasErrors()) : ?>
			$("#modal-login-user").effect( "shake", {times:3, distance:7}, 50);
		<?php endif; ?>
	});
</script>