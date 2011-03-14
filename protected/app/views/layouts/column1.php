<?php $this->beginContent('//layouts/main'); ?>
<div class="main">
		
	<!-- breadcrumbs -->
	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	)); ?>
	
	<?php echo $content; ?>
			
</div>
<?php $this->endContent(); ?>