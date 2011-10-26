<?php
if ($action == 'view')
	$partial = '_viewComputeruser';
else
	$partial = '_editComputeruser';

$this->renderPartial('view/tabs/computeruser/'.$partial, array('model'=>$model, 'cid'=>$cid, 'student_id'=>$student_id, 'contact'=>$contact));