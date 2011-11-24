<div class="page-header">
	<h2><?php echo $this->t('Add a Donation'); ?></h2>
</div>
<?php 
$this->renderPartial('edit/_editDonation', array(
	'model'=>$model,
	'action'=>'create',
));