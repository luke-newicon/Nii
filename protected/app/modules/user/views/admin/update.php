<?php
$this->breadcrumbs=array(
	(UserModule::t('Users'))=>array('/user/admin/index'),
	$model->username=>array('view','id'=>$model->id),
	(UserModule::t('Update')),
);
?>

<h1><?php echo  UserModule::t('Update User')." ".$model->id; ?></h1>

<?php echo $this->renderPartial('_menu', array(
		'list'=> array(
			CHtml::link(UserModule::t('Create User'),array('create')),
			CHtml::link(UserModule::t('View User'),array('view','id'=>$model->id)),
		),
	)); 

	echo $this->renderPartial('_form', array('model'=>$model)); ?>