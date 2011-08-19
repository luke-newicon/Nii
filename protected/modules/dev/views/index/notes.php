<h3>Model 1</h3>
<?php
	$model = NFile::model()->findByPk(1);
	$this->widget('modules.nii.widgets.notes.NNotes',array(
		'model'=>$model,
		'canAdd'=>true,
		'canDelete'=>true,
		'displayUserPic'=>false,
		'canEdit'=>true,
		'canEditMine'=>true
	));
?>
<h3>Model 1 with type [second]</h3>
<?php
//	$model = NFile::model()->findByPk(1);
//	$this->widget('modules.nii.widgets.notes.NNotes',array(
//		'model'=>$model,
//		'canAdd'=>true,
//		'canDelete'=>true,
//		'displayUserPic'=>false,
//		'canEdit'=>true,
//		'type'=>'second',
//		'canEditMine'=>true
//	));
?>

<h3>Model 2</h3>
<?php
	$model = NFile::model()->findByPk(2);
	$this->widget('modules.nii.widgets.notes.NNotes',array(
		'model'=>$model,
		'canAdd'=>true,
		'canDelete'=>true,
		'displayUserPic'=>true,
		'canEdit'=>true,
		'canEditMine'=>true,
	));
?>