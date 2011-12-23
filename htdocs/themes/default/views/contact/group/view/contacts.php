<div class="page-header">
	<h3>Members</h3>
	<div class="action-buttons">
		<?php //echo NHtml::link('Add a Contact', array('addContact'), array('class'=>'btn primary')); ?>
<!--		<a class="btn primary" data-controls-modal="modal-contact-add" data-backdrop="static">Add a Contact</a>-->
	</div>
</div>
<?php
$form = $this->beginWidget('NActiveForm', array(
		'id' => 'newMemberForm',
		'enableAjaxValidation' => false,
	));
?>
<div class="line pbs">
	<div class="unit">
		<div class="field inputInline">
			<?php echo NHtml::label('Add a new member...', false, array('class'=>'lbl')); ?>
			<div class="input w300">
				<?php
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'name' => 'member_contact_id',
						'source' => $this->createUrl('/contact/autocomplete/contactList',array('withEmail'=>true)),
						// additional javascript options for the autocomplete plugin
						'options' => array(
							'showAnim' => 'fold',
							'select' => 'js:function(event, ui) {
									$("#ContactGroupContactMembers_contact_id").val(ui.item.id);
							}'
						),
					));
					echo $form->hiddenField($model, 'contact_id');
				?>
			</div>
		</div>
	</div>
	<div class="lastUnit buttons" style="padding-top:20px;">
		<?php
		echo NHtml::btnLink($this->t('Add'), '#', 'icon fam-add', array('class' => 'btn primary memberSave', 'id' => 'memberSave', 'style' => 'margin-left: 5px; padding-left: 7px;'));
		?>	
	</div>
</div>
<?php 
$model->group_id = $model->groupId;
echo $form->hiddenField($model,'group_id');

$this->endWidget(); ?>
<script>
	$(function() {
		$('#newMemberForm').delegate('#memberSave','click',function(){
			var inputUrl = '<?php echo NHtml::url(array('/contact/group/addMember','groupId'=>$model->groupId)); ?>';
			$.ajax({
				url: inputUrl,
				data: jQuery("#newMemberForm").serialize(),
				dataType: "json",
				type: "post",
				success: function(response){ 
					if (response.success) {
//						reponseID = response.id
						$.fn.yiiGridView.update('ContactGroupContactsGrid');
						$('#member_contact_id').val('');
						$('#ContactGroupContactMembers_contact_id').val('');
						$('.members_count').html(response.count);
						$('#totalMembersCount').html(response.countTotal);
						if (response.count > 0) {
							$('.members_count').addClass('notice');
						} else {
							$('.members_count').removeClass('notice');
						}
					}
					return false;
				},
				error: function(response) {
					alert ("JSON failed to return a valid response...");
				}
			}); 
		}); 
		

	});
</script>
<?php
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'dataProvider' => $dataProvider,
	'filter' => $model,
	'id' => 'ContactGroupContactsGrid',
	'enableButtons'=>true,
	'enableCustomScopes'=>false,
)); ?>