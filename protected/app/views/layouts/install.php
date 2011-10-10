<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="en" />

		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		
<!--		<link rel="stylesheet" type="text/css" href="<?php echo $this->coreAssets; ?>/oocss/all.css" />-->
		<link rel="stylesheet" media="print" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" />
<!--		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />-->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />
		<script tyle="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/functions.js"></script>
	</head>
	<body class="install">
		<div class="page">
			<?php $this->renderPartial('//layouts/install/_head'); ?>
			<div class="body">
				<div class="main">
					<div class="shadowBlockLarge pam w700" style="margin: 0 auto;">
<!--						<div id="sitelogo"><img src="<?php echo Yii::app()->baseUrl; ?>/images/logo.gif" /></div>-->
						<h1>Installation</h1>
						<?php $this->renderPartial('//layouts/_messages'); ?>
						<?php echo $content; ?>
					</div>
				</div>
			</div>
		</div>
		<?php $this->renderPartial('//layouts/install/_foot'); ?>
	</body>
</html>