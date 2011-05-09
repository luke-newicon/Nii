<?php
$this->breadcrumbs=array(
	'Projects'=>array('index/index'),
	$model->issue->project->name=>array('index/view','projectId'=>$model->issue->project->id),
	$model->issue->name=>array('task/view','taskId'=>$model->task_id),
	'Add Time Record'
);

?>

<h1>Add Time Record</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>