<div class="page-header">
	<h1><?php echo $action=='create' ? 'Create a New' : 'Edit a ' ?> Contact Group</h1>
</div>
<?php
$form = $this->beginWidget('NActiveForm', array(
		'id' => 'contactGroupForm',
		'action' => $action,
		'enableAjaxValidation'=>false,
		'enableClientValidation'=>true,
	));

?>
<div class="container pull-left">
		<div class="line field">
			<div class="unit size1of4 detailLabel"><?php echo $this->t('Group Name') ?></div>
			<div class="lastUnit">
				<div class="input">
					<?php echo $form->textField($model, 'name', array('size' => 30)); ?>
				</div>
				<?php echo $form->error($model,'name'); ?>
			</div>
		</div>
		<div class="line field">
			<div class="unit size1of4 detailLabel"><?php echo $this->t('Description') ?></div>
			<div class="lastUnit">
				<div class="input">
					<?php echo $form->textArea($model, 'description', array('rows' => 3)); ?>
				</div>
				<?php echo $form->error($model,'description'); ?>
			</div>
	</div>
	<div class="actions">
		<?php
		$cancelUrl = ($model->id) ? array('group/view','id'=>$model->id) : array('group/index');
		echo NHtml::submitButton('Save', array('class'=>'btn primary')) . '&nbsp;';
		echo NHtml::btnLink('Cancel', $cancelUrl, null, array('class'=>'btn cancel cancelButton')) . '&nbsp;';
		?>		
	</div>
</div>
<?php $this->endWidget();