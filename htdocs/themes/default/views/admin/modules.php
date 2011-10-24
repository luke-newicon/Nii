<?php


$modules = Yii::app()->niiModulesAll;

foreach($modules as $id => $module){
	$data[] = array(
		'id' => $id,
		'name'=>$module->name,
		'description' => $module->description,
		'version' => $module->version,
		'state' => true,
	);
}

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
			'name' => 'state',
			'type' => 'raw',
			'htmlOptions' => array('width'=>'100','align'=>'center'),
			'value' => 'CHtml::dropDownList("state[".$data["id"]."]",$data["state"], array("disabled","active","reinstall"), array("class"=>"module-state","data-module"=>$data["id"]))',
		),
	),
));
?>

<script>
	jQuery(function($){
		$('.module-state').live('change',function(){
			var module = $(this).attr('data-module');
			var state = $(this).val();
			$.ajax({
				url: '<?php echo CHtml::normalizeUrl(array('/admin/moduleState')) ?>?module='+module+'&state='+state,
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