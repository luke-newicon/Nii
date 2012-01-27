<?php

// Files

$this->widget('nii.widgets.attachments.NAttachments',
	array(
		'model'=>$model,
		'title' => 'Files',
		'canAdd'=>Yii::app()->user->checkAccess('project/index/edit'),
		'canDelete'=>Yii::app()->user->checkAccess('project/index/edit'),
		'canEdit'=>Yii::app()->user->checkAccess('project/index/edit'),
		'canEditMine'=>Yii::app()->user->checkAccess('project/index/edit'),
		'emptyText'=>'<span class="noData">There are currently no files for this project</span>',
	)
);