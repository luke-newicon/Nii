<div id="message"></div>
<div class="head">
	<?php if (!Yii::app()->user->isGuest) $this->widget('app.widgets.user.TUserProfile',array('id'=>'profileMenuWidget')); ?>
	<div id="sitelogo"><a href="<?php echo Yii::app()->baseUrl; ?>"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo.gif" /></a></div>
	<?php if (!Yii::app()->user->isGuest) { ?>
	<div class="menu">
		<?php $this->widget('zii.widgets.CMenu', array('items' => Yii::app()->getModule('admin')->menu->items,'id'=>'mainMenu','activateParents'=>true)); ?>
	</div>
	<div class="subMenu"></div>
	<?php } ?>
</div>