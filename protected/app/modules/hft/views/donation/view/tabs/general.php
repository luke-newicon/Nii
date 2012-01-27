<?php

// Relationships

$this->widget('nii.widgets.relationships.NRelationships',
	array(
		'model'=>$model,
		'canAdd'=>Yii::app()->user->checkAccess('hft/donation/edit'),
		'canDelete'=>Yii::app()->user->checkAccess('hft/donation/edit'),
		'canEdit'=>Yii::app()->user->checkAccess('hft/donation/edit'),
		'emptyText'=>'<span class="noData">There are currently no other relationships for this donation</span>',
	)
);