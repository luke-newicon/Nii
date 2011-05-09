<?php
$this->pageTitle='Systems - '.Yii::app()->name;
$this->breadcrumbs=array(
	'Systems',
);?>

<h1>Systems</h1>
<?php $this->widget('modules.nii.widgets.markdown.NMarkdownInput',array('value'=>'tests','name'=>'test')); ?>
<?php $this->widget('modules.nii.widgets.markdown.NMarkdownInput',array('value'=>'tests','name'=>'test')); ?>
<?php $this->widget('modules.nii.widgets.markdown.NMarkdownInput',array('model'=>$projectTask,'attribute'=>'description')); ?>
<?php

$model = ProjectProject::model()->findByPk(51);
$this->widget('modules.nii.widgets.notes.NNotes',array('model'=>$model,'canAdd'=>true,'ajaxController'=>'nii/index/NNotes'));?>

<?php 
$model = ProjectProject::model()->findByPk(52);
$this->widget('modules.nii.widgets.notes.NNotes',array('model'=>$model,'canAdd'=>true,'ajaxController'=>'nii/index/NNotes'));?>

<?php
$model = ProjectProject::model()->findByPk(53);
$this->widget('modules.nii.widgets.notes.NNotes',array('model'=>$model,'canAdd'=>true,'ajaxController'=>'nii/index/NNotes','title'=>'Item Notes'));?>