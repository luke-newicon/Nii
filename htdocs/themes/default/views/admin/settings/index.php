<?php //Yii::app()->bootstrap->registerScriptFile('bootstrap-tabs.js'); ?>
<?php
$this->widget('nii.widgets.NTabs', 
	array(
		'id' => 'SettingsTabs',
		'tabs' => $settings,
		'htmlOptions' => array(
			'class' => 'vertical',
		)
	)
);
?>

<?php
//	$this->widget('ext.bootstrap.widgets.menu.BootTabs',array(
//		'id' => 'SettingsTabs',
//		'items' => $settings['items'],
//		'heading' => 'Settings',
//		'htmlOptions' => array('class' => 'tabs vertical'),
//	));
?>
<!--<div class="tab-content vertical">
	<?php //foreach($settings['pages'] as $page) : ?>
	<div<?php //echo CHtml::renderAttributes($page['htmlOptions']) ?>>
		Loading...
	</div>
	<?php //endforeach ?>
</div>-->
<!--<script>
	jQuery(function($){
		var loadPage = function($page){
			$page.load($page.attr('data-ajax-url'));
		}
		
		$('#SettingsTabs a').click(function(){
			loadPage($($(this).attr('href')));
		});
		
		$('#SettingsTabs').tabs();
		
		loadPage($('.tab-content .active'));
	});
</script>-->