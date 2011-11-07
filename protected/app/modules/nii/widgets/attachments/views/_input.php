<?php
$form = $this->beginWidget('NActiveForm', array(
		'id' => 'newAttachmentForm-'.$id,
		'enableAjaxValidation' => false,
	));
?>
<div class="line pbl">
	<div class="unit size1of3" id="fileSelector-<?php echo $id?>">
				<span class="uploadButton btn btnN">Browse</span>
				<?php
				$this->widget('nii.widgets.uploadify.UploadifyWidget', array(
					'multi' => false,
					'ID' => 'attachmentUpload',
					'script' => Yii::app()->createAbsoluteUrl('nii/index/attachments/?action=uploadAttachment'),
					'onComplete' => 'js:function(event, queueID, fileObj, response, data){updateAttachmentID(response)}',
//					'auto' => false,
					'hideButton' => true,
					'wmode' => 'transparent',
					'width' => 64,
				));
				?>&nbsp;
	</div>
	<div class="unit size2of5">
		<div class="field inputInline">
			<div class="inputBox w350">
				<?php echo $form->labelEx($model, 'description', array('class'=>'inFieldLabel')) ?>
				<?php echo $form->textField($model, 'description'); ?>
			</div>
		</div>
	</div>
	<div class="lastUnit buttons submitButtons">
		<?php
		echo CHtml::link($this->t('Cancel'), '#', array('class' => 'attachmentCancel cancelLink', 'id' => 'attachmentCancel-'.$id));
		echo NHtml::btnLink($this->t('Add'), '#', 'icon fam-add', array('class' => 'btn btnN attachmentSave', 'id' => 'attachmentSave-'.$id, 'style' => 'padding: 3px 5px;'));
		?>	
	</div>
</div>
<?php 

echo $form->hiddenField($model, 'file_id');

$model->model = $classname;
$model->model_id = $id;
$model->type = $type;
echo $form->hiddenField($model,'model');
echo $form->hiddenField($model,'model_id');
echo $form->hiddenField($model,'type');

$this->endWidget(); ?>
<script>
	function updateAttachmentID(response) {
		var url = '<?php echo Yii::app()->createAbsoluteUrl('/nii/index/fileNameWithIcon/');?>?id='+response;
		$('#fileSelector-<?php echo $id?>').load(url);
		$('#Attachment_file_id').val(response);
	}
	
	$(function() {
		$('#newAttachmentForm-<?php echo $id?>').delegate('#attachmentSave-<?php echo $id?>','click',function(){
			var model_id = '<?php echo $id?>';
			var inputUrl = $('#attachmentInputUrl-'+model_id).val();
			$.ajax({
				url: inputUrl+'?action=saveAttachment',
				data: jQuery("#newAttachmentForm-<?php echo $id?>").serialize(),
				dataType: "json",
				type: "post",
				success: function(response){ 
					if (response.success) {
						reponseID = response.id
						$.fn.yiiListView.update(model_id+'_attachmentlist');
						$('#attachments-input-'+model_id).html('');
						setTimeout(function(response) {
							$('.line.attachment_'+reponseID).effect("highlight");
						}, 500 );
						return false;
					}
				},
				error: function(response) {
					alert ("JSON failed to return a valid response...");
				}
			}); 
		}); 
		
		$('#newAttachmentForm-<?php echo $id?>').delegate('#attachmentCancel-<?php echo $id?>','click',function(){
			$('#attachments-input-<?php echo $id?>').html('');
			return false;
		});
	});
</script>