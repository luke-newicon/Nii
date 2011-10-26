<h3>Settings</h3>
<?php
$this->widget('ext.bootstrap.widgets.menu.BootTabs',array(
	'id' => 'SettingsTabs',
	'items' => $settings['items'],
));
?>
<div class="tab-content">
	<?php foreach($settings['pages'] as $page) : ?>
	<div id="<?php echo $page['id'] ?>" data-ajax-url="<?php echo CHtml::normalizeUrl($page['data-ajax-url']) ?>">
		<?php echo CHtml::normalizeUrl($page['data-ajax-url']) ?>
	</div>
	<?php endforeach ?>
</div>
<script>
	jQuery(function($){
		$('#SettingsTabs').tabs();
	});
</script>