<h2><?php echo $this->t('Churches') ?></h2>
<?php 
$this->widget('app.widgets.grid.TGridView', array(
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'id'=> THelper::getGridId(),
	'enableButtons'=>true,
	'scopes' => array(
		'items' => array(
			'default' => 'All',
		),
	),
	'columns'=>$model->columns(Setting::visibleColumns('Church')),
));