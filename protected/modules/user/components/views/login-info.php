<?php if($user->isGuest): ?>
<?php $this->widget('zii.widgets.CMenu',array(
	'items'=>array(
		array('label'=>'Login', 'url'=>Yii::app()->getModule('user')->loginUrl),
		array('label'=>'Register', 'url'=>Yii::app()->getModule('user')->registrationUrl),
	)
)); ?>
guest
<div class="media man" style="float:left;width:250px;">
	<a href="<?php echo NHtml::url('/users/profile'); ?>">
	<?php //echo $this->com('users/gravatar',array(
	//	'email'=>$user->email,
	//	'size'=>25,
	//	'htmlOptions'=>array('class'=>'img','style'=>'background-color:#fff;padding:2px;border:1px solid #ddd;')));?>
	</a>
	<div class="bd">
		<p>
			<a href="<?php echo NHtml::url('/users/profile'); ?>">
				<?php
					//If a name is set in your prfile then displays that 
					//If not then uses your e-mail address.
//					if($user->user_first_name || $user->user_last_name){
//						echo $user->user_first_name.' '.$user->user_last_name;
//					}else{
//						echo $user->email;
//					}
					
				?>
			</a>
		</p>
	</div>
</div>
<?php else: ?>

<?php endif; ?>
