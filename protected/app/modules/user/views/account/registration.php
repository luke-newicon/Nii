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
	'focus'=>''
)); ?>

<div class="line" style="font-size:15px;">
	
	<div class="unit size2of5">
		<?php echo $form->errorSummary(array($model)); ?>
		<div>
			<?php if (UserModule::get()->showUsernameField) : ?>
				<div class="field mbl <?php echo ($model->hasErrors('username'))?'error':''; ?>">
					<div class="inputContainer">
						<?php echo $form->labelEx($model,'username', array('class'=>'inFieldLabel')); ?>
						<div class="inputBox">
							<?php echo $form->textField($model,'username'); ?>
						</div>
					</div>
					<?php echo $form->error($model,'username'); ?>
				</div>
			<?php endif; ?>
			<div class="field mbl <?php echo ($model->hasErrors('email'))?'error':''; ?>">
				<div class="inputContainer">
					<?php echo $form->labelEx($model,'email', array('class'=>'inFieldLabel')); ?>
					<div class="inputBox">
						<?php echo $form->textField($model,'email'); ?>
					</div>
				</div>
				<?php echo $form->error($model,'email'); ?>
			</div>
			<div class="field line mbl <?php echo ($model->hasErrors('password')||$model->hasErrors('verifyPassword'))?'error':''; ?>">
				<div class="unit size1of2">
					<div class="field man">
						<div class="inputContainer">
							<?php echo $form->labelEx($model,'password', array('class'=>'inFieldLabel')); ?>
							<div class="inputBox">
								<?php echo $form->passwordField($model,'password'); ?>
							</div>
						</div>
						
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
					</div>
				</div>
				<?php echo $form->error($model,'password'); ?>
				<?php echo $form->error($model,'verifyPassword'); ?>
			</div>
		</div>
		<?php if(Yii::app()->domain): ?>
		<div class="field mbl <?php echo ($domain->hasErrors('domain'))?'error':''; ?>">
			<div class="inputContainer">
				<div class="line">
					<?php echo $form->labelEx($domain,'domain',array('class'=>'inFieldLabel')); ?>
					<div class="unit size1of2">
						<div class="inputBox">
						<?php echo $form->textField($domain,'domain'); ?>
						</div>
					</div>
					<div class="lastUnit">
						<label class="mlm" for="AppDomain_domain" style="color:#999;">.<?php echo Yii::app()->hostname; ?></label>
					</div>
				</div>
			</div>
			<?php echo $form->error($domain,'domain'); ?>
			<span class="hint">This is only set once. It can be your company or agency name.</span>
		</div>
		<?php  endif; ?>
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

			
		<div class="field submit line mtl">
			<p class="hint" style="line-height:16px;">By singing up you agree to the <a href="<?php echo NHtml::url('site/terms'); ?>">terms and conditions</a></p>
			<?php echo CHtml::submitButton(UserModule::t("Register"),array('class'=>'btn aristo primary large pll prl','style'=>'width:100%','onclick'=>'$(this).val(\'Loading...\').addClass(\'disabled\')')); ?>
		</div>
	</div>
	<div class="lastUnit pll">
		<div class="line">
			<div class="unit">
				<img style="padding-left:50px" src="<?php echo Yii::app()->theme->baseUrl.'/images/whitefade.png' ?>" />
			</div>
			<div class="lastUnit">				
				
			</div>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>
<?php endif; ?>