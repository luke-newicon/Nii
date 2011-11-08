<form id="gridSettingsForm" method="post">
<?php
$className = get_class($model);
$columns = NData::visibleColumns($className, $gridId);
foreach ($columns as $key=>$value) {
	
	echo '<div class="line">';
	echo CHtml::checkBox($key,$value, array('style'=>'margin-right: 8px;', 'uncheckValue'=>'0'));
	echo CHtml::label($model->getAttributeLabel($key), $key);
	echo '</div>';
	
} ?>
<div class="line ptm">
	<?php echo NHtml::btnLink($this->t('Save'), '#', 'icon fam-tick', array('class' => 'btn btnN gridSettingsSave', 'id' => 'gridSettingsSave', 'style' => 'padding: 3px 5px;')); ?>
</div>
</form>
<script>
	$(function(){

		pageUrl = "<?php echo CHtml::normalizeUrl(array('grid/updateGridSettings/', 'key'=>$gridId)); ?>";

		$("#gridSettingsForm").delegate(".gridSettingsSave","click",function(){
			$.ajax({
				url: pageUrl,
				data: jQuery("#gridSettingsForm").serialize(),
				dataType: "json",
				type: "post",
				success: function(response){ 
					if (response.success) {
						$("#gridSettingsDialog").dialog("close");
						$.fn.yiiGridView.update("<?php echo $gridId; ?>");
						showMessage(response.success);
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