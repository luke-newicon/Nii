<div id="spotForm" class="spotForm" style="display:none;">
	<div class="spotFormContainer" style="position:relative;">
		<div class="triangle" style="left: -19px; top: 12px;position:absolute;"></div>
		<div class="spotFormPart plm prm">
			<div class="field pbs">
				<label for="screenSelect" class="lbl">Link to: <a id="followlink" href="#">Follow</a></label>
				<div id="screenList" class="line input pan">
					<div class="unit btn btnToolbarLeft" style="width:230px;padding:4px;height:16px;"><input id="screenListInput" placeholder="- select screen -" /></div>
					<div class="lastUnit"><a href="#" class="btn btnN btnToolbarRight" style="width:19px;height:14px;border-color:#bbb;border-width:0px 0px 0px 1px;border-radius:0px 3px 3px 0px;-moz-border-radius:0px 3px 3px 0px;-webkit-border-radius:0px 3px 3px 0px;"><span class="icon fam-bullet-arrow-down">&nbsp;</span></a></div>
				</div>
			</div>
			<div class="field pbs">
				<div id="spotTemplatesNone" style="display:none;"><a id="add-new-template" href="#">Add to a new template</a></div>
				<div id="spotTemplatesSelect" class="line">
					<label class="unit" for="hotspotTemplate">Add to template: &nbsp;</label>
					<div class="lastUnit"><select id="hotspotTemplate"></select></div>
				</div>
			</div>
			<div class="field pbs">
				<input name="fixedScroll" id="fixedScroll" type="checkbox" /> <label for="fixedScroll">Fixed scroll position</label>
			</div>
			<div class="field line">
				<div class="unit size3of4">
					<button id="okSpot" href="#" class="btn aristo">Ok</button>
					<a id="deleteSpot" href="#" class="delete mls">Delete</a>
				</div>
				<div class="lastUnit txtR"><!--<a id="followlink" href="#">follow link</a>--></div>
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