<?php
$this->breadcrumbs=array(
	'Projects'=>array('index'),
	$project->name,
);

$this->menu=array(
	array('label'=>'Project',
	'items'=>array(
		array('label'=>'Create', 'url'=>array('create')),
		array('label'=>'Update', 'url'=>array('update', 'id'=>$project->id)),
		array('label'=>'Delete', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$project->id),'confirm'=>'Are you sure you want to delete this item?')),
		)
	),
	array('label'=>'Tasks',
	'items'=>array(
		array('label'=>'Create', 'url'=>array('task/create/projectId/'.$project->id)),
		)
	),
);
?>

<h1><?php echo $project->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$project,
	'attributes'=>array(
		'code',
		'description',
		'completion_date',
		array('name'=>'estimated_time','value'=>$project->estimated_time),
		array('label'=>'Total Recorded Time','value'=>$project->getRecordedTime()),
		'created',
	),
));

?>

<h2>Stats</h2>
<div>Time record types:</div>
<table>
    <?php foreach($project->projectTimeOverviewTimeType() as $overviewTimeType):?>
    <tr>
	<td><?php echo $overviewTimeType->name?></td>
	<td><?php echo $overviewTimeType->recorded_time?></td>
    </tr>
    <?php endforeach;?>
</table>
<div>Task types:</div>
<table>
    <?php foreach($project->projectTimeOverviewTaskType() as $overviewTaskType):?>
    <tr>
	<td><?php echo $task->getType($overviewTaskType->type)?></td>
	<td><?php echo $overviewTaskType->recorded_time?></td>
    </tr>
    <?php endforeach;?>
</table>

<h2>Tasks</h2>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$task->search(),
	'filter'=>$task,
	'columns'=>array(
		'id',
		array('name'=>'name','value'=>'$data->nameCol()','type'=>'html'),
		array('name'=>'type','value'=>'$data->getType("$data->type")','filter'=>$task->getTaskTypes()),
		'description',
		'created',
		array('name'=>'estimated_time'),
	    array('name'=>'recorded_time','filter'=>''),
		array('name'=>'out_of_scope','value'=>'$data->outOfScopeCol()','filter'=>array('No','Yes')),
		array('class'=>'CButtonColumn',
			'updateButtonUrl'=>'"/Nii/project/task/update/id/".$data->id',
			'deleteButtonUrl'=>'"/Nii/project/task/delete/id/".$data->id',
			'template'=>'{update}{delete}'
			)
	)
));?>


