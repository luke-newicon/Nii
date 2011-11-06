<?php $this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Login"); ?>

<div class="modal hide<?php echo $model->hasErrors() ? '' : ' fade' ?>" id="modal-login-user">
	<div class="modal-header">
		<h3>Welcome to <?php echo Yii::app()->name ?></h3>
	</div>
	<div class="modal-body">
		<?php
		$form = $this->beginWidget('NActiveForm', array(
			'id' => 'login-user-form',
			'enableAjaxValidation' => false,
			'enableClientValidation' => false,
//			'clientOptions' => array(
//				'validateOnSubmit' => true,
//				'validateOnChange' => true,
//			),
			'focus' => array($model, 'username'),
			'htmlOptions' => array('class' => 'float'),
		));
		?>
		<?php if($model->hasErrors()) : ?>
			<div class="alert-message block-message error">Sorry the login information is incorrect. Please try again.</div>
		<?php else : ?>
			<div class="alert-message block-message info">Please enter your details below to login to the system.</div>
		<?php endif; ?>
		<fieldset>
			<div class="field">
				<?php echo $form->labelEx($model, 'username'); ?>
				<div class="inputContainer">
					<div class="input">
						<?php echo $form->textField($model, 'username'); ?>
					</div>
					<?php echo $form->error($model, 'username'); ?>
				</div>
			</div>
			<div class="field">
				<?php echo $form->labelEx($model, 'password'); ?>
				<div class="inputContainer">
					<div class="input">
						<?php echo $form->passwordField($model, 'password'); ?>
					</div>
					<?php echo $form->error($model, 'password'); ?>
				</div>
			</div>
			<div class="field">
				<label>
					<?php echo $form->checkBox($model, 'rememberMe'); ?>
					<?php echo $model->getAttributeLabel('rememberMe'); ?>
				</label>
			</div>
			<input type="submit" class="hide" />
		</fieldset>
		<?php $this->endWidget(); ?>
	</div>
	<div class="modal-footer">
		<a id="user-login" class="btn primary" href="#">Login</a>
		<a id="password-recovery" class="btn pull-left" href="<?php echo CHtml::normalizeUrl(Yii::app()->getModule('user')->recoveryUrl) ?>">Password Recovery</a>
	</div>
</div>
<script>
	jQuery(function($){
		$('#modal-login-user.hide').modal({backdrop:'static',show:true});

		$('#user-login').click(function(){
			$('#login-user-form').submit();
			return false;
		});
		
		<?php if($model->hasErrors()) : ?>
			$("#modal-login-user").effect( "shake", {times:3, distance:7}, 50);
		<?php endif; ?>
	});
</script>