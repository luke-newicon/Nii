
<div id="shareForm" class="spotForm spotForm toolbarForm" style="position:fixed;display:none;">
	<div class="spotFormContainer" style="position:relative;">
		<div class="triangle-verticle"></div>
		<form id="shareLinkForm">
			<input id="project_id" name="project_id" type="hidden" value="<?php echo $project->id; ?>" />
		<div class="field">Share this screen</div>
		<div class="field">Share the whole project <a href="#" onclick="return false;" class="btn aristo" id="getlink">get link</a></div>
		</form>
		<span id="project-link"></span>
		<div class="templateOk txtR"><button class="btn aristo">Ok</button></div>
	</div>
</div>
<script>
	$('#getlink').click(function(){
		var pf = $.deparam($('#shareLinkForm').serialize());
		$.post("<?php echo NHtml::url('/project/details/projectLink'); ?>", 
		{'ProjectLink':pf}, function(r){
			$('#project-link').html('<a href="<?php echo NHtml::url(ProjectModule::get()->shareLink); ?>/'+r+'">'+r+'</a>');
		});
	});
</script>