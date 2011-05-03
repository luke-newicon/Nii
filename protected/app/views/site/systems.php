<?php
$this->pageTitle='Systems - '.Yii::app()->name;
$this->breadcrumbs=array(
	'Systems',
);?>

<h1>Systems</h1>
<?php $this->widget('modules.nii.widgets.markdown.NMarkdownInput',array('value'=>'tests','name'=>'test')); ?>
<?php $this->widget('modules.nii.widgets.markdown.NMarkdownInput',array('value'=>'tests','name'=>'test')); ?>
<?php $this->widget('modules.nii.widgets.markdown.NMarkdownInput',array('model'=>$projectTask,'attribute'=>'description')); ?>