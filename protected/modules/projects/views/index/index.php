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
					'headerHtmlOptions' => array('style' => 'width:200px;'), 'type'=>'datetime'),
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

.notelet{padding:0px;}
.ui-dialog.notelet,.ui-dialog.notelet,.ui-dialog.notelet .ui-dialog-content{-moz-border-radius:0px;-moz-box-shadow: -6px 9px 13px #BBBBBB;-webkit-box-shadow: -6px 9px 13px #BBBBBB;}
.ui-dialog.notelet .ui-widget-header,.ui-dialog.notelet .ui-dialog-content{background-color: #FBFDDD;}
.ui-dialog.notelet,.ui-dialog.notelet,.ui-dialog.notelet .ui-dialog-titlebar{border:none;background-image: none;}


.grid-view .delButton, .grid-view .button-column{width:18px;}
</style>

<script>
//	$('.project_name_link').click(function() {
//	  $('#issueCard').dialog('open');
//	 var itemId = ($(this).parent().siblings('.itemId').html());
//	  $('#issueCard').dialog( "option", "title", $(this).html());
//	  $('#issueCard').html('loading info for: '+ itemId);
//	});

	$('.update').click(function() {
		$('#updateDialog').dialog('open');
		var itemId = ($(this).parent().siblings('.itemId').html());
		var name = ($(this).parent().siblings('.itemName').html());
		 $('#updateDialog').dialog( "option", "title", name);
		 $('#updateDialog').html('loading info for: '+ itemId);
		 return false;
	});
</script>

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