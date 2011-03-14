<?php
$this->breadcrumbs=array(
	'Hosting Domains'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List HostingDomain', 'url'=>array('index')),
	array('label'=>'Create HostingDomain', 'url'=>array('create')),
	array('label'=>'Update HostingDomain', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete HostingDomain', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage HostingDomain', 'url'=>array('admin')),
);
?>

<h1>View HostingDomain #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'domain',
		'registered_date',
		'expires_date',
		'registered_with',
		'contact_id',
	),
)); ?>
