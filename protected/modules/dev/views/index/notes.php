<?php
$model = NFile::model()->findByPk(1);
$this->widget('modules.nii.widgets.notes.NNotes',array(
			'model'=>$model,
			'canAdd'=>true,
			'ajaxController'=>'nii/index/NNotes'));
?>
