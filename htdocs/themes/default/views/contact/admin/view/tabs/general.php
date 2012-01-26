<?php

// Relationships

$this->widget('nii.widgets.relationships.NRelationships',
	array(
		'model'=>$model,
		'canAdd'=>Yii::app()->user->checkAccess('contact/admin/edit'),
		'canDelete'=>Yii::app()->user->checkAccess('contact/admin/edit'),
		'canEdit'=>Yii::app()->user->checkAccess('contact/admin/edit'),
		'emptyText'=>'<span class="noData">There are currently no other relationships for this contact</span>',
	)
);