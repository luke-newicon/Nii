<?php
$this->breadcrumbs=array(
	'Project Project Assigneds'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ProjectProjectAssigned', 'url'=>array('index')),
	array('label'=>'Create ProjectProjectAssigned', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('project-project-assigned-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Project Project Assigneds</h1>

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
	'id'=>'project-project-assigned-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'project_id',
		'user_id',
		'project_role',
		'added',
		'assigned_by',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>