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

<div class="form">
<?php $form=$this->beginWidget('nii.widgets.NActiveForm', array(
	'id'=>'registration-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary(array($model)); ?>

	<?php if(UserModule::get()->showUsernameField): ?>
		<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
		</div>
	<?php endif; ?>
	
	<div class="row">
	<?php echo $form->labelEx($model,'email'); ?>
	<?php echo $form->textField($model,'email'); ?>
	<?php echo $form->error($model,'email'); ?>
	</div>

	<?php  // show fields from linked CRM module ?>
	<?php if(UserModule::get()->useCrm): ?>
		<div class="row">
		<?php echo $form->labelEx($contact,'first name'); ?>
		<?php echo $form->textField($contact,'first_name'); ?>
		<?php echo $form->error($contact,'first_name'); ?>
		</div>

		<div class="row">
		<?php echo $form->labelEx($contact,'last name'); ?>
		<?php echo $form->textField($contact,'last_name'); ?>
		<?php echo $form->error($contact,'last_name'); ?>
		</div>
	<?php endif; ?>

	<div class="row">
	<?php echo $form->labelEx($model,'password'); ?>
	<?php echo $form->passwordField($model,'password'); ?>
	<?php echo $form->error($model,'password'); ?>
	<p class="hint">
	<?php echo UserModule::t("Minimal password length 4 symbols."); ?>
	</p>
	</div>

	<div class="row">
	<?php echo $form->labelEx($model,'verifyPassword'); ?>
	<?php echo $form->passwordField($model,'verifyPassword'); ?>
	<?php echo $form->error($model,'verifyPassword'); ?>
	</div>



	<?php if (UserModule::doCaptcha('registration')): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'verifyCode'); ?>

		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		<?php echo $form->error($model,'verifyCode'); ?>

		<p class="hint"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
		<br/><?php echo UserModule::t("Letters are not case-sensitive."); ?></p>
	</div>
	<?php endif; ?>
	
	<?php if(UserModule::get()->domain): ?>
		<h2>Select your site address!</h2>
		<div class="row">
			https://<?php echo $form->textField($domain,'domain'); ?>.<?php echo Yii::app()->hostname; ?>
			<?php echo $form->error($domain,'domain'); ?>
		</div>
	<?php endif; ?>
		
		
	<?php if(UserModule::get()->termsRequired): ?>
		<h2>Terms</h2>
		<div class="row">
			<?php echo $form->checkBox($model,'terms'); ?>
			<label for="<?php echo CHtml::activeId($model,'terms'); ?>" style="display:inline;font-weight:normal;">I have read and accept the </label><a href="#">terms and conditions</a>
			<?php echo $form->error($model,'terms'); ?>
		</div>
	<?php endif; ?>

	<div class="row submit">
		<?php echo CHtml::submitButton(UserModule::t("Register"),array('class'=>'btn aristo primary')); ?>
		<p class="hint">By submitting this form you are accepting our <a href="#">terms and conditions</a></p>
	</div>
	
<?php $this->endWidget(); ?>
</div><!-- form -->
<?php endif; ?>