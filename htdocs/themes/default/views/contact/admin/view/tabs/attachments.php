<?php

// Attachments

$this->widget('nii.widgets.attachments.NAttachments',
	array(
		'model'=>$model,
		'canAdd'=>Yii::app()->user->checkAccess('contact/admin/edit'),
		'canDelete'=>Yii::app()->user->checkAccess('contact/admin/edit'),
		'canEdit'=>Yii::app()->user->checkAccess('contact/admin/edit'),
		'canEditMine'=>Yii::app()->user->checkAccess('contact/admin/edit'),
		'emptyText'=>'<span class="noData">There are currently no attachments for this contact</span>',
	)
);