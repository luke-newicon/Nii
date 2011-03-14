<?php
$this->breadcrumbs=array(
	'Project Time Records'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProjectTimeRecord', 'url'=>array('index')),
	array('label'=>'Manage ProjectTimeRecord', 'url'=>array('admin')),
);
?>

<h1>Create ProjectTimeRecord</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>