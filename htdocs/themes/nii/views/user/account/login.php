<?php
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
$this->breadcrumbs=array(
	UserModule::t("Login"),
);
?>

<h1><?php echo UserModule::t("Login"); ?></h1>

<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

<div class="success">
	<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
</div>

<?php endif; ?>


<div style="width:400px;">
	
<?php $form=$this->beginWidget('nii.widgets.NActiveForm', array(
	'id'=>'userloginform',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
)); ?>
<!--	<form method="post" id="userloginform">-->

<!--		<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>-->

		<?php echo $form->errorSummary($model); ?>
		<div class="line">
			<div class="unit size2of5">
				<div class="field ">
					<?php echo $form->labelEx($model,'username',array('class'=>'inFieldLabel')); ?>
					<div class="inputBox bLeft">
						<?php echo $form->textField($model,'username',array('style'=>'font-size:17px;')) ?>
					</div>
				</div>
			</div>
			<div class="unit size2of5 ">
				<div class="field">
					<?php echo $form->labelEx($model,'password',array('class'=>'inFieldLabel',)); ?>
					<div class="inputBox bMid">
						<?php echo $form->passwordField($model,'password',array('style'=>'font-size:17px;')) ?>
					</div>
				</div>
			</div>
			<div class="lastUnit">
				<div class="field submit">
					<?php echo CHtml::submitButton(UserModule::t("Login"), array('class'=>'btn aristo primary bRight','style'=>'font-size:16px;height:30px;')); ?>
				</div>
			</div>
		</div>

		<div class="field rememberMe">
			<?php echo $form->checkBox($model,'rememberMe'); ?>
			<?php echo $form->labelEx($model,'rememberMe'); ?>
		</div>
		<div class="field">
			<p class="hint">
				<?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
			</p>
		</div>

		

		
<?php $this->endWidget(); ?>		
		
	
<!--	</form>-->
</div><!-- form -->