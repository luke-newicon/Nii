<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" style="background-color:#f9f9f9;">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="en" />
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		<link rel="stylesheet" media="print" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" />
		<?php Yii::app()->bootstrap->registerBootstrap(); ?>
	</head>
	<body class="install" style="background-color:#f9f9f9;">
		<div class="page">
			<div id="message"></div>
			<div class="body">
				<div class="main">
					<div class="shadowBlockLarge pam w500" style="margin: 0 auto;">
						<h1>Installation</h1>
						<?php echo $content; ?>
					</div>
				</div>
			</div>
		</div>
		<div id="gridSettingsDialog"></div>
		<div id="exportGridDialog"></div>
		<div id="customScopeDialog"></div>
	</body>
</html>
