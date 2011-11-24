<div class="page-header">
	<h2><?php echo $this->t('Edit Contact'); ?></h2>
	<div class="action-buttons">
		<?php
			if ($c->id)
				echo NHtml::trashButton($c, 'contact', '/contact/admin/', 'Successfully deleted '.$c->name);
		?>
	</div>
</div>


<?php

$this->renderPartial(
	'edit/_general',
	array(
		'c'=>$c,
		'type'=>$c->contact_type,
		'action'=>array('admin/edit','id'=>$c->id,'type'=>$c->contact_type),
		'event'=>$event,
	)
);