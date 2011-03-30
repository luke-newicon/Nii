<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user/permissions/index'),
	UserModule::t('Permissions')=>array('/user/permissions/index'),
	UserModule::t('Roles'),
);
?>

<?php echo CHtml::link('Create Role', '#', array('onclick' => '$("#addrole").dialog("open"); return false;','class'=>'btn btnN')); ?>
<h1><?php echo UserModule::t("Manage Users"); ?></h1>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'addrole',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Create Role',
        'autoOpen'=>false,
		'width'=>'390px',
		'open'=>'js:function(){$("#addrole .content").load("'.NHtml::url('/user/permissions/createRoleForm').'")}',
		'buttons'=>array(
			'save' => array(
				'text' => 'Save',
				'click'=>'js:function() {
					$.post("'.NHtml::url('/user/permissions/createRoleForm').'", $("#authitem").serialize(), function(r){
						if(r){
							// added role
							$("#addrole").dialog("close");
							$("#addrole .content").html("Loading...");
							// refresh roles list!
						}
					});
				}'
			),
			'cancel' => array(
				'text' => 'Cancel',
				'click'=>'js:function() { $(this).dialog("close"); }'
			),
		),
    ),
));

echo '<div class="content">Loading...</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');

?>




Roles:
<ul>
<?php foreach($roles as $role): ?>
	<li><?php echo $role->name; ?></li>
<?php endforeach; ?>
</ul>