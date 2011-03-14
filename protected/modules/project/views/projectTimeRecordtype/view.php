<?php
$this->breadcrumbs=array(
	'Project Time Recordtypes'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ProjectTimeRecordtype', 'url'=>array('index')),
	array('label'=>'Create ProjectTimeRecordtype', 'url'=>array('create')),
	array('label'=>'Update ProjectTimeRecordtype', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProjectTimeRecordtype', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProjectTimeRecordtype', 'url'=>array('admin')),
);
?>

<h1>View ProjectTimeRecordtype #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
	),
)); ?>
