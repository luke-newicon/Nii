<?php
if ($action == 'view') {
	$partial = '_viewCleric';
} else {
	$partial = '_editCleric';
}	
	$this->renderPartial('view/tabs/cleric/'.$partial, array('model'=>$model, 'cid'=>$cid, 'action'=>$action));