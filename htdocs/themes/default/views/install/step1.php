<?php $this->pageTitle = Yii::app()->name . ' - Installation Step 1'; ?>
<?php $form = $this->beginWidget('NActiveForm', array(
		'id' => 'installForm',
		'htmlOptions'=>array('class'=>'float')
	));
if ($model->installDb == true) {
?>
	<p class="alert-message info block-message">Please fill in the details below to install this application</p>
	<fieldset>
		<legend>Site Details</legend>
	<div class="field">
		<?php echo $form->labelEx($model, 'sitename'); ?>
		<div class="input">
			<?php echo $form->textField($model, 'sitename'); ?>
		</div>
		<?php echo $form->error($model, 'sitename'); ?>
	</div>
	<div class="field">
		<?php echo $form->labelEx($model, 'timezone'); ?>
		<div class="input">
			<?php if (!$model->timezone) $model->timezone = 'Europe/London';
			echo $form->dropDownList($model, 'timezone', Controller::getTimeZones()); ?>
		</div>
		<?php echo $form->error($model, 'timezone'); ?>
	</div>
	<fieldset>
		<legend>Database Details</legend>
		<?php echo $form->error($model, 'db', array('class'=>'errorMessage alert-message block-message error')); // shows general database errors if in debug mode ?>
	<div class="field <?php echo ($model->hasErrors('db_host'))?'error':''; ?>">
		<?php echo $form->labelEx($model, 'db_host'); ?>
		<div class="input w300">
			<?php echo $form->textField($model, 'db_host'); ?>
		</div>
		<small>e.g. localhost <em>-or-</em> mydomain.com</small>
		<?php echo $form->error($model, 'db_host'); ?>
	</div>
	<div class="field <?php echo ($model->hasErrors('db_name'))?'error':''; ?>">
		<?php echo $form->labelEx($model, 'db_name'); ?>
		<div class="input w300">
			<?php echo $form->textField($model, 'db_name'); ?>
		</div>
		<?php echo $form->error($model, 'db_name'); ?>
	</div>
	<div class="field <?php echo ($model->hasErrors('db_password'))?'error':''; ?> <?php echo ($model->hasErrors('db_username'))?'error':''; ?>">
		<?php echo $form->labelEx($model, 'db_username'); ?>
		<div class="input w300">
			<?php echo $form->textField($model, 'db_username'); ?>
		</div>
		<?php echo $form->error($model, 'db_username'); ?>
	</div>
	<div class="field ">
		<?php echo $form->labelEx($model, 'db_password'); ?>
		<div class="input w300">
			<?php echo $form->passwordField($model, 'db_password'); ?>
		</div>
		<?php echo $form->error($model, 'db_password'); ?>
		<span class="hint">Leave blank if using root with no password (not recommended)</span>
	</div>
	<div class="line field">
		<?php echo $form->labelEx($model, 'db_tablePrefix'); ?>
		<div class="input w300">
			<?php echo $form->textField($model, 'db_tablePrefix'); ?>
		</div>
		<?php echo $form->error($model, 'db_tablePrefix'); ?>
		<span class="hint">Leave blank for no prefix</span>
	</div>
<?php } else { ?>
	<p class="notice-msg">The database details have already been installed for this application.<br />To add a new admin user, enter the details below:</p>
<?php } ?>
	</fieldset>
	<fieldset>
		<legend>Admin User Details</legend>
	<div class="field <?php echo ($model->hasErrors('username'))?'error':''; ?>">
		<?php echo $form->labelEx($model, 'username'); ?>
		<div class="input w300">
			<?php echo $form->textField($model, 'username'); ?>
		</div>
		<?php echo $form->error($model, 'username'); ?>
	</div>
	<div class="field <?php echo ($model->hasErrors('password'))?'error':''; ?>">
		<?php echo $form->labelEx($model, 'password'); ?>
		<div class="input w300">
			<?php echo $form->passwordField($model, 'password'); ?>
		</div>
		<?php echo $form->error($model, 'password'); ?>
	</div>
	<div class="field <?php echo ($model->hasErrors('email'))?'error':''; ?>">
		<?php echo $form->labelEx($model, 'email'); ?>
		<div class="input w300">
			<?php echo $form->textField($model, 'email'); ?>
		</div>
		<?php echo $form->error($model, 'email'); ?>
	</div>
	<div class="line ptm">
		<div class="unit size1of5">&nbsp;</div>
		<div class="lastUnit">
			<?php echo NHtml::btn('Install','icon fam-database-go','installSubmit primary'); ?>
		</div>
	</div>
	</fieldset>
<?php 
echo $form->hiddenField($model,'installDb');
$this->endWidget(); ?>
<script>
	$('#installForm').delegate('.installSubmit','click',function(){
		$('#installForm').submit();
		return false;
	}); 
	$('#<?php echo CHtml::activeId($model, 'db_username'); ?>, #<?php echo CHtml::activeId($model, 'db_password'); ?>').change(function(){
		$.fn.yiiactiveform.doValidate('#installForm', {attributes:['<?php echo CHtml::activeId($model, 'db_username'); ?>','<?php echo CHtml::activeId($model, 'db_password'); ?>']})
	});
</script>