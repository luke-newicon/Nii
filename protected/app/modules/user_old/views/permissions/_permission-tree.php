<div class="row">
<?php echo CHtml::checkBox('superuserchk'); ?>
&nbsp;<?php echo CHtml::label('Is Super User', 'superuserchk'); ?>
</div>
<?php
$this->Widget('nii.widgets.jstree.NJsTree', array(
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



<script>
$(function(){
	$('#superuserchk').click(function(){
		$('#permissions').fadeToggle(0);
	})
});
</script>