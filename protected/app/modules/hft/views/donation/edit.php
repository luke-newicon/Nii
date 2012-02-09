<div class="page-header">
	<h1><?php echo $this->t('Edit a Donation'); ?></h1>
	<div class="pull-right">
		<?php echo NHtml::trashButton($model, 'donation', '/hft/donation/', 'Successfully deleted donation'); ?>
	</div>
</div>
<?php 
$this->renderPartial('edit/_editDonation', array(
	'model'=>$model,
	'action'=>'edit',
));