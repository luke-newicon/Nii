<?php $this->renderPartial('//layouts/admin/_header'); ?>
<body style="background-image:none;">
	<div class="page liquid">
		<?php //$this->renderPartial('//layouts/admin/_head'); ?>
		<div class="body">
			<div class="main">
				<?php $this->renderPartial('//layouts/_breadcrumbs'); ?>
				<?php echo $content; ?>
			</div>
		</div>
		<?php $this->renderPartial('//layouts/admin/_foot'); ?>
	</div>	
	<?php //$this->renderPartial('//layouts/admin/_footer'); ?>
</body>
</html>