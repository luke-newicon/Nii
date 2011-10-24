<?php $this->pageTitle = Yii::app()->name . ' - Installation Step 1'; ?>
<?php $form = $this->beginWidget('NActiveForm', array(
		'id' => 'installForm',
	));
if ($model->installDb == true) {
?>
	<p class="alert-message info block-message">Please fill in the details below to install this application</p>
	<h3>Site Details</h3>
	<div class="line field">
		<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($model, 'sitename'); ?></div>
		<div class="lastUnit">
			<div class="inputBox">
				<?php echo $form->textField($model, 'sitename'); ?>
			</div>
			<?php echo $form->error($model, 'sitename'); ?>
		</div>
	</div>
	<div class="line field">
		<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($model, 'timezone'); ?></div>
		<div class="lastUnit">
			<div class="inputBox">
				<?php if (!$model->timezone) $model->timezone = 'Europe/London';
				echo $form->dropDownList($model, 'timezone', Controller::getTimeZones()); ?>
			</div>
			<?php echo $form->error($model, 'timezone'); ?>
		</div>
	</div>
	<h3>Database Details</h3>
	<div class="line field">
		<?php echo $form->error($model, 'db', array('class'=>'errorMessage alert-message block-message error')); // shows general database errors if in debug mode ?>
	</div>
	<div class="line field <?php echo ($model->hasErrors('db_host'))?'error':''; ?>">
		<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($model, 'db_host'); ?></div>
		<div class="lastUnit">
			<div class="inputBox w300">
				<?php echo $form->textField($model, 'db_host'); ?>
			</div>
			<small>e.g. localhost <em>-or-</em> mydomain.com</small>
			<?php echo $form->error($model, 'db_host'); ?>
		</div>
	</div>
	<div class="line field <?php echo ($model->hasErrors('db_name'))?'error':''; ?>">
		<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($model, 'db_name'); ?></div>
		<div class="lastUnit">
			<div class="inputBox w300">
				<?php echo $form->textField($model, 'db_name'); ?>
			</div>
			<?php echo $form->error($model, 'db_name'); ?>
		</div>
	</div>
	<div class="field <?php echo ($model->hasErrors('db_password'))?'error':''; ?> <?php echo ($model->hasErrors('db_username'))?'error':''; ?>">
		<div class="line field ">
			<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($model, 'db_username'); ?></div>
			<div class="lastUnit">
				<div class="inputBox w300">
					<?php echo $form->textField($model, 'db_username'); ?>
				</div>
				<?php echo $form->error($model, 'db_username'); ?>
			</div>
		</div>
		<div class="line field ">
			<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($model, 'db_password'); ?></div>
			<div class="lastUnit">
				<div class="inputBox w300">
					<?php echo $form->passwordField($model, 'db_password'); ?>
				</div>
				<?php echo $form->error($model, 'db_password'); ?>
				<small>Leave blank if using root with no password (not recommended)</small>
			</div>
		</div>
	</div>
	<div class="line field">
		<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($model, 'db_tablePrefix'); ?></div>
		<div class="lastUnit">
			<div class="inputBox w300">
				<?php echo $form->textField($model, 'db_tablePrefix'); ?>
			</div>
			<?php echo $form->error($model, 'db_tablePrefix'); ?>
			<small>Leave blank for no prefix</small>
		</div>
	</div>
<?php } else { ?>
	<p class="notice-msg">The database details have already been installed for this application.<br />To add a new admin user, enter the details below:</p>
<?php } ?>
<h3>Admin User Details</h3>
<div class="line field <?php echo ($model->hasErrors('username'))?'error':''; ?>">
	<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($model, 'username'); ?></div>
	<div class="lastUnit">
		<div class="inputBox w300">
			<?php echo $form->textField($model, 'username'); ?>
		</div>
		<?php echo $form->error($model, 'username'); ?>
	</div>
</div>
<div class="line field <?php echo ($model->hasErrors('password'))?'error':''; ?>">
	<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($model, 'password'); ?></div>
	<div class="lastUnit">
		<div class="inputBox w300">
			<?php echo $form->passwordField($model, 'password'); ?>
		</div>
		<?php echo $form->error($model, 'password'); ?>
	</div>
</div>
<div class="line field <?php echo ($model->hasErrors('email'))?'error':''; ?>">
	<div class="unit size1of5 inputLabel"><?php echo $form->labelEx($model, 'email'); ?></div>
	<div class="lastUnit">
		<div class="inputBox w300">
			<?php echo $form->textField($model, 'email'); ?>
		</div>
		<?php echo $form->error($model, 'email'); ?>
	</div>
</div>
<div class="line ptm">
	<div class="unit size1of5">&nbsp;</div>
	<div class="lastUnit">
		<?php echo NHtml::btn('Install','icon fam-database-go','installSubmit primary'); ?>
	</div>
</div>
<?php 
echo $form->hiddenField($model,'installDb');
$this->endWidget(); ?>
<script>
	$('#installForm').delegate('.installSubmit','click',function(){
		$('#installForm').submit();
		return false;
	}); 
</script>