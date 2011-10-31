<?php $this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Password Recovery"); ?>

<div class="modal hide" id="modal-recover-password">
	<div class="modal-header">
		<h3>Welcome to <?php echo Yii::app()->name ?></h3>
	</div>
	<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
		<div class="modal-body">
			<div class="alert-message success">
				<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
			</div>
		</div>
		<div class="modal-footer">
			<a id="user-login" class="btn" style="float:left" href="<?php echo CHtml::normalizeUrl(Yii::app()->getModule('user')->loginUrl) ?>">Back to login</a>
		</div>
	<?php else: ?>
		<div class="modal-body">
			<div class="alert-message block-message info">
				<p>Please enter your<?php echo UserModule::get()->usernameRequired ? ' username or' : '' ?> email address to recover your password.</p>
			</div>
			<?php
				$form = $this->beginWidget('NActiveForm', array(
				'id' => 'recover-password-form',
				'enableAjaxValidation' => false,
				'enableClientValidation' => false,
				'focus' => array($model, 'username_or_email'),
				'htmlOptions' => array('class' => 'float'),
				));
			?>
			<fieldset>
				<div class="field">
					<?php echo $form->labelEx($model, 'username_or_email'); ?>
					<div class="input">
						<?php echo $form->textField($model, 'username_or_email'); ?>
					</div>
					<?php echo $form->error($model, 'username_or_email'); ?>
				</div>
				<input type="submit" class="hide" />
			</fieldset>
			<?php $this->endWidget(); ?>
		</div>
		<div class="modal-footer">
			<a id="recover-password" class="btn primary" href="#">Restore</a>
			<a id="user-login" class="btn" style="float:left" href="<?php echo CHtml::normalizeUrl(Yii::app()->getModule('user')->loginUrl) ?>">Back to login</a>
		</div>
	<?php endif; ?>
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