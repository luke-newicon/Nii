<div id="templateForm" class="spotForm toolbarForm" style="position:fixed;display:none;">
	<div class="spotFormContainer" style="position:relative;">
		<div class="triangle-verticle"></div>
		<p id="templateFormNoTemplate">You don't have any templates, why not add a new one?</p>
		<ul class="noBull man">
			<li class="addTemplate">
				<label>
					<div class="line">
						<div class="unit size4of5">
							<div class="inputBox" style="position:relative;">
								<input id="newTemplate" name="newTemplate" type="text" autocomplete="off" />
								<label id="newTemplate-hint" style="position:absolute;left:8px;top:4px;color:#aaa;" for="newTemplate">Enter a new template name</label>
							</div>
						</div>
						<div class="lastUnit">
							<input id="newTemplateSubmit" style="padding:3px 7px 4px 7px;" type="submit" class="btn aristo btnToolbarRight" value="save"/>
						</div>
					</div>
				</label>
			</li>
			<?php foreach($screen->getTemplates() as $template): ?>
				<?php $this->renderPartial('/screen/_template-item', array('template'=>$template, 'screenId'=>$screen->id)); ?>
			<?php endforeach; ?>
		</ul>
		<div class="templateOk"><button class="btn aristo">Ok</button></div>
		<div id="deleteOverlay" style="text-align:right;border-radius:3px;text-shadow:none;padding:2px 5px 2px 5px;background-color:rgba(0,0,0,0.7);display:none;position:absolute;">
			<span style="color:#ccc;">Are you sure? </span><button class="btn aristo delete">Delete</button> <a href="#" onclick="$('#deleteOverlay').hide();return false;" style="color:#fff;">Cancel</a>
		</div>
	</div>
</div>
<style>
	.template .templateFuns{visibility:hidden;}
	.template.hover .templateFuns{visibility:visible;}
</style>
<script>
$(function(){
	$('#templateForm').delegate('.deleteTemplate','click',function(){
		var $tpl = $(this).closest('.template');
		$('#deleteOverlay').width($tpl.width()-10);
		$('#deleteOverlay').height($tpl.height()+10);
		$('#deleteOverlay').fadeTo(0,0.1).position({'my':'left top','at':'left top','of':$tpl,'offset':'0 -1px'}).fadeTo(250,1);
	});
});
</script>