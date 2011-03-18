<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="en" />

		<link rel="stylesheet" type="text/css" href="<?php echo $this->coreAssets; ?>/oocss/all.css" />
		<link rel="stylesheet" media="print" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />

		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	</head>
	<body id="mainLayout">
		<div class="page liquid">
			<div class="head">
				<div class="bigHead">
					<div class="mainMenu">
						<?php
							$items = array(
								array('label' => CHtml::image(Yii::app()->baseUrl.'/images/house.png', 'Dashboard'), 'url' => array('/site/index')),
								array('label' => CHtml::image(Yii::app()->baseUrl.'/images/user_gray.png', 'Conatacts'), 'url' => array('/site/contact')),
							);
							$items = CMap::mergeArray($items, NWebModule::$items);
							$this->widget('zii.widgets.CMenu', array('items'=>$items,'encodeLabel'=>false));
						?>
						<script>
							var menuWidth = jQuery('.mainMenu li').size();
							jQuery(function($){
								$('.mainMenu ul').hover(
									function(){
										$('.mainMenu ul').css('width',menuWidth*56);
									},
									function(){
										$('.mainMenu ul').css('width',56);
									});
							});
						</script>
					</div>
					<div class="loginMenu">
						<div class="menu menuR">
							<?php $this->widget('user.components.NLoginInfo'); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="body"><!-- Body -->
				<?php $this->widget('application.components.NBreadcrumbs', array('links' => $this->breadcrumbs,)); ?>
				<?php echo $content; ?>
			</div>
			<div class="foot"><?php // echo $this->renderPartial('core/_footer');    ?></div>
		</div>
		<div class="footer">
			<div class="logo">
				<a href="<?php ?>">
					<img src="<?php echo NHtml::baseUrl(); ?>/images/newicon-logo.png" />
				</a>
			</div>
		</div>
	</body>
</html>