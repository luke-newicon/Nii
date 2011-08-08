<style>
	.toolbar{height:50px;background-color:#000;}
</style>
<?php $this->renderPartial('//layouts/admin/_header'); ?>
<body style="background-image:none;">
	<div class="page liquid">
		<?php //$this->renderPartial('//layouts/admin/_head'); ?>
		<div class="body">
			<div class="main">
				<?php $this->renderPartial('//layouts/_messages'); ?>
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
		setTimeout(function(){
			$.post("<?php echo NHtml::url('/nii/index/heartbeat'); ?>",function(r){
				if(r.success == true) return true;
			})
		},15000);
	});
</script>