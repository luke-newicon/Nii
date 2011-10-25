<?php


$dataProvider = new CArrayDataProvider($data);



$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'modules-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
			'name' => 'name',
			'header' => 'Name',
		),
		array(
			'name' => 'description',
			'header' => 'Description',
		),
		array(
			'name' => 'version',
			'header' => 'Version',
		),
		array(
			'name' => 'enabled',
			'type' => 'raw',
			'htmlOptions' => array('width'=>'100','align'=>'center'),
			'value' => 'CHtml::dropDownList("enabled[".$data["id"]."]",$data["enabled"], array("disabled","active"), array("class"=>"module-enabled","data-module"=>$data["id"]))',
		)
	),
));
?>

<script>
	jQuery(function($){
		$('.module-enabled').live('change',function(){
			var module = $(this).attr('data-module');
			var enabled = $(this).val();
			$.ajax({
				url: '<?php echo CHtml::normalizeUrl(array('/admin/index/moduleState')) ?>?moduleId='+module+'&enabled='+enabled,
				dataType: 'json',
				success: function(msg){
					if(msg.success){
						alert(msg.success);
						
//						$.fn.yiiGridView.update('modules-grid');
					}
				}
			});
		});
	});
</script>