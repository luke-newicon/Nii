
<div id="shareForm" class="spotForm spotForm toolbarForm" style="position:fixed;display:none;">
	<div class="spotFormContainer" style="position:relative;">
		<div class="triangle-verticle"></div>
		<form id="shareForm">
			<input name="project_name" type="hidden" value="<?php echo $project->id; ?>" />
		<div class="field">Share this screen</div>
		<div class="field">Share the whole project <a href="#" onclick="return false;" class="btn aristo" id="getlink">get link</a></div>
		</form>
		<div class="templateOk txtR"><button class="btn aristo">Ok</button></div>
	</div>
</div>
<script>
	$('#getlink').click(function(){
		var pf = $('#shareForm').serialize();
		$.post("<?php echo NHtml::url('/project/details/projectLink'); ?>", 
		{'ProjectLink':pf})
	});
</script>