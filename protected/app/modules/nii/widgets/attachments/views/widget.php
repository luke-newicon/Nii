<div id="attachments-<?php echo $id;?>" class="attachment_widget" data-model-id="<?php echo $id;?>">
	<?php if ($displayTitle) :
		echo '<'.$titleWrapperTag.' class="'.$titleClass.'">'.$title.$addButton.'</'.$titleWrapperTag.'>';
	else :
		echo $addButton;
	endif; ?>
	<div class="attachments_input" id="attachments-input-<?php echo $id;?>"></div>
	<div>
		<?php
			$this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$dataProvider,
				'itemView'=>'_item',
				'id'=>$id.'_attachmentlist',
				'afterAjaxUpdate'=>'function(){$("#'.$id.'_notelist").NAttachments("highlightNote");}',
				'emptyText'=>$emptyText,
				'htmlOptions'=>array('class'=>'list-view attachments-list'),
				'summaryText'=>'',
				'viewData'=>array(
					'canDelete'=>$canDelete,
				)
			));
		?>
	</div>
</div>
<input type="hidden" id="attachmentInputUrl-<?php echo $id ?>" value="<?php echo $ajaxLocation ?>" />
<script>
	$(function() {
		var model_id = '<?php echo $id ?>';
		var model = '<?php echo $model_name?>';
		var widgetID = '<?php echo 'attachments-'.$id?>';
		var inputUrl = $('#attachmentInputUrl-'+model_id).val();
		var type = '<?php echo $type ?>';
		
		$('#'+widgetID).delegate('#attachments-add-'+model_id,'click',function(){
			$("#attachments-input-"+model_id).load(inputUrl+'?action=displayNew&model='+model+'&model_id='+model_id+'&type='+type);
			return false;
		});
		
		$('#'+widgetID).delegate('.attachment_delete_button','click',function(){
			attid = $(this).parent().parent().attr("data-attachment-id");
			if(confirm("Are you sure you want to delete this attachment?")){
				$.ajax({
					url: inputUrl,
					type: "POST",
					data: ({id:attid,action:'deleteAttachment'}),
					success: function(){
						$.fn.yiiListView.update(model_id+'_attachmentlist');
						showMessage('Attachment deleted');
					}
				});
			} else {
				return false;
			}
		});
	});
</script>