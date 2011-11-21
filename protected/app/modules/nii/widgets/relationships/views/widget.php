<div id="relationships-<?php echo $id;?>" class="relationship_widget" data-model-id="<?php echo $id;?>">
	<?php if ($displayTitle) :
		echo '<'.$titleWrapperTag.' class="'.$titleClass.'">'.$title.$addButton.'</'.$titleWrapperTag.'>';
	else :
		echo $addButton;
	endif; ?>
	<div class="relationships_input" id="relationships-input-<?php echo $id;?>"></div>
	<div>
		<?php
			$this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$dataProvider,
				'itemView'=>'_item',
				'id'=>$id.'_relationshiplist',
				'emptyText'=>$emptyText,
				'htmlOptions'=>array('class'=>'list-view relationships-list'),
				'summaryText'=>'',
				'viewData'=>array(
					'canDelete'=>$canDelete,
				)
			));
		?>
	</div>
</div>
<input type="hidden" id="relationshipInputUrl-<?php echo $id ?>" value="<?php echo $ajaxLocation ?>" />
<script>
	$(function() {
		var model_id = '<?php echo $id ?>';
		var model = '<?php echo $model_name?>';
		var widgetID = '<?php echo 'relationships-'.$id?>';
		var inputUrl = $('#relationshipInputUrl-'+model_id).val();
		
		$('#'+widgetID).delegate('#relationships-add-'+model_id,'click',function(){
			$("#relationships-input-"+model_id).load(inputUrl+'?action=displayNew&model='+model+'&model_id='+model_id);
			return false;
		});
		
		$('#'+widgetID).delegate('.relationship_delete_button','click',function(){
			relid = $(this).parent().parent().attr("data-relationship-id");
			if(confirm("Are you sure you want to delete this relationship?")){
				$.ajax({
					url: inputUrl,
					type: "POST",
					data: ({id:relid,action:'delete'}),
					success: function(){
						$.fn.yiiListView.update(model_id+'_relationshiplist');
						nii.showMessage('Relationship deleted');
						return false;
					}
				});
			} else {
				return false;
			}
		});
	});
</script>