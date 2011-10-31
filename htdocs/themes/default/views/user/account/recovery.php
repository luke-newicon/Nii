<?php $this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Password Recovery"); ?>

<div class="modal hide" id="modal-recover-password">
	<div class="modal-header">
		<h3>Welcome to <?php echo Yii::app()->name ?></h3>
	</div>
	<div class="modal-body">
		<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
		<div class="alert-message success">
			<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
		</div>
		<?php else: ?>
			<div class="alert-message block-message info">
				<p>Please enter your username or email address to recover your password.</p>
			</div>
			<?php
				$form = $this->beginWidget('NActiveForm', array(
				'id' => 'recover-password-form',
				'enableAjaxValidation' => false,
				'enableClientValidation' => false,
				'focus' => array($model, 'login_or_email'),
				));
			?>
			<fieldset>
				<div class="field">
					<?php echo $form->labelEx($model, 'login_or_email'); ?>
					<div class="input">
						<?php echo $form->textField($model, 'login_or_email'); ?>
					</div>
					<?php echo $form->error($model, 'login_or_email'); ?>
				</div>
				<input type="submit" class="hide" />
			</fieldset>
			<?php $this->endWidget(); ?>
		<?php endif; ?>
	</div>
	<div class="modal-footer">
		<a id="recover-password" class="btn primary" href="#">Restore</a>
		<a id="user-login" class="btn" style="float:left" href="<?php echo CHtml::normalizeUrl(Yii::app()->getModule('user')->loginUrl) ?>">Back to login</a>
	</div>
</div>
<script>
	jQuery(function($){
		$('#modal-recover-password').modal({backdrop:'static',show:true});
		$('#recover-password').click(function(){
			$('#recover-password-form').submit();
			return false;
		});
	});
</script>