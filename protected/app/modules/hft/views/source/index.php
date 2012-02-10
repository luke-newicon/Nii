<?php $this->pageTitle = Yii::app()->name . ' - Sources'; ?>
<div class="page-header">
	<h2>Sources</h2>
	<div class="action-buttons">
		<a id="add-source" class="btn primary">Add a Source</a>
	</div>
</div>
<?php
$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'dataProvider' => $dataProvider,
	'filter' => $model,
	'id' => 'SourceAllGrid',
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
<div id="addSourceDialog" class="" title="New Source" style="display:none;">
	<form>
		<div class="field stacked	">
			<div class="inputContainer">
				<label for="sourceName" class="inFieldLabel" style="font-size:16px;" >Source Name</label>
				<div class="input">
					<input style="font-size:16px;" type="text" id="sourceName" name="sourceName">
				</div>
			</div>
			
		</div>
	</form>
</div>
<div id="editSourceDialog" class="" title="Edit Source" style="display:none;">
	<form>
		<div class="field stacked	">
			<div class="inputContainer">
				<div class="input">
					<input style="font-size:16px;" type="text" id="editSourceName" name="editSourceName">
				</div>
			</div>
			
		</div>
	</form>
</div>
<script>
	jQuery(function($){
		$.fn.nii.form();
		$('#add-source').click(function(){
			$('#addSourceDialog').dialog({
				modal:true,
				width:'400',
				buttons:[
					{
						text:'Create Source',
						class:'btn primary',
						click:function(){
							$.post('<?php echo NHtml::url('hft/source/create'); ?>', {HftContactSource:{name:$('#sourceName').val()}}, function(){
								$.fn.yiiGridView.update('SourceAllGrid');
								$('#addSourceDialog').dialog('close');
								$('#sourceName').val('');
								$('#sourceName').blur()
							})
						}
					},
					{
						text:'Cancel',
						class:'btn',
						click:function(){
							$('#addSourceDialog').dialog('close');
						}
					}
				]
			});
		});
		
		$('.edit-source').click(function(){
			var sourceId = $(this).data('model-id');
			$('#editSourceName').val($(this).data('name'));
			$('#editSourceDialog').dialog({
				modal:true,
				width:'400',
				buttons:[
					{
						text:'Update',
						class:'btn primary',
						click:function(){
							$.post('<?php echo NHtml::url('hft/source/update'); ?>/id/'+sourceId, {HftContactSource:{name:$('#editSourceName').val()}}, function(){
								$.fn.yiiGridView.update('SourceAllGrid');
								$('#editSourceDialog').dialog('close');
								$('#editSourceName').val('');
								$('#editSourceName').blur()
							})
						}
					},
					{
						text:'Cancel',
						class:'btn',
						click:function(){
							$('#editSourceDialog').dialog('close');
						}
					}
				]
			});
		});
		
	});
</script>