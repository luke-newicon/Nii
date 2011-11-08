<form id="exportGridForm" method="post">
<?php
$url = array('grid/exportProcess/', 'model'=>$className, 'gridId'=>$gridId);
$model = new $className;
if ($model_id && $model_id != '')
	$url = array_merge ($url, array('model_id'=>$model_id));

if ($scope && $scope != '')
	$url = array_merge ($url, array('scope'=>$scope));
else if (isset($model->defaultScope))
	$url = array_merge ($url, array('scope'=>$model->defaultScope));

$columns = NData::exportColumns($className, $gridId);
foreach ($columns as $key=>$value) {
	
	echo '<div class="line">';
	echo CHtml::checkBox('field['.str_replace('.', '__', $key).']',$value, array('style'=>'margin-right: 8px;', 'uncheckValue'=>'0'));
	echo CHtml::label($model->getAttributeLabel($key), $key);
	echo '</div>';
	
} ?>
<div class="line ptm">
	<?php echo NHtml::btnLink($this->t('Export to CSV'), '#', 'icon fam-table-go', array('class' => 'btn btnN exportSave', 'data-id' => 'csv', 'style' => 'padding: 3px 5px;')); ?>
	<?php echo NHtml::btnLink($this->t('Export to Excel'), '#', 'icon fam-page-white-excel', array('class' => 'btn btnN exportSave', 'data-id' => 'excel', 'style' => 'padding: 3px 5px;')); ?>
	<?php echo NHtml::btnLink($this->t('Export to ODS'), '#', 'icon fam-page-white-odf', array('class' => 'btn btnN exportSave', 'data-id' => 'ods', 'style' => 'padding: 3px 5px;')); ?>
</div>
</form>
<script>
	$(function(){

		pageUrl = "<?php echo CHtml::normalizeUrl($url); ?>";

		$("#exportGridForm").delegate(".exportSave","click",function(){
			
			var filters = jQuery("#<?php echo $gridId?> tr.filters input, #<?php echo $gridId?>Grid tr.filters select").serialize();
			$.ajax({
				url: pageUrl+"/fileType/"+$(this).attr('data-id'),
				data: jQuery("#exportGridForm").serialize()+'&'+filters,
				dataType: "json",
				type: "post",
				success: function(response){ 
					if (response.success) {
						$("#exportGridDialog").dialog("close");
//						showMessage(response.success);
						window.location = "<?php echo CHtml::normalizeUrl(array('grid/exportDownload/'))?>?filename="+response.filename;
					} else {
						showMessage(response.error,{className:'error'});
					}
				},
				error: function() {
					alert ("JSON failed to return a valid response");
				}
			}); 
			return false;
		}); 

	});

</script>