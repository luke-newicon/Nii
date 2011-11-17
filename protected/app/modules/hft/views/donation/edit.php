<h2><?php echo $this->t('Edit a Donation'); ?></h2>
<?php 
$this->renderPartial('edit/_editDonation', array(
	'model'=>$model,
	'action'=>'edit',
));