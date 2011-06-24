<div class="head">
	<div class="menu">
		<!--<a class="logo" href="<?php echo Yii::app()->baseUrl; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/newicon.png" /></a>-->
		<?php $this->widget('zii.widgets.CMenu', array('items' => $this->menu)); ?>
		<div id="sitesearch"><?php echo CHtml::textField('gsearch', '', array('placeholder'=>'SEARCH', 'class'=>'input')); ?></div>
	</div>
</div>