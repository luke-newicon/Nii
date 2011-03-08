<?php
$this->breadcrumbs=array(
	'Projects Issues'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ProjectsIssue', 'url'=>array('index')),
	array('label'=>'Create ProjectsIssue', 'url'=>array('create')),
	array('label'=>'Update ProjectsIssue', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProjectsIssue', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProjectsIssue', 'url'=>array('admin')),
);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$projectModel,
	'attributes'=>array(
		'id',
		'type',
		'name',
		'description',
		'status',
		'project_id',
		'completed',
		'completed_by',
		'deleted',
		'estimated_time',
		'out_of_scope',
	),
)); ?>
