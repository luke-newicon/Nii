<?php
$this->breadcrumbs=array(
	'Project Sprints'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProjectSprint', 'url'=>array('index')),
	array('label'=>'Create ProjectSprint', 'url'=>array('create')),
	array('label'=>'View ProjectSprint', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProjectSprint', 'url'=>array('admin')),
);
?>

<h1>Update ProjectSprint <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>