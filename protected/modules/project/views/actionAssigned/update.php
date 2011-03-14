<?php
$this->breadcrumbs=array(
	'Project Action Assigneds'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProjectActionAssigned', 'url'=>array('index')),
	array('label'=>'Create ProjectActionAssigned', 'url'=>array('create')),
	array('label'=>'View ProjectActionAssigned', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProjectActionAssigned', 'url'=>array('admin')),
);
?>

<h1>Update ProjectActionAssigned <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>