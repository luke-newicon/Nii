<style>
.labelTag{background-color:#aaa;border-radius:10px;-moz-border-radius:10px;color:#fff;padding:0px 5px 0px 5px;font-size:10px;}
</style>
<div class="media">
	<a href="#" class="img">
		<?php echo $contact->getImage(array('size'=>70)); ?>
	</a>
	<div class="bd">
  		<h1>
  			<a href="<?php echo Nworx::url('crm/detail/index/'.$contact->id()); ?>">
    		<?php if($contact->isPerson()): ?>
				<?php echo $contact->contact_first_name . ' ' . $contact->contact_last_name; ?>
			<?php else: ?>
				<?php echo $contact->contact_company; ?>
			<?php endif; ?>
			</a>
		</h1>
		<?php if($contact->isPerson() && $contact->hasCompany()): ?>
		<p class="mtn"><?php echo $contact->getCompany()->contact_company; ?></p>
		<?php endif; ?>
	</div>
</div>
<ul>
<?php foreach($contact->emails as $email): ?>
	<li><span class="icon fam-email"></span> <?php echo $email->address; ?> <?php if ($email->label!=''): ?><span class="labelTag"><?php echo $email->label; ?></span><?php endif; ?></li>
<?php endforeach; ?>
</ul>
<ul>
<?php foreach($contact->phones as $phone): ?>
	<li><span class="icon fam-phone"></span> <?php echo $phone->number; ?> <?php if ($phone->label!=''): ?><span class="labelTag"><?php echo $phone->label; ?></span><?php endif; ?> </li>
<?php endforeach; ?>
</ul>
<ul>
<?php foreach($contact->websites as $web): ?>
	<li><span class="icon fam-page-white-world"></span> <?php echo $web->address; ?> <?php if ($web->label!=''): ?><span class="labelTag"><?php echo $web->label; ?></span><?php endif; ?> </li>
<?php endforeach; ?>
</ul>
<ul>
<?php foreach($contact->addresses as $address): ?>
	<li class="line">
		<div class="unit" style="width:26px;">
			<span class="icon fam-house"></span>
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
		<?php echo $this->com('crm/card', array('contact'=>$c)); ?>
	<?php endforeach; ?>
<?php endif; ?>

<?php echo NPage::ajaxLink('facebook', 'crm/index/facebook-lookup/'.$contact->id(), array(
	'live'=>false,
	'success'=>'js:function(r){alert(r);}'
)); ?>