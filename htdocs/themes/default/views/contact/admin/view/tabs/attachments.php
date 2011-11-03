<?php

// Attachments

$this->widget('nii.widgets.attachments.NAttachments',
	array(
		'model'=>$model,
		'canAdd'=>Yii::app()->user->checkAccess('editor'),
		'canDelete'=>Yii::app()->user->checkAccess('editor'),
		'canEdit'=>Yii::app()->user->checkAccess('editor'),
		'canEditMine'=>Yii::app()->user->checkAccess('editor'),
		'emptyText'=>'<span class="noData">There are currently no attachments for this contact</span>',
	)
);