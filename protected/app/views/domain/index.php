<?php
$this->breadcrumbs=array(
	'Hosting Domains',
);

$this->menu=array(
	array('label'=>'Create HostingDomain', 'url'=>array('create')),
	array('label'=>'Manage HostingDomain', 'url'=>array('admin')),
);
?>

<h1>Hosting Domains</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
