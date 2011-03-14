<?php
$this->breadcrumbs=array(
	'Projects Issues',
);

$this->menu=array(
	array('label'=>'Create ProjectsIssue', 'url'=>array('create')),
	array('label'=>'Manage ProjectsIssue', 'url'=>array('admin')),
);
?>

<h1>Projects Issues</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
