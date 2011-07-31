<style>
	.previewBox{background-color:#f9f9f9;padding:4px;border-radius:3px 3px 0px 0px;-moz-border-radius:3px 3px 0px 0px;-webkit-border-radius:3px 3px 0px 0px;}
	a.active{font-weight:bold;}
</style>
<div class="NTextareaMarkdown inputBox" id="md-<?php echo $id; ?>" style="padding:0px;">
	<div class="previewBox" style="display:none;">Loading...</div>
	<div class="editBox" style="padding:3px;border-radius:3px 3px 0px 0px;-moz-border-radius:3px 3px 0px 0px;-webkit-border-radius:3px 3px 0px 0px;">
		<?php echo $inputElement ?>
	</div>
	<div class="buttons line" style="border-top:1px solid #eee;border-radius:0px 0px 3px 3px;-moz-border-radius:0px 0px 3px 3px;-webkit-border-radius:0px 0px 3px 3px; background-color:#f9f9f9;font-size:80%;padding:3px;">
		<?php $this->displayButtons(); ?>
	</div>
</div>