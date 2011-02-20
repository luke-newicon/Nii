<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />
<!--	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />-->

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div class="page liquid">
	<div class="head">

		<div class="logo">
			<a href="<?php  ?>">
				<img src="<?php echo NHtml::baseUrl(); ?>/images/newicon-logo.png" />
			</a>
		</div>
		<div class="title"><h2><?php echo CHtml::encode(Yii::app()->name); ?></h2></div>
		<div class="loginMenu">
			<div class="menu menuR">
			<?php if(!Yii::app()->user->isGuest): ?>
				<?php $login = $this->widget('application.components.UserLoginInfo'); ?>
				<?php //$this->widget('zii.widgets.CMenu',array(
					//'items'=>array(
					//	array('label'=>'profile', 'url'=>array('users/profile'), 'template'=>$login),
					//	array('label'=>'Sign out', 'url'=>array('users/index/logout'))
					//)
				//)); ?>
			<?php else: ?>
				<?php $this->widget('zii.widgets.CMenu',array(
					'items'=>array(
						array('label'=>'Sign in', 'url'=>'users/index/login')
					)
				)); ?>
			<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="body"><!-- Body -->
		<div class="main">
			<div class="menu lightBar">
			<?php $this->widget('zii.widgets.CMenu',array(
				'items'=>array(
					array('label'=>'Home', 'url'=>array('/site/index')),
					array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
					array('label'=>'Crm', 'url'=>array('/crm/index')),
					array('label'=>'Contact', 'url'=>array('/site/contact')),
					array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
					array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
				),
			)); ?>
			</div>
			<?php //echo $this->renderPartial('core/_nav'); ?>
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
			)); ?><!-- breadcrumbs -->

			<?php echo $content; ?>
		</div>
	</div>
	<div class="foot"><?php // echo $this->renderPartial('core/_footer'); ?></div>
</div>

	

	

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->


</body>
</html>