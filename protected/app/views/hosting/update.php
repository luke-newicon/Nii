<?php
$this->breadcrumbs=array(
	'Hosting Hostings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List HostingHosting', 'url'=>array('index')),
	array('label'=>'Create HostingHosting', 'url'=>array('create')),
	array('label'=>'View HostingHosting', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage HostingHosting', 'url'=>array('admin')),
);
?>

<h1>Update HostingHosting <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>