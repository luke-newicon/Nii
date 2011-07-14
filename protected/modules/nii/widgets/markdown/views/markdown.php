<div class="NTextareaMarkdown">
	<?php
		if($this->displayButtons && $this->buttonPosition=='top'){
			$this->displayButtons();
		}
	?>
	<div class="inputBox"><?php echo $inputElement ?></div>
	<div class="previewBox" style="display:none;">Loading...</div>
	<?php
		if($this->displayButtons && $this->buttonPosition=='bottom'){
			$this->displayButtons();
		}
	?>
</div>