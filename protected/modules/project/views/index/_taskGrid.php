<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $task->search(),
    'filter' => $task,
    'columns' => array(
	array('name' => 'name', 'value' => '$data->nameCol()', 'type' => 'html','headerHtmlOptions'=>array('class'=>'topperGreyBar')),
	array('name' => 'type', 'value' => '$data->getType("$data->type")', 'filter' => $task->getTaskTypes(),'headerHtmlOptions'=>array('class'=>'topperGreyBar')),
	array('name'=>'description','headerHtmlOptions'=>array('class'=>'topperGreyBar')),
	array('name'=>'created','headerHtmlOptions'=>array('class'=>'topperGreyBar')),
	array('name' => 'estimated_time','headerHtmlOptions'=>array('class'=>'topperGreyBar')),
	array('name' => 'recorded_time', 'filter' => '','headerHtmlOptions'=>array('class'=>'topperGreyBar')),
	array('name' => 'out_of_scope', 'value' => '$data->outOfScopeCol()', 'filter' => array('No', 'Yes'),'headerHtmlOptions'=>array('class'=>'topperGreyBar')),
	array('class' => 'CButtonColumn',
	    'updateButtonUrl' => '"/Nii/project/task/update/id/".$data->id',
	    'deleteButtonUrl' => '"/Nii/project/task/delete/id/".$data->id',
	    'template' => '{update}{delete}','headerHtmlOptions'=>array('class'=>'topperGreyBar')
	),
    ),
    'emptyText'=>'There are no tasks currently associated with this project'
)); ?>