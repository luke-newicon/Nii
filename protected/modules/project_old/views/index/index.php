<?php
$this->breadcrumbs=array('Projects');

$this->menu=array(
	array('label'=>'Project',
	'items'=>array(
		array('label'=>'Create', 'url'=>array('create')),
		)
	),
);
?>
<h1>All Projects</h1>
<?php $this->renderPartial('_grid',array('project'=>$project)) ?>