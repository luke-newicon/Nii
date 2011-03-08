<?php
$this->breadcrumbs=array(
	'Projects Issues'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProjectsIssue', 'url'=>array('index')),
	array('label'=>'Create ProjectsIssue', 'url'=>array('create')),
	array('label'=>'View ProjectsIssue', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProjectsIssue', 'url'=>array('admin')),
);
?>

<h1>Update ProjectsIssue <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>