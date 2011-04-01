<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user/permissions/index'),
	UserModule::t('Permissions')=>array('/user/permissions/index'),
	UserModule::t('Roles'),
);
?>

<?php echo CHtml::link('Create Role', '#', array('onclick' => '$("#addrole").dialog("open"); return false;','class'=>'btn btnN')); ?>
<h1><?php echo UserModule::t("Manage Roles"); ?></h1>

<?php
NHtml::popupForm('addrole', 'Create Role', '/user/permissions/createRoleForm', '380px', '$.fn.yiiGridView.update(\'authitemGrid\');');
?>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'authitemGrid',
	'dataProvider'=>$model->roles()->search(),
	'filter'=>$model->roles(),
	'columns'=>array(
		array(
			'name' => 'name',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->name),array("/user/permissions/role/","id"=>$data->name))',
		),
		'description',
	),
)); ?>


