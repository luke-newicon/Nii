<div class="projectBox" data-id="<?php echo $screen->id; ?>" data-name="<?php echo $screen->getName(); ?>">
	<a href="<?php echo NHtml::url(array('/project/screen/index','id'=>$screen->id)); ?>" class="projImg">
		<?php if(!isset($loadIn)): ?>
		<img src="<?php echo NHtml::urlImageThumb($screen->file_id, 'projectThumb'); ?>" />
		<?php endif; ?>
	</a>
	<div class="projName">
		<div class="name" title="<?php echo $screen->getName(); ?>"><?php echo $screen->getName(); ?></div>
	</div>
	<div class="projFuns">
		<a style="padding-top:5px;" href="#" class="deleteScreen btn aristo" ><img height="15" src="<?php echo ProjectModule::get()->getAssetsUrl().'/trash.png'; ?>"/></a>
		<a style="width:12px;" class="screenInfo btn aristo txtC">i</a>
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
		<div style="position:absolute;bottom:8px;position:absolute;right:10px;"><a href="#" class="revertFlip btn aristo">Done</a></div>
	</div>
</div>
