<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration");
$this->breadcrumbs=array(
	UserModule::t("Registration"),
);
?>
<h1><?php echo UserModule::t("Registration"); ?></h1>

<?php if(Yii::app()->user->hasFlash('registration')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('registration'); ?>
</div>
<?php else: ?>


<?php $form=$this->beginWidget('nii.widgets.NActiveForm', array(
	'id'=>'registration-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>
<div class="line">
	<div class="unit size1of2">
<!--		<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>-->


		<h3>Your Account</h3>
		<div>
			<?php if(UserModule::get()->showUsernameField): ?>
				<div class="field">
					<div class="inputContainer">
						<?php echo $form->labelEx($model,'username', array('class'=>'inFieldLabel')); ?>
						<div class="inputBox">
							<?php echo $form->textField($model,'username'); ?>
						</div>
					</div>
					<?php echo $form->error($model,'username'); ?>
				</div>
			<?php endif; ?>
			<div class="field">
				<div class="inputContainer">
					<?php echo $form->labelEx($model,'email', array('class'=>'inFieldLabel')); ?>
					<div class="inputBox">
						<?php echo $form->textField($model,'email'); ?>
					</div>
				</div>
				<?php echo $form->error($model,'email'); ?>
			</div>
			<div class="field line">
				<div class="unit size1of2">
					<div class="field man">
						<div class="inputContainer">
							<?php echo $form->labelEx($model,'password', array('class'=>'inFieldLabel')); ?>
							<div class="inputBox">
								<?php echo $form->passwordField($model,'password'); ?>
							</div>
						</div>
						<?php echo $form->error($model,'password'); ?>
						<p class="hint">
							<?php echo UserModule::t("Minimal password length 4 symbols."); ?>
						</p>
					</div>
				</div>
				<div class="lastUnit">
					<div class="field man mls">
						<div class="inputContainer">
							<?php echo $form->labelEx($model,'verifyPassword', array('class'=>'inFieldLabel')); ?>
							<div class="inputBox">
								<?php echo $form->passwordField($model,'verifyPassword'); ?>
							</div>
						</div>
						<?php echo $form->error($model,'verifyPassword'); ?>
					</div>
				</div>
			</div>
		</div>
		<?php if (UserModule::doCaptcha('registration')): ?>
		<div class="field">
			<?php echo $form->labelEx($model,'verifyCode'); ?>

			<?php $this->widget('CCaptcha'); ?>
			<?php echo $form->textField($model,'verifyCode'); ?>
			<?php echo $form->error($model,'verifyCode'); ?>

			<p class="hint pan"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
			<br/><?php echo UserModule::t("Letters are not case-sensitive."); ?></p>
		</div>
		<?php endif; ?>

		<?php if(UserModule::get()->domain): ?>
			<h3>Select your site address!</h3>
			<div class="field">
				<div class="inputContainer">
					<div class="inputBox">
						<div class="line">
							<label class="unit size1of10" for="AppDomain_domain" style="line-height:16px;color:#999;">http://</label>
							<div class="unit size6of10">
								<?php echo $form->textField($domain,'domain'); ?>
							</div>
							<label class="lastUnit" for="AppDomain_domain" style="line-height:16px;color:#999;">.<?php echo Yii::app()->hostname; ?></label>
						</div>
					</div>
				</div>
				<?php echo $form->error($domain,'domain'); ?>
			</div>
		<?php endif; ?>


		<?php if(UserModule::get()->termsRequired): ?>
			<h3>Terms</h3>
			<div class="field">
				<?php echo $form->checkBox($model,'terms'); ?>
				<label for="<?php echo CHtml::activeId($model,'terms'); ?>" style="display:inline;font-weight:normal;">I have read and accept the </label><a href="#">terms and conditions</a>
				<?php echo $form->error($model,'terms'); ?>
			</div>
		<?php endif; ?>

		<div class="field submit line mtl">
			<div class="unit size1of2">
				<?php echo CHtml::submitButton(UserModule::t("Register"),array('class'=>'btn aristo primary large pll prl','style'=>'width:100%')); ?>
			</div>
			<div class="lastUnit">
				<p class="pll hint" style="line-height:16px;">By submitting this form you are accepting our <br/><a href="#">terms and conditions</a></p>
			</div>
		</div>
	</div>
	<div class="lastUnit pll" style="padding-top:29px">
		<?php echo $form->errorSummary(array($model)); ?>
		<?php // echo $form->error($model,'username'); ?>
		<?php // echo $form->error($model,'email'); ?>
		<?php // echo $form->error($model,'password'); ?>
		<?php // echo $form->error($model,'verifyPassword'); ?>
		<?php // echo $form->error($domain,'domain'); ?>
	</div>
</div>
<?php $this->endWidget(); ?>
<?php endif; ?>