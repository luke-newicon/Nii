<div class="line field">
	<div class="unit size1of6"><?= $form->labelEx($c,'status') ?></div>
	<div class="lastUnit">
		<div class="input w120"><?php echo $form->dropDownList($c, 'status', NHtml::enumItem($c, 'status')); ?></div>
		<?php echo $form->error($c,'status'); ?>
	</div>
</div>
<div class="line field topLine">
	<div class="unit size1of6"><span class="lbl"><?php echo $this->t('Communication') ?></span></div>
	<div class="lastUnit">
		<div><?php echo $form->checkBox($c, 'receive_emails'); ?><?= $form->labelEx($c,'receive_emails', array('style' => 'display: inline-block; margin-left: 5px;')) ?></div>
		<div><?php echo $form->checkBox($c, 'receive_letters'); ?><?= $form->labelEx($c,'receive_letters', array('style' => 'display: inline-block; margin-left: 5px;')) ?></div>
		<span class="help-block">Checked box indicates that the custom is happy to receive communication using the specified method.</span>
	</div>
</div>
<div class="line field">
	<div class="unit size1of6"><?= $form->labelEx($c,'source_id') ?></div>
	<div class="lastUnit">
		<div class="input w400"><?php echo $form->dropDownList($c, 'source_id', HftContactSource::getSourcesArray(), array('prompt'=>'select...')); ?></div>
		<?php echo $form->error($c,'source_id'); ?>
	</div>
</div>