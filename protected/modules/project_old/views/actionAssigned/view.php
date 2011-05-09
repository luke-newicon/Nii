<?php
$this->breadcrumbs=array(
	'Project Action Assigneds'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ProjectActionAssigned', 'url'=>array('index')),
	array('label'=>'Create ProjectActionAssigned', 'url'=>array('create')),
	array('label'=>'Update ProjectActionAssigned', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProjectActionAssigned', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProjectActionAssigned', 'url'=>array('admin')),
);
?>

<h1>View ProjectActionAssigned #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'issue_id',
		'user_id',
		'project_role',
		'added',
		'assigned_by',
	),
)); ?>
