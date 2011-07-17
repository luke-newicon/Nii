<style>
	.previewBox{background-color:#f9f9f9;border:1px solid #ccc;padding:4px;}
	a.active{font-weight:bold;}
</style>
<div class="NTextareaMarkdown" id="md-<?php echo $id; ?>">
	<div class="previewBox" style="display:none;">Loading...</div>
	<div class="editBox inputBox" style="border-radius:3px 3px 0px 0px;">
		<?php echo $inputElement ?>
	</div>
	<?php $this->displayButtons(); ?>
	
</div>