<?php
if ($action == 'view') {
	$partial = '_viewStudent';
} else {
	$partial = '_editStudent';
}	
	$this->renderPartial('view/tabs/student/'.$partial, array('s'=>$s, 'cid'=>$cid));