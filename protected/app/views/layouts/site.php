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
	<body>
		<div class="page">
			<?php $this->renderPartial('//layouts/site/_head'); ?>
			<div class="body">
				<div class="main">
					<?php $this->renderPartial('//layouts/_messages'); ?>
					<?php // $this->renderPartial('//layouts/_breadcrumbs'); ?>
					<?php echo $content; ?>
				</div>
			</div>
			<?php $this->renderPartial('//layouts/site/_foot'); ?>
		</div>
	</body>
</html>