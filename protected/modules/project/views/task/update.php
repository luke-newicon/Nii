<?php
$this->breadcrumbs=array(
	'Projects'=>array('index/index'),
	$model->project->name=>array('index/view/','id'=>$model->project_id),
	'Update'
);
?>

<h1>Update ProjectTask <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>