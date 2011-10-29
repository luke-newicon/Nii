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
		$('#UserTabs').tabs();
		$('#UserTabs a').click(function(){
			var $tab = $($(this).attr('href'));
			var ajaxUrl = $tab.attr('data-ajax-url');
			if(ajaxUrl){
				$tab.load(ajaxUrl, function(response, status, xhr) {
					if (status == "error") {
						var msg = "Sorry but there was an error loading this tab: ";
						$tab.html(msg + xhr.status + " " + xhr.statusText);
					}
				});
			}
		});
	});
</script>