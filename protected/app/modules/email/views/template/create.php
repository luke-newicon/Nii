<div class="page-header"><h2>Start a New Email Campaign</h2></div>
<?php 
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'emailCampaignForm',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
));
?>
<div class="container pull-left">
	<div class="line field">
		<div class="unit size1of6"><?= $form->labelEx($model,'template_id') ?></div>
		<div class="lastUnit">
			<div class="input w250">
				<?php echo $form->dropDownList($model,'template_id',EmailTemplate::getTemplatesArray(), array(
					'prompt'=>'...',
					'onchange'=>$model->selectTemplateFromDropdown(),
				)); ?>
			</div>
			<?php echo $form->error($model,'template_id'); ?>
		</div>
	</div>
	<div class="line field">
		<div class="unit size1of6"><?= $form->labelEx($model,'recipients') ?></div>
		<div class="lastUnit">
				<?php $this->widget('nii.widgets.tokeninput.NTokenInput', array(
					'model'=>$model,
					'attribute'=>'recipients',
					'url'=>'/email/index/contacts',
					'options'=>array('hintText'=>'','addNewTokens'=>true,'animateDropdown'=>false)
				)); ?>
			<?php echo $form->error($model,'recipients'); ?>
		</div>
	</div>
	<div class="line field">
		<div class="lbl"><h3>Design</h3></div>
		<div class="input w700">
		<?php
		$this->widget('nii.widgets.editor.CKkceditor',array(
			"name"=>'content',
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

<?php $this->endWidget();