<?php
$this->breadcrumbs=array(
	'Project Time Records'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ProjectTimeRecord', 'url'=>array('index')),
	array('label'=>'Create ProjectTimeRecord', 'url'=>array('create')),
	array('label'=>'Update ProjectTimeRecord', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProjectTimeRecord', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProjectTimeRecord', 'url'=>array('admin')),
);
?>

<h1>View ProjectTimeRecord #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'date_of_work',
		'time_spent',
		'issue_id',
		'description',
		'added',
		'added_by',
		'type',
	),
)); ?>
