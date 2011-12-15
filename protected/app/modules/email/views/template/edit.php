<?php 
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'SavedCampaignForm',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
));
?>
<div class="page-header">
	<h2><?php echo isset($model->id) ? $this->t('Edit Design Template') : $this->t('New Design Template'); ?></h2>
	<div class="action-buttons">
		<?php 
		if (isset($model->id))
			echo NHtml::trashButton($model, 'template', '/email/template', 'Successfully deleted template: '.$model->name); 
		?>
	</div>
</div>
<div class="line field">
	<div class="unit w140"><?= $form->labelEx($model,'name') ?></div>
	<div class="lastUnit w500">
		<div class="input">
			<?php echo $form->textField($model,'name'); ?>
		</div>
		<?php echo $form->error($model,'name'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit w140"><?= $form->labelEx($model,'description') ?></div>
	<div class="lastUnit w500">
		<div class="input">
			<?php echo $form->textArea($model,'description'); ?>
		</div>
		<?php echo $form->error($model,'description'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit w140"><?= $form->labelEx($model,'default_template') ?></div>
	<div class="lastUnit w500">
		<div>
			<?php echo $form->checkBox($model,'default_template'); ?>
		</div>
		<?php echo $form->error($model,'default_template'); ?>
	</div>
</div>
<div class="line field">
	<div class="lbl"><?= $form->labelEx($model,'content') ?></div>
	<div class="lastUnit">
		<div class="alert-message block-message info">
			Use the [content] tag to define where the main email content will be displayed.
		</div>
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