<?php
$this->widget('ext.bootstrap.widgets.menu.BootTabs',array(
	'id' => 'DeveloperTabs',
	'items' => array(
		array('label'=>'Cache', 'url'=>'#cache', 'active' => true),
		array('label'=>'Bootstrap', 'url'=>'#bootstrap'),
		array('label'=>'Oocss', 'url'=>'#oocss'),
	),
	'heading' => 'Developer Tools',
));
?>
<div class="tab-content">
	<div id="cache" class="active">
		<a class="btn danger" href="<?php echo CHtml::normalizeUrl(array('/dev/admin/flush-assets')) ?>">Flush Assets Folder</a>
		<a class="btn danger" href="<?php echo CHtml::normalizeUrl(array('/dev/admin/flushCache')) ?>">Flush Cache (includes schema)</a>
		<a class="btn danger" href="<?php echo CHtml::normalizeUrl(array('/dev/admin/flush-runtime')) ?>">Flush Runtime Folder</a>
	</div>
	<div id="bootstrap">
		<a class="btn danger" href="<?php echo CHtml::normalizeUrl(array('/dev/admin/bootstrap')) ?>" target="_blank">Launch Bootstrap Site</a>
	</div>
	<div id="oocss">
		<a class="btn danger" href="<?php echo CHtml::normalizeUrl(array('/dev/index/oocss')) ?>" target="_blank">Launch Nii Oocss Site</a>
	</div>
</div>
<script>
	jQuery(function($){
		$('#DeveloperTabs').tabs();
	});
</script>
