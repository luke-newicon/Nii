<?php
$this->breadcrumbs=array(
	'Crm Contacts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CrmContact', 'url'=>array('index')),
	array('label'=>'Manage CrmContact', 'url'=>array('admin')),
);
?>

<h1>Create CrmContact</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>