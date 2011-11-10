<!-- toolbar template (not used yet, should replace toolbar on screen.php) -->
<script type="text/template" id="toolbar-template">
	<ul>
		<li><a id="pickfiles" class="btn aristo upload" data-tip="{fade:true,'offset':5}" title="Upload screens to this project" href="#"><span class="icon hotspot-upload man"></span></a></li>
		<li><div class="menuDivider"></div></li>
		<li><a class="<% if(window.canvas.screenCount()==0){ print('disabled')} %> btn aristo share" data-tip="{fade:true,'offset':5}" title="Share your project" href="#"><span class="icon fugue-arrow-curve man"></span></a></li>
		<li><div class="menuDivider"></div></li>
		<li><a class="<% if(!window.canvas.screenExists()){ print('disabled')} %> btn aristo template" data-tip="{'fade':'true','offset':5}" title="Apply a template" href="#"><span class="icon fugue-template man"></span></a></li>
		<li>
			<div class="btnGroup">
<!--				<a class="<% if(!window.canvas.screenExists()){ print('disabled')} %> btn aristo btnToolbarLeft comments <% if(mode == 'comment') { print('selected') } %>" data-tip="{fade:true,'offset':5}" title="View comments" href="#"><span class="icon fugue-balloon-white-left man"></span></a>-->
				<a class="<% if(!window.canvas.screenExists()){ print('disabled')} %> btn aristo btnToolbarLeft edit <% if(mode == 'edit') {print('selected')}%>" data-tip="{fade:true,'offset':5}" title="Add hotspot links" href="#"><span class="icon fugue-layer-shape man"></span> <span class="hotspot-number"><% print(window.hotspotList.hotspotScreenCount()); %></span></a>
				<a class="<% if(!window.canvas.screenExists()){ print('disabled')} %> btn aristo preview btnToolbarRight <% if(mode == 'preview') {print('selected')}%>" data-tip="{fade:true,'offset':5}" title="Preview your project" href="#"><span class="icon fugue-magnifier man"></span></a>
			</div>
		</li>
		<li><div class="menuDivider"></div></li>
		<li><a class="btn aristo del <% if(!window.canvas.screenExists()){ print('disabled')} %>" data-tip="{fade:true,'offset':5}" title="Delete this screen" href="#"><span class="icon hotspot-trash man"></span></a></li>
		<li><div class="menuDivider"></div></li>
		<li><a id="userBox" href="#" class="btn aristo"><?php echo Yii::app()->user->getName(); ?><span class="icon fam-bullet-arrow-down mls mrn " style="padding-left:14px;"></span></a></li>
	</ul>
</script>


<!-- Screen pane template -->
<script type="text/template" id="screen-pane-template">
	<div id="screen-pane" class="unit" style="overflow: auto;z-index:300;width:200px;">
		
	</div>
	<div id="sidebarButtons">
		<a class="sidebarOpen disabled" href="#">&#9654;</a>
		<a class="sidebarClose" href="#">&#9664;</a>
	</div>
</script>



<!-- Screen template -->
<script type="text/template" id="screen-template">
	<div class="screen" data-id="<%= id %>">
		<a class="sideImg loading" href="#" onclick="return false;" style="display:block;" title="<%= name %>" ></a>
	</div>
	<div class="progress" style="height:15px;display:none;"></div>
	<span class="imageTitle"><%= name %></span>
</script>

<!-- Canvas template -->
<script type="text/template" id="canvas-template">
	<div id="canvas">
<!--		<div id="canvas-start"></div>-->
		<div id="canvas-hotspots"></div>
		<div id="canvas-comments"></div>
	</div>
	<!-- view shown when no screens exist -->
</script>

<!-- hotspot form template -->
<script type="text/template" id="hotspot-form-template">
	<div class="spotFormContainer" style="position:relative;">
		<div class="triangle" style="left: -19px; top: 1px;position:absolute;"></div>
		<div class="spotFormPart plm prm">
			<div class="field pbs">
				<div id="screenList" class="line inputBox pan">
					<div class="unit btn btnToolbarLeft" style="width:230px;padding:4px;height:16px;"><input id="screenListInput" placeholder="Link to screen -" /></div>
					<div class="lastUnit"><a href="#" class="btn btnN btnToolbarRight" style="width:19px;height:14px;border-color:#bbb;border-width:0px 0px 0px 1px;border-radius:0px 3px 3px 0px;-moz-border-radius:0px 3px 3px 0px;-webkit-border-radius:0px 3px 3px 0px;"><span class="icon fam-bullet-arrow-down">&nbsp;</span></a></div>
				</div>
			</div>
			<div class="field pbs">
				<% if (window.templateList.length == 0) { %>
				<div id="spotTemplatesNone"><a id="add-new-template" href="#">Add to a new template</a></div>
				<% } else { %>
				<div id="spotTemplatesSelect" class="line">
					<label class="unit" for="hotspotTemplate">Add to template: &nbsp;</label>
					<div class="lastUnit"><select id="hotspotTemplate"></select></div>
				</div>
				<% } %>
			</div>
			<div class="field pbs">
				<input value="1" name="fixedScroll" id="fixedScroll" type="checkbox" <% if(fixed_scroll!=0){ %> checked="checked" <% } %> /> <label for="fixedScroll">Fixed scroll position</label>
			</div>
			<div class="field line">
				<div class="unit size3of4">
					<button id="okSpot" href="#" class="btn aristo">Ok</button>
					<a id="deleteSpot" href="#" class="delete mls">Delete</a>
				</div>
				<div class="lastUnit txtR pts"><% if(screen_id_link!=null){ %><a class="follow-link" href="#">follow link</a> <% } %></div>
			</div>
		</div>
	</div>
</script>

<!-- hotspot form automcomplete drop down select item template -->
<script type="text/template" id="hotspot-form-select-item-template">
	<li class="screenItem">
		<a>
			<div class="media" style="margin-bottom:0px;">
				<div class="img txtC">
					<img style="display:inline;" src="<%= screen.get('image_url_thumb_select') %>" />
				</div>
				<div class="bd pls"><p><%= screen.getNameSearchHighlight() %></p></div>
			</div>
		</a>
	</li>
</script>



<!-- template form -->
<script type="text/template" id="template-form-template">
	<div class="spotFormContainer" style="position:relative;">
		<div class="triangle-verticle"></div>
		<p id="templateFormHint">You don't have any templates, why not add a new one?</p>
		<ul class="noBull man template-items">
			<li class="addTemplate">
				<label>
					<div class="line">
						<div class="unit size6of8">
							<div class="field man">
								<label class="inFieldLabel" for="newTemplate">Type a new template name</label>
								<div class="inputBox">
									<input id="newTemplate" name="newTemplate" type="text" autocomplete="off" />
								</div>
							</div>
						</div>
						<div class="lastUnit">
							<input style="padding:3px 7px 4px 7px;" type="submit" class="new-template-save btn aristo btnToolbarRight" value="save"/>
						</div>
					</div>
				</label>
			</li>

		</ul>
		<div class="templateOk pts"><button class="btn aristo">Ok</button></div>
		<div id="deleteOverlay" style="text-align:right;border-radius:3px;text-shadow:none;padding:2px 5px 2px 5px;background-color:rgba(0,0,0,0.7);display:none;position:absolute;">
			<span style="color:#ccc;">Are you sure? </span><button class="btn aristo delete">Delete</button> <a href="#" onclick="$('#deleteOverlay').hide();return false;" style="color:#fff;">Cancel</a>
		</div>
	</div>
</script>

<!-- template form checkbox list item -->
<script type="text/template" id="template-form-item">
	<div class="display line" style="margin:5px 0px;">
		<div class="unit size4of5">
			<label class="templateName">
				<% if (window.screenTemplateList.isScreenTemplate(id)) { %>
					<input checked="checked" class="checkbox" type="checkbox" />
				<% } else { %>
					<input class="checkbox" type="checkbox" />
				<% } %>
				<%= name %>
			</label>
		</div>
		<div class="lastUnit txtR">
			<div class="templateFuns">
				<a class="edit"   style="display:inline-block;"  href="#" data-tip="{gravity:'sw'}" title="Edit" ><span class="icon fugue-pencil mrn"></span></a>
				<a class="delete" style="display:inline-block;"  href="#" data-tip="{gravity:'sw'}" title="Delete"><span class="icon fugue-minus-circle mrn"></span></a>
			</div>
		</div>	
	</div>
	<div class="editForm line" style="display:none;margin:3px 0px;">
		<div class="unit size4of5 field man">
			<div class="inputBox" style="padding:1px 3px 1px 3px;"><input class="rename" value="<%= name %>" /></div>
		</div>
		<div class="lastUnit txtR">
			<div class="templateFuns">
				<a style="display:inline-block;" class="saveTemplate" href="#" data-tip="{gravity:'sw'}" title="Save"><span class="icon fugue-disk-black mrn"></span></a>
				<a style="display:inline-block;" href="#" data-tip="{gravity:'sw'}" title="Cancel" onclick="$(this).closest('.editForm').hide().closest('.template').find('.display').show();return false;"><span class="icon fugue-cross mrn"></span></a>
			</div>
		</div>	
	</div>
</script>

<script type="text/template" id="share-form-template">
	<div class="spotFormContainer" style="position:relative;">
		<div class="triangle-verticle"></div>
		<div class="share-link"><a target="_blank" href="<%= link_url %>"><%= link_url %></a></div>
		<form id="shareLinkForm">
			<div class="field">
				<input <% (password == null || password == '') ? print('') : print('checked="checked"'); %> autocomplete="off" onclick="$('#passwordBox').toggle();$('#ProjectLink_password').focus();" type="checkbox" name="makepassword" id="makepassword" />
				<label for="makepassword">Password protect this link</label>
			</div>
			<div id="passwordBox" class="mll field" style="<% (password == null || password == '') ? print('display:none') : print('display:bock');  %>">
				<?php //echo CHtml::activeLabel($link, 'password',array('class'=>'inFieldLabel')); ?>
				<label for="share-password" class="inFieldLabel">Password </label>
				<div  class="inputBox" style="width:200px;">
					<input id="share-password" name="share-password" type="password" autocomplete="off" value="<%= password %>" />
				</div>
			</div>
			<div class="field man"><a href="#" class="btn aristo ok">Ok</a></div>
		</form>
	</div>
</script>

<script type="text/template" id="canvas-start-template">
	<img style="display:inline;padding-top:8px;" src="<?php echo HotspotModule::get()->getAssetsUrl(); ?>/no-screens.png" />
</script>


<!-- don't need this widget, at the moment it is only included to force the plupload assets to be included -->
<?php $this->widget('nii.widgets.plupload.PluploadWidget', array('config' => array('runtimes' => 'html5,flash,silverlight'))); ?>