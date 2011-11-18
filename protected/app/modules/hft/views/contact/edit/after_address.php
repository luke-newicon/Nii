<div class="line field topLine">
	<div class="unit size1of6"><?= $form->labelEx($c,'source_id') ?></div>
	<div class="lastUnit">
		<div class="input w170"><?php echo $form->dropDownList($c, 'source_id', HftContactSource::getSourcesArray(), array('prompt'=>'select...')); ?></div>
		<?php echo $form->error($c,'source_id'); ?>
	</div>
</div>