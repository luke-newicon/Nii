<?php $this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Password Recovery"); ?>

<?php if (Yii::app()->user->hasFlash('recoveryMessage')): ?>
	<div class="modal hide" id="modal-recover-password">
		<div class="modal-header">
			<h3>Welcome to <?php echo Yii::app()->name ?></h3>
		</div>
		<div class="modal-body">
			<div class="alert alert-block alert-success">
				<h4 class="alert-heading">Thank You!</h4>
				<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
			</div>
		</div>
		<div class="modal-footer">
			<a id="user-login" class="btn pull-left" href="<?php echo CHtml::normalizeUrl(Yii::app()->getModule('user')->loginUrl) ?>"><?php echo UserModule::t('Back to login') ?></a>
		</div>
	</div>
<?php else: ?>
	<?php
		$form = $this->beginWidget('NActiveForm', array(
			'id' => 'recover-password-form',
			'enableAjaxValidation' => false,
			'enableClientValidation' => false,
			'focus' => array($model, 'username_or_email'),
		));
	?>
	<div class="modal hide" id="modal-recover-password">
		<div class="modal-header">
			<h3>Welcome to <?php echo Yii::app()->name ?></h3>
		</div>
		<div class="modal-body">
			<?php if ($model->hasErrors()) : ?>
				<div class="alert alert-block alert-error">
					<p>Sorry the login information is incorrect. Please try again.</p>
				</div>
			<?php else : ?>
				<div class="alert alert-block alert-info">
					<p>Please enter your<?php echo UserModule::get()->usernameRequired ? ' username or' : '' ?> email address to recover your password.</p>
				</div>
			<?php endif; ?>
			<fieldset>
				<?php echo $form->field($model, 'username_or_email'); ?>
			</fieldset>
		</div>
		<div class="modal-footer">
			<?php echo CHtml::submitButton(UserModule::t("Restore"), array('class' => 'btn btn-primary')); ?>
			<a id="user-login" class="btn pull-left" href="<?php echo CHtml::normalizeUrl(Yii::app()->getModule('user')->loginUrl) ?>"><?php echo UserModule::t('Back to login') ?></a>
		</div>
	</div>
	<?php $this->endWidget(); ?>
<?php endif; ?>
<script>
	jQuery(function($){
		$('#modal-recover-password').modal({backdrop:'static',show:true});
	});
</script>