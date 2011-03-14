<?php
$this->breadcrumbs=array(
	'Hosting Hostings',
);

$this->menu=array(
	array('label'=>'Create HostingHosting', 'url'=>array('create')),
	array('label'=>'Manage HostingHosting', 'url'=>array('admin')),
);
?>

<h1>Hosting Hostings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
