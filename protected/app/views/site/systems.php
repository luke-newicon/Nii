<?php
$this->pageTitle='Systems - '.Yii::app()->name;
$this->breadcrumbs=array(
	'Systems',
);?>

<h1>Systems</h1>
<?php $this->widget('modules.nii.widgets.markdown.NMarkdownInput',array('value'=>'tests','name'=>'test')); ?>
<?php $this->widget('modules.nii.widgets.markdown.NMarkdownInput',array('value'=>'tests','name'=>'test','htmlOptions'=>array('style'=>'width:100%;height:160px;border:1px solid #ccc;margin:0px;border:0px;'))); ?>
<?php $this->widget('modules.nii.widgets.markdown.NMarkdownInput',array('model'=>$projectTask,'attribute'=>'description','htmlOptions'=>array('style'=>'width:100%;height:160px;border:1px solid #ccc;margin:0px;border:0px;'))); ?>