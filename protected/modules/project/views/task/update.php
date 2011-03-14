<?php
$this->breadcrumbs=array(
	'Project Tasks'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProjectTask', 'url'=>array('index')),
	array('label'=>'Create ProjectTask', 'url'=>array('create')),
	array('label'=>'View ProjectTask', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProjectTask', 'url'=>array('admin')),
);
?>

<h1>Update ProjectTask <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>