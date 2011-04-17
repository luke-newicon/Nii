<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
	'id'=>'userpoptabs',
	'tabs'=>array(
		'User'=>$this->renderPartial('_form', array('model'=>$model), true, true),
		'Permissions'=>'permissions',
	),
	// additional javascript options for the tabs plugin
	'options'=>array(
		'collapsible'=>false,
		'create'=>'js:function(){}',
	),
	'htmlOptions'=>array('class'=>'solid rounded')
));
?>
<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user/admin/index'),
	UserModule::t('Create'),
);
?>
<h1><?php echo UserModule::t("Add User"); ?></h1>

<?php //echo $this->renderPartial('_form', array('model'=>$model)); ?>