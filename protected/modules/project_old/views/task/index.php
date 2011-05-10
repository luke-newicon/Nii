<?php
$this->breadcrumbs=array(
	'Project Tasks',
);

$this->menu=array(
	array('label'=>'Create ProjectTask', 'url'=>array('create')),
	array('label'=>'Manage ProjectTask', 'url'=>array('admin')),
);
?>

<h1>Project Tasks</h1>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
