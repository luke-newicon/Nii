



<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
	'tabs'=>array(
		'role'=>$this->renderPartial('_role-form', array('model'=>$model, 'role'=>$role), true),
		'Permissions'=>$this->renderPartial('_permission-tree', array('permissions'=>$permissions,'role'=>$role), true),
	),
	// additional javascript options for the tabs plugin
	'options'=>array(
		'collapsible'=>false,
	),
	'htmlOptions'=>array('class'=>'solid rounded')
));
?>
