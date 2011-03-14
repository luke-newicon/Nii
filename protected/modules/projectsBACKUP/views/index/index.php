<?php
$this->breadcrumbs=array('Projects Projects');
$this->menu=array(array('label'=>'Create Project', 'url'=>array('create')),);?>

<h1>Projects Projects</h1>

<?php
$this->widget('zii.widgets.grid.CGridView',
		array('dataProvider' => $model->search(),
			'filter' => $model,
			'nullDisplay' => '-',
			'columns' => array(
				array('name' => 'id',
					'id' => 'project_id',
					'headerHtmlOptions' => array('style' => 'width:20px;'),
					'htmlOptions' => array('class' => 'itemId')),
				array('value' => '$data->projectNameFilter()',
					'name' => 'name',
					'headerHtmlOptions' => array('style' => 'width:200px;'),
					'type' => 'html', 'htmlOptions' => array('class' => 'itemName')),
				array('name' => 'created',
					'id' => 'project_created',
					'headerHtmlOptions' => array('style' => 'width:200px;')),
				array('name' => 'status',
					'filter' => $model->statusDropdown(),
					'headerHtmlOptions' => array('style' => 'width:200px;')),
				array('name' => 'createdBy.username',
					'id' => 'project_created',
					'header' => 'Created By'),
				array('class' => 'CButtonColumn',
					'template' => '{delete}',
					'headerHtmlOptions' => array('class' => 'delButton')))));?>

<style>
.grid-view .delButton, .grid-view .button-column{width:18px;}
</style>

<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'updateDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Dialog box 1',
        'autoOpen'=>false,
		'dialogClass'=>'notelet'
),));
$this->endWidget('zii.widgets.jui.CJuiDialog');

?>