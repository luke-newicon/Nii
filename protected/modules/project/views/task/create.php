<?php
$this->breadcrumbs=array(
	'Projects'=>array('index/index'),
	'Projects'=>array('index/index'),
	'Create',
);
?>

<h1>Add Task</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>