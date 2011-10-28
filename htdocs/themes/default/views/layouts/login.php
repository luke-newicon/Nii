<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="en" />
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		<?php Yii::app()->bootstrap->registerBootstrap(); ?>
		<?php Yii::app()->bootstrap->registerScriptFile('bootstrap-tabs.js'); ?>
		<?php Yii::app()->bootstrap->registerScriptFile('bootstrap-dropdown.js'); ?>
		<?php Yii::app()->bootstrap->registerScriptFile('bootstrap-modal.js'); ?>
		<?php Yii::app()->bootstrap->registerScriptFile('bootstrap-alerts.js'); ?>
		<link rel="stylesheet" media="print" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" />
		
	</head>
	<body class="login-page">
		<div class="page">
			<div class="main">
				<?php echo $content; ?>
			</div>
		</div>
	</body>
</html>