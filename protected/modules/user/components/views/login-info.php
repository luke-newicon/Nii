<?php if($user->isGuest): ?>
	<?php $this->widget('zii.widgets.CMenu',array(
		'items'=>array(
			array('label'=>'Login', 'url'=>Yii::app()->getModule('user')->loginUrl),
			array('label'=>'Register', 'url'=>Yii::app()->getModule('user')->registrationUrl),
		)
	)); ?>
<?php else: ?>
	<div class="line man" style="float:left">
		<div class="unit size1of3">
		<?php if($user->contact !== null): ?>
			<?php $this->widget('crm.components.CrmCard',array(
					'size'=>$this->size,
					'contact'=>$user->contact,
					'profileUrl'=>Yii::app()->getModule('user')->profileUrl)
				); 
			?>
		<?php endif; ?>
		</div>
		<div class="lastUnit">
				<?php $this->widget('zii.widgets.CMenu',array(
					'items'=>array(
						array('url'=>Yii::app()->getModule('user')->loginUrl, 'label'=>"Login", 'visible'=>Yii::app()->user->isGuest),
						array('url'=>Yii::app()->getModule('user')->registrationUrl, 'label'=>"Register", 'visible'=>Yii::app()->user->isGuest),
						array('url'=>Yii::app()->getModule('user')->profileUrl, 'label'=>"Profile", 'visible'=>!Yii::app()->user->isGuest),
						array('url'=>Yii::app()->getModule('user')->logoutUrl, 'label'=>"Logout".' ('.Yii::app()->user->name.')', 'visible'=>!Yii::app()->user->isGuest),
					),
				)); ?>
		</div>
	</div>
<?php endif; ?>
