<?php
$this->breadcrumbs=array(
	'Projects Projects'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProjectsProject', 'url'=>array('index')),
	array('label'=>'Create ProjectsProject', 'url'=>array('create')),
	array('label'=>'View ProjectsProject', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProjectsProject', 'url'=>array('admin')),
);
?>

<h1>Update ProjectsProject <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>