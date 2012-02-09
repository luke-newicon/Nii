<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password"); ?>
<?php
	$form = $this->beginWidget('NActiveForm', array(
		'id' => 'user-password-form',
	));
?>
<div class="modal hide" id="modal-change-password">
	<div class="modal-header">
		<h3><?php echo UserModule::t("Change Password"); ?></h3>
	</div>
	
	<div class="modal-body">
		<div class="alert-message block-message info">
			<p>Your password needs to be updated.</p>
		</div>
		<fieldset>
			<?php echo $form->field($model, 'password', passwordField); ?>
			<?php echo $form->field($model, 'verifyPassword', passwordField); ?>
		</fieldset>
	</div>
	<div class="modal-footer">
		<?php echo CHtml::submitButton(UserModule::t("Update Password"),array('class'=>'btn btn-primary')); ?>
	</div>
</div>
<?php $this->endWidget(); ?>
<script>
	jQuery(function($){
		$('#modal-change-password').modal({backdrop:'static',show:true});
	});
</script>