<?php

/*
 * Sub item to show an individual template
 */
?>
<?php $applied = false; ?>
<?php $selected = (isset($screenId)) ? (($applied = $template->isAppliedTo($screenId)) ? 'selected':'' ): ''; ?>
<li class="template <?php echo $selected; ?>">
	<label>
		<input name="template[]" <?php echo $applied ? 'checked="checked"': ''; ?> type="checkbox" value="<?php echo $template->id; ?>"/> <?php echo $template->name; ?>
		<br />Delete | Edit
	</label>
</li>