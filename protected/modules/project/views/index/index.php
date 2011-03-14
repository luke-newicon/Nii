<?php
$this->breadcrumbs=array(
	'Projects',
);
?>

<h1>All Projects</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-project-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array('name'=>'name','value'=>'$data->nameFilter()','type'=>'html'),
		'code',
		'description',
		'completion_date',
		'estimated_time',
		'created',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
