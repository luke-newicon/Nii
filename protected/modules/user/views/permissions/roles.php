<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user/admin/index'),
	UserModule::t('Roles'),
);
?>
<h1><?php echo UserModule::t("Manage Roles"); ?></h1>

<?php if(UserModule::isAdmin()) {
	?><ul class="actions">
	<li><?php echo CHtml::link(UserModule::t('Manage Users'),array('/user/admin/index')); ?></li>
</ul><!-- actions --><?php
} ?>

<?php echo CHtml::link('Create Role', '#', array('onclick' => '$("#addrole").dialog("open"); return false;','class'=>'btn btnN')); ?>

<?php
NHtml::popupForm('addrole', 'Create Role', '/user/permissions/getRoleForm', '500px',"js:function() {
	var perms = {};
	jQuery('#permissions').jstree('get_checked').each(function(i,el){
		perms[i] = $(el).attr('id');
	});
	var data = {
		'roleData':$('#addrole form').serialize(),
		'perms':perms
	}
	$.post('".NHtml::url('/user/permissions/saveRole')."', $.param(data), function(r){
		if(r){
			// added role
			$('#addrole').dialog('close');
			$('#addrole .content').html('Loading...');
			$.fn.yiiGridView.update('authitemGrid');
		}
	});
}");
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


