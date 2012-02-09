<?php $flashes = array('success', 'error', 'info', 'warning'); ?>
<?php foreach($flashes as $k => $flashKey): ?>
	<?php if(Yii::app()->user->hasFlash($flashKey)): ?>
		<div data-alert class="alert-message block-message <?php echo $flashKey ?>">
			<p><?php echo Yii::app()->user->getFlash($flashKey); ?></p>
		</div>
	<?php endif; ?>
<?php endforeach; ?>
<?php
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'user-account-form',
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
));
?>
<fieldset>
	<?php echo $form->field($model, 'first_name'); ?>
	<?php echo $form->field($model, 'last_name'); ?>
	<?php echo $form->field($model, 'email'); ?>
</fieldset>
<?php $this->endWidget(); ?>