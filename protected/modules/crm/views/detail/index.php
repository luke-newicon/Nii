<style>
.labelTag{background-color:#aaa;border-radius:10px;-moz-border-radius:10px;color:#fff;padding:0px 5px 0px 5px;font-size:10px;}
</style>
<div class="media">
	<a href="#" class="img">
		<?php $this->widget('crm.components.CrmImage',array('size'=>70,'contact'=>$contact)); ?>
	</a>
	<div class="bd">
  		<h1>
  			<a href="<?php echo NHtml::url('crm/detail/index/'.$contact->id()); ?>">
    		<?php if($contact->isPerson()): ?>
				<?php echo $contact->first_name . ' ' . $contact->last_name; ?>
			<?php else: ?>
				<?php echo $contact->company; ?>
			<?php endif; ?>
			</a>
		</h1>
		<?php if($contact->isPerson() && $contact->hasCompany()): ?>
		<p class="mtn"><?php echo $contact->getCompany()->company; ?></p>
		<?php endif; ?>
	</div>
</div>
<?php if($contact->emails): ?>
<h4>Email</h4>
<?php endif; ?>
<ul>
<?php foreach($contact->emails as $email): ?>
	<li><span class="icon fam-email">&nbsp;</span> <?php echo $email->address; ?> <?php if ($email->label!=''): ?><span class="labelTag"><?php echo $email->label; ?></span><?php endif; ?></li>
<?php endforeach; ?>
</ul>
<?php if($contact->phones): ?>
<h4>Phone</h4>
<?php endif; ?>
<ul>
<?php foreach($contact->phones as $phone): ?>
	<li><span class="icon fam-phone">&nbsp;</span> <?php echo $phone->number; ?> <?php if ($phone->label!=''): ?><span class="labelTag"><?php echo $phone->label; ?></span><?php endif; ?> </li>
<?php endforeach; ?>
</ul>
<?php if($contact->websites): ?>
<h4>Websites</h4>
<?php endif; ?>
<ul>
<?php foreach($contact->websites as $web): ?>
	<li><span class="icon fam-page-white-world">&nbsp;</span> <?php echo $web->address; ?> <?php if ($web->label!=''): ?><span class="labelTag"><?php echo $web->label; ?></span><?php endif; ?> </li>
<?php endforeach; ?>
</ul>
<?php if($contact->addresses): ?>
<h4>Address</h4>
<?php endif; ?>
<ul>
<?php foreach($contact->addresses as $address): ?>
	<li class="line">
		<div class="unit" style="width:26px;">
			<span class="icon fam-house">&nbsp;</span>
		</div>
		<address class="lastUnit">
			<?php echo $address->address(); ?>
			<?php if ($address->label!=''): ?><span class="labelTag"><?php echo $address->label; ?></span><?php endif; ?>
			<a target="_blank" href="<?php echo $address->mapLink(); ?>">show on map</a>
		</address>
		
	</li>
<?php endforeach; ?>
</ul>

<?php if($contact->isCompany()): ?>
	<?php foreach($contact->contacts as $c): ?>
		<?php $this->widget('crm.components.CrmCard', array('contact'=>$c)); ?>
	<?php endforeach; ?>
<?php endif; ?>

<?php //echo NHtml::ajaxLink('facebook', 'crm/index/facebook-lookup/'.$contact->id(), array(
//	'live'=>false,
//	'success'=>'js:function(r){alert(r);}'
//)); ?>