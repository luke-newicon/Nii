<?php
$this->breadcrumbs=array(
	'Projects'=>array('index/index'),
	$model->project->name=>array('index/view/','id'=>$model->project_id),
	'Create'
);
?>

<h1>Add Task</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>