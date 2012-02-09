<div class="page-header">
	<h1><?php echo $this->t('Add a Donation'); ?></h1>
</div>
<?php 
$this->renderPartial('edit/_editDonation', array(
	'model'=>$model,
	'action'=>'create',
));