<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="en" />
		<?php Yii::app()->bootstrap->registerBootstrap(); ?>
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" />
	</head>
	
<?php
Yii::app()->clientScript->registerScript('data-confirm',
	'$(\'[data-confirm]\').live(\'click\',function(){
		var $link = $(this);
		if(confirm($link.attr(\'data-confirm\'))){
			return true;
		}
		return false;
	});'
);