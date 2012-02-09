<div class="page-header">
	<h2><?php echo $action=='edit' ? 'Edit Server Details - '.$model->name : 'Add Server Details'; ?></h2>
	<?php if ($action=='edit') : ?>
		<div class="action-buttons">
			<div class="pull-right">
				<?php echo NHtml::trashButton($model, 'server', '/hosting/server/', 'Successfully deleted server'); ?>
			</div>
		</div>
	<?php endif; ?>
</div>
	<?php
$formAction = $action=='edit' ? array($action, 'id'=>$model->id) : array($action);
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'donationForm',
	'action' => $formAction,
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
));

$modelName = get_class($model);
?>
<div class="pull-left">
	<div class="line field">
		<div class="unit size1of6"><?php echo $form->labelEx($model,'name') ?></div>
		<div class="lastUnit">
			<div class="input w170"><?php echo $form->textField($model, 'name', array('size' => 30)); ?></div>
			<?php echo $form->error($model,'name'); ?>
		</div>
	</div>
	<div class="line field">
		<div class="unit size1of6"><?php echo $form->labelEx($model,'server_name') ?></div>
		<div class="lastUnit">
			<div class="input w170"><?php echo $form->textField($model, 'server_name', array('size' => 30)); ?></div>
			<?php echo $form->error($model,'server_name'); ?>
		</div>
	</div>
	<div class="line field">
		<div class="unit size1of6"><?php echo $form->labelEx($model,'ip_address') ?></div>
		<div class="lastUnit">
			<div class="input w170"><?php echo $form->textField($model, 'ip_address', array('size' => 30)); ?></div>
			<?php echo $form->error($model,'ip_address'); ?>
		</div>
	</div>
	<div class="line field">
		<div class="unit size1of6"><?php echo $form->labelEx($model,'root_password') ?></div>
		<div class="lastUnit">
			<div class="input w170"><?php echo $form->textField($model, 'root_password', array('size' => 30)); ?></div>
			<?php echo $form->error($model,'root_password'); ?>
		</div>
	</div>
	<div class="line field">
		<div class="unit size1of6"><?php echo $form->labelEx($model,'created_date') ?></div>
		<div class="lastUnit">
			<div class="w170"><?php $this->widget('nii.widgets.forms.DateInput', array('model' => $model, 'attribute' => 'created_date')); ?></div>
			<?php echo $form->error($model,'created_date'); ?>
		</div>
	</div>
	<div class="actions">
		<?php
		$cancelUrl = ($model->id) ? array('server/view','id'=>$model->id) : array('server/index');
		echo NHtml::submitButton('Save', array('class'=>'btn primary')) . '&nbsp;';
		echo NHtml::btnLink('Cancel', $cancelUrl, null, array('class'=>'btn cancel cancelButton')) . '&nbsp;';
//		if ($model->id)
//			echo NHtml::trashButton($model, 'donation', 'donation/index', 'Successfully deleted donation');

		?>		
	</div>
</div>

<?php $this->endWidget();