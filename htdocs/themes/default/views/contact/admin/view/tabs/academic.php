<?php
if ($action == 'view') {
	$partial = '_viewAcademic';
} else {
	$partial = '_editAcademic';
}	
	$this->renderPartial('view/tabs/academic/'.$partial, array('model'=>$model, 'cid'=>$cid));