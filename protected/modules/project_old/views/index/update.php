<?php
$this->breadcrumbs=array(
	'Projects'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);
?>

<h1>Update ProjectProject <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('/index/partials/_form', array('model'=>$model)); ?>