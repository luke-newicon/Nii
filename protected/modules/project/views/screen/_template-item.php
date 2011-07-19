<?php

/*
 * Sub item to show an individual template
 */
?>
<?php $applied = false; ?>
<?php $selected = (isset($screenId)) ? (($applied = $template->isAppliedTo($screenId)) ? 'selected':'' ): ''; ?>
<li data-id="<?php echo $template->id; ?>" class="template <?php echo $selected; ?> line pts pbs" onmouseover="$(this).addClass('hover')" onmouseout="$(this).removeClass('hover')">
	<div class="display">
		<div class="unit size4of5">
			<input id="template-<?php echo $template->id; ?>" name="template[]" <?php echo $applied ? 'checked="checked"': ''; ?> type="checkbox" value="<?php echo $template->id; ?>"/> 	
			<label for="template-<?php echo $template->id; ?>"><?php echo $template->name; ?></label>
		</div>
		<div class="lastUnit txtR templateFuns">
			<a data-tip="{gravity:'sw'}" title="Edit" onclick="$(this).closest('.display').hide().closest('.template').find('.editForm').show().find('input').focus();return false;" href="#"><span class="fugue fugue-pencil"></span></a>
			<a class="deleteTemplate" href="#" data-tip="{gravity:'sw'}" title="Delete"><span class="fugue fugue-minus-circle"></span></a>
		</div>	
	</div>
	<div class="editForm" style="display:none;">
		<div class="unit size4of5">
			<div class="inputBox"><input data-id="<?php echo $template->id; ?>" id="template-<?php echo $template->id; ?>" value="<?php echo $template->name; ?>" /></div>
		</div>
		<div class="lastUnit txtR templateFuns">
			<a class="saveTemplate" href="#" data-tip="{gravity:'sw'}" title="Save"><span class="fugue fugue-disk-black"></span></a>
			<a href="#" data-tip="{gravity:'sw'}" title="Cancel" onclick="$(this).closest('.editForm').hide().closest('.template').find('.display').show();return false;"><span class="fugue fugue-cross"></span></a>
		</div>	
	</div>
</li>