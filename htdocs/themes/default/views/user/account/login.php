<?php $this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Login"); ?>

<div class="modal hide<?php echo $model->hasErrors() ? '' : ' fade' ?>" id="modal-login-user">
	<div class="modal-header">
		<h3>Welcome to <?php echo Yii::app()->name ?><?php echo $model->hasErrors() ? ' Hello' : ''; ?></h3>
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
			<div class="field" style="float:right">
				<div class="checkbox">
					<?php echo $form->checkBox($model, 'rememberMe', array('class' => 'inputInline')); ?>
					<?php echo $form->labelEx($model, 'rememberMe'); ?>
				</div>
			</div>
			<?php //echo CHtml::link(UserModule::t("Lost Password?"), Yii::app()->getModule('user')->recoveryUrl); ?>
			<input type="submit" class="hide" />
		</fieldset>
		<?php $this->endWidget(); ?>
	</div>
	<div class="modal-footer">
		<a id="user-login" class="btn primary" href="#">Login</a>
		<a id="password-recovery" class="btn" style="float:left" href="<?php echo CHtml::normalizeUrl(Yii::app()->getModule('user')->recoveryUrl) ?>">Password Recovery</a>
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