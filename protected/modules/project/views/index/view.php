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

//$this->widget('system.web.widgets.CTabView',array('tabs'=>array(
//    'tasks'=>array(
//          'title'=>'Tasks',
//	  'view'=>'/task/partials/_grid',
//	  'data'=>array('task'=>$task)
//    ),
//),
//	'htmlOptions'=>array('class'=>'solidTabs')));

?>
<?php $this->renderPartial('/task/partials/_grid',array('class'=>'solidTabs','task'=>$task))?>

