<div class="projectBox" data-id="<?php echo $project->id; ?>">
	<a class="projImg" href="<?php echo NHtml::url(array('/project/details/index/','project'=>$project->name)); ?>">
		<img src="<?php echo NHtml::urlImageThumb($project->getImageId(), 'projectThumb'); ?>" />
	</a>
	<div class="projName">
		<span class="name"><?php echo $project->name; ?></span>
	</div>
	<div class="projInfo btn aristo"><a href="#">i</a></div>
	<div class="projFlip" style="display:none;">
		<div class="projName">
			<span class="name"><?php echo $project->name; ?></span>
		</div>
		<br />
		<p><?php echo $project->getNumScreens(); ?> screens.</p>
		<p><?php echo $project->getNumComments(); ?> comments.</p>
		<div class="line">
			<div class="unit mrs">
				<a href="#" class="projDelete btn aristo delete">Delete</a>
			</div>
			<div class="lastUnit">
				<p>this project</p>
			</div>
		</div>
		<a href="#" class="revertFlip btn aristo">Done</a>
	</div>
</div>
