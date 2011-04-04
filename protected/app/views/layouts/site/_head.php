<div class="head">
	<div class="menu">
		<a class="logo" href="<?php echo Yii::app()->baseUrl; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/newicon-white.png" /></a>
		<?php $this->widget('zii.widgets.CMenu', array('items' => $this->menu)); ?>
		<?php echo CHtml::textField('sitesearch','Search'); ?>
	</div>
</div>