<h3>Modules</h3>
<?php if (Yii::app()->user->hasFlash('success')) : ?>
<div class="alert-message success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>

<?php
$dataProvider = new CArrayDataProvider($data);

$this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
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
			'value' => '($data["enabled"]) ? CHtml::link("Disable", array("/admin/modules/disable","module"=>$data["id"]), array("class"=>"btn aristo disable")) : CHtml::link("Enable", array("/admin/modules/enable","module"=>$data["id"]), array("class"=>"btn aristo primary enable"))',
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