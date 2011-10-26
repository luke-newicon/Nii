<?php
if ($action == 'view') {
	$partial = '_viewDiocese';
} else {
	$partial = '_editDiocese';
}	
	$this->renderPartial('view/tabs/diocese/'.$partial, array('model'=>$model, 'cid'=>$cid));