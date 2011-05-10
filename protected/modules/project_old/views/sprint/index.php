<?php
$this->breadcrumbs=array(
	'Project Sprints',
);

$this->menu=array(
	array('label'=>'Create ProjectSprint', 'url'=>array('create')),
	array('label'=>'Manage ProjectSprint', 'url'=>array('admin')),
);
?>

<h1>Project Sprints</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
