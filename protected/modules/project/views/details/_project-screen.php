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
		<a href="#" class="deleteScreen btn aristo" ><img height="14" src="<?php echo ProjectModule::get()->getAssetsUrl().'/trash.png'; ?>"/></a>
		<div class="screenInfo btn aristo"><a href="#">i</a></div>
	</div>
	<div class="screenFlip" style="display:none;">
		<div class="screen-info loading" style="height:200px;">
			
		</div>
<!--		<div class="projName">
			<span class="name"><?php echo $screen->getName(); ?></span>
		</div>
		<br />
		<p><?php echo $screen->getNumHotspots(); ?> hotspots.</p>
		<p>0 comments.</p>
		<div class="line">
			<div class="unit mrs">
				<a href="#" class="projDelete btn aristo">Delete</a>
			</div>
			<div class="lastUnit">
				<p>this project</p>
			</div>
		</div>-->
		<div class="functions"><a href="#" class="revertFlip btn aristo">Done</a></div>
	</div>
</div>
