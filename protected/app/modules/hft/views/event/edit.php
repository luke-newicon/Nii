<div class="page-header">
	<h2><?php echo $this->t('Edit an Event'); ?></h2>
	<div class="pull-right">
		<?php echo NHtml::trashButton($model, 'event', 'event/index', 'Successfully deleted event'); ?>
	</div>
</div>
<?php 
$this->renderPartial('edit/_editEvent', array(
	'model'=>$model,
	'action'=>'edit',
));