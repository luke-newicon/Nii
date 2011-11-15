<div class="line field">
	<div class="unit size1of6"><?= $form->labelEx($c,'account_number') ?></div>
	<div class="lastUnit">
		<div class="input w170"><?php echo $form->textField($c, 'account_number', array('size' => 30)); ?></div>
		<?php echo $form->error($c,'account_number'); ?>
	</div>
</div>