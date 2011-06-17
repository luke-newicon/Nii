<ul class="userList man" style="overflow:hidden;">
	<?php $l = ''; ?>
	<?php foreach ($contacts as $i=>$c): $n = substr(strtoupper($c->sortName()),0,1); ?>
		<?php if($l != $n): $l = $n; ?>
			<li class="letter"><a name="<?php echo $l; ?>"><?php echo $l; ?></a></li>
		<?php endif; ?>
		<li class="contact" data-type="<?php echo $c->isCompany()?'company':'contact'; ?>" data-id="<?php echo $c->id(); ?>" id="cid_<?php echo $c->id(); ?>">
			<?php $this->widget('crm.components.CrmCard',array('contact'=>$c,'term'=>$term));	?>
		</li>
	<?php endforeach; ?>
</ul>