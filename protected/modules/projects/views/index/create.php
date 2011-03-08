<?php
$this->breadcrumbs=array(
	'Projects Projects'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProjectsProject', 'url'=>array('index')),
	array('label'=>'Manage ProjectsProject', 'url'=>array('admin')),
);
?>

<h1>Create ProjectsProject</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>