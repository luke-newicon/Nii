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

<?php echo CHtml::link('Create Role', '#', array('onclick' => '$("#rolepop").dialog("open"); $("#rolepop .content").html("Loading..."); $("#rolepop .content").load("'.NHtml::url('/user/permissions/getRoleForm').'"); return false;','class'=>'btn btnN')); ?>

<?php
NHtml::popupForm('rolepop', 'Role', '', '500px',"js:function() {
	var permsObj = {
		perms:[]
	};
	jQuery('#permissions').jstree('get_checked').each(function(i,el){
		permsObj.perms[i] = $(el).attr('id');
	});

	var data = $('#rolepop form').serialize() + '&' + $.param(permsObj);
	//var data = {
	//	'roleData':$('#rolepop form').serialize(),
	//	'perms':perms
	//};
	//alert($.param(perms));
	$.post('".NHtml::url('/user/permissions/saveRole')."', data, function(r){
		if(r){
			// added role
			$('#rolepop').dialog('close');
			$('#rolepop .content').html('Loading...');
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
			'value' => '"<a href=\"#\" onclick=\"jQuery(\'#rolepop\').dialog(\'open\');$(\'#rolepop .content\').html(\'Loading...\');$(\'#rolepop .content\').load(\''.NHtml::url('/user/permissions/getRoleForm').'\',{role:\'$data->name\'});return false;\">$data->name</a>"',
		),
		'description',
	),
)); ?>