<h3><?php 
	echo $this->t('Notes'); 
	if (Yii::app()->user->checkAccess('hft/event/edit')) {
		echo CHtml::link('','#',
			array(
				'class'=>'icon fam-add',
				'onclick'=>'$("#'.NAttributeWidget::getWidgetId('NNotes', $model).'").NNotes("addNewNoteSwitch");return false;',
				'style' => 'position: relative; height: 16px; line-height: 16px; display: inline-block; margin-left: 8px; top: 3px;',
			)
		);
	}
?></h3>
<?php
$this->widget('nii.widgets.notes.NNotes',
	array(
		'model'=>$model,
		'canAdd'=>Yii::app()->user->checkAccess('hft/event/edit'),
		'canDelete'=>Yii::app()->user->checkAccess('hft/event/edit'),
		'canEdit'=>Yii::app()->user->checkAccess('hft/event/edit'),
		'canEditMine'=>Yii::app()->user->checkAccess('hft/event/edit'),
		'emptyText' => '<span class="noData">There are currently no associated notes for this event</span>',
		'addNoteButtonHtml' => '',
	)
);