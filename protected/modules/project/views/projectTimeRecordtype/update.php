<?php
$this->breadcrumbs=array(
	'Project Time Recordtypes'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProjectTimeRecordtype', 'url'=>array('index')),
	array('label'=>'Create ProjectTimeRecordtype', 'url'=>array('create')),
	array('label'=>'View ProjectTimeRecordtype', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProjectTimeRecordtype', 'url'=>array('admin')),
);
?>

<h1>Update ProjectTimeRecordtype <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>