<div class="line field">
	<div class="unit size1of6"><?= $form->labelEx($c,'source_id') ?></div>
	<div class="lastUnit">
		<div class="input w170"><?php echo $form->dropDownList($c, 'source_id', HftContactSource::getSourcesArray()); ?></div>
		<?php echo $form->error($c,'account_number'); ?>
	</div>
</div>