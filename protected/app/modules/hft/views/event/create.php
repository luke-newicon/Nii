<div class="page-header">
	<h1><?php echo $this->t('Create an Event') ?></h1>
</div>	
<?php 
$this->renderPartial('edit/_editEvent', array(
	'model'=>$model,
	'action'=>'create',
));