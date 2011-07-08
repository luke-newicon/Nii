<div class="projectBox" data-id="<?php echo $screen->id; ?>" data-name="<?php echo $screen->getName(); ?>">
	<a href="<?php echo NHtml::url(array('/project/details/screen','id'=>$screen->id)); ?>" class="projImg">
		<?php if(!isset($loadIn)): ?>
		<img src="<?php echo NHtml::urlImageThumb($screen->file_id, 'projectThumb'); ?>" />
		<?php endif; ?>
	</a>
	<div class="projName">
		<div class="name" title="<?php echo $screen->getName(); ?>"><?php echo $screen->getName(); ?></div>
	</div>
	<div class="functions">
		<a href="#" class="deleteScreen btn aristo" ><img width="16" height="16" src="<?php echo ProjectModule::get()->getAssetsUrl().'/trash.png'; ?>"/></a>
	</div>
</div>
