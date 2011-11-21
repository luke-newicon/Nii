<div id="attendees-<?php echo $model->id?>">
	<h3>Attendees<?php echo NHtml::link('','#',
		array(
			'class'=>'icon fam-add',
			'style' => 'position: relative; height: 16px; line-height: 16px; display: inline-block; margin-left: 8px; top: 3px;',
			'id'=>'attendee_add-'.$model->id,
		)); ?></h3>
	<div class="attendee_input" id="attendee_input-<?php echo $model->id;?>"></div>
		<div class="items">
			<?php
			$this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$dataProvider,
				'itemView'=>'hft.views.event.view.tabs.attendees._attendee_item',
				'id'=>'attendee_list-'.$model->id,
				'emptyText'=>'<span class="noData">No attendees have been listed against this event</span>',
				'htmlOptions'=>array('class'=>'list-view attendee_list'),
				'summaryText'=>'',
				'viewData'=>array(),
			));
		?>
		</div>
		<script>
			$(function() {
				var model_id = '<?php echo $model->id ?>';
				var widgetID = '<?php echo 'attendees-'.$model->id?>';
				var inputUrl = '<?php echo NHtml::url(array('/hft/event/addAttendee','id'=>$model->id)); ?>';
				var deleteUrl = '<?php echo NHtml::url(array('/hft/event/deleteAttendee')); ?>';

				$('#'+widgetID).delegate('#attendee_add-'+model_id,'click',function(){
					$("#attendee_input-"+model_id).load(inputUrl);
					return false;
				});

				$('#'+widgetID).delegate('.attendee_list_delete_button','click',function(){
					relid = $(this).parent().parent().attr("data-attendee-id");
					if(confirm("Are you sure you want to delete this attendee?")){
						$.ajax({
							url: deleteUrl,
							type: "POST",
							dataType: "json",
							data: ({id:relid, modelid:model_id}),
							success: function(response){
								$.fn.yiiListView.update('attendee_list-'+model_id);
								$('.attendees_count').html(response.count);
								nii.showMessage('Attendee deleted');
							}
						});
					} else {
						return false;
					}
				});
			});
		</script>
</div>