<?php
$this->breadcrumbs=array(
	'Projects'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ProjectProject', 'url'=>array('index')),
	array('label'=>'Create ProjectProject', 'url'=>array('create')),
	array('label'=>'Update ProjectProject', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProjectProject', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProjectProject', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'code',
		'description',
		'completion_date',
		'estimated_time',
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
		array('name'=>'type'),
		'description',
		'created',
		array('name'=>'estimated_time'),
		'out_of_scope',
		array('class'=>'CButtonColumn',
			'updateButtonUrl'=>'"/Nii/project/task/update/id/".$data->id',
			'deleteButtonUrl'=>'"/Nii/project/task/delete/id/".$data->id')
	)
));




?>


