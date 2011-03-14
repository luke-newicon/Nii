<?php
$this->breadcrumbs=array(
	'Projects'=>array('index/index'),
	$model->project->name=>array('index/view','id'=>$model->project->id),
	$model->name,
);

$this->menu=array(
	array('label'=>'Project',
	'items'=>array(
			array('label'=>'Create','url'=>array('create','projectId'=>$model->project_id)),
			array('label'=>'Update', 'url'=>array('update', 'id'=>$model->id)),
			array('label'=>'Delete', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
		)),
	array('label'=>'Time Record',
	'items'=>array(
			array('label'=>'Create','url'=>array('timeRecord/create','projectId'=>$model->project_id)),
		)),
);
?>


<h1><?php echo $model->name; ?></h1>

<?php

//Created by column
$createdUser = $model->createdByUserName->username;

//Assigned user column
$assignedUser = ' ';
if($model->assigned_user)
$assignedUser = $model->assignedToUser->username;



$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'type',
		'description',
		'project_id',
		'created',
		array('label'=>'Created By','value'=>$createdUser),
		'estimated_time',
		'out_of_scope',
		array('label'=>'Assigned User','value'=>$assignedUser),
		'sprint_id',
	),
)); ?>

<h2>Time Record</h2>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$ProjectTimeRecord->search($model->id),
	'filter'=>$ProjectTimeRecord,
	'columns'=>array(
		'id',
		array('name'=>'date_of_work'),
		array('name'=>'added_by','value'=>'$data->addedByUser->username'),
		'description',
		'time_spent',
		array('name'=>'type','value'=>'$data->typeInfo->name','filter'=>$ProjectTimeRecord->getTypes()),
		'added'
	)
)); ?>

