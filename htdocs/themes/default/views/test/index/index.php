<?php
$this->widget('nii.widgets.grid.NGridView', array(
	'dataProvider' => $dataProvider,
	'filter' => $model,
	'columns' => array(
		'id',
	),
));