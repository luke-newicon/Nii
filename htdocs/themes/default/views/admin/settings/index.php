<?php
	$this->widget('ext.bootstrap.widgets.menu.BootTabs',array(
		'id' => 'SettingsTabs',
		'items' => $settings['items'],
		'heading' => 'Settings',
	));
?>
<div class="tab-content">
	<?php foreach($settings['pages'] as $page) : ?>
	<div<?php echo CHtml::renderAttributes($page['htmlOptions']) ?>>
		<h3><?php echo $page['htmlOptions']['id'] ?> Settings</h3>
		<?php echo $page['htmlOptions']['data-ajax-url'] ?>
	</div>
	<?php endforeach ?>
</div>
<script>
	jQuery(function($){
		$('#SettingsTabs').tabs();
	});
</script>