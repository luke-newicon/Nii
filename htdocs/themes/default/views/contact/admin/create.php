<h2><?php echo $this->t('Create New Contact'); ?></h2>
<?php

$view = ($type == 'none') ? 'edit/_selectType' : 'edit/_general';
$this->renderPartial(
	$view,
	array(
		'c'=>$c,
		'type'=>$type,
		'action'=>array('/contact/create','type'=>$type),
	)
);