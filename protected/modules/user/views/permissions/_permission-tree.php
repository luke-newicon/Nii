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

<button id="savePerms" class="btn btnN">Save</button>
<script>
$(function(){
	$('#savePerms').click(function(){
		var perms = {}; 
		jQuery('#permissions').jstree('get_checked').each(function(i,el){
			perms[i] = $(el).attr('id');
		});
		$.post("<?php echo NHtml::url(array('/user/permissions/setRolePermission','role'=>$role->name)); ?>", 
			{'perms':perms}, function(){
			
		})
	});
	
});
</script>