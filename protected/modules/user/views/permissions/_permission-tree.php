<div class="row">
<?php echo CHtml::checkBox('superuserchk'); ?>
&nbsp;<?php echo CHtml::label('Is Super User', 'superuserchk'); ?>
</div>
<?php
$this->Widget('application.widgets.jstree.CJsTree', array(
	'id'=>'permissions',
	'core'=>array('animation'=>0),
	'json_data'=>array(
		'data'=>$permissions
	),
	'themes'=>array('theme'=>'ni'),
	'plugins'=>array("themes", "json_data", "checkbox"),
));
?>

<!--<button id="savePerms" class="btn btnN">Save</button>-->

<?php if($role): ?>
	<?php $url = NHtml::url(array('/user/permissions/setRolePermission','role'=>$role->name)); ?>
<?php else: ?>
	<?php $url = NHtml::url('/user/permissions/setRolePermission'); ?>
<?php endif; ?>

<script>
$(function(){
	$('#superuserchk').click(function(){
		$('#permissions').fadeToggle(0);
	})
});
</script>