<?php $this->renderPartial('//layouts/site/_header'); ?>
<body id="frontLayout">
	<div class="page">
		<?php $this->renderPartial('//layouts/site/_head'); ?>
		<div class="body">
			<div class="main">
				<?php $this->renderPartial('//layouts/_messages'); ?>
				<?php $this->renderPartial('//layouts/_breadcrumbs'); ?>
				<?php echo $content; ?>
			</div>
		</div>
		<?php $this->renderPartial('//layouts/site/_foot'); ?>
	</div>
</body>
<?php $this->renderPartial('//layouts/site/_footer'); ?>