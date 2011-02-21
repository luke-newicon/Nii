<?php
$this->breadcrumbs=array(
	'Crm Contacts'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List CrmContact', 'url'=>array('index')),
	array('label'=>'Create CrmContact', 'url'=>array('create')),
	array('label'=>'Update CrmContact', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CrmContact', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CrmContact', 'url'=>array('admin')),
);
?>

<h1>View CrmContact #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'first_name',
		'last_name',
		'company',
		'company_id',
		'type',
	),
)); ?>
