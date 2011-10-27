<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Restore");
$this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Restore"),
);
?>

<h1><?php echo UserModule::t("Restore"); ?></h1>

<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
</div>
<?php else: ?>

<div class="form">
<?php echo CHtml::beginForm(); ?>

	<?php echo CHtml::errorSummary($form); ?>
	
	<div class="field">
		<div class="inputContainer">
			<?php echo CHtml::activeLabel($form,'login_or_email',array('class'=>'inFieldLabel')); ?>
			<div class="inputBox">
				<?php echo CHtml::activeTextField($form,'login_or_email') ?>
			</div>
		</div>
		<p class="hint"><?php echo UserModule::t("Please enter your email address."); ?></p>
	</div>
	
	<div class="field submit">
		<?php echo CHtml::submitButton(UserModule::t("Restore"),array('class'=>'btn aristo')); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->
<?php endif; ?>