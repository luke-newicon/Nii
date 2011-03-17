<?php
$this->breadcrumbs=array(
	'Projects'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Project',
	'items'=>array(
		array('label'=>'Create', 'url'=>array('create')),
		array('label'=>'Update', 'url'=>array('update', 'id'=>$model->id)),
		array('label'=>'Delete', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
		)
	),
	array('label'=>'Tasks',
	'items'=>array(
		array('label'=>'Create', 'url'=>array('task/create/projectId/'.$model->id)),
		)
	),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'code',
		'description',
		'completion_date',
		array('name'=>'estimated_time','value'=>$model->estimated_time),
		'created',
	),
));

?>

<h2>Tasks</h2>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$issues->search($model->id),
	'filter'=>$issues,
	'columns'=>array(
		'id',
		array('name'=>'name','value'=>'$data->nameCol()','type'=>'html'),
		array('name'=>'type','value'=>'$data->getType("$data->type")','filter'=>$issues->getTaskTypes()),
		'description',
		'created',
		array('name'=>'estimated_time'),
		array('name'=>'out_of_scope'),
		array('class'=>'CButtonColumn',
			'updateButtonUrl'=>'"/Nii/project/task/update/id/".$data->id',
			'deleteButtonUrl'=>'"/Nii/project/task/delete/id/".$data->id',
			'template'=>'{update}{delete}'
			)
	)
));?>


