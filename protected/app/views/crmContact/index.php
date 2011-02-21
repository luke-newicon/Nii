<?php
$this->breadcrumbs=array(
	'Crm Contacts',
);

$this->menu=array(
	array('label'=>'Create CrmContact', 'url'=>array('create')),
	array('label'=>'Manage CrmContact', 'url'=>array('admin')),
);
?>

<h1>Crm Contacts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
