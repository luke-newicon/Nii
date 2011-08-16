<?php
$model = NFile::model()->findByPk(1);
$this->widget('modules.nii.widgets.notes.NNotes',array(
			'model'=>$model,
			'canAdd'=>true,
			'canDelete'=>true,
			'displayUserPic'=>false,
			'canEdit'=>true));
?>

<?php
$model2 = NFile::model()->findByPk(2);
$this->widget('modules.nii.widgets.notes.NNotes',array(
			'model'=>$model2,
			'canAdd'=>true,
			'canDelete'=>true,
			'displayUserPic'=>false,
			'canEdit'=>true));
?>