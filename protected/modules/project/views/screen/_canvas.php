<div id="canvas" data-id="<?php echo $screen->id; ?>" style="cursor:crosshair;"> 
	<img src="<?php echo NHtml::urlFile($screen->file_id, $screen->name); ?>" width="<?php echo $screen->getWidth(); ?>" height="<?php echo $screen->getHeight(); ?>" />
	<?php foreach($screen->getHotspots() as $hotspot): ?>
		<a data-id="<?php echo $hotspot->id; ?>" <?php echo ($hotspot->screen_id_link)? 'data-screen="'.$hotspot->screen_id_link.'"':''; ?>  class="hotspot" style="width:<?php echo $hotspot->width; ?>px;height:<?php echo $hotspot->height; ?>px;left:<?php echo $hotspot->left; ?>px; top:<?php echo $hotspot->top; ?>px;"></a>
	<?php endforeach; ?>
	<?php foreach($screen->getTemplateHotspots() as $hotspot): ?>
		<a data-template="<?php echo $hotspot->template_id; ?>" data-id="<?php echo $hotspot->id; ?>" <?php echo ($hotspot->screen_id_link)?'data-screen="'.$hotspot->screen_id_link.'"':''; ?> class="hotspot spot-template <?php echo ($hotspot->screen_id_link)?'linked':''; ?>" style="width:<?php echo $hotspot->width; ?>px;height:<?php echo $hotspot->height; ?>px;left:<?php echo $hotspot->left; ?>px; top:<?php echo $hotspot->top; ?>px;"></a>
	<?php endforeach; ?>
	<?php foreach($screen->getComments() as $i=>$comment): ?>
		<a data-id="<?php echo $comment->id; ?>" class="commentSpot" style="display:none;left:<?php echo $comment->left; ?>px; top:<?php echo $comment->top; ?>px;"><?php echo $i+1; ?></a>
	<?php endforeach; ?>
</div>

<?php $this->renderPartial('_comment-form'); ?>
<?php $this->renderPartial('_spot-form'); ?>
