<?php
$this->breadcrumbs=array(
	'Project Projects'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProjectProject', 'url'=>array('index')),
	array('label'=>'Manage ProjectProject', 'url'=>array('admin')),
);
?>

<h1>Create ProjectProject</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>