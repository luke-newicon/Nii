<?php $this->renderPartial('//layouts/admin/_header'); ?>
<body style="background-image:none;">
	<div class="page liquid">
		<div class="body">
			<div class="main">
				<?php $this->renderPartial('//layouts/_breadcrumbs'); ?>
				<?php echo $content; ?>
			</div>
		</div>
		<?php $this->renderPartial('//layouts/admin/_foot'); ?>
	</div>
</body>
<?php $this->renderPartial('//layouts/admin/_footer'); ?>
<script>
	
	$(function(){
		window.heartbeat = {
			time:600000,
			beat:function(){
				setTimeout(function(){
					$.get("<?php echo NHtml::url('/nii/index/heartbeat'); ?>");
					window.heartbeat.beat();
				}, window.heartbeat.time);
			}
		};
		window.heartbeat.beat();
	});
	
	
</script>
</body>
</html>
