<?php
$this->breadcrumbs=array(
	'Projects'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Project',
	'items'=>array(
		array('label'=>'Create', 'url'=>array('create')),
		array('label'=>'Update', 'url'=>array('update', 'id'=>$model->id)),
		array('label'=>'Delete', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
		)
	),
	array('label'=>'Tasks',
	'items'=>array(
		array('label'=>'Create', 'url'=>array('task/create/projectId/'.$model->id)),
		)
	),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'code',
		'description',
		'completion_date',
		array('name'=>'estimated_time','value'=>$model->estimated_time),
		array('label'=>'Total Recorded Time','value'=>$model->getRecordedTime()),
		'created',
	),
));

?>

<?php

$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs'=>array(
        'Statistics'=>'',
        'Tasks'=>array('ajax'=>array('task/taskList')),
        'Attached Items'=>array('ajax'=>''),
    ),
    // additional javascript options for the tabs plugin
    'options'=>array(
        'collapsible'=>true,
    ),
    'htmlOptions'=>array('class'=>'solid')
));


?>
<h2>Time</h2>
<div>Time record types:</div>
<table>
    <?php foreach($projectTimeOverviewTimeType as $OverviewTimeType):?>
    <tr>
	<td><?php echo $OverviewTimeType->name?></td>
	<td><?php echo $OverviewTimeType->recorded_time?></td>
    </tr>
    <?php endforeach;?>
</table>
<div>Task types:</div>
<table>
    <?php foreach($projectTimeOverviewTaskType as $OverviewTaskType):?>
    <tr>
	<td><?php echo $issues->getType($OverviewTaskType->type)?></td>
	<td><?php echo $OverviewTaskType->recorded_time?></td>
    </tr>
    <?php endforeach;?>
</table>
