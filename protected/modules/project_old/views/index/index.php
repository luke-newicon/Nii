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
<h1>Active Projects</h1>
<?php $this->renderPartial('/index/partials/_status',array('overallProjectStats'=>$project->getProjectStats())) ?>
<?php $this->renderPartial('/index/partials/_grid',array('project'=>$project)) ?>