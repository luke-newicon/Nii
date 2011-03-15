<?php
$this->breadcrumbs=array(
	'Projects'=>array('index/index'),
	$model->issue->project->name=>array('index/view','id'=>$model->issue->project->id),
	$model->issue->name=>array('task/view','id'=>$model->task_id),
);

?>

<h1>Add Time Record</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>