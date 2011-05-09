<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user/admin/index'),
	UserModule::t('Create'),
);
?>
<h1><?php echo UserModule::t("Add User"); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>