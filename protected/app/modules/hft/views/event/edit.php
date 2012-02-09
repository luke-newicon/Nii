<div class="page-header">
	<h1><?php echo $this->t('Edit Event'); ?><?php echo ($model->id) ? ' - '.$model->name : ''; ?></h1>
	<div class="pull-right">
		<?php echo NHtml::trashButton($model, 'event', '/hft/event/', 'Successfully deleted event'); ?>
	</div>
</div>
<?php 
$this->renderPartial('edit/_editEvent', array(
	'model'=>$model,
	'action'=>'edit',
));