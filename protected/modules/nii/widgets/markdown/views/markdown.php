<div class="NTextareaMarkdown">
	<div class="buttons">
		<?php
		echo cHtml::button('Edit', array('class' => $this->editButtonClass.' edit active'));
		echo cHtml::button('Preview', array('class' => $this->previewButtonClass.' preview'));
		echo cHtml::hiddenField('textAreaStatus', 1, array('class' =>'updated'));
		echo cHtml::link('Help', 'http://daringfireball.net/projects/markdown/syntax', array('target' => 'blank', 'class' => 'help_button'));?>
	</div>
	<div class="input"><?php echo $inputElement ?></div>
	<div class="previewBox" style="display:none;">Loading...</div>
</div>