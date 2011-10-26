<?php
$this->widget('ext.bootstrap.widgets.menu.BootTabs',array(
	'id' => 'UserTabs',
	'items' => array(
		array('label'=>'Users', 'url'=>'#users', 'active' => true),
		array('label'=>'Roles', 'url'=>'#roles'),
	)
));
?>
<div class="tab-content">
	<div id="users" class="active">
		<?php $this->renderPartial('_users',array('model'=>$model,'dataProvider'=>$dataProvider)) ?>
	</div>
	<div id="roles">
		<?php $this->renderPartial('_roles') ?>
	</div>
</div>
<script>
	jQuery(function($){
		$('#UserTabs').tabs();
	});
</script>