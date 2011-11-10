<?php

/*
 * Sub item to show an individual template
 */
?>
<?php $applied = false; ?>
<?php $selected = (isset($screen->id)) ? (($applied = $template->isAppliedTo($screen)) ? 'selected':'' ): ''; ?>
<li data-id="<?php echo $template->id; ?>" class="template <?php echo $selected; ?> line pts pbs" onmouseover="$(this).addClass('hover')" onmouseout="$(this).removeClass('hover')">
	<div class="display line">
		<div class="unit size4of5">
			<input id="template-<?php echo $template->id; ?>" name="template[]" <?php echo $applied ? 'checked="checked"': ''; ?> type="checkbox" value="<?php echo $template->id; ?>"/> 	
			<label class="templateName" for="template-<?php echo $template->id; ?>"><?php echo $template->name; ?></label>
		</div>
		<div class="lastUnit txtR">
			<div class="templateFuns">
				<a class="edit" style="display:inline-block;" data-tip="{gravity:'sw'}" title="Edit" href="#"><span class="icon fugue-pencil mrn"></span></a>
				<a style="display:inline-block;" class="deleteTemplate" href="#" data-tip="{gravity:'sw'}" title="Delete"><span class="icon fugue-minus-circle mrn"></span></a>
			</div>
		</div>	
	</div>
	<div class="editForm line" style="display:none;">
		<div class="unit size4of5 field man">
			<div class="inputBox"><input class="rename" data-id="<?php echo $template->id; ?>" id="template-<?php echo $template->id; ?>-rename" value="<?php echo $template->name; ?>" /></div>
		</div>
		<div class="lastUnit txtR">
			<div class="templateFuns">
				<a style="display:inline-block;" class="saveTemplate" href="#" data-tip="{gravity:'sw'}" title="Save"><span class="icon fugue-disk-black mrn"></span></a>
				<a style="display:inline-block;" href="#" data-tip="{gravity:'sw'}" title="Cancel" onclick="$(this).closest('.editForm').hide().closest('.template').find('.display').show();return false;"><span class="icon fugue-cross mrn"></span></a>
			</div>
		</div>	
	</div>
</li>