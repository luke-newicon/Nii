<?php
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'user-password-form',
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
	),
));
?>
<fieldset>
	<?php echo $form->field($model, 'password', 'passwordField'); ?>
	<?php echo $form->field($model, 'verifyPassword', 'passwordField'); ?>
</fieldset>
<?php $this->endWidget(); ?>