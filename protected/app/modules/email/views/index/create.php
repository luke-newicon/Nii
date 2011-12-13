<div class="page-header">
	<h2>Send an Email</h2>
	<div class="action-buttons email-campaign-details"<?php echo (isset($model->template_id)) ? '' : ' style="display:none;"';?>>
		<?php echo NHtml::submitButton('Continue', array('class'=>'btn primary')) . '&nbsp;'; ?>		
	</div>
</div>
<?php 
$form = $this->beginWidget('NActiveForm', array(
	'id' => 'emailCampaignForm',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
));
?>
<div class="container pull-left">
	<div class="line field">
		<div class="unit w140"><?= $form->labelEx($model,'template_id') ?></div>
		<div class="lastUnit w500">
			<div class="input">
				<?php echo $form->dropDownList($model,'template_id',EmailCampaignTemplate::getTemplatesArray(), array(
					'prompt'=>'...',
					'onchange'=>$model->selectTemplateFromDropdown(),
				)); ?>
			</div>
			<?php echo $form->error($model,'template_id'); ?>
		</div>
	</div>
</div>
<div class="email-campaign-details"<?php echo (isset($model->template_id)) ? '' : ' style="display:none;"';?>>
	<div class="container pull-left">
		<div class="line field">
			<div class="unit w140"><?= $form->labelEx($model,'recipients') ?></div>
			<div class="lastUnit w500">
					<?php $this->widget('nii.widgets.tokeninput.NTokenInput', array(
						'model'=>$model,
						'attribute'=>'recipients',
						'url'=>'/email/index/recipients',
						'prePopulate'=>$model->explodeRecipients(),
						'options'=>array('hintText'=>'', 'addNewTokens'=>true, 'animateDropdown'=>false)
					)); ?>
				<?php echo $form->error($model,'recipients'); ?>
			</div>
		</div>
		<div class="line field">
			<div class="unit w140"><?= $form->labelEx($model,'subject') ?></div>
			<div class="lastUnit w500">
				<div class="input">
					<?php echo $form->textField($model,'subject'); ?>
				</div>
				<?php echo $form->error($model,'subject'); ?>
			</div>
		</div>
	</div>
	<div class="line field">
		<div class="lbl"><?= $form->labelEx($model,'content') ?></div>
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
		<div class="lastUnit well pts">
			<h4 class="ptn mts">Smart Tags</h4>
			<div class="line lbl">
				<div class="unit size1of3">Tag</div>
				<div class="lastUnit">Description</div>
			</div>
			
			<?php $t = new StringTags;
			$tags = $t->getTagsArray();
			foreach($tags as $tag) : ?>
				<div class="line">
					<div class="unit size1of3"><?php echo $tag['name'] ?></div>
					<div class="lastUnit"><?php echo $tag['description'] ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="actions">
		<?php echo NHtml::submitButton('Continue', array('class'=>'btn primary')) . '&nbsp;'; ?>		
	</div>
</div>
<?php $this->endWidget();