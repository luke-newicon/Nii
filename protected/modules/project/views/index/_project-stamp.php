<div class="projectBox" data-id="<?php echo $project->id; ?>">
	<a class="projImg" href="<?php echo NHtml::url(array('/project/details/index/','project'=>$project->name)); ?>">
		<img src="<?php echo NHtml::urlImageThumb($project->getImageId(), 'projectThumb'); ?>" />
	</a>
	<div class="projName">
		<span class="name"><?php echo $project->name; ?></span>
	</div>
	<span class="numOf" data-tip="" title="<?php echo $project->getNumComments(); ?> Comments"><?php echo $project->getNumComments(); ?></span>
	<span class="numOf"><?php echo $project->getNumScreens(); ?></span>
	<div class="projFuns"><a href="#" class="btn aristo txtC">i</a></div>
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
