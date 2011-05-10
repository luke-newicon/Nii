<?php
$this->breadcrumbs=array(
	'Project Sprints'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ProjectSprint', 'url'=>array('index')),
	array('label'=>'Create ProjectSprint', 'url'=>array('create')),
	array('label'=>'Update ProjectSprint', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProjectSprint', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProjectSprint', 'url'=>array('admin')),
);
?>

<h1>View ProjectSprint #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'code',
		'description',
		'duration',
		'created_by',
		'created',
		'project_id',
		'status',
		'sprint_order',
	),
)); ?>
