<legend>Communication</legend>
<div class="control-group">
	<label class="control-label">Receives</label>
	<div class="controls">
		<?php echo $form->checkBoxField($c, 'receive_emails'); ?>
		<?php echo $form->checkBoxField($c, 'receive_letters'); ?>
		<span class="help-block">Checked box indicates that the custom is happy to receive communication using the specified method.</span>
	</div>
</div>
<?php echo $form->field($c, 'source_id', 'dropDownList', HftContactSource::getSourcesArray(), array('prompt'=>'Select')); ?>