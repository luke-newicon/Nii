<?php
$this->breadcrumbs=array(
	'Project Time Records'=>array('index'),
	$model->id,
);
?>

<h1>View ProjectTimeRecord #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'date_of_work',
		'time_spent',
		'task_id',
		'description',
		'added',
		'added_by',
		'type',
	),
)); ?>
