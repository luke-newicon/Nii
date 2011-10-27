<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user/admin/index'),
	$model->username,
);
?>
<h1><?php echo UserModule::t('View User').' "'.$model->username.'"'; ?></h1>


<?php echo CHtml::link('Impersonate '.$model->username,array('/user/admin/impersonate', 'id'=>$model->id),array('class'=>'btn btnN')); ?>

<?php echo $this->renderPartial('_menu', array(
		'list'=> array(
			CHtml::link(UserModule::t('Create User'),array('create')),
			CHtml::link(UserModule::t('Update User'),array('update','id'=>$model->id)),
			CHtml::link(UserModule::t('Update Roles'),array('roles','id'=>$model->id)),
			CHtml::link(UserModule::t('Change Password'),array('changePassword','id'=>$model->id)),
			CHtml::linkButton(UserModule::t('Delete User'),array('submit'=>array('delete','id'=>$model->id),'confirm'=>UserModule::t('Are you sure to delete this item?'))),
		),
	)); 


	$attributes = array(
		'id',
		'username',
	);
	
	array_push($attributes,
		'password',
		'email',
		'activekey',
		array(
			'name' => 'createtime',
			'value' => date("d.m.Y H:i:s",$model->createtime),
		),
		array(
			'name' => 'lastvisit',
			'value' => (($model->lastvisit)?date("d.m.Y H:i:s",$model->lastvisit):UserModule::t("Not visited")),
		),
		array(
			'name' => 'superuser',
			'value' => User::itemAlias("AdminStatus",$model->superuser),
		),
		array(
			'name' => 'status',
			'value' => User::itemAlias("UserStatus",$model->status),
		)
	);
	
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>$attributes,
	));
	

?>
