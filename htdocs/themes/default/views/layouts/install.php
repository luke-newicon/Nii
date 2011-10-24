<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="en" />
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		<link rel="stylesheet" media="print" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" />
	</head>
	<body class="install">
		<div class="page">
			<?php $this->renderPartial('//layouts/install/_head'); ?>
			<div class="body">
				<div class="main">
					<div class="shadowBlockLarge pam w700" style="margin: 0 auto;">
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