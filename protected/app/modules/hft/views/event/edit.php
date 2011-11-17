<h2><?php echo $this->t('Edit an Event'); ?></h2>
<?php 
$this->renderPartial('edit/_editEvent', array(
	'model'=>$model,
	'action'=>'edit',
));