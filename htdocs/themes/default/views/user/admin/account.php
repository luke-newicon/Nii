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
//	'enableAjaxValidation' => true,
//	'enableClientValidation' => false,
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
	<div class="field">
		<?php echo $form->labelEx($model, 'email'); ?>
		<div class="inputContainer">
			<div class="input">
				<?php echo $form->textField($model, 'email'); ?>
			</div>
			<?php echo $form->error($model, 'email'); ?>
		</div>
	</div>
</fieldset>
<?php $this->endWidget(); ?>