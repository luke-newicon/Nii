<?php if ($dialog==null) { ?><h2><?php echo $this->t('Create a Contact'); ?></h2><?php } ?>
<?php

$view = ($type == 'none') ? 'edit/_selectType' : 'edit/_general';
$this->renderPartial(
	$view,
	array(
		'c'=>$c,
		'type'=>$type,
		'action'=>array('admin/create','type'=>$type),
	)
);