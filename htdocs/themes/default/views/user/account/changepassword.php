<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password"); ?>

<div class="modal hide" id="modal-change-password">
	<div class="modal-header">
		<h3><?php echo UserModule::t("Change Password"); ?></h3>
	</div>
	<div class="modal-body">
		<div class="alert-message block-message info">
			<p>Your password needs to be updated.</p>
		</div>
		<?php
		$form = $this->beginWidget('NActiveForm', array(
			'id' => 'user-password-form',
		));
		?>
		<fieldset>
			<?php echo $form->field($model, 'password', passwordField); ?>
			<?php echo $form->field($model, 'verifyPassword', passwordField); ?>
		</fieldset>
		<?php $this->endWidget(); ?>
	</div>
	<div class="modal-footer">
		<a id="user-password-save" class="btn btn-primary" href="#">Update Password</a>
	</div>
</div>
<script>
	jQuery(function($){
		$('#modal-change-password').modal({backdrop:'static',show:true});
	});
</script>