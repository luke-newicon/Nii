<?php

// Relationships

$this->widget('nii.widgets.relationships.NRelationships',
	array(
		'model'=>$model,
		'canAdd'=>Yii::app()->user->checkAccess('hft/event/edit'),
		'canDelete'=>Yii::app()->user->checkAccess('hft/event/edit'),
		'canEdit'=>Yii::app()->user->checkAccess('hft/event/edit'),
		'emptyText'=>'<span class="noData">There are currently no other relationships for this event</span>',
	)
);