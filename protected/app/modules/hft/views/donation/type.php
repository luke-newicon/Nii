<?php $this->pageTitle = Yii::app()->name . ' - Donation Types'; ?>
<div class="page-header">
	<h2>Donation Types</h2>
	<div class="action-buttons">
		<a id="add-type" class="btn primary">Add a Donation Type</a>
	</div>
</div>
<?php
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'dataProvider' => $dataProvider,
	'filter' => $model,
	'id' => 'DonationTypeAllGrid',
//	'scopes' => array(
//		'items' => array(
//			'default' => array(
//				'label'=>'All',
//			),
//		),
//	),
	
	//'ajaxUpdate' => '#ContactAllGrid_c3',
	'enableButtons'=>true,
	'enableCustomScopes'=>false,
//	'columns'=>$model->columns(Setting::visibleColumns('Contact')),
));
?>
<div id="addTypeDialog" class="" title="New Donation Type" style="display:none;">
	<form>
		<div class="field stacked	">
			<div class="inputContainer">
				<label for="typeName" class="inFieldLabel" style="font-size:16px;" >Donation Type Name</label>
				<div class="input">
					<input style="font-size:16px;" type="text" id="typeName" name="typeName">
				</div>
			</div>
			
		</div>
	</form>
</div>
<div id="editTypeDialog" class="" title="Edit Donation Type" style="display:none;">
	<form>
		<div class="field stacked	">
			<div class="inputContainer">
				<div class="input">
					<input style="font-size:16px;" type="text" id="editTypeName" name="editTypeName">
				</div>
			</div>
			
		</div>
	</form>
</div>
<script>
	jQuery(function($){
		$.fn.nii.form();
		$('#add-type').click(function(){
			$('#addTypeDialog').dialog({
				modal:true,
				width:'400',
				buttons:[
					{
						text:'Create Donation Type',
						class:'btn primary',
						click:function(){
							$.post('<?php echo NHtml::url('hft/donation/createType'); ?>', {HftDonationType:{name:$('#typeName').val()}}, function(){
								$.fn.yiiGridView.update('DonationTypeAllGrid');
								$('#addTypeDialog').dialog('close');
								$('#typeName').val('');
								$('#typeName').blur()
							})
						}
					},
					{
						text:'Cancel',
						class:'btn',
						click:function(){
							$('#addTypeDialog').dialog('close');
						}
					}
				]
			});
		});
		
		$('.edit-type').click(function(){
			var typeId = $(this).data('model-id');
			$('#editTypeName').val($(this).data('name'));
			$('#editTypeDialog').dialog({
				modal:true,
				width:'400',
				buttons:[
					{
						text:'Update',
						class:'btn primary',
						click:function(){
							$.post('<?php echo NHtml::url('hft/donation/updateType'); ?>/id/'+typeId, {HftDonationType:{name:$('#editTypeName').val()}}, function(){
								$.fn.yiiGridView.update('DonationTypeAllGrid');
								$('#editTypeDialog').dialog('close');
								$('#editTypeName').val('');
								$('#editTypeName').blur()
							})
						}
					},
					{
						text:'Cancel',
						class:'btn',
						click:function(){
							$('#editTypeDialog').dialog('close');
						}
					}
				]
			});
		});
		
	});
</script>