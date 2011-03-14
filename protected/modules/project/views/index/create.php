<?php
$this->breadcrumbs=array(
	'Projects'=>array('index'),
	'Create',
);
?>

<h1>Add New Project</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>