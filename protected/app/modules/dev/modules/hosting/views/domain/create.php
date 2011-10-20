<?php
$this->breadcrumbs=array(
	'Hosting Domains'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List HostingDomain', 'url'=>array('index')),
	array('label'=>'Manage HostingDomain', 'url'=>array('admin')),
);
?>

<h1>Create HostingDomain</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>