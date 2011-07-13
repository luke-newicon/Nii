<style type="text/css" media="screen">
	body{background-color: rgb(<?php echo $rgb['red']; ?>,<?php echo $rgb['green']; ?>,<?php echo $rgb['blue']; ?>);}
	#canvas{margin: 0 auto;width:<?php echo $width; ?>px;cursor:crosshair;position:relative;}
	
	.hotspot{cursor:pointer;z-index: 100; position: absolute;background-color:#c3d0f6;border: 1px solid #2946a7;opacity: 0.7;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";filter: alpha(opacity=70);}
	.hotspot.helper{border:1px dotted #2946a7;cursor:crosshair;opacity: 0.4;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=40)";filter: alpha(opacity=40);}
	
	.spotForm{border-radius:5px;z-index:3000;background-color:#f1f1f1;background:-moz-linear-gradient(bottom, #ddd, #f1f1f1);background:-webkit-gradient(linear, left top, left bottom, from(#ddd), to(#f1f1f1));width:300px;border:1px solid #535a64;box-shadow:0px 3px 10px #444,inset 0px 1px 0px 0px #fff; top:100px;left:100px;position:absolute; }
	.triangle{background:url("<?php echo ProjectModule::get()->getAssetsUrl().'/triangle.png'; ?>") no-repeat top left;width:19px;height:34px;left:-19px;top:10px;position:absolute;}
	.spotFormPart{padding:5px;}
	a.delete, a.btn.btnN.delete {color:#cc0000;}
	
	.screenItem{background-color:#fff;cursor:pointer; border-bottom: 1px solid #CCCCCC;}
	.screenItem .img{width:48px;height:48px;background-color:#f9f9f9;border:1px solid #ccc;margin:2px;}
	.ui-autocomplete {border:1px solid #666;max-height: 300px;overflow-y: auto;overflow-x: hidden;width:300px;background-color:#fff;}
	/* IE 6 doesn't support max-height
	 * we use height instead, but this forces the menu to always be this tall
	 */
	* html .ui-autocomplete {height: 250px;}
	
	.small .toolbarArrow{background-position:100% 0px;}
	.small .titleBarText{padding-top:5px;font-size:14px;}
	.toolbar.screen{min-width:1024px;border-bottom-color:#666;height:46px;background-color:#000;position:fixed;box-shadow: 0 1px 0 #FFFFFF inset, 0 0 8px #000000;z-index:4000;}
	
	
	.hotspot.link{background-color:transparent;border:none;}
	
	#closePreview{position:absolute;top:0px;right:0px;z-index:700;}
	
	#templateForm{display:none;z-index:4001;padding:10px;width:250px;text-shadow:0px 1px 0px #fff;}
	.triangle-verticle{background:url("<?php echo ProjectModule::get()->getAssetsUrl().'/triangle-verticle.png'; ?>") no-repeat top left;width:30px;height:22px;left:45%;top:-29px;position:absolute;}
	.template label:hover {}
	.template.selected label{}
	.addTemplate .inputBox{border-radius:3px 0px 0px 3px;}
	
	.spot-template{background-color:orange;border-color:red;}
	
</style>
<?php echo CHtml::linkTag('stylesheet', 'text/css', ProjectModule::get()->getAssetsUrl().'/project.css'); ?>
<div id="mainToolbar" class="toolbar screen plm">
	<div class="line small">
		<div class="unit toolbarArrow mrm" style="padding-top:8px;">
			<a href="<?php echo NHtml::url('/project/index/index'); ?>" class="titleBarText" style="display:block;">Projects</a>
		</div>
		<div class="unit toolbarArrow prm" style="padding-top:8px;">
			<a href="<?php echo NHtml::url(array('/project/details/index','project'=>$project->name)); ?>" class="titleBarText" style="display:block;"><?php echo $project->name; ?></a>
		</div>
		<div class="unit plm ptm prm" style="padding-top:8px;">
			<h1 class="man titleBarText" ><?php echo $screen->getName(); ?></h1>
		</div>
		<div class="unit">
			<div style="margin:12px 5px;width:0px;height:20px;border-left:1px solid #ababab;border-right:1px solid #fff;"></div>
		</div>
		<div class="unit plm" style="padding-top:10px;">
			<button class="btn aristo template" href="#"><span class="icon fam-application-side-list"></span> Templates</button>
		</div>
		<div class="unit plm btnGroup" style="padding-top:10px;">
			<button class="btn aristo btnToolbarLeft comments" href="#"><span class="fugue fugue-balloon-white-left"></span> Comments</button><button class="btn aristo btnToolbarRight edit selected" href="#"><span class="fugue fugue-layer-shape"></span>Edit</button>
		</div>
		<div class="unit plm" style="padding-top:10px;">
			<button class="btn aristo preview" href="#"><span class="fugue fugue-magnifier"></span>Preview</button>
		</div>
		<div class="unit plm" style="padding-top:10px;">
			<button class="btn aristo" data-tip="" title="Share" href="#"><span class="fugue fugue-arrow-curve"></span></button>
		</div>
		<div class="unit plm" style="padding-top:10px;">
			<button class="btn aristo" data-tip="" title="Configure" href="#"><span class="icon fam-cog"></span></button>
		</div>
	</div>
</div>
<div id="closePreview" class="">
	<button class="btn aristo editMode" data-tip="{gravity:'ne'}" title="Close preview and return to edit mode" href="#"><span class="fugue fugue-layer-shape"></span> Edit</button>
</div>
<div id="templateForm" class="spotForm" style="position:fixed;">
	<div class="spotFormContainer" style="position:relative;">
		<div class="triangle-verticle"></div>
		<p id="templateFormNoTemplate">You don't have any templates, why not add a new one?</p>
		<ul class="noBull man">
			<li class="addTemplate">
				<label>
					<div class="line">
						<div class="unit size3of4">
							<div class="inputBox" style="position:relative;">
								<input id="newTemplate" name="newTemplate" type="text" autocomplete="off" />
								<label id="newTemplate-hint" style="position:absolute;left:8px;top:4px;color:#aaa;" for="newTemplate">Enter a new template name</label>
							</div>
						</div>
						<div class="lastUnit">
							<input id="newTemplateSubmit" style="width:62px;padding-bottom:4px;" type="submit" class="btn aristo btnToolbarRight" value="save"/>
						</div>
					</div>
				</label>
			</li>
			<?php foreach($screen->getTemplates() as $template): ?>
				<?php $this->renderPartial('/screen/_template-item', array('template'=>$template, 'screenId'=>$screen->id)); ?>
			<?php endforeach; ?>
		</ul>
		<div class="templateOk txtR"><button class="btn aristo">Ok</button></div>
	</div>
</div>

<div class="line">
	<div class="unit" id="screenUnit">
		<div id="screenPane" class="unit" style="overflow:auto;position:relative;top:48px;z-index:300;height:400px;width:200px;background-color:#ccc;border-right:1px solid #000;">
			<?php foreach($project->getScreens() as $s): ?>
			<img src="<?php echo NHtml::urlImageThumb($s->file_id); ?>" />
			<? endforeach; ?>
		</div>
	</div>
	<div class="lastUnit">
		<div id="canvasWrap" style="position: relative; top:48px; overflow: auto; height: 400px;"> 
			<div id="canvas"> 
				<img src="<?php echo NHtml::urlFile($file->id, $file->original_name); ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />
				<?php foreach($hotspots as $hotspot): ?>
					<a data-id="<?php echo $hotspot->id; ?>" <?php if($hotspot->screen_id_link): ?> data-screen="<?php echo $hotspot->screen_id_link; ?>" <?php endif; ?> class="hotspot" style="width:<?php echo $hotspot->width; ?>px;height:<?php echo $hotspot->height; ?>px;left:<?php echo $hotspot->left; ?>px; top:<?php echo $hotspot->top; ?>px;"></a>
				<?php endforeach; ?>
				<?php foreach($templateHotspots as $hotspot): ?>
					<a data-template="<?php echo $hotspot->template_id; ?>" data-id="<?php echo $hotspot->id; ?>" <?php if($hotspot->screen_id_link): ?> data-screen="<?php echo $hotspot->screen_id_link; ?>" <?php endif; ?> class="hotspot spot-template" style="width:<?php echo $hotspot->width; ?>px;height:<?php echo $hotspot->height; ?>px;left:<?php echo $hotspot->left; ?>px; top:<?php echo $hotspot->top; ?>px;"></a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>

<script>
$(function($){
	
	var resizer = function(){
		$('#canvasWrap').snapy({'snap':'.main'});
		$('#screenPane').snapy({'snap':'.main'});
		console.log($('#screenPane').border());
		$('#canvasWrap').css('width',($(window).width()-$('#screenPane').width()+$('#screenPane').border().right-2) + 'px');
	}
	$(window).resize(function(){
		resizer();
	});
	$('#canvasWrap').snapy({'snap':'.main'});
	$('#screenPane').snapy({'snap':'.main'});
	$('#screenUnit').resizable({
		handles:'e',
		alsoResize:'#screenPane',
		stop:function(){
			resizer();
		}
	});
});
	
(function( $ ){

	function _padHeight($el){
		padding = $el.padding();
		return padding.top + padding.bottom;
	}
	function _padWidth($el){
		padding = $el.padding();
		return padding.left + padding.right;
	}
	var methods = {
		init : function( options ) {
			return this.each(function(){
				$this = $(this);
				//options
				var minHeight = 200;
				$snapTo = $(options.snap);
				
				var winHeight = $(window).height();
				
				if(!((winHeight-$this.position().top) <= minHeight)){
					$this.css('height',(winHeight - $this.position().top - _padHeight($this)) + 'px');
				}
			});
		}
	};
	$.fn.snapy = function( method ) {
		if ( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.tooltip' );
		}    
	};
})(jQuery);
/*
 * Used to determine border pixel sizes for resizing panes
 * e.g. $('selector').border().bottom ( = integer size in pixels )
 * 
 * JSizes - JQuery plugin v0.33
 *
 * Licensed under the revised BSD License.
 * Copyright 2008-2010 Bram Stein
 * All rights reserved.
 */
(function(b){var a=function(c){return parseInt(c,10)||0};b.each(["min","max"],function(d,c){b.fn[c+"Size"]=function(g){var f,e;if(g){if(g.width!==undefined){this.css(c+"-width",g.width)}if(g.height!==undefined){this.css(c+"-height",g.height)}return this}else{f=this.css(c+"-width");e=this.css(c+"-height");return{width:(c==="max"&&(f===undefined||f==="none"||a(f)===-1)&&Number.MAX_VALUE)||a(f),height:(c==="max"&&(e===undefined||e==="none"||a(e)===-1)&&Number.MAX_VALUE)||a(e)}}}});b.fn.isVisible=function(){return this.is(":visible")};b.each(["border","margin","padding"],function(d,c){b.fn[c]=function(e){if(e){if(e.top!==undefined){this.css(c+"-top"+(c==="border"?"-width":""),e.top)}if(e.bottom!==undefined){this.css(c+"-bottom"+(c==="border"?"-width":""),e.bottom)}if(e.left!==undefined){this.css(c+"-left"+(c==="border"?"-width":""),e.left)}if(e.right!==undefined){this.css(c+"-right"+(c==="border"?"-width":""),e.right)}return this}else{return{top:a(this.css(c+"-top"+(c==="border"?"-width":""))),bottom:a(this.css(c+"-bottom"+(c==="border"?"-width":""))),left:a(this.css(c+"-left"+(c==="border"?"-width":""))),right:a(this.css(c+"-right"+(c==="border"?"-width":"")))}}}})})(jQuery);
</script>


<div id="spotForm" class="spotForm" style="display:none;">
	<div class="spotFormContainer" style="position:relative;">
		<div class="triangle" style="left: -19px; top: 12px;position:absolute;"></div>
		<div class="spotFormPart form">
			<div class="field">
				<label for="screenSelect">Link to:</label>
<!--			<div class="inputBox" style="padding:3px;width:200px;">
					<?php echo CHtml::dropDownList('screenSelect', 0, $project->getScreensListData(),array('class'=>'input','style'=>'margin:0px;')) ?>
				</div>-->
				<div id="screenList" class="line">
					<div class="unit inputBox btn btnToolbarLeft" style="width:230px;"><input placeholder="- select screen -" /></div>
					<div class="lastUnit"><a href="#" class="btn btnN btnToolbarRight" style="width:18px;height:14px;border-color:#bbb;"><span class="icon fam-bullet-arrow-down">&nbsp;</span></a></div>
				</div>
			</div>
			<div class="field">
				<label for="hotspotTemplate">Add to template</label><select id="hotspotTemplate"></select>
			</div>
<!--		<div class="field">
				<input class="mrs" style="float:left;" type="checkbox" id="maintainScroll" name="maintainScroll"/>
				<label  for="maintainScroll" style="font-weight:normal;">Maintain scroll position</label>
			</div>-->
			<div class="field">
				<button id="okSpot" href="#" class="btn aristo">Ok</button>
<!--				<a id="cancelSpot" href="#" class="btn btnN ">Cancel</a>-->
				<a id="deleteSpot" href="#" class="delete mls">Delete</a>
			</div>
		</div>
	</div>
</div>
<script>
	
//$('#spotForm').dialog({autoOpen:false});
// Boxer plugin
$.widget("ui.boxer", $.ui.mouse, {
	_init: function() {
		this.element.addClass("ui-boxer");
		this.dragged = false;
		this._mouseInit();
		this.helper = $(document.createElement('a'))
		.addClass('hotspot helper ui-boxer-helper')
	},
	destroy: function() {
		this.element
		.removeClass("ui-boxer ui-boxer-disabled")
		.removeData("boxer")
		.unbind(".boxer");
		this._mouseDestroy();
		return this;
	},
	_mouseStart: function(event) {
		$("#screenList input").autocomplete("close");
		//var self = this;
		this.opos = [event.pageX, event.pageY];
		if (this.options.disabled)
			return;
		var options = this.options;
		this._trigger("start", event);
		$('#canvas').append(this.helper);
		this.helper.css({
			"z-index": 100,
			"position": "absolute",
			"left": event.clientX,
			"top": event.clientY,
			"width": 0,
			"height": 0
		});
	},
	_mouseDrag: function(event) {
		//var self = this;
		this.dragged = true;
		if (this.options.disabled)
			return;
		var options = this.options;
		var x1 = this.opos[0], y1 = this.opos[1], x2 = event.pageX, y2 = event.pageY;
		if (x1 > x2) { var tmp = x2; x2 = x1; x1 = tmp; }
		if (y1 > y2) { var tmp = y2; y2 = y1; y1 = tmp; }
		this.helper.css({left: x1-$('#canvas').offset().left, top: y1-$('#canvas').offset().top, width: x2-x1, height: y2-y1});
		this._trigger("drag", event);
		return false;
	},
	_mouseStop: function(event) {
		//var self = this;
		this.dragged = false;
		var clone = this.helper.clone()
		.removeClass('ui-boxer-helper').appendTo(this.element);
		this._trigger("stop", event, { box: clone });
		this.helper.remove();
		return false;
	}
});
	
/**
 * Hotspot plugin
 */
(function($){
	var methods = {
		init : function(options) {
			return this.each(function(){
				var $this = $(this);
				$this.draggable({
					cancel:'.link',
					drag: function(event, ui) {
						if($('#spotForm:visible').index){
							// make the spotForm follow the hotspot being dragged
							$('#spotForm').position({my:'left top',at:'right top',of:$this,offset:"18 -30",collision:'none'});
						}
					},
					stop:function(e,ui){
						$this.hotspot('update');
					}
				})
				.resizable({
					stop:function(e,ui){
						$this.hotspot('update');
					}
				})
				.click(function(e){
					// detect keypress
					// if shift click then load the screen link
					// only available if there is a screen link id
					if (e.shiftKey && $this.is('[data-screen]')) {
						location.href = "<?php echo NHtml::url('/project/details/screen'); ?>/id/"+$this.attr('data-screen');
					} else { 
						$this.hotspot('showForm');
					}
				});
			})
			return $spot;
		},
		showForm:function(){
			spotForm.showForm($(this));			
		},
		update:function(){
			var $spot = $(this);
			var offset = $spot.position();
			var id = -1;
			var screenId = 0;
			if($spot.is('[data-id]'))
				id = $spot.attr('data-id');
			if($spot.is('[data-screen]'))
				screenId = $spot.attr('data-screen');
			$.post("<?php echo NHtml::url('/project/details/saveHotspot'); ?>",
				{ProjectHotSpot:{
					hotspot_id:id,
					screen_id:"<?php echo $screen->id; ?>",
					width:$spot.width(),
					height:$spot.height(),
					left:offset.left,
					top:offset.top,
					screen_id_link:screenId
				}},
				function(json){
					//populate my id
					$spot.attr('data-id',json.id);
				},
				'json'
			);
			return $spot;
		},
		deleteSpot:function(){
			var $spot = $(this);
			$spot.remove();
			$('#spotForm').hide();
			$.post("<?php echo NHtml::url('/project/details/deleteSpot'); ?>",{id:$spot.attr('data-id')});
		},
		click:function(){
			alert(el.attr('data-id'));
		}
	};
	$.fn.hotspot = function( method ) {
		if ( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.hotspot' );
		}    
	};
})( jQuery );

var spotForm = {
	screens:<?php echo json_encode($project->getScreenList()); ?>,
	$spot:null,
	showForm:function($spot){
		spotForm.$spot = $spot;
		// show and position the popup form
		$('#spotForm').show()
		.position({my:'left top',at:'right top',of:$spot,offset:"18 -30",collision:'none'});
		// unbind all previously set events
		$('#spotForm').unbind('.spotForm');
		// ok spot link
		$('#spotForm').delegate('#okSpot','click.spotForm',function(){$('#spotForm').hide();});
		// delete spot link
		$('#spotForm').delegate('#deleteSpot','click.spotForm',function(){$spot.hotspot('deleteSpot');return false;});

		spotForm.autocomplete();
		spotForm.initTemplates();
		$('#spotForm').delegate('#hotspotTemplate','change.spotForm',function(){spotForm.applyTemplate()});
	},
	applyTemplate:function(){
		var val = $('#hotspotTemplate').find(':selected').val();
		// alert(val);
		if(val==0) return;
		
		// save it
		$.post("<?php echo NHtml::url('/project/screen/addTemplateSpot') ?>",
		{'spot':spotForm.$spot.attr('data-id'), 'template':val},function(){
			spotForm.$spot.attr('data-template',val).addClass('spot-template');
			// need to ensure this template is now applied to the current screen
			// or maybe not this seems logical but actually becomes confusing,
			// plus you may want only one item of the template
			toolbar.templateForm.ensureTemplateChecked(val);
		});
	},
	initTemplates:function(){
		// get a list of all templates
		$select = $('#hotspotTemplate').html('');
		$select.append('<option>- select template -</option>');
		$('#templateForm li.template').each(function(){
			$select.append('<option value="'+$(this).find('input:checkbox').val()+'">'+$(this).find('label').text()+'</option>');
		});
		// lets set the initial selected option
		if(spotForm.$spot!=null && spotForm.$spot.is('[data-template]')){
			$select.val(spotForm.$spot.attr('data-template'));
		}
	},
	autocomplete:function(){
		$spot = spotForm.$spot;
		$('#spotForm').delegate("#screenList input",'click.spotForm',function(){
			$('#screenList a').click();
		})
		$("#spotForm").delegate('#screenList a','click.spotForm',function(){
			// close if already visible
			if ($("#screenList input").autocomplete("widget").is(":visible")) {
				$("#screenList input").autocomplete("close");
				return false;
			}
			// work around a bug (likely same cause as #5265)
			$(this).blur();
			// pass empty string as value to search for, displaying all results
			$("#screenList input").autocomplete("search", "");
			$("#screenList input").focus();
			return false;
		});
		$('#screenList a').attr("tabIndex", -1).attr("title", "Show All Items")
		// load the initial state of the drop down
		if($spot.is('[data-screen]')){
			// spot is already linked to a screen
			var screenLink = $spot.attr('data-screen');
			$(spotForm.screens).map(function(){
				if(this.value == screenLink){
					$("#screenList input").val(this.name);
					return false;
				}
			})
		}else{
			$("#screenList input").val('');
		}
		$("#screenList input").autocomplete({
			minLength: 0,
			source: function( request, response ) {
				var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
				response($(spotForm.screens).map(function() {
					if (this.value && (!request.term || matcher.test(this.label)))
						return {
							label: this.label.replace(
								new RegExp(
									"(?![^&;]+;)(?!<[^<>]*)(" +
									$.ui.autocomplete.escapeRegex(request.term) +
									")(?![^<>]*>)(?![^&;]+;)", "gi"
								), "<strong>$1</strong>" ),
							value: this.value,
							src: this.src,
							name: this.name
						};
				}));
			},
			focus: function(event, ui) {
				$("#screenList input").val(ui.item.name);
				return false;
			},
			select: function(event, ui) {
				spotForm.$spot.attr('data-screen',ui.item.value);
				spotForm.$spot.hotspot('update');
				return false;
			},
			position:{'my':'left top','at':'left bottom','of':'#screenList','collision':'none'}
		})
		.data("autocomplete")._renderItem = function( ul, item ) {
			return $('<li class="screenItem "></li>')
				.data("item.autocomplete", item)
				.append(
					'<a><div class="media" style="margin-bottom:0px;">' +
						'<div class="img txtC">'+
							'<img style="display:inline;" src="'+item.src+'"/>' +
						'</div>' +
						'<div class="bd pls"><p>'+item.label+'</p></div>'+
					'</div></a>'
				)
				.appendTo(ul);
		};
	}
};
// template form
var toolbar = {
	$mainToolbar:null,
	$btnPreview:null,
	$btnEdit:null,
	$btnEditMode:null,
	$btnTemplate:null,
	$btnComments:null,
	init:function(){
		this.$mainToolbar = $('#mainToolbar');
		this.$btnPreview = this.$mainToolbar.find('.preview');
		this.$btnEditMode = $('#closePreview .editMode');
		this.$btnEdit = this.$mainToolbar.find('.edit');
		this.$btnTemplate = this.$mainToolbar.find('.template');
		this.$btnComments = this.$mainToolbar.find('.comments');
		this.templateForm.init();
		// toolbar button events
		this.$btnPreview.click(function(){toolbar.previewMode()});
		this.$btnEditMode.click(function(){toolbar.showSpots();toolbar.editMode()});
		this.$btnTemplate.click(function(e){toolbar.templateForm.open(e)});
		this.$btnComments.click(function(){toolbar.fadeSpots()});
		this.$btnEdit.click(function(){toolbar.showSpots();});

		$('#mainToolbar .btnGroup .btn').click(function(){
			$('#mainToolbar .btnGroup .btn').removeClass('selected');
			$(this).addClass('selected');
		});
	},
	showSpots:function(){
		$('#canvas .hotspot').fadeTo(250,0.7);
	},
	fadeSpots:function(){
		$('#canvas .hotspot').fadeTo(250,0.2);
	},
	previewMode:function(){
		$('#closePreview').position({'my':'left','at':'left','of':$('#mainToolbar .preview')});
		this.$mainToolbar.animate({top:-60},500,'easeInBack');
		$('#canvasWrap').animate({top:0},500,'easeInBack')
			.find('.hotspot')
			.fadeOut(function(){
				$(this).addClass('link').attr('data-editable','false').show();
			})
			.find('.ui-resizable-handle')
			.hide();
		this.templateForm.close();
	},
	editMode:function(){
		this.$mainToolbar.animate({top:0},500,'easeInBack');
		$('#canvasWrap').animate({top:48},500,'easeInBack', function(){
			$(this).find('.hotspot')
			.hide()
			.removeClass('link')
			.find('.ui-resizable-handle')
			.show()
			toolbar.showSpots();
		});
	},
	templateForm : {
		init:function(){
			// does the label hint
			$('#newTemplate').keyup(function(){
				if($(this).val().length == 0){
					$('#newTemplate-hint').show();
				}else{
					$('#newTemplate-hint').hide();
				}
			});
			$('#newTemplateSubmit').click(function(){toolbar.templateForm.newTemplate();});
			$('#templateForm .templateOk button').click(function(){toolbar.templateForm.close();});
			$('#templateForm').delegate('input:checkbox','click',function(){
				toolbar.templateForm.applyTemplate($(this));
			});
		},
		newTemplate:function(){
			if($('#newTemplate').val() == '') 
				return false;
			$.post("<?php echo NHtml::url('/project/screen/addTemplate') ?>",
				{template:$('#newTemplate').val(),project:<?php echo $project->id; ?>}, 
				function(r){
					if(r.template_id){
						var $newItem = $(r.item);
						$('#templateForm li.addTemplate').after($newItem)
						$newItem.hide().show(500,function(){
							if($('#templateFormNoTemplate').is(':visible')){
								$('#templateFormNoTemplate').hide('normal');
							}
						});
						$('#newTemplate').val('').focus();
						$('#newTemplate-hint').show();
						// update the spotForm templates select box
						spotForm.initTemplates();
					}
				},
				'json'
			);
		},
		toggleInfo:function(){
			if($('#templateForm li').length > 1){
				$('#templateFormNoTemplate').hide();
				$('#templateForm .templateOk').show();
			}else{
				$('#templateFormNoTemplate').show();
				$('#templateForm .templateOk').hide();
			}
		},
		open:function(e){
			this.toggleInfo();
			$('#templateForm').show();
			toolbar.$btnTemplate.addClass('selected');
			$('#templateForm').position({'my':'center top','at':'center bottom','of':toolbar.$btnTemplate,'offset':'0px 12px','collision':'none'});
			$('#newTemplate').focus();
			$('#templateForm').click(function(e){
				e.stopPropagation();
			});
			$('body').bind('click.templateForm',function(){
				toolbar.templateForm.close();
			});
			e.stopPropagation();
		},
		close: function(){
			toolbar.$btnTemplate.removeClass('selected');
			$('body').unbind('click.templateForm');
			$('#templateForm').hide();
		},
		ensureTemplateChecked:function(templateId){
			$checkbox = $('#templateForm').find('input[value="'+templateId+'"]');
			if(!$checkbox.is(':checked')){
				// its not checked so lets check it!
				$checkbox.attr('checked','checked');
				toolbar.templateForm.applyTemplate($checkbox);
			}
		},
		applyTemplate:function($checkBox){
			var templateId = $checkBox.val();
			if($checkBox.is(':checked')){
				$.post("<?php echo NHtml::url('/project/screen/applyTemplate') ?>",
				{'template':templateId,'screen':<?php echo $screen->id; ?>},function(hotspots){
					// get template hotspot info and add hotspots
					$(hotspots).map(function(){
						if($('#canvas').find('[data-id="'+this.id+'"]').length != 0)
							return;
						$('<a></a>').attr('data-id',this.id)
							.attr('data-screen',this.screen_id_link)
							.attr('data-template',this.template_id)
							.addClass('hotspot spot-template')
							.width(this.width)
							.height(this.height)
							.css('left',this.left+'px')
							.css('top',this.top+'px')
							.appendTo($('#canvas'))
							.hotspot();

					})
				},'json');
			}else{
				$.post("<?php echo NHtml::url('/project/screen/removeTemplate') ?>",
				{'template':templateId,'screen':<?php echo $screen->id; ?>},function(){
					// remove template hotspots
					$('#canvas').find('[data-template="'+templateId+'"]').remove();
				});
			};
		}
	}
}
	
$(function($){
		
	// Using the boxer plugin
	$('#canvas').boxer({
		stop: function(event, ui) {
			ui.box.addClass('hotspot')
			.removeClass('helper')
			.hotspot()
			.hotspot('update')
			.hotspot('showForm');// lets save our creation
		}
	}).click(function(){
		$("#screenList input").autocomplete("close");
	});
	$('.hotspot').hotspot();
	
	// lets code the toolbar
	
	
	
	toolbar.init();
	
	
	
	
});
	
</script>