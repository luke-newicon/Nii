<?php
$this->breadcrumbs=array(
	'Hosting Hostings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List HostingHosting', 'url'=>array('index')),
	array('label'=>'Create HostingHosting', 'url'=>array('create')),
	array('label'=>'Update HostingHosting', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete HostingHosting', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage HostingHosting', 'url'=>array('admin')),
);
?>

<h1>View HostingHosting #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'domain_id',
		'server',
		'product',
		'price',
		'expires_date',
		'start_date',
		'contact_id',
	),
)); ?>
