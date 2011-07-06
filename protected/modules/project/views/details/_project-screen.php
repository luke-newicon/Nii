<div class="projectBox" data-id="<?php echo $screen->id; ?>">
	<a href="<?php echo NHtml::url(array('/project/details/screen','id'=>$screen->id)); ?>" class="projImg">
		<img src="<?php echo NHtml::urlImageThumb($screen->file_id, 'projectThumb'); ?>" />
	</a>
	<div class="projName">
		<span class="name"><?php echo $screen->getName(); ?></span>
	</div>
	<div class="functions">
		<a class="deleteScreen delete" href="">Delete</a>
	</div>
</div>
