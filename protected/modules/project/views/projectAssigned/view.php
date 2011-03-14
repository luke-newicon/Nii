<?php
$this->breadcrumbs=array(
	'Project Project Assigneds'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ProjectProjectAssigned', 'url'=>array('index')),
	array('label'=>'Create ProjectProjectAssigned', 'url'=>array('create')),
	array('label'=>'Update ProjectProjectAssigned', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProjectProjectAssigned', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProjectProjectAssigned', 'url'=>array('admin')),
);
?>

<h1>View ProjectProjectAssigned #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'project_id',
		'user_id',
		'project_role',
		'added',
		'assigned_by',
	),
)); ?>
