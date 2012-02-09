<div class="page-header">
	<h1>Modules</h1>
</div>
<?php
$dataProvider = new CArrayDataProvider($data, array(
			'pagination'=>array(
				'pageSize'=>20,
            ),
	));

$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'id' => 'modules-grid',
	'dataProvider' => $dataProvider,
	'columns' => array(
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
			'header' => 'Enabled',
			'type' => 'raw',
			'htmlOptions' => array('width' => '100', 'align' => 'center'),
			'value' => '($data["enabled"]) ? CHtml::link("Disable", array("/admin/modules/disable","module"=>$data["id"]), array("class"=>"btn btn-danger disable")) : CHtml::link("Enable", array("/admin/modules/enable","module"=>$data["id"]), array("class"=>"btn btn-success enable"))',
		),
	),
));
?>
<script>
	jQuery(function($){
		$('.btn.enable,.btn.disable').live('click',function(){
			if($(this).is('.enable'))
				$(this).html('Enabling').addClass('disabled');
			else
				$(this).html('Disabling').addClass('disabled');
		});
	});
</script>