<?php
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'add-user-form',
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
	),
	'focus' => array($model, 'first_name'),
));
?>
<fieldset>
	<div class="line">
		<div class="field unit size1of2">
			<?php echo $form->labelEx($model, 'first_name'); ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo $form->textField($model, 'first_name'); ?>
				</div>
				<?php echo $form->error($model, 'first_name'); ?>
			</div>
		</div>
		<div class="field lastUnit">
			<?php echo $form->labelEx($model, 'last_name'); ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo $form->textField($model, 'last_name'); ?>
				</div>
				<?php echo $form->error($model, 'last_name'); ?>
			</div>
		</div>
	</div>
	<div class="line">
		<div class="field unit size1of2">
			<?php echo $form->labelEx($model, 'email'); ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo $form->textField($model, 'email'); ?>
				</div>
				<?php echo $form->error($model, 'email'); ?>
			</div>
		</div>
		<div class="field lastUnit">
			<?php echo $form->labelEx($model, 'username'); ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo $form->textField($model, 'username'); ?>
				</div>
				<?php echo $form->error($model, 'username'); ?>
			</div>
		</div>
	</div>
	<div class="line">
		<div class="field unit size1of2">
			<?php echo $form->labelEx($model, 'password'); ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo $form->passwordField($model, 'password'); ?>
				</div>
				<?php echo $form->error($model, 'password'); ?>
			</div>
		</div>
		<div class="field lastUnit">
			<?php echo $form->labelEx($model, 'verifyPassword'); ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo $form->passwordField($model, 'verifyPassword'); ?>
				</div>
				<?php echo $form->error($model, 'verifyPassword'); ?>
			</div>
		</div>
	</div>
	<div class="line">
		<div class="field unit size1of2">
			<?php echo $form->labelEx($model, 'superuser'); ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo $form->dropDownList($model, 'superuser', User::itemAlias('AdminStatus')); ?>
				</div>
				<?php echo $form->error($model, 'superuser'); ?>
			</div>
		</div>
		<div class="field lastUnit">
			<?php echo $form->labelEx($model, 'status'); ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo $form->dropDownList($model, 'status', User::itemAlias('UserStatus')); ?>
				</div>
				<?php echo $form->error($model, 'status'); ?>
			</div>
		</div>
	</div>
	<div class="line">
		<div class="field">
			<?php echo $form->labelEx($model, 'roleName'); ?>
			<div class="inputContainer">
				<div class="input">
					<?php echo $form->dropDownList($model, 'roleName', CHtml::listData(Yii::app()->authManager->roles,'name','description')) ?>
				</div>
				<?php echo $form->error($model, 'roleName'); ?>
			</div>
		</div>
	</div>
</fieldset>
<?php $this->endWidget(); ?>