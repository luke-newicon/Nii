
<?php //$this->renderPartial('_role-form', array('model'=>$model, 'role'=>$role), false, true); ?>
<?php //$this->renderPartial('_permission-tree', array('permissions'=>$permissions,'role'=>$role), false, true); ?>

<div id="roleMindYourManners" style="display:none;">
<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
	'id'=>'poptabs',
	'tabs'=>array(
		'role'=>$this->renderPartial('_role-form', array('model'=>$model, 'role'=>$role), true, true),
		'Permissions'=>$this->renderPartial('_permission-tree', array('permissions'=>$permissions,'role'=>$role), true, true),
	),
	// additional javascript options for the tabs plugin
	'options'=>array(
		'collapsible'=>false,
		'create'=>'js:function(){$("#roleMindYourManners").show();}',
	),
	'htmlOptions'=>array('class'=>'solid rounded')
));
?>
</div>