<h2><?php echo $this->t('Students') ?></h2>
<?php 
$this->widget('app.widgets.grid.TGridView', array(
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'id'=> THelper::getGridId(),
	'scopes' => array(
		'default'=>$model->defaultScope,
		'items' => array(
			'active' => array(
				'label' => 'Current',
				'description' => 'Display students who are currently enrolled onto a course'
			),
			'inactive' => array(
				'label' => 'Previous',
				'description' => 'Display students who are not currently enrolled onto a course'
			),
			'default' => 'All',
			'postgrad' => array(
				'label' => 'Postgrads',
				'description' => 'All students current on a postgrad programme',
			),
		),
	),
	'enableButtons'=>true,
	'columns'=>$model->columns(Setting::visibleColumns('Student')),
));