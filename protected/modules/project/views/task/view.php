<?php
$this->breadcrumbs=array(
	'Projects'=>array('index/index'),
	$model->project->name=>array('index/view','id'=>$model->project->id),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ProjectTask', 'url'=>array('index')),
	array('label'=>'Create ProjectTask', 'url'=>array('create')),
	array('label'=>'Update ProjectTask', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProjectTask', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProjectTask', 'url'=>array('admin')),
);
?>


<h1><?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'type',
		'description',
		'project_id',
		'created',
		'created_by',
		'estimated_time',
		'out_of_scope',
		'assigned_user',
		'sprint_id',
	),
)); ?>

<h2>Time Record</h2>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$ProjectTimeRecord->search($model->id),
	'filter'=>$ProjectTimeRecord,
	'columns'=>array(
		'id',
		'date_of_work',
		'description',
		'time_spent',
		array('name'=>'type','value'=>'$data->typeInfo->name','filter'=>$ProjectTimeRecord->getTypes()),
		'added'
	)
)); ?>

