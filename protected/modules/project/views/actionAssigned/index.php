<?php
$this->breadcrumbs=array(
	'Project Action Assigneds',
);

$this->menu=array(
	array('label'=>'Create ProjectActionAssigned', 'url'=>array('create')),
	array('label'=>'Manage ProjectActionAssigned', 'url'=>array('admin')),
);
?>

<h1>Project Action Assigneds</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
