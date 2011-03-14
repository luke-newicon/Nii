<?php
$this->breadcrumbs=array(
	'Project Tasks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProjectTask', 'url'=>array('index')),
	array('label'=>'Manage ProjectTask', 'url'=>array('admin')),
);
?>

<h1>Add Task</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>