<?php
if ($action == 'view') {
	$partial = '_viewStaff';
} else {
	$partial = '_editStaff';
}	
	$this->renderPartial('view/tabs/staff/'.$partial, array('model'=>$model, 'cid'=>$cid, 'action'=>$action));