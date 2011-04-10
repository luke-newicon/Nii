<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Update Role");
$this->breadcrumbs=array(
	(UserModule::t('Users'))=>array('/user/admin/index'),
	$model->username=>array('view','id'=>$model->id),
	UserModule::t("Roles"),
);
?>
<div class="form pal userRoles">
<form>
<?php foreach($roles as $role): ?>
	<?php if($role->getBizRule() == ''): ?>
	
	<div class="row pas" style="border-bottom:1px solid #ccc;background-color:#ebebeb;margin:1px;">
		<?php echo CHtml::checkBox("roles[{$role->name}]", array_key_exists($role->name, $userRoles), array('style'=>'float:left;margin-right:5px;')); ?>
		<div class="unit size1of2">
		<?php echo CHtml::label($role->name, "roles_{$role->name}", array('style'=>'font-weight:normal;font-size:1em;'));?>
		</div>
		<div class="lastUnit">
		<?php echo $role->description; ?>&nbsp;
		</div>
	</div>
	<?php endif; ?>
<?php endforeach; ?>
	<div class="row buttons">
	<?php echo CHtml::submitButton('save', array('id'=>'saveUserRoles')); ?>
	</div>
</form>
</div>

<script>

$('#saveUserRoles').click(function(){
	alert($('.userRoles form').serialize());
	$.post("<?php echo NHtml::url(array('/user/admin/assignRoles', 'userId'=>$model->id)); ?>",$('.userRoles form').serialize(),function(){
		
	});
	return false;
});

</script>