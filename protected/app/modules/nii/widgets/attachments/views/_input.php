<?php
$form = $this->beginWidget('NActiveForm', array(
		'id' => 'newAttachmentForm-'.$id,
		'enableAjaxValidation' => false,
	));
?>
<div class="line pbl">
	<div class="unit size1of4" id="fileSelector-<?php echo $id?>">
				<span class="uploadButton btn primary">Browse</span>
				<?php
				$this->widget('nii.widgets.uploadify.UploadifyWidget', array(
					'multi' => false,
					'ID' => 'attachmentUpload',
					'script' => Yii::app()->createAbsoluteUrl('nii/index/attachments/?action=uploadAttachment'),
					'onComplete' => 'js:function(event, queueID, fileObj, response, data){updateAttachmentID(response)}',
//					'auto' => false,
					'hideButton' => true,
					'wmode' => 'transparent',
					'width' => 74,
				));
				?>&nbsp;
	</div>
	<div class="unit size2of5">
		<div class="field inputInline">
			<div class="input w250">
				<?php echo $form->labelEx($model, 'description', array('class'=>'inFieldLabel')) ?>
				<?php echo $form->textField($model, 'description'); ?>
			</div>
		</div>
	</div>
	<div class="lastUnit buttons submitButtons">
		<?php
		echo CHtml::link($this->t('Cancel'), '#', array('class' => 'attachmentCancel btn', 'id' => 'attachmentCancel-'.$id));
		echo '&nbsp;';
		echo NHtml::btnLink($this->t('Add'), '#', 'icon fam-add', array('class' => 'btn primary attachmentSave', 'id' => 'attachmentSave-'.$id, 'style' => 'padding-left: 7px;'));
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
		$('#NAttachment_file_id').val(response);
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
						$('.attachments_count').html(response.count);
						if (response.count > 0) {
							$('.attachments_count').addClass('notice');
						} else {
							$('.attachments_count').removeClass('notice');
						}
						setTimeout(function(response) {
							$('.line.attachment_'+reponseID).effect("highlight");
						}, 500 );
					}
				},
				error: function(response) {
					alert ("JSON failed to return a valid response...");
				}
			});
			return false;
		}); 
		
		$('#newAttachmentForm-<?php echo $id?>').delegate('#attachmentCancel-<?php echo $id?>','click',function(){
			$('#attachments-input-<?php echo $id?>').html('');
			return false;
		});
	});
</script>