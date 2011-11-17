<h3><?php 
	echo $this->t('Notes'); 
	if (Yii::app()->user->checkAccess('editor')) {
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
		'canAdd'=>Yii::app()->user->checkAccess('editor'),
		'canDelete'=>Yii::app()->user->checkAccess('editor'),
		'canEdit'=>Yii::app()->user->checkAccess('editor'),
		'canEditMine'=>Yii::app()->user->checkAccess('editor'),
		'emptyText' => '<span class="noData">There are currently no associated notes for this donation</span>',
		'addNoteButtonHtml' => '',
	)
);