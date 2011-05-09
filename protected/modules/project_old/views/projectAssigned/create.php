<?php
$this->breadcrumbs=array(
	'Project Project Assigneds'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProjectProjectAssigned', 'url'=>array('index')),
	array('label'=>'Manage ProjectProjectAssigned', 'url'=>array('admin')),
);
?>

<h1>Create ProjectProjectAssigned</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>