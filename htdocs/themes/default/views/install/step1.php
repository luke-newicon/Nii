<?php $this->pageTitle = Yii::app()->name . ' - Installer'; ?>
<?php $form = $this->beginWidget('NActiveForm', array(
		'id' => 'installForm',
		'htmlOptions'=>array('class'=>'float')
	));
?>
<?php if(Yii::app()->user->hasFlash('debug')): ?>
	<div class="alert-message error block-message">
		<?php echo Yii::app()->user->getFlash('debug'); ?>
	</div>
<? endif; ?>

<?php if(Yii::app()->user->hasFlash('error')): ?>
	<div class="alert-message error block-message">
		<p><?php echo Yii::app()->user->getFlash('error'); ?></p>
	</div>
<? endif; ?>


	<div class="alert-message info block-message">
		<p>Please fill in the details below to install this application.</p>
		<div class="alert-actions">
			<a class="btn small" href="<?php echo NHtml::url('/install/requirements/index.php'); ?>">Check Requirements</a>
		</div>
	</div>
	<fieldset>
		<legend>Site Details</legend>
		<div class="field">
			<?php echo $form->labelEx($dbForm, 'sitename'); ?>
			<div class="input large">
				<?php echo $form->textField($dbForm, 'sitename'); ?>
			</div>
			<?php echo $form->error($dbForm, 'sitename'); ?>
		</div>
		<div class="field">
			<?php echo $form->labelEx($dbForm, 'timezone'); ?>
			<div class="input xlarge">
				<?php if (!$dbForm->timezone) $dbForm->timezone = 'Europe/London';
				echo $form->dropDownList($dbForm, 'timezone', Controller::getTimeZones()); ?>
			</div>
			<?php echo $form->error($dbForm, 'timezone'); ?>
		</div>
	</fieldset>
	<fieldset>
		<legend>Database Details</legend>
		<?php echo $form->error($dbForm, 'db', array('class'=>'errorMessage alert-message block-message error')); // shows general database errors if in debug mode ?>
		<div class="field <?php echo ($dbForm->hasErrors('host'))?'error':''; ?>">
			<?php echo $form->labelEx($dbForm, 'host'); ?>
			<div class="input large">
				<?php echo $form->textField($dbForm, 'host'); ?>
			</div>
			<small>e.g. localhost <em>-or-</em> mydomain.com</small>
			<?php echo $form->error($dbForm, 'host'); ?>
		</div>
		<div class="field <?php echo ($dbForm->hasErrors('name'))?'error':''; ?>">
			<?php echo $form->labelEx($dbForm, 'name'); ?>
			<div class="input large">
				<?php echo $form->textField($dbForm, 'name'); ?>
			</div>
			<?php echo $form->error($dbForm, 'name'); ?>
		</div>
		<div class="field <?php echo ($dbForm->hasErrors('password'))?'error':''; ?> <?php echo ($dbForm->hasErrors('username'))?'error':''; ?>">
			<?php echo $form->labelEx($dbForm, 'username'); ?>
			<div class="input large">
				<?php echo $form->textField($dbForm, 'username'); ?>
			</div>
			<?php echo $form->error($dbForm, 'username'); ?>
		</div>
		<div class="field ">
			<?php echo $form->labelEx($dbForm, 'password'); ?>
			<div class="input large">
				<?php echo $form->passwordField($dbForm, 'password'); ?>
			</div>
			<?php echo $form->error($dbForm, 'password'); ?>
			<span class="hint">Leave blank if using root with no password (not recommended)</span>
		</div>
		<div class="line field">
			<?php echo $form->labelEx($dbForm, 'tablePrefix'); ?>
			<div class="input small">
				<?php echo $form->textField($dbForm, 'tablePrefix'); ?>
			</div>
			<?php echo $form->error($dbForm, 'tablePrefix'); ?>
			<span class="hint">Leave blank for no prefix</span>
		</div>
	</fieldset>
	<div class="actions">
		<?php echo NHtml::submitButton('Install Database - Next',array('class'=>'btn installSubmit primary large')); ?>
	</div>
<?php 
$this->endWidget(); ?>
<script>
	$('#installForm').delegate('.installSubmit','click',function(){
		$('#installForm').submit();
		return false;
	}); 
	$('#<?php echo CHtml::activeId($dbForm, 'username'); ?>, #<?php echo CHtml::activeId($dbForm, 'password'); ?>').change(function(){
		$.fn.yiiactiveform.doValidate('#installForm', {attributes:['<?php echo CHtml::activeId($dbForm, 'username'); ?>','<?php echo CHtml::activeId($dbForm, 'password'); ?>']})
	});
</script>