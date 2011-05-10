<?php
$this->breadcrumbs=array(
	'Project Project Assigneds',
);

$this->menu=array(
	array('label'=>'Create ProjectProjectAssigned', 'url'=>array('create')),
	array('label'=>'Manage ProjectProjectAssigned', 'url'=>array('admin')),
);
?>

<h1>Project Project Assigneds</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
