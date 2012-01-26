<?php

// Attachments

$this->widget('nii.widgets.attachments.NAttachments',
	array(
		'model'=>$model,
		'canAdd'=>Yii::app()->user->checkAccess('hft/donation/edit'),
		'canDelete'=>Yii::app()->user->checkAccess('hft/donation/edit'),
		'canEdit'=>Yii::app()->user->checkAccess('hft/donation/edit'),
		'canEditMine'=>Yii::app()->user->checkAccess('hft/donation/edit'),
		'emptyText'=>'<span class="noData">There are currently no attachments for this donation</span>',
	)
);