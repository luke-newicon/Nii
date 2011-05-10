<div class="line">
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'project-project-grid',
		'dataProvider'=>$project->search(),
		'filter'=>$project,
		'columns'=>array(
			'code',
			array('name'=>'name','value'=>'$data->nameCol()','type'=>'html'),
			'started',
			'date_due',
			'completion_date',
			'estimated_time',
			array('name'=>'recorded_time','value'=>'$data->recordedTimeCol()','type'=>'html'),
			array(
				'class'=>'CButtonColumn',
				'template'=>'{update}{delete}Record time'
			),
		),
	)); ?>
</div>