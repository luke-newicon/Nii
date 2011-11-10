<?php $onlyLinked = (isset($onlyLinked))?$onlyLinked:false; ?>
<div id="canvas" data-id="<?php echo $screen->id; ?>"> 
	<img data-id="<?php echo $screen->id; ?>" src="<?php echo NHtml::urlFile($screen->file_id, $screen->name); ?>" width="<?php echo $screen->getWidth(); ?>" height="<?php echo $screen->getHeight(); ?>" />
	<div id="canvas-hotspots">
		<?php $this->renderPartial('/old/old/_hotspots',array('screen'=>$screen, 'onlyLinked'=>$onlyLinked)); ?>
	</div>
	<div id="canvas-comments">
		<?php foreach($screen->getComments() as $i=>$comment): ?>
			<a data-id="<?php echo $comment->id; ?>" class="commentSpot" style="display:none;left:<?php echo $comment->left; ?>px; top:<?php echo $comment->top; ?>px;"><?php echo $i+1; ?></a>
		<?php endforeach; ?>
	</div>
</div>
<?php $this->renderPartial('/old/old/_comment-form'); ?>
<?php $this->renderPartial('/old/old/_spot-form'); ?>
