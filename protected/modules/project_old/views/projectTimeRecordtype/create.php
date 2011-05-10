<?php
$this->breadcrumbs=array(
	'Project Time Recordtypes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProjectTimeRecordtype', 'url'=>array('index')),
	array('label'=>'Manage ProjectTimeRecordtype', 'url'=>array('admin')),
);
?>

<h1>Create ProjectTimeRecordtype</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>