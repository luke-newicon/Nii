<?php
$form = $this->beginWidget('NActiveForm', array(
		'id' => 'newRelationshipForm-'.$id,
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
						'name' => 'relatedName',
						'source' => $this->createUrl('/autocomplete/contactList'),
						// additional javascript options for the autocomplete plugin
						'options' => array(
							'showAnim' => 'fold',
							'select' => 'js:function(event, ui) {
									$("#NRelationship_contact_id").val(ui.item.id);
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
			<?php echo $form->labelEx($model, 'label') ?>
			<div class="input w200">
				<?php echo $form->textField($model, 'label'); ?>
			</div>
		</div>
	</div>
	<div class="lastUnit buttons" style="padding-top:20px;">
		<?php
		echo CHtml::link($this->t('Cancel'), '#', array('class' => 'relationshipCancel cancelLink btn', 'id' => 'relationshipCancel-'.$id));
		echo NHtml::btnLink($this->t('Add'), '#', 'icon fam-add', array('class' => 'btn primary relationshipSave', 'id' => 'relationshipSave-'.$id, 'style' => 'margin-left: 5px; padding-left: 7px;'));
		?>	
	</div>
</div>
<?php 

$model->model = $classname;
$model->model_id = $id;
echo $form->hiddenField($model,'model');
echo $form->hiddenField($model,'model_id');

$this->endWidget(); ?>
<script>
	$(function() {
		$('#newRelationshipForm-<?php echo $id?>').delegate('#relationshipSave-<?php echo $id?>','click',function(){
			var model_id = '<?php echo $id?>';
			var inputUrl = $('#relationshipInputUrl-'+model_id).val();
			$.ajax({
				url: inputUrl+'?action=save',
				data: jQuery("#newRelationshipForm-<?php echo $id?>").serialize(),
				dataType: "json",
				type: "post",
				success: function(response){ 
					if (response.success) {
						reponseID = response.id
						$.fn.yiiListView.update(model_id+'_relationshiplist');
						$('#relationships-input-'+model_id).html('');
						setTimeout(function(response) {
							$('.line.relationship_'+reponseID).effect("highlight");
						}, 500 );
						return false;
					}
				},
				error: function(response) {
					alert ("JSON failed to return a valid response...");
				}
			}); 
		}); 
		
		$('#newRelationshipForm-<?php echo $id?>').delegate('#relationshipCancel-<?php echo $id?>','click',function(){
			$('#relationships-input-<?php echo $id?>').html('');
			return false;
		});
	});
</script>