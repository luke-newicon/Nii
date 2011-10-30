<?php

// Relationships

$this->widget('modules.nii.widgets.relationships.NRelationships',
	array(
		'model'=>$model,
		'canAdd'=>Yii::app()->user->checkAccess('editor'),
		'canDelete'=>Yii::app()->user->checkAccess('editor'),
		'canEdit'=>Yii::app()->user->checkAccess('editor'),
		'emptyText'=>'<span class="noData">There are currently no other relationships for this contact</span>',
	)
);