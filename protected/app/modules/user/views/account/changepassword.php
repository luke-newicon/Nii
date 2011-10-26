<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password");
$this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/admin'),
	UserModule::t("Change Password"),
);
?>

<h1><?php echo UserModule::t("Change Password"); ?></h1>


<div style="width:400px;">
<?php echo CHtml::beginForm(); ?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
	<?php echo CHtml::errorSummary($form); ?>
	
	<div class="field">
		<?php echo CHtml::activeLabelEx($form,'password',array('class'=>'inFieldLabel')); ?>
		<div class="inputBox">
			<?php echo CHtml::activePasswordField($form,'password'); ?>
		</div>
	</div>
	
	<div class="field">
		<?php echo CHtml::activeLabelEx($form,'verifyPassword',array('class'=>'inFieldLabel')); ?>
		<div class="inputBox">
			<?php echo CHtml::activePasswordField($form,'verifyPassword'); ?>
		</div>
	</div>
	
	<div class="field submit">
	<?php echo CHtml::submitButton(UserModule::t("Save"),array('class'=>'btn aristo')); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->