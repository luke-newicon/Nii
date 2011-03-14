<?php
$this->breadcrumbs=array(
	'Project Projects'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProjectProject', 'url'=>array('index')),
	array('label'=>'Create ProjectProject', 'url'=>array('create')),
	array('label'=>'View ProjectProject', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProjectProject', 'url'=>array('admin')),
);
?>

<h1>Update ProjectProject <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>