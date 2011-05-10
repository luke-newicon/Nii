<?php
$this->breadcrumbs=array(
	'Project Sprints'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProjectSprint', 'url'=>array('index')),
	array('label'=>'Manage ProjectSprint', 'url'=>array('admin')),
);
?>

<h1>Create ProjectSprint</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>