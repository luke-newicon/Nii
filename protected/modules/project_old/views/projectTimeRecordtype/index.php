<?php
$this->breadcrumbs=array(
	'Project Time Recordtypes',
);

$this->menu=array(
	array('label'=>'Create ProjectTimeRecordtype', 'url'=>array('create')),
	array('label'=>'Manage ProjectTimeRecordtype', 'url'=>array('admin')),
);
?>

<h1>Project Time Recordtypes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
