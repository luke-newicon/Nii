<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user/admin/index'),
	UserModule::t('Permissions'),
);
?>

<ul>
	<li><a href="<?php echo NHtml::url('/user/permissions/roles'); ?>">Roles</a></li>
</ul>