<div class="media">
	<a href="<?php echo $contact->getUrl(); ?>" class="img">
		<?php $this->widget('crm.components.CrmImage',array('contact'=>$contact,'size'=>24)); ?>
	</a>
	<div class="bd">
		<p class="mtn mbn">
			<?php if($term!=''):?>
				<?php echo $contact->name($term); ?>
			<?php else: ?>
			<strong><?php echo $contact->getNamePartOne(); ?></strong> <?php echo $contact->getNamePartTwo($term); ?>
			<?php endif; ?>
		</p>
		
		<!--<?php if($contact->hasCompany()):?>
			<p class="mtn">
				<?php  echo $contact->getCompany()->company; ?>
			</p>
		<?php endif;?>
		
	--></div>
</div>