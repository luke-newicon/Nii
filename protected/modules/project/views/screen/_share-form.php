
<div id="shareForm" class="spotForm spotForm toolbarForm" style="width:400px;position:fixed;display:none;">
	<div class="spotFormContainer" style="position:relative;">
		<div class="triangle-verticle"></div>
		<div id="linkTable">
			<a style="margin-bottom:5px;" href="#" onclick="$('#linkTable').hide();$('#shareLinkForm').show();return false;" class="btn aristo" id="">Generate a new link</a>
			<div class="data">
				<table>
					<thead>
						<tr>
							<th>Link</th>
							<th>Password</th>
						</tr>
					</thead>
					<?php foreach($project->getLinks() as $l): ?>
					<tr>
						<td><a target="_blank" href="<?php echo $l->getLink(); ?>"><?php echo $l->link; ?></a></td>
						<td><?php echo $l->password; ?></td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
			<div class="templateOk txtR"><button class="btn aristo">Ok</button></div>
		</div>
		<form id="shareLinkForm" style="display:none;">
			<div class="field">
				<h4>Generate a new link</h4>
				<input onclick="$('#passwordBox').toggle();$('#password').focus();" type="checkbox" name="makepassword" id="makepassword" />
				<label for="makepassword">password protect this link</label>
				<div id="passwordBox" style="display:none;">
					<label for="password" id="passwordHint" style="position:absolute;top:55px;left:23px;color:#ccc;">Enter a password</label>
					<div class="inputBox" style="margin:2px 0px 0px 12px;width:200px;" >
						<input id="password" type="text" name="password" />
					</div>
				</div>
				<div class="field">
					<input type="checkbox" name="allowcomments" id="allowcomments" />
					<label for="allowcomments">Allow Comments</label>
				</div>
			</div>
			<input id="project_id" name="project_id" type="hidden" value="<?php echo $project->id; ?>" />
			<div class="txtR"><button onclick="$('#shareLinkForm').hide();$('#linkTable').show();return false;" class="btn aristo">Cancel</button> <button class="templateOk btn aristo primary">Save</button></div>
		</form>
		
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
	$(function(){
		$('#password').keyup(function(){
			if($('#password').val()!='')
				$('#passwordHint').hide();
			else
				$('#passwordHint').show();
		});
	});
	
</script>