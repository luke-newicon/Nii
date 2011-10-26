<?php
if ($action == 'view') {
	$partial = '_viewTrainingfacility';
} else {
	$partial = '_editTrainingfacility';
}	
	$this->renderPartial('view/tabs/trainingfacility/'.$partial, array('model'=>$model, 'cid'=>$cid, 'action'=>$action));