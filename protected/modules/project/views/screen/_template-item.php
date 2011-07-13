<?php

/*
 * Sub item to show an individual template
 */
?>
<?php $applied = false; ?>
<?php $selected = (isset($screenId)) ? (($applied = $template->isAppliedTo($screenId)) ? 'selected':'' ): ''; ?>
<li class="template <?php echo $selected; ?> line">
	<div class="unit pas">
		<input id="template-<?php echo $template->id; ?>" name="template[]" <?php echo $applied ? 'checked="checked"': ''; ?> type="checkbox" value="<?php echo $template->id; ?>"/> 	
		<label for="template-<?php echo $template->id; ?>"><?php echo $template->name; ?></label>
	</div>
	<div class="lastUnit pas">
		
	</div>	
</li>