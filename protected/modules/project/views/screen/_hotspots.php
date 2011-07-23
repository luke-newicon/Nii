<?php $onlyLinked = (isset($onlyLinked))?$onlyLinked:false; ?>
<?php foreach($screen->getHotspots($onlyLinked) as $hotspot): ?>
	<a data-id="<?php echo $hotspot->id; ?>" <?php echo ($hotspot->screen_id_link)? 'data-screen="'.$hotspot->screen_id_link.'"':''; ?>  class="hotspot" <?php echo ($hotspot->fixed_scroll)?'data-fixed-scroll="true"':''; ?> style="width:<?php echo $hotspot->width; ?>px;height:<?php echo $hotspot->height; ?>px;left:<?php echo $hotspot->left; ?>px; top:<?php echo $hotspot->top; ?>px;"></a>
<?php endforeach; ?>
<?php foreach($screen->getTemplateHotspots($onlyLinked) as $hotspot): ?>
	<a data-template="<?php echo $hotspot->template_id; ?>" data-id="<?php echo $hotspot->id; ?>" <?php echo ($hotspot->screen_id_link)?'data-screen="'.$hotspot->screen_id_link.'"':''; ?> class="hotspot spot-template <?php echo ($hotspot->screen_id_link)?'linked':''; ?>" <?php echo ($hotspot->fixed_scroll)?'data-fixed-scroll="true"':''; ?> style="width:<?php echo $hotspot->width; ?>px;height:<?php echo $hotspot->height; ?>px;left:<?php echo $hotspot->left; ?>px; top:<?php echo $hotspot->top; ?>px;"></a>
<?php endforeach; ?>