<h3><?php 
	echo $this->t('Notes'); 
	if (Yii::app()->user->checkAccess('hft/donation/edit')) {
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
		'canAdd'=>Yii::app()->user->checkAccess('hft/donation/edit'),
		'canDelete'=>Yii::app()->user->checkAccess('hft/donation/edit'),
		'canEdit'=>Yii::app()->user->checkAccess('hft/donation/edit'),
		'canEditMine'=>Yii::app()->user->checkAccess('hft/donation/edit'),
		'emptyText' => '<span class="noData">There are currently no associated notes for this donation</span>',
		'addNoteButtonHtml' => '',
	)
);