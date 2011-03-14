<?php
$this->breadcrumbs=array(
	'Project Project Assigneds'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProjectProjectAssigned', 'url'=>array('index')),
	array('label'=>'Create ProjectProjectAssigned', 'url'=>array('create')),
	array('label'=>'View ProjectProjectAssigned', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProjectProjectAssigned', 'url'=>array('admin')),
);
?>

<h1>Update ProjectProjectAssigned <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>