<div class="projectBox" data-id="<?php echo $project->id; ?>">
	<a class="projImg" href="<?php echo NHtml::url(array('/hotspot/screen/screen/','project'=>$project->id)); ?>">
		<img src="<?php echo NHtml::urlImageThumb($project->getImageId(), 'projectThumb'); ?>" <?php echo NHtml::nImageSizeAttr('projectThumb'); ?> />
	</a>
	<div class="projName">
		<span class="name"><?php echo $project->name; ?></span>
	</div>
	<div class="numOfPos">
		<?php $numScreens = $project->getScreensCount(); ?>
		<?php $numComments = $project->getCommentsCount(); ?>
		<?php if($numComments): ?>
			<div class="numOf sprite hotspot-comments" data-tip="" title="<?php echo $numComments; ?> Comments"><?php echo $numComments; ?></div>
		<?php endif; ?>
		<?php if($numScreens): ?>
			<div class="numOf hotspot-screen" style="left:<?php echo ($numComments)?'45px':'5px'; ?>;" data-tip="" title="<?php echo $numScreens; ?> Screens"><?php echo $numScreens; ?></div>
		<?php endif; ?>
	</div>
	<div class="projFuns"><a href="#" class="btn aristo txtC">i</a></div>
	<div class="projFlip" style="display:none;">
		<div class="projName">
			<span class="name"><?php echo $project->name; ?></span>
		</div>
		<br />
		<p><?php echo $numScreens; ?> <?php echo ($numScreens==1) ? 'screen':'screens'; ?></p>
		<p><?php echo ($hotspots = $project->getHotspotCount()); ?> <?php echo ($hotspots==1) ? 'hotspot':'hotspots'; ?></p>
<!--		<p><?php //echo $project->getCommentsCount(); ?> comments.</p>-->
		<div>
			<a href="#" class="projDelete btn aristo delete">Delete this project</a>
		</div>
		<a href="#" class="revertFlip btn aristo">Done</a>
	</div>
</div>
