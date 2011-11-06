<?php
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'user-password-form',
//	'enableAjaxValidation' => true,
//	'enableClientValidation' => false,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
	),
	'focus' => array($model, 'name'),
));
?>
<fieldset>
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
</fieldset>
<?php $this->endWidget(); ?>