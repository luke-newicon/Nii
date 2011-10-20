<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login"); ?>



<?php
$form = $this->beginWidget('nii.widgets.NActiveForm', array(
    'id' => 'userloginform',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,));
?>

<div class="shadowBlockLarge paddedBlock w400">
<div style="text-align:center; margin-bottom: 16px;"><img src="<?php echo Yii::app()->baseUrl; ?>/images/logo.gif" /></div>

<div style="margin-left: 12px;">
<h2><?php echo UserModule::t("Login"); ?></h2>

<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>
	<div class="success-msg">
		<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
	</div>
<?php endif; ?>

<p class="note">Please enter your details to login to the system.</p>


	<?php if (Yii::app()->user->hasFlash('success')): ?>

            <div class="alert-message block-message success">
                <?php echo Yii::app()->user->getFlash('success'); ?>
            </div>

	<?php endif; ?>
	
	<?php if ($model->hasErrors()): ?>
		<div class="alert-message block-message error">
			<?php echo $form->errorSummary($model); ?>
		</div>
	<?php endif; ?>
	
	<div class="line">
		<div class="field  <?php echo $model->hasErrors('username') ? 'error' : ''; ?>">
			<div class="unit size1of3">
				<?php echo $form->LabelEx($model,'username'); ?>
			</div>
			<div class="lastUnit">
				<div class="inputBox w240">
					<?php echo $form->textField($model,'username') ?>
				</div>
				<?php echo $form->error($model,'username') ?>
			</div>
		</div>
	</div>
	
	<div class="line">
		<div class="field <?php echo $model->hasErrors('password') ? 'error' : ''; ?>">
			<div class="unit size1of3">
				<?php echo $form->LabelEx($model,'password'); ?>
			</div>
			<div class="lastUnit">
				<div class="inputBox w240">
					<?php echo $form->passwordField($model,'password') ?>
				</div>
				<?php echo $form->error($model,'password') ?>
			</div>
		</div>
	</div>

	<div class="line rememberMe">
		<div class="unit size1of3">&nbsp;</div>
		<div class="lastUnit">
			<div class="unit size1of10">
				<?php echo $form->checkBox($model,'rememberMe',array('class'=>'inputInline')); ?>
			</div>
			<div class="lastUnit">
				<?php echo $form->labelEx($model,'rememberMe'); ?>
			</div>
		</div>
	</div>

	<div class="line submit pts">
		<div class="unit size1of3">&nbsp;</div>
		<div class="lastUnit">
			<?php echo CHtml::submitButton(UserModule::t("Login"), array('class'=>'btn btnN')); ?>
		</div>
	</div>
	<?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
	

</div><!-- form -->
</div>
</div>
<?php $this->endWidget(); ?>

<?php if($model->hasErrors()): ?>
    <?php $focus = ($model->hasErrors('password')) ? CHtml::getActiveId($model, 'password') : '';  ?>
    <?php $focus = ($model->hasErrors('username')) ? CHtml::getActiveId($model, 'username') : $focus;  ?>
    <?php Yii::app()->clientScript->registerScript('login-shake','$("#userloginform").effect( "shake", {times:3, distance:7}, 50, function(){$("#'.$focus.'").focus();});', CClientScript::POS_READY); ?>
<?php endif; ?>