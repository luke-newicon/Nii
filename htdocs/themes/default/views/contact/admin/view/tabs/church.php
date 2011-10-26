<?php
if ($action == 'view') {
	$partial = '_viewChurch';
} else {
	$partial = '_editChurch';
}	
	$this->renderPartial('view/tabs/church/'.$partial, array('model'=>$model, 'cid'=>$cid, 'action' => $action));