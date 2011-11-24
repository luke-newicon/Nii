<div class="page-header">
	<h2><?php echo $this->t('Create an Event') ?></h2>
</div>	
<?php 
$this->renderPartial('edit/_editEvent', array(
	'model'=>$model,
	'action'=>'create',
));