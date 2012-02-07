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
			<div class="line">
				<div class="field unit size1of2">
					<?php echo $form->labelEx($model, 'password'); ?>
					<div class="inputContainer">
						<div class="input">
							<?php echo $form->passwordField($model, 'password'); ?>
						</div>
						<?php echo $form->error($model, 'password'); ?>
					</div>
				</div>
				<div class="field lastUnit">
					<?php echo $form->labelEx($model, 'verifyPassword'); ?>
					<div class="inputContainer">
						<div class="input">
							<?php echo $form->passwordField($model, 'verifyPassword'); ?>
						</div>
						<?php echo $form->error($model, 'verifyPassword'); ?>
					</div>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="modal-footer">
		<?php echo CHtml::submitButton(UserModule::t("Update Password"),array('class'=>'btn btn-primary')); ?>
<!--		<a id="user-password-save" class="btn primary" href="#">Update Password</a>-->
	</div>
</div>
<?php $this->endWidget(); ?>
<script>
	jQuery(function($){
		$('#modal-change-password').modal({backdrop:'static',show:true});
	});
</script>