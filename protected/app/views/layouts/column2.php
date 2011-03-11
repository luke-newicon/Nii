<?php $this->beginContent('//layouts/main'); ?>
<div class="leftCol gMail">
	<div id="sidebar">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Operations',
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'operations'),
			));
			$this->endWidget();
		?>
	</div><!-- sidebar -->
</div>
<div class="main">
		
	<?php echo $content; ?>
			
</div>
<?php $this->endContent(); ?>