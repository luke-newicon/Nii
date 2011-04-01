<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user/permissions/index'),
	UserModule::t('Permissions')=>array('/user/permissions/index'),
	UserModule::t('Roles')=>array('/user/permissions/roles'),
	UserModule::t('Role ' . $role->name)
);
?>
<h1>Role: <?php echo $role->name; ?></h1>
<p><?php echo $role->description; ?></p>
<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
	'tabs'=>array(
		'Permissions'=>$this->renderPartial('_permission-tree', array('permissions'=>$permissions), true),
		'Users'=>array('content'=>'Users in this role', 'id'=>'tab2'),
	),
	// additional javascript options for the tabs plugin
	'options'=>array(
		'collapsible'=>true,
	),
	'htmlOptions'=>array('class'=>'solid rounded')
));
?>


