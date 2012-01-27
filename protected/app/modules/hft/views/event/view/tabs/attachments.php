<?php

// Attachments

$this->widget('nii.widgets.attachments.NAttachments',
	array(
		'model'=>$model,
		'canAdd'=>Yii::app()->user->checkAccess('hft/event/edit'),
		'canDelete'=>Yii::app()->user->checkAccess('hft/event/edit'),
		'canEdit'=>Yii::app()->user->checkAccess('hft/event/edit'),
		'canEditMine'=>Yii::app()->user->checkAccess('hft/event/edit'),
		'emptyText'=>'<span class="noData">There are currently no attachments for this event</span>',
	)
);