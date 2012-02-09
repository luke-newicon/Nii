<?php 
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'SavedCampaignForm',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
));
?>
<div class="page-header">
	<h1><?php echo isset($model->id) ? $this->t('Edit Saved Campaign') : $this->t('New Saved Campaign'); ?></h1>
	<div class="action-buttons">
		<?php 
		if (isset($model->id))
			echo NHtml::trashButton($model, 'saved campaign', '/email/manage/', 'Successfully deleted '.$model->name); 
		?>
	</div>
</div>
<div class="line field">
	<div class="unit w140"><?php echo $form->labelEx($model,'name') ?></div>
	<div class="lastUnit w500">
		<div class="input">
			<?php echo $form->textField($model,'name'); ?>
		</div>
		<?php echo $form->error($model,'name'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit w140"><?php echo $form->labelEx($model,'description') ?></div>
	<div class="lastUnit w500">
		<div class="input">
			<?php echo $form->textArea($model,'description'); ?>
		</div>
		<?php echo $form->error($model,'description'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit w140"><?php echo $form->labelEx($model,'default_group_id') ?></div>
	<div class="lastUnit w500">
		<div class="input">
			<?php echo $form->dropDownList($model,'default_group_id', ContactGroup::getGroups(), array('prompt'=>'None')); ?>
		</div>
		<?php echo $form->error($model,'default_group_id'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit w140"><?php echo $form->labelEx($model,'design_template_id') ?></div>
	<div class="lastUnit w500">
		<div class="input">
			<?php echo $form->dropDownList($model,'design_template_id', EmailTemplate::getTemplates(), array('prompt'=>'None')); ?>
		</div>
		<?php echo $form->error($model,'design_template_id'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit w140"><?php echo $form->labelEx($model,'subject') ?></div>
	<div class="lastUnit w500">
		<div class="input">
			<?php echo $form->textField($model,'subject'); ?>
		</div>
		<?php echo $form->error($model,'subject'); ?>
	</div>
</div>
<div class="line field">
	<div class="lbl"><?php echo $form->labelEx($model,'content') ?></div>
	<div class="unit size2of3">
		<div class="input">
		<?php
		$this->widget('nii.widgets.editor.CKkceditor',array(
			"attribute"=>'content',
			'model'=>$model,
			'width'=>'100%',
			'height'=>'500px',
			'config'=>array(
				'toolbar'=> array(
					array('Bold', 'Italic', 'Underline', '-', 'Format',
						'-', 'JustifyLeft','JustifyCenter','JustifyRight', '-', 'BulletedList','NumberedList'),
					array( 'Image', 'Link', 'Unlink', 'Anchor','-','Source' )
				),
//				'toolbar'=>'Full',
				'skin'=>'nii',
				'toolbarCanCollapse'=>false,
				'resize_enabled'=>false,
				'bodyId'=>'emailContent'
			),
			"filespath"=>Yii::app()->getRuntimePath(),
			"filesurl"=>'/runtime',
		));

		?>
		</div>
	</div>
</div>
<div class="actions">
	<?php 
	echo NHtml::submitButton('Save', array('class'=>'btn primary')) . '&nbsp;';
	if (isset($model->id))
		echo NHtml::link('Cancel', array('view','id'=>$model->id), array('class'=>'btn')) . '&nbsp;';
	else
		echo NHtml::link('Cancel', array('index'), array('class'=>'btn'));
	?>
</div>
<?php $this->endWidget();