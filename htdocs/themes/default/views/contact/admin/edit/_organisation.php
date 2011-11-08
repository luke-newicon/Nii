<div class="line">
	<div class="unit size1of2 field inlineInput">
		<div class="unit size1of3"><?= $form->labelEx($c,'name') ?></div>
		<div class="lastUnit">
			<div class="input">
				<?php echo $form->textField($c, 'company_name', array('class' => 'inputInline', 'size' => '30')); ?>
			</div>
			<?php echo $form->error($c, 'company_name'); ?>
		</div>
	</div>
	<div class="unit size1of2 field inlineInput">
		<div class="unit size1of3"><?= $form->labelEx($c,'contact_name') ?></div>
		<div class="lastUnit">
			<div class="input">
				<?php echo $form->textField($c, 'contact_name', array('class' => 'inputInline', 'size' => '30')); ?>
			</div>	
			<?php echo $form->error($c, 'contact_name'); ?>
		</div>
	</div>
</div>