<div class="projectBox">
	<a class="projImg" href="<?php echo NHtml::url(array('/project/details/index/','project'=>$project->name)); ?>">
		<img src="<?php echo NHtml::urlImageThumb($project->getImageId()); ?>" />
	</a>
	<div class="projName">
		<span class="name"><?php echo $project->name; ?></span>
	</div>
</div>