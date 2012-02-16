<div class="page-header">
	<h2><?php echo $this->t('Edit '.$c->contact_type); ?><?php echo ($c->id) ? ' - '.$c->displayName : ''; ?></h2>
	<div class="action-buttons">
		<?php
			if ($c->contact_type=='Person')
				$newType = 'Organisation';
			else
				$newType = 'Person';
			echo NHtml::link ('Make into Organisation', NHtml::normalizeUrl(array('/contact/admin/changeType','id'=>$c->id, 'newType' => $newType)), array('style'=>'margin-right: 5px;'));
			
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