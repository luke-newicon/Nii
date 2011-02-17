<ul class="userList man" style="overflow:hidden;">
	<?php $l = ''; ?>
	<?php foreach ($contacts as $i=>$c): $n = substr(strtoupper($c->name),0,1); ?>
		<?php if($l != $n): $l = $n; ?>
			<li class="letter"><a name="<?php echo $l; ?>"><?php echo $l; ?></a></li>
		<?php endif; ?>
		<li class="contact" id="cid_<?php echo $c->id(); ?>">
			<?php echo $this->com('crm/card',array('contact'=>$c,'term'=>$term));	?>
		</li>
	<?php endforeach; ?>
</ul>