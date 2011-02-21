<?php
$this->breadcrumbs=array(
	'Crm Contacts'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CrmContact', 'url'=>array('index')),
	array('label'=>'Create CrmContact', 'url'=>array('create')),
	array('label'=>'View CrmContact', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CrmContact', 'url'=>array('admin')),
);
?>

<h1>Update CrmContact <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>