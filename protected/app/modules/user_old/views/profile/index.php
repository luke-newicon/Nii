<?php if ($contact !== null): ?>
<div class="line">
	<div class="unit gMail txtR">
		<?php $this->widget('crm.components.CrmImage',array(
			'contact'=>$contact,
			'size'=>150,
			'edit'=>true,
			'htmlOptions'=>array('style'=>'display:inline-block;'))); ?>
	</div>
	<div class="lastUnit plm" style="border-left:1px solid #ccc;">
		<h2 class="mtn"><?php echo $contact->first_name .' '. $contact->last_name; ?></h2>
	</div>
</div>
<?php else: ?>


<?php endif; ?>
