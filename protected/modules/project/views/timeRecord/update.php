<?php
$this->breadcrumbs=array(
	'Project Time Records'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProjectTimeRecord', 'url'=>array('index')),
	array('label'=>'Create ProjectTimeRecord', 'url'=>array('create')),
	array('label'=>'View ProjectTimeRecord', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProjectTimeRecord', 'url'=>array('admin')),
);
?>

<h1>Update ProjectTimeRecord <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>