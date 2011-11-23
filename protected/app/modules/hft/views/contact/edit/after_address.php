<div class="line field topLine">
	<div class="unit size1of6"><?= $form->labelEx($c,'newsletter') ?></div>
	<div class="lastUnit">
		<div><?php echo $form->checkBox($c, 'newsletter'); ?></div>
		<?php echo $form->error($c,'newsletter'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit size1of6"><?= $form->labelEx($c,'source_id') ?></div>
	<div class="lastUnit">
		<div class="input w170"><?php echo $form->dropDownList($c, 'source_id', HftContactSource::getSourcesArray(), array('prompt'=>'select...')); ?></div>
		<?php echo $form->error($c,'source_id'); ?>
	</div>
</div>