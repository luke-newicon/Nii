<?php if($user->isGuest): ?>
	<?php $this->widget('zii.widgets.CMenu',array(
		'items'=>array(
			array('label'=>'Login', 'url'=>Yii::app()->getModule('user')->loginUrl),
			array('label'=>'Register', 'url'=>Yii::app()->getModule('user')->registrationUrl),
		)
	)); ?>
<?php else: ?>
	<div>
		<a href=""><?php echo $user->getName(); ?></a>
	</div>
	<div class="menu" style="display:none;">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('url'=>Yii::app()->getModule('user')->loginUrl, 'label'=>"Login", 'visible'=>Yii::app()->user->isGuest),
				array('url'=>Yii::app()->getModule('user')->registrationUrl, 'label'=>"Register", 'visible'=>Yii::app()->user->isGuest),
				array('url'=>array('/user/dashboard/index'), 'label'=>"Dashboard", 'visible'=>!Yii::app()->user->isGuest),
				array('url'=>Yii::app()->getModule('user')->logoutUrl, 'label'=>"Logout".' ('.Yii::app()->user->name.')', 'visible'=>!Yii::app()->user->isGuest),
			),
		)); ?>
	</div>
<?php endif; ?>
