<?php
$this->breadcrumbs=array(
	'Project Time Records'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ProjectTimeRecord', 'url'=>array('index')),
	array('label'=>'Create ProjectTimeRecord', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('project-time-record-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Project Time Records</h1>

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
	'id'=>'project-time-record-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'date_of_work',
		'time_spent',
		'issue_id',
		'description',
		'added',
		/*
		'added_by',
		'type',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
