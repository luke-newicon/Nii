<?php
$this->breadcrumbs=array(
	'Hosting Domains'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List HostingDomain', 'url'=>array('index')),
	array('label'=>'Create HostingDomain', 'url'=>array('create')),
	array('label'=>'View HostingDomain', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage HostingDomain', 'url'=>array('admin')),
);
?>

<h1>Update HostingDomain <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>