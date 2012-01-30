<?php $this->pageTitle = Yii::app()->name . ' - Installer'; ?>
<?php $form = $this->beginWidget('NActiveForm', array(
		'id' => 'installForm',
		'htmlOptions'=>array('class'=>'float')
	));
?>
<fieldset>
	<legend>Admin User Details</legend>
	<div class="field <?php echo ($userForm->hasErrors('email'))?'error':''; ?>">
		<?php echo $form->labelEx($userForm, 'email'); ?>
		<div class="input large">
			<?php echo $form->textField($userForm, 'email'); ?>
		</div>
		<?php echo $form->error($userForm, 'email'); ?>
	</div>
	<div class="field <?php echo ($userForm->hasErrors('username'))?'error':''; ?>">
		<?php echo $form->labelEx($userForm, 'username'); ?>
		<div class="input medium">
			<?php echo $form->textField($userForm, 'username'); ?>
		</div>
		<?php echo $form->error($userForm, 'username'); ?>
	</div>
	<div class="field <?php echo ($userForm->hasErrors('password'))?'error':''; ?>">
		<?php echo $form->labelEx($userForm, 'password'); ?>
		<div class="input medium">
			<?php echo $form->passwordField($userForm, 'password'); ?>
		</div>
		<?php echo $form->error($userForm, 'password'); ?>
	</div>
	<div class="actions">
		<?php echo NHtml::submitButton('Install',array('class'=>'btn installSubmit primary large')); ?>
	</div>
</fieldset>
<?php $this->endWidget(); ?>