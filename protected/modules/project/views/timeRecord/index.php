<?php
$this->breadcrumbs=array(
	'Project Time Records',
);

$this->menu=array(
	array('label'=>'Create ProjectTimeRecord', 'url'=>array('create')),
	array('label'=>'Manage ProjectTimeRecord', 'url'=>array('admin')),
);
?>

<h1>Project Time Records</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
