<?php
$form = $this->beginWidget('NActiveForm', array(
		'id' => 'newAttendeeForm-'.$id,
		'enableAjaxValidation' => false,
	));
?>
<div class="line pbl">
	<div class="unit">
		<div class="field inputInline">
			<?php echo $form->labelEx($model, 'contact_id'); ?>
			<div class="input w200">
				<?php
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'name' => 'HftEventAttendee[attendee_name]',
						'source' => $this->createUrl('/contact/autocomplete/contactList'),
						// additional javascript options for the autocomplete plugin
						'options' => array(
							'showAnim' => 'fold',
							'select' => 'js:function(event, ui) {
									$("#HftEventAttendee_contact_id").val(ui.item.id);
							}'
						),
					));
					echo $form->hiddenField($model, 'contact_id');
				?>
			</div>
		</div>
	</div>
	<div class="unit">
		<div class="field inputInline">
			<?php echo $form->labelEx($model, 'additional_attendees') ?>
			<div class="input w60">
				<?php echo $form->textField($model, 'additional_attendees'); ?>
			</div>
		</div>
	</div>
	<div class="lastUnit buttons" style="padding-top:20px;">
		<?php
		echo CHtml::link($this->t('Cancel'), '#', array('class' => 'attendeeCancel cancelLink btn', 'id' => 'attendeeCancel-'.$id));
		echo NHtml::btnLink($this->t('Add'), '#', 'icon fam-add', array('class' => 'btn primary attendeeSave', 'id' => 'attendeeSave-'.$id, 'style' => 'margin-left: 5px; padding-left: 7px;'));
		?>	
	</div>
</div>
<?php 

$model->event_id = $id;
echo $form->hiddenField($model,'event_id');

$this->endWidget(); ?>
<script>
	$(function() {
		$('#newAttendeeForm-<?php echo $id?>').delegate('#attendeeSave-<?php echo $id?>','click',function(){
			var model_id = '<?php echo $id?>';
			var inputUrl = '<?php echo NHtml::url(array('/hft/event/addAttendee','id'=>$id)); ?>';
			$.ajax({
				url: inputUrl,
				data: jQuery("#newAttendeeForm-<?php echo $id?>").serialize(),
				dataType: "json",
				type: "post",
				success: function(response){ 
					if (response.success) {
						reponseID = response.id
						$.fn.yiiListView.update('attendee_list-'+model_id);
						$('#attendee_input-'+model_id).html('');
						$('.attendees_count').html(response.count);
						setTimeout(function(response) {
							$('.line.attendee_'+reponseID).effect("highlight");
						}, 500 );
						return false;
					}
				},
				error: function(response) {
					alert ("JSON failed to return a valid response...");
				}
			}); 
		}); 
		
		$('#newAttendeeForm-<?php echo $id?>').delegate('#attendeeCancel-<?php echo $id?>','click',function(){
			$('#attendee_input-<?php echo $id?>').html('');
			return false;
		});
	});
</script>