<?php
$this->breadcrumbs = array(
    'Projects' => array('index'),
    $project->name,
);

$this->menu = array(
    array('label' => 'Project',
	'items' => array(
	    array('label' => 'Create', 'url' => array('create')),
	    array('label' => 'Update', 'url' => array('update', 'id' => $project->id)),
	    array('label' => 'Delete', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $project->id), 'confirm' => 'Are you sure you want to delete this item?')),
	)
    ),
    array('label' => 'Tasks',
	'items' => array(
	    array('label' => 'Create', 'url' => array('task/create/projectId/' . $project->id)),
	)
    ),
);
?>
<h1><?php echo $project->name; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $project,
    'attributes' => array(
	'code',
	'description',
	'completion_date',
	array('name' => 'estimated_time', 'value' => $project->estimated_time),
	'created',
    ),
));
?>

<?php

$this->widget('system.web.widgets.CTabView',array('tabs'=>array(
    'tab0'=>array(
          'title'=>'Statistics',
	  'view'=>'_stats',
	  'data'=>array('task'=>$task,'project'=>$project,'totalTime'=>$project->getRecordedTime())
    ),
    'tasks'=>array(
          'title'=>'Tasks',
	  'view'=>'_taskGrid',
	  'data'=>array('task'=>$task)
    ),
    'files'=>array(
          'title'=>'Files',
          'url'=>'http://www.yiiframework.com/',
    ),
),
	'htmlOptions'=>array('class'=>'solidTabs')));

?>

