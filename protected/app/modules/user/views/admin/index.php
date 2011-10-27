<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user/admin/index'),
	UserModule::t('Manage'),
);
?>
<h1><?php echo UserModule::t("Manage Users"); ?></h1>

<?php if(UserModule::isAdmin()) {
	?><ul class="actions">
	<li><?php echo CHtml::link(UserModule::t('Manage Roles'),array('/user/permissions/roles')); ?></li>
</ul><!-- actions --><?php
} ?>

<a class="btn btnN" href="<?php echo NHtml::url('/user/admin/create'); ?>">Add User</a>

<?php echo CHtml::link('Create a new user', '#', 
		array('onclick' => '$("#userpop").dialog("open"); $("#userpop .content").html("Loading...");
 $("#userpop .content").load("'.NHtml::url('/user/admin/create').'"); return false;			
','class'=>'btn btnN')); ?>
<?php
NHtml::popupForm('userpop', 'Role', '', '500px',"js:function() {
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
}", array('height'=>'475'));
?>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->username), array("admin/view","id"=>$data->id))',
		),
		array(
			'name'=>'email',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->email), "mailto:".$data->email)',
		),
		array(
			'name' => 'createtime',
			'value' => 'date("d.m.Y H:i:s",$data->createtime)',
		),
		array(
			'name' => 'lastvisit',
			'value' => '(($data->lastvisit)?date("d.m.Y H:i:s",$data->lastvisit):UserModule::t("Not visited"))',
		),
		array(
			'name'=>'status',
			'value'=>'User::itemAlias("UserStatus",$data->status)',
		),
		array(
			'name'=>'superuser',
			'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
