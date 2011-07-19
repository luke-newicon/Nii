<div id="spotForm" class="spotForm" style="display:none;">
	<div class="spotFormContainer" style="position:relative;">
		<div class="triangle" style="left: -19px; top: 12px;position:absolute;"></div>
		<div class="spotFormPart form">
			<div class="field">
				<label for="screenSelect">Link to:</label>
				<div id="screenList" class="line">
					<div class="unit inputBox btn btnToolbarLeft" style="width:230px;"><input id="screenListInput" placeholder="- select screen -" /></div>
					<div class="lastUnit"><a href="#" class="btn btnN btnToolbarRight" style="width:18px;height:14px;border-color:#bbb;"><span class="icon fam-bullet-arrow-down">&nbsp;</span></a></div>
				</div>
			</div>
			<div class="field">
				<div id="spotTemplatesNone" style="display:none;"><a id="add-new-template" href="#">Add to a new template</a></div>
				<div id="spotTemplatesSelect">
					<label for="hotspotTemplate">Add to template</label><select id="hotspotTemplate"></select>
				</div>
			</div>
			<div class="field">
				<button id="okSpot" href="#" class="btn aristo">Ok</button>
				<a id="deleteSpot" href="#" class="delete mls">Delete</a>
			</div>
		</div>
	</div>
</div>
<script>
$(function(){
	$('#add-new-template').click(function(){
		window.toolbar.$btnTemplate.trigger('click');
		return false;
	});
});
</script>