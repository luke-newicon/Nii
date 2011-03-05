<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" media="print" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="page liquid">
	<div class="head">
		<div class="bigHead">
			<div class="logo">
				<a href="<?php  ?>">
					<img src="<?php echo NHtml::baseUrl(); ?>/images/newicon-logo.png" />
				</a>
			</div>
			<div class="title"><h2><?php echo CHtml::encode(Yii::app()->name); ?></h2></div>
			<div class="loginMenu">
				<div class="menu menuR">
					<com:user.components.NLoginInfo/>
					<?php //$this->widget('user.components.NLoginInfo'); ?>
				</div>
			</div>
		</div>
		<div class="menu lightBar mainMenu">		
				<?php $this->widget('zii.widgets.CMenu',array(
					'items'=>array(
						array('label'=>'Home', 'url'=>array('/site/index')),
						array('label'=>'Contact', 'url'=>array('/site/contact')),
						array('url'=>Yii::app()->getModule('user')->loginUrl, 'label'=>"Login", 'visible'=>Yii::app()->user->isGuest),
						array('url'=>Yii::app()->getModule('user')->registrationUrl, 'label'=>"Register", 'visible'=>Yii::app()->user->isGuest),
						array('url'=>Yii::app()->getModule('user')->profileUrl, 'label'=>"Profile", 'visible'=>!Yii::app()->user->isGuest),
						array('url'=>Yii::app()->getModule('user')->logoutUrl, 'label'=>"Logout".' ('.Yii::app()->user->name.')', 'visible'=>!Yii::app()->user->isGuest),
					),
				)); ?>
				<?php $this->widget('zii.widgets.CMenu',array(
					'items'=>NWebModule::$items,
				)); ?>
		</div>
	</div>
	<div class="body"><!-- Body -->
		<?php echo $content; ?>
	</div>
	<div class="foot"><?php // echo $this->renderPartial('core/_footer'); ?></div>
</div>

<div id="footer">

</div><!-- footer -->


</body>
</html>