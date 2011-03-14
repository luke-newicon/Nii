<?php
$this->breadcrumbs=array(
	'Projects Issues'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ProjectsIssue', 'url'=>array('index')),
	array('label'=>'Create ProjectsIssue', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('projects-issue-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Projects Issues</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'projects-issue-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'type',
		'name',
		'description',
		'status',
		'project_id',
		/*
		'created',
		'created_by',
		'completed',
		'completed_by',
		'deleted',
		'estimated_time',
		'out_of_scope',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
