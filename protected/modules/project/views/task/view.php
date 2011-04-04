<?php
$this->breadcrumbs = array(
    'Projects' => array('index/index'),
    $task->project->name => array('index/view', 'projectId' => $task->project->id),
    $task->name,
);

$this->menu = array(
    array('label' => 'Task',
	'items' => array(
	    array('label' => 'Create', 'url' => array('create', 'projectId' => $task->project_id)),
	    array('label' => 'Update', 'url' => array('update', 'id' => $task->id)),
	    array('label' => 'Delete', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $task->id), 'confirm' => 'Are you sure you want to delete this item?')),
    )),
    array('label' => 'Time Record',
	'items' => array(
	    array('label' => 'Create', 'url' => array('timeRecord/create', 'issueId' => $task->id)),
    )),
);
?>

<h1><?php echo $task->name; ?></h1>

<?php
//Created by column
$createdUser = $task->createdByUserName->username;

//Assigned user column
$assignedUser = ' ';
if ($task->assigned_user)
    $assignedUser = $task->assignedToUser->username;

$sprint_name = null;
if (isset($task->sprint->name))
    $sprint_name = $task->sprint->name;

$this->widget('zii.widgets.CDetailView', array(
    'data' => $task,
    'attributes' => array(
	'description',
	array('label' => 'Type', 'value' => $task->getType()),
	'estimated_time',
	array('name' => 'out_of_scope', 'value' => $task->outOfScopeCol()),
	array('label' => 'Assigned User', 'value' => $assignedUser),
	array('label' => 'Sprint', 'value' => $sprint_name),
	'created',
	array('label' => 'Created By', 'value' => $createdUser),
    ),
));
?>
<?php

$this->widget('system.web.widgets.CTabView',array('tabs'=>array(
    'stats'=>array(
          'title'=>'Statistics',
	  'view'=>'_stats',
	  'data'=>array('taskTimeOverview'=>$taskTimeOverview,'task'=>$task,'taskTime'=>$task->getRecordedTime())
    ),
    'tab0'=>array(
          'title'=>'Time',
	  'view'=>'_timeRecords',
	  'data'=>array('ProjectTimeRecord'=>$ProjectTimeRecord)
    ),
),
	'htmlOptions'=>array('class'=>'solidTabs')));?>

<?php foreach ($ProjectTimeRecord->getTypes(false) as $typeId => $type): ?>
	<div><?php echo chtml::link($type,array('timeRecord/quickAdd/','recordId'=>$typeId)) ?></div>
<?php endforeach; ?>
<?php
			$this->widget('zii.widgets.grid.CGridView', array(
				'dataProvider' => $ProjectTimeRecord->search(),
				'filter' => $ProjectTimeRecord,
				'columns' => array(
					'id',
					array('name' => 'added_by', 'value' => '$data->addedByUser->username'),
					'description',
					array('name' => 'type', 'value' => '$data->typeInfo->name', 'filter' => $ProjectTimeRecord->getTypes(false)),
					'time_started',
					array('name' => 'time_finished', 'value' => '$data->time_finished'),
					array('name' => 'recorded_time'),
					array('header' => 'Stop work', 'value' => '$data->stopCol()', 'type' => 'html'),
					array('class' => 'CButtonColumn', 'template' => '{update}{delete}', 'updateButtonUrl' => 'yii::app()->createUrl("project/timeRecord/update/id/$data->id")',
						'deleteButtonUrl' => 'yii::app()->createUrl("project/timeRecord/delete/id/$data->id")'),
				)
			)); ?>
?>