<?php
$this->breadcrumbs=array(
	'Hosting Hostings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List HostingHosting', 'url'=>array('index')),
	array('label'=>'Manage HostingHosting', 'url'=>array('admin')),
);
?>

<h1>Create HostingHosting</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>