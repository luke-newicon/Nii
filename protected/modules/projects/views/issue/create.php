<?php
$this->breadcrumbs=array(
	'Projects Issues'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProjectsIssue', 'url'=>array('index')),
	array('label'=>'Manage ProjectsIssue', 'url'=>array('admin')),
);
?>

<h1>Create ProjectsIssue</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>