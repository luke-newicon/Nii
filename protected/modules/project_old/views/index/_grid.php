<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-project-grid',
	'dataProvider'=>$project->search(),
	'filter'=>$project,
	'columns'=>array(
		array('name'=>'name','value'=>'$data->nameCol()','type'=>'html'),
		'code',
		'description',
		'completion_date',
		'estimated_time',
		array('name'=>'recorded_time','value'=>'$data->recordedTimeCol()','type'=>'html'),
		'created',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}'
		),
	),
)); ?>