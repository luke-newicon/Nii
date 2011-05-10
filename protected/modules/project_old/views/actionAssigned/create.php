<?php
$this->breadcrumbs=array(
	'Project Action Assigneds'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProjectActionAssigned', 'url'=>array('index')),
	array('label'=>'Manage ProjectActionAssigned', 'url'=>array('admin')),
);
?>

<h1>Create ProjectActionAssigned</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>