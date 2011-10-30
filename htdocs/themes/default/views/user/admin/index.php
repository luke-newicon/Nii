<?php
$this->widget('ext.bootstrap.widgets.menu.BootTabs',array(
	'id' => 'UserTabs',
	'items' => array(
		array('label'=>'Users', 'url'=>'#users', 'active' => true),
		array('label'=>'Roles', 'url'=>'#roles'),
	),
	'heading' => 'Permissions',
));
?>
<div class="tab-content">
	<div id="users" class="active" data-ajax-url="<?php echo CHtml::normalizeUrl(array('/user/admin/users')) ?>"></div>
	<div id="roles" data-ajax-url="<?php echo CHtml::normalizeUrl(array('/user/admin/roles')) ?>"></div>
</div>
<script>
	jQuery(function($){
		// Add the tabbing functionality
		$('#UserTabs').tabs();
		// Function for loading tab content by ajax
		var loadTab = function($tab){
			var ajaxUrl = $tab.attr('data-ajax-url');
			if(ajaxUrl){
				$tab.load(ajaxUrl, function(response, status, xhr) {
					if (status == "error") {
						var msg = "Sorry but there was an error loading this tab: ";
						$tab.html(msg + xhr.status + " " + xhr.statusText);
					}
				});
			}
		}
		// Load the tab when clicked
		$('#UserTabs a').click(function(){
			loadTab($($(this).attr('href')));
		});
		// Load any active tabs
		loadTab($('.tab-content .active'));
	});
</script>