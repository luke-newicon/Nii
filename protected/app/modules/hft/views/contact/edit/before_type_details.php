<div class="line field">
	<div class="unit size1of6"><?= $form->labelEx($c,'classification_id') ?></div>
	<div class="lastUnit">
		<div class="input w120"><?php echo $form->dropDownList($c, 'classification_id', HftContactClassification::getClassificationsArray(), array('prompt'=>'select...')); ?></div>
		<?php echo $form->error($c,'classification_id'); ?>
	</div>
</div>
<div class="line field">
	<div class="unit size1of6"><?= $form->labelEx($c,'id') ?></div>
	<div class="lastUnit">
		<div class="w170"><?php echo $c->id; ?></div>
	</div>
</div>