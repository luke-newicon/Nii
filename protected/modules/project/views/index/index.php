<?php
$this->breadcrumbs=array(
	'Projects',
);

$this->menu=array(
	array('label'=>'Project',
	'items'=>array(
		array('label'=>'Create', 'url'=>array('create')),
		)
	),
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
			'template'=>'{update}{delete}'
		),
	),
)); ?>
