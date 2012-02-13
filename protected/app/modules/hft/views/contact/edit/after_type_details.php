<div class="line">
<?php if ($c->contact_type=='Person') { ?>
	<div class="unit size1of2 field inlineInput">
		<div class="unit size1of3"><?= $form->labelEx($c,'company_name') ?></div>
		<div class="lastUnit">
			<div class="input">
				<?php echo $form->textField($c, 'company_name'); ?>
			</div>
			<?php echo $form->error($c, 'company_name'); ?>
		</div>
	</div>
<?php } ?>
	<div class="unit size1of2 field inlineInput pbm">
		<div class="unit size1of3"><?= $form->labelEx($c,'company_position') ?></div>
		<div class="lastUnit">
			<div class="input">
				<?php echo $form->textField($c, 'company_position'); ?>
			</div>	
			<?php echo $form->error($c, 'company_position'); ?>
		</div>
	</div>
</div>