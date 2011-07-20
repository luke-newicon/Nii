<style type="text/css" media="screen">
	body{background-color: rgb(<?php echo $rgb['red']; ?>,<?php echo $rgb['green']; ?>,<?php echo $rgb['blue']; ?>);}
	html{background-color: rgb(<?php echo $rgb['red']; ?>,<?php echo $rgb['green']; ?>,<?php echo $rgb['blue']; ?>);}
	#canvas{margin: 0 auto;width:<?php echo $width; ?>px;position:relative;cursor:crosshair;}
	
	/** 
	 * hotspot styles
	 */
	.hotspot{cursor:pointer;z-index: 100; position: absolute;background-color:#c3d0f6;border:1px dotted #2946a7;opacity: 0.4;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";filter: alpha(opacity=70);}
	.hotspot.helper{border:1px dotted #2946a7;cursor:crosshair;opacity: 0.3;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=40)";filter: alpha(opacity=40);}
	
/*	.hotspot.linked{opacity:0.7;border-style:solid;}*/
	.hotspot[data-screen]{opacity:0.7;border-style:solid;}
	.hotspot[data-template]{background-color:orange;border-color:red;}
	
	.hotspot.link{background-color:transparent;border:none;}
	a.hotspot[data-disabled="true"]{cursor:help;}
	/*.spot-template{background-color:orange;border-color:red;}*/
	
	.spotForm{border-radius:5px;z-index:3000;background-color:#f1f1f1;background:-moz-linear-gradient(bottom, #ddd, #f1f1f1);background:-webkit-gradient(linear, left bottom, left top, from(#ddd), to(#f1f1f1));width:300px;border:1px solid #535a64;box-shadow:0px 3px 10px #444,inset 0px 1px 0px 0px #fff; top:100px;left:100px;position:absolute; }
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

	

	#closePreview{position:absolute;top:0px;right:0px;z-index:700;}
	
	.toolbarForm{z-index:4001;padding:10px;width:250px;text-shadow:0px 1px 0px #fff;}
	.triangle-verticle{background:url("<?php echo ProjectModule::get()->getAssetsUrl().'/triangle-verticle.png'; ?>") no-repeat top left;width:30px;height:22px;left:45%;top:-29px;position:absolute;}
	.template label:hover {}
	.template.selected label {}
	.addTemplate .inputBox{border-radius:3px 0px 0px 3px;}
	.sidebarImg .sideImg{box-shadow:0px 0px 5px #000;margin:10px;}
	.imageTitle{padding:5px 10px;border-radius:10px;background-color:#666;color:#fff;text-shadow:0px 1px 0px #000;}
	.sidebarImg .loading{width:165px;height:165px;background-color:#f1f1f1;}

	button{margin:0px;}
	body{overflow:hidden;}
	
	.username{font-weight:bold;}
	.stats{color:#999;}

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
			<button class="btn aristo sidebar selected" href="#"><span class="icon fam-application-side-list man"></span></button>
		</div>
		<div class="unit plm" style="padding-top:10px;">
			<button class="btn aristo template" href="#"><span class="icon fam-application-side-list"></span> Templates</button>
		</div>
		<div class="unit plm btnGroup" style="padding-top:10px;">
			<button class="btn aristo btnToolbarLeft comments" href="#"><span class="fugue fugue-balloon-white-left"></span>Comments</button><button class="btn aristo btnToolbarRight edit selected" href="#"><span class="fugue fugue-layer-shape"></span>Edit</button>
		</div>
		<div class="unit plm" style="padding-top:10px;">
			<button class="btn aristo preview" href="#"><span class="fugue fugue-magnifier"></span>Preview</button>
		</div>
		<div class="unit plm" style="padding-top:10px;">
			<button class="btn aristo share" data-tip="" title="Share" href="#"><span class="fugue fugue-arrow-curve"></span></button>
		</div>
		<div class="unit plm" style="padding-top:10px;">
			<button class="btn aristo" data-tip="" title="Configure" href="#"><span class="icon fam-cog"></span></button>
		</div>
	</div>
</div>
<div id="closePreview" style="position:absolute;top:10px;left:10px;">
	<button class="btn aristo editMode" data-tip="{gravity:'nw'}" title="Close preview and return to edit mode" href="#"><span class="fugue fugue-layer-shape"></span> Edit</button>
</div>

<?php $this->renderPartial('_template-form',array('screen'=>$screen)); ?>
<?php $this->renderPartial('_share-form',array('screen'=>$screen,'project'=>$project)); ?>


<div  id="screenWrap" style="position: absolute; width:200px; top:48px;  height: 400px;border-right:1px solid #000;">
	<div id="screenPane" class="unit" style="overflow: auto;z-index:300;background-color:#aaa;">
		<?php foreach($project->getScreens() as $s): ?>
		<div class="sidebarImg txtC">
			<a href="#" onclick="return false;" style="display:block" title="<?php echo $s->name; ?>" class="loading sideImg" data-id="<?php echo $s->id; ?>" data-src="<?php echo NHtml::urlImageThumb($s->file_id, 'projectSidebarThumb'); ?>"></a>
			<span class="imageTitle"><?php echo $s->name; ?></span>
		</div>
		<? endforeach; ?>
	</div>
</div>

<div id="canvasWrap" style="position: absolute; top:48px; overflow: auto; left:200px; height: 400px;"> 
<?php $this->renderPartial('_canvas',array('screen'=>$screen)); ?>
</div>

<!-- this is a hidden div image cache -->
<div style="display: none; ">
	<?php foreach($project->getScreenList() as $cache): ?>
	<img src="<?php echo $cache['src']; ?>" width="48" />
	<?php endforeach; ?>
</div>
<script>

// comment code is insanely fragile
// perhaps rewrite into controller to handle states
// example: 
// - clicked from saved spot to canvas
// - from saved spot to another saved spot
// - from an unsaved spot to a new spot
// - etc
//
(function($){
	
	
	$(function(){
		$('#screenPane .sidebarImg a').click(function(){
			var id = $(this).attr('data-id');
			$.post("<?php echo NHtml::url('/project/screen/load') ?>",{'id':id},function(r){
				$('#canvasWrap').html(r.canvas);
				commentForm.commentStore = r.commentsJson;
				initCanvas();
				toolbar.initTemplates();
			},'json')
		});
	});
	
	var methods = {
		init : function(options) {
			return this.each(function(){
				var $this = $(this);
				$this.draggable({
					start:function(){
						// handles the case when dragging a db spot from a non db spot
						// we want to remove the non db spot
						if(commentForm.$currentSpot!=undefined 
						&& !commentForm.$currentSpot.is('[data-id]') 
						&& $this.is('[data-id]'))
						{
							commentForm.$currentSpot.remove();
						}
						commentForm.$form.hide();
					},
					drag: function(event, ui) {
					},
					stop:function(e,ui){
						commentForm.show($this);
						if($this.is('[data-id]')){
							commentForm.show($this);
							$this.commentSpot('save', false);
						}
					}
				})
				.click(function(e){
					$this.commentSpot('click',e);
				});
			});
		},
		save:function(hideForm){
			hideForm = (hideForm === false) ? false:true;
			var $spot = $(this);
			//alert($spot.text());
			var id = 0;
			var comment = commentForm.$textarea.val();
			if(comment=='')
				return;
			
			commentForm.formModel = true;
			commentForm.$form.find('.save').text('Saving...')
			
			if($spot.is('[data-id]')){
				id = $spot.attr('data-id');
			}else{
				// we are saving the comment spot
				// we need to create an empty data-id attribute so the app knows its saved,
				// this prevents the race condition of the app cleaning this spot 
				// and the textarea up because it thinks it is not saved, when the ajax returns the data-id attribute will be populated
				$spot.attr('data-id','');
			}
			
			$.post("<?php echo NHtml::url('/project/screen/saveComment'); ?>",
				{
					"screen":<?php echo $screen->id; ?>,
					"comment":commentForm.$textarea.val(),
					"id":id,
					"top":$spot.position().top,
					"left":$spot.position().left,
					"number":$spot.text()
				},
				function(r){
					// on save i want to get the id. store it in an array as the key with the comment being the value
					// so i don't have to ajax in the comment all the time'
					$spot.attr('data-id', r.id);
					
					commentForm.commentStore[r.id] = {'comment':comment,'view':r.comment};
					commentForm.formModel = false;
					commentForm.$form.find('.save').text('Save');
					if(hideForm){
						$('#commentForm').hide();
						$('#commentView').html(r.comment);
						$('#commentViewWrap').show();
						//commentForm.$form.hide();
					}
				},
				'json'
			);
			
		},
		click:function(e){
			var $spot = $(this);
			commentForm.show($spot);
		},
		deleteComment:function(){
			var $spot = $(this);
			if(!$spot.is('[data-id]')){
				$spot.remove();
				commentForm.$form.fadeOut('fast');
			}else{
				$.post("<?php echo NHtml::url('/project/screen/deleteComment') ?>",
					{"id":$spot.attr('data-id')},
					function(){
						//$spot.remove();
						//commentForm.$form.fadeOut('fast');
					},
					'json'
				);
			}
			
			$spot.remove();
			commentForm.$textarea.val('');
			commentForm.$form.fadeOut('fast');
		}
	};
	$.fn.commentSpot = function( method ) {
		if ( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.hotspot' );
		}    
	};
})( jQuery );
var commentForm = {
	defaultHeight:60,
	$form:null,
	$canvas:null,
	$textarea:null,
	$save:null,
	$cancel:null,
	commentStore:<?php echo $this->getCommentsJson($screen); ?>,
	$currentSpot:null,
	formModel:false,
	init:function(){
		this.$form = $('#commentsForm');
		this.$canvas = $('#canvas');
		this.$textarea = commentForm.$form.find('textarea');
		this.$save = this.$form.find('.save');
		this.$cancel = this.$form.find('.cancel');
		// attach events n stuff
		// remove the browser default textarea resize handle
		
		this.$textarea.css('resize','none');
		//this.$form.resizable({alsoResize:'#commentsForm textarea, #commentsForm .previewBox'});
		this.$textarea.keyup(function(){
			if(commentForm.$textarea.val() == ''){
				commentForm.$save.addClass('disabled');
			}else{
				commentForm.$save.removeClass('disabled');
			}
		})
	},
	canvasClick:function(e){
		commentForm.$form.find('#md-comments').markdown('edit');
		if(commentForm.formModel)
			return false;
		if($(e.target).is('.commentSpot')){
			// alert('omment spot');
			$(e.target).commentSpot('click')
		}else{
			commentForm.newComment(e);
		}
		e.stopPropagation();
		return false;
	},
	position:function($cSpot){
		this.$form.position({'my':'left top','at':'left top','of':$cSpot,'offset':'43px -16px','collision':'none'});
	},
	show:function($cSpot){
		if(this.$form.is(':visible')){
			// if the comment form is already visible lets hide it
			// if clicking on a spot from a new spot we want the hide function to remove the spot with no data-id attribute
			// otherwise we get zombie spots
			commentForm.hide(this.$currentSpot);
		}
		this.$currentSpot = $cSpot;
		
		this.setTextarea($cSpot);
		
		this.$form.show();
		this.$textarea.focus();
		
		this.position($cSpot);
		
		// attach events
		this.$form.unbind('.commentForm');
		this.$form.delegate('.save','click.commentForm',function(e){if($(e.target).is('.disabled')){return false;}$cSpot.commentSpot('save');});
		this.$form.delegate('.cancel','click.commentForm',function(){commentForm.cancel($cSpot)});
		this.$form.delegate('.close','click.commentForm',function(){commentForm.close($cSpot)});
		this.$form.delegate('.edit','click.commentForm',function(){commentForm.edit($cSpot)});
		this.$form.delegate('.delete','click.commentForm',function(){$cSpot.commentSpot('deleteComment')});
	},
	cancel:function($cSpot){
		if($cSpot.is('[data-id]')){
			commentForm.showView();
		} else {
			commentForm.close($cSpot);
		}
	},
	edit:function($cSpot){
		var h = $('#commentViewWrap').height();
		$('#commentViewWrap').hide();$('#commentForm').show();
		$('#commentForm textarea').height(h-61);
	},
	close:function($cSpot){
		commentForm.hide($cSpot);
		commentForm.$textarea.val('');
	},
	newComment:function(e){
		commentForm.showForm();
		commentForm.$textarea.height(commentForm.defaultHeight);
		if(this.$form.is(':visible')){
			// if the comment form is already visible lets hide it
			// if we return false here we will prevent clicking elsewhere on the canvas whilst
			// the comment form is visible
			// return false;
			commentForm.hide(this.$currentSpot);
		}
		if(this.$currentSpot == undefined || this.$currentSpot.is('[data-id]')){
			// we are clicking a new comment from an existing comment
			// we want the textarea to appear empty - not with the current comments comment
			this.$textarea.val('');
		}
		
		var commentNo = this.$canvas.find('.commentSpot').length+1;
		var $spot = $('<a class="commentSpot">'+commentNo+'</a>');
		this.$canvas.append($spot);
		$spot.css({
			"z-index": 100,
			"position": "absolute",
			"left": e.clientX-this.$canvas.offset().left,
			"top": e.clientY-this.$canvas.offset().top
		});
		$spot.commentSpot();
		$spot.commentSpot('click');
	},
	setTextarea:function($cSpot){
		if(commentForm.$textarea.val() == ''){
			commentForm.$save.addClass('disabled');
		}
		if($cSpot.is('[data-id]')){
			
			var key = $cSpot.attr('data-id');
			if(key in commentForm.commentStore){
				// alert(commentForm.commentStore[key].view);
				
				// display view
				$('#commentForm').hide();
				$('#commentView').html(commentForm.commentStore[key].view);
				$('#commentViewWrap').show();
				
				commentForm.$textarea.val(commentForm.commentStore[key].comment);
			}
		}else{
			commentForm.$cancel.text('Cancel');
		}
	},
	showView:function(){
		$('#commentForm').hide();$('#commentViewWrap').show();
	},
	showForm:function(){
		$('#commentForm').show();$('#commentViewWrap').hide();
	},
	hide:function($cSpot){
		// lets remove the spot if there is no comment
		if(!$cSpot.is('[data-id]')){
			$cSpot.remove();
		}
		this.$form.hide();
	}
}





var resizer = function(){
	$('#canvasWrap').snapy({'snap':$(window)});
	$('#screenWrap').snapy({'snap':$(window)});
	$('#screenPane').snapy({'snap':'#screenWrap'});
	$('#canvasWrap').css('width',($('body').width()-$('#screenWrap').width()+$('#screenWrap').border().right-2) + 'px');
	$('#canvasWrap').css('left',$('#screenWrap').width());
	
	//$('#canvasWrap').css('height',$(window).height()-$('#canvasWrap').offset().top);
	//$('#screenWrap').css('height',$(window).height()-$('#screenWrap').offset().top);
	
	$('#screenPane img').width($('#screenPane').width()-35);
}
$(function($){
	$(window).resize(function(){
		resizer();
	});
	$('#canvasWrap').snapy({'snap':$(window)});
	$('#screenWrap').snapy({'snap':$(window)});
	$('#screenWrap').resizable({
		handles:'e',
		alsoResize:'#screenPane',
		stop:function(){
			resizer();
		}
	});
	commentForm.init();
	resizer();
	$('#screenPane').scroll(function(){
		$('.sideImg').tipsy('show');
	});
	//$('.sideImg').draggable({'helper':$('<div>screen</div>').appendTo('body')});
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
				
				var winHeight = $snapTo.height();
				
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
		if(!$('#mainToolbar .edit').is('.selected')){
			// we are not in edit mode!'
			return false;
		}
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
					$this.hotspot('click',e);
				});
			});
		},
		showForm:function(){
			spotForm.showForm($(this));			
		},
		update:function(){
			// update the server with spot details
			var $spot = $(this);
			var offset = $spot.position();
			var id = -1;
			var screenId = 0;
			if($spot.is('[data-id]'))
				id = $spot.attr('data-id');
			if($spot.is('[data-screen]')){
				screenId = $spot.attr('data-screen');
				$spot.addClass('linked');
			}else{
				$spot.removeClass('linked');
			}
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
		setStateLink:function(){
			this.removeAttr('data-disabled')
				.addClass('link')
				.attr('data-editable','false').show()
				.find('.ui-resizable-handle').hide()
		},
		setStateEdit:function(){
			this.removeClass('link')
				.attr('data-editable','true')
				.find('.ui-resizable-handle').show()
		},
		link:function(){
			// hotspots may not have a defined screen id, so be careful
			var $spot = $(this);
			if($spot.is('[data-screen]')){
				location.href = "<?php echo NHtml::url('/project/screen/index'); ?>/id/"+$spot.attr('data-screen');
			}
		},
		click:function(e){
			var $spot = $(this);
			// detect keypress
			// if shift click then load the screen link
			// only available if there is a screen link id
			if($spot.is('[data-disabled]')){
				//spot is disabled so don't do anything.
				return false;
			}
			if (e.shiftKey) {
				$spot.hotspot('link');
			}else{
				if($spot.is('.link')){
					$spot.hotspot('link');
				}else{
					$spot.hotspot('showForm');
				}
			}
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
		if(val==0) {
			// we have selected no template so if the current spot is a template we want to unlink it.
			spotForm.$spot.removeAttr('data-template').removeClass('spot-template');
			// update db to unlink spot from template
			$.post("<?php echo NHtml::url('/project/screen/addTemplateSpot') ?>",
				{'spot':spotForm.$spot.attr('data-id'), 'template':val});
			return false;
		}
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
		$select.append('<option value="0">- select template -</option>');
		$templates = $('#templateForm li.template');
		if($templates.length == 0){
			$('#spotTemplatesNone').show();
			$('#spotTemplatesSelect').hide();
		}else{
			$('#spotTemplatesNone').hide();
			$('#spotTemplatesSelect').show();
		}
		$templates.each(function(){
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
		$("#screenListInput").autocomplete({
			minLength: 0,
			source: function( request, response ) {
				var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
				response($(spotForm.screens).map(function() {
					if (this.value && (!request.term || matcher.test(this.label)))
						return {
							label: this.label.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + $.ui.autocomplete.escapeRegex(request.term) + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<strong>$1</strong>" ),
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
	$btnShare:null,
	sidebarWidth:200,
	init:function(){
		this.$mainToolbar = $('#mainToolbar');
		this.$btnPreview = this.$mainToolbar.find('.preview');
		this.$btnEditMode = $('#closePreview .editMode');
		this.$btnEdit = this.$mainToolbar.find('.edit');
		this.$btnTemplate = this.$mainToolbar.find('.template');
		this.$btnComments = this.$mainToolbar.find('.comments');
		this.$btnShare = this.$mainToolbar.find('.share');
		this.templateForm.init();
		this.shareForm.init();
		// toolbar button events
		this.$btnPreview.click(function(){toolbar.previewMode()});
		this.$btnEditMode.click(function(){toolbar.showSpots();toolbar.editMode()});
		this.$btnTemplate.click(function(e){toolbar.templateForm.open(e)});
		this.$btnShare.click(function(e){toolbar.shareForm.open(e)});
		this.$btnComments.click(function(){toolbar.comments()});
		this.$btnEdit.click(function(){toolbar.edit();});

		$('#mainToolbar .btnGroup .btn').click(function(){
			$('#mainToolbar .btnGroup .btn').removeClass('selected');
			$(this).addClass('selected');
		});
		$('#mainToolbar .sidebar').click(function(){
			if($(this).is('.selected')){
				toolbar.sidebarClose();
			}else{
				toolbar.sidebarOpen();
			}
		});
	},
	showSpots:function(){
		$('#canvas .hotspot').css('opacity','').removeAttr('data-disabled').find('.ui-resizable-handle').show();
	},
	fadeSpots:function(){
		$('#canvas .hotspot').fadeTo(250,0).attr('data-disabled','true').find('.ui-resizable-handle').hide();
	},
	showComments:function(){
		$('#canvas .commentSpot').show();
	},
	fadeComments:function(){
		$('#canvas .commentSpot').fadeOut(250);
	},
	previewMode:function(){
		toolbar.sidebarClose();
		//$('#closePreview').position({'my':'left','at':'left','of':$('#mainToolbar .preview')});
		this.$mainToolbar.animate({top:-60},500,'easeInBack');
		//$('#screenWrap').hide('fast',function(){/*$(this).width(0);*/});
		$('#canvasWrap').animate({top:0},500,'swing')
			.find('.hotspot').hotspot('setStateLink');
		
		this.templateForm.close();
		if(toolbar.$btnComments.is('.selected')){
			
		}
		$('#canvas').css('cursor','default');
	},
	editMode:function(){
		toolbar.sidebarOpen();
		$('#screenWrap').show('fast')
		this.$mainToolbar.animate({top:0},500,'easeInBack');
		$('#canvasWrap').find('.hotspot').hotspot('setStateEdit');
		toolbar.showSpots();
		$('#canvasWrap').animate({top:48},500,'easeInBack', function(){
			resizer();
		});
		//$('#screenWrap').width(200);
		//$('#screenWrap').show('fast');
		$('#canvas').css('cursor','crosshair');
		toolbar.$btnEdit.click();
	},
	edit:function(){
		toolbar.showSpots();
		toolbar.fadeComments();
		$('#canvas').css('cursor','');
	},
	comments:function(){
		toolbar.fadeSpots();
		toolbar.showComments();
		$('#canvas').css('cursor','help');
	},
	sidebarOpen:function(){
		$('#screenWrap').show();
		if(toolbar.sidebarWidth==0){
			toolbar.sidebarWidth = 200;
		}
		$('#screenWrap').width(toolbar.sidebarWidth);
		$('#screenPane').width(toolbar.sidebarWidth);
		$('#canvasWrap').width($(window).width()-toolbar.sidebarWidth);
		$('#canvasWrap').css('left',toolbar.sidebarWidth);
		$('#mainToolbar .sidebar').addClass('selected');
		resizer();
		
	},
	sidebarClose:function(){
		if($('#screenWrap').width() != 0){
			toolbar.sidebarWidth = $('#screenWrap').width();
		}
		$('#screenWrap').width(0);
		$('#screenPane').width(0);
		$('#canvasWrap').width($(window).width());
		$('#canvasWrap').css('left',0);
		$('#mainToolbar .sidebar').removeClass('selected');
		resizer();
		$('#screenWrap').hide();
	},
	shareForm:{
		init:function(){
			$('#shareForm .templateOk button').click(function(){toolbar.shareForm.close();});
		},
		open:function(e){
			$('#shareForm').show();
			toolbar.$btnShare.addClass('selected');
			$('#shareForm').position({'my':'center top','at':'center bottom','of':toolbar.$btnShare,'offset':'0px 12px','collision':'none'});
			$('#shareForm').click(function(e){
				e.stopPropagation();
			});
			$('body').bind('click.shareForm',function(){
				toolbar.shareForm.close();
			});
			e.stopPropagation();
		},
		close: function(){
			toolbar.$btnShare.removeClass('selected');
			$('body').unbind('click.shareForm');
			$('#shareForm').hide();
		}
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
						var $spot = $('<a></a>').attr('data-id',this.id)
							.attr('data-screen',this.screen_id_link)
							.attr('data-template',this.template_id)
							.addClass('hotspot spot-template')
							.width(this.width)
							.height(this.height)
							.css('left',this.left+'px')
							.css('top',this.top+'px')
							.appendTo($('#canvas'))
							.hotspot();
						if($spot.is('[data-screen]')){
							$spot.addClass('linked');
						}

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

var initCanvas = function(){
	// Using the boxer plugin
	$('#canvas').boxer({
		stop: function(event, ui) {
			ui.box.addClass('hotspot')
			.removeClass('helper')
			.hotspot()
			.hotspot('update')
			.hotspot('showForm');// lets save our creation
		}
	}).click(function(e){
		if($('#mainToolbar .comments').is('.selected')){
			commentForm.canvasClick(e)
		}
		$("#screenList input").autocomplete("close");
	})
	$('#canvas .hotspot').hotspot();
	$('#canvas .commentSpot').commentSpot();
	// lets code the toolbar
	toolbar.init();
}
	
$(function($){
	initCanvas();
	


	// load sidebar images
//	
	var loadSideImage = function($div){
		var src = $div.attr('data-src');
		var img = new Image();
		// wrap our new image in jQuery, then:
		$(img).load(function () {
			// set the image hidden by default    
			$(this).hide().width($div.width());	
			$div.append(this).removeClass('loading');
			$(this).fadeIn();
		})
		.error(function () {
			// show broken image graphic here
			alert('oops broken image');
		})
		.attr('src', src)
		.width($('#screenPane').width()-35);	
	};
	$('#screenWrap .sidebarImg .sideImg').each(function(){
		var $div = $(this);
		setTimeout(function(){loadSideImage($div)},10);
	});
	

});
	
</script>