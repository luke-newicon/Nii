<h2><?php echo $this->t('Editing '.$c->contact_type.'\'s Contact Details'); ?></h2>
<?php

$this->renderPartial(
	'edit/_general',
	array(
		'c'=>$c,
		'type'=>$c->contact_type,
		'action'=>array('/contact/edit','id'=>$c->id,'type'=>$type),
	)
);