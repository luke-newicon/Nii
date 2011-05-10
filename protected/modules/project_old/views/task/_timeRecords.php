<!--<h3>Quick Add</h3>-->

<?php // foreach ($ProjectTimeRecord->getTypes(false) as $typeId => $type): ?>
<?php // echo $typeId ?> <?php // echo $type ?>
<?php // endforeach; ?>
<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $ProjectTimeRecord->search(),
    'filter' => $ProjectTimeRecord,
    'columns' => array(
	array('name' => 'added_by', 'value' => '$data->addedByUser->username'),
	'description',
	array('name' => 'type', 'value' => '$data->typeInfo->name', 'filter' => $ProjectTimeRecord->getTypes(false)),
	'time_started',
	array('name' => 'time_finished', 'value' => '$data->time_finished'),
	array('name' => 'recorded_time'),
	array('header' => 'Stop work', 'value' => '$data->stopCol()', 'type' => 'html'),
	array('class' => 'CButtonColumn', 'template' => '{update}{delete}', 'updateButtonUrl' => 'yii::app()->createUrl("project/timeRecord/update/id/$data->id")',
	    'deleteButtonUrl' => 'yii::app()->createUrl("project/timeRecord/delete/id/$data->id")'),
    ),
));
?>