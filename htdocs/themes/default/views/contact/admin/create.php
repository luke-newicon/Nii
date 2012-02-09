<?php if ($dialog==null) : ?>
<div class="page-header">
	<h1><?php echo $this->t('Create a Contact'); ?></h1>
</div>
<?php endif; ?>
<?php
$view = ($type == 'none') ? 'edit/_selectType' : 'edit/_general';
$this->renderPartial(
	$view,
	array(
		'c'=>$c,
		'type'=>$type,
		'action'=>array('admin/create','type'=>$type),
		'event'=>$event,
	)
);