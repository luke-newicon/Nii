<style type="text/css" media="screen">
	body{background-color: rgb(<?php echo $rgb['red']; ?>,<?php echo $rgb['green']; ?>,<?php echo $rgb['blue']; ?>);}
	html{background-color: rgb(<?php echo $rgb['red']; ?>,<?php echo $rgb['green']; ?>,<?php echo $rgb['blue']; ?>);}
	#canvas{margin: 0 auto;position:relative;cursor:default;width:<?php echo $screen->getWidth(); ?>px}
	.hotspot{position:absolute;cursor:pointer;}
	.hotspot.viewspot{background-color:#75ff4b;border-radius:5px; opacity:0.6;filter: alpha(opacity=50);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";}
	
	
	.ui-progressbar{background:-webkit-gradient(linear,center bottom,center top,from(#aaa), to(#666));background:-moz-linear-gradient(center top,#666, #aaa);border:1px solid #bbb;height:22px;}
	
	
	.ui-widget-overlay{background:#000;}
	.ui-dialog,.ui-dialog .ui-dialog-content{background:none;border-bottom:0px;box-shadow:none;}
	.ui-widget-header{border-bottom:0px;}
	#dialog h1,#dialog,.ui-widget-header{color:#fff;text-shadow:0px 1px 0px #000;}
	.percent{font-weight:bold;}
	
	#preload{width:100%;}
	
	#messageDialog .ui-widget-overlay{background:#fff;}
</style>




<div id="canvasWrap" >
	<?php $this->renderPartial('/screen/_canvas',array('screen'=>$screen,'onlyLinked'=>true)); ?>
</div>



<!--
<div id="info" style="display:none;">
	<div class="line" style="padding-top:30px;">
		<div class="unit size2of7"><img style="display:inline;" src="<?php echo ProjectModule::get()->assetsUrl; ?>/keys.png" /></div>
		<div class="lastUnit"><h1 style="font-size:22px;padding-top:8px;">Tap the Shift or H key to show hotspots</h1></div>
	</div>
	<ul class="ptl" style="font-size:11px;">
		<li>The “H” key will hold the hotspots on the screen, you can tap “H” again or the shift key to hide the hotspots.</li>
		<li>The Shift key will show the hotspots only whilst it is pressed down.</li>
	</ul>
	<div id="infobtn" style="display:none;">
		<button style="font-size:200%;width:100%;" class="btn aristo primary mtm">Ok</button>
	</div>
</div>
-->
<div id="messageDialog">
</div>

<div id="dialog" title="" style="display:none;">
	<div id="preload">
		<h1 style="padding-bottom:8px;">Visuals have been shared with you for review.</h1>
		<div class="line">
			<div class="unit size2of7"><img style="display:inline;" src="<?php echo ProjectModule::get()->assetsUrl; ?>/keys.png" /></div>
			<div class="lastUnit"><h1 style="font-size:22px;padding-top:8px;">Tap the Shift or H key to show hotspots</h1></div>
		</div>
		<ul class="ptl" style="font-size:11px;">
			<li>The “H” key will hold the hotspots on the screen, you can tap “H” again or the shift key to hide the hotspots.</li>
			<li>The Shift key will show the hotspots only whilst it is pressed down.</li>
		</ul>
	</div>
	<div id="progress" style="display:block;position:absolute;top:175px;width:600px;">
		<div class="bar"></div>
		<div style="padding-top:3px;">Loading visuals: <span class="percent"></span></div>
	</div>
	<div id="infobtn" style="display:none;">
		<button onclick="$('.ui-widget-overlay').fadeOut();$('#dialog').fadeOut(function(){$('#dialog').dialog('close');});" style="font-size:200%;width:100%;" class="btn aristo primary mtm">Ok</button>
	</div>
</div>


<div id="commentMode" style="position:fixed;bottom:0px;right:0px;background-color:#000;color:white">Comments</div>

<script>

(function($){
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
					"screen":$('#canvas').attr('data-id'),
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
			// if the form is visible and the spot is not stored in db then we don't want to do nofin' or nofin'
			if($('#commentsForm').is(':visible') && !$spot.is('[data-id]')){
				// do nofin or nofin
			}else{
				commentForm.show($spot);
			}
			
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

/**
 * Load in a screen and its hotspots and comments by ajax
 */
var loadScreen = function(screenId){
	// select the sidebar image
	$.bbq.pushState({i:screenId});
}

var _doLoadScreen = function(hsId){
	$canvas = $('#canvas');
	var screenId = view.hotspotData[hsId].screen_id_link
	//console.log(view.hotspotData);
	$img = $canvas.find('img')
	$newImg = $canvas.find('img[data-id="'+screenId+'"]');
	// as the home page image is both preloaded in and loaded in on initial load we need to remove it
	if($newImg.length>1){
		$newImg.eq(1).remove();
	}
	$img.hide();
	$newImg.show()
	
	// now load the hotspots for the screen
	var $canvasHs = $('#canvas-hotspots').html('');
	var hotspot;
	$.each(view.screenData[screenId].screenHotspots,function(i,h){
		//console.log(h);
		hotspot = view.hotspotData[h];
		var $h = $('<a><br/></a>')
			.attr('href','#i='+hotspot.id)
			.attr('data-id',hotspot.id)
			.attr('data-screen',hotspot.screen_id_link)
			.addClass("hotspot")
			.width(hotspot.width)
			.height(hotspot.height)
			.css('left',hotspot.left+'px')
			.css('top',hotspot.top+'px')
			.appendTo($canvasHs);
	});
	
	// load in comments for the screen
	// sort comments out
	var $canvasCom = $('#canvas-comments').html('');
	var cNum = 1;
	$.each(view.screenData[screenId].comments,function(i,c){
		
		console.log(c);
		$('<a></a>')
			.attr('data-id', c.data.id)
			.attr('data-screen', c.data.screen_id)
			.css('left', c.data.left+'px')
			.css('top', c.data.top+'px')
			.css('position','absolute')
			.addClass('commentSpot')
			.hide()
			.html(cNum)
			.appendTo($canvasCom)
			.commentSpot();
		cNum++;
	})
	commentForm.commentStore = view.screenData[screenId].comments;
	
	$canvas.attr('data-id',screenId);
	$canvas.width($newImg);
	//$('#canvas-hotspots').html(view.screenData[screenId].hotspots);
	// lookup hotspot data. see if it should fix scroll position
	//console.log(view.hotspotData[hsId])
	//console.log(view.hotspotData[hsId].fixed_scroll)
	if(view.hotspotData[hsId].fixed_scroll == 0){
		$(document).scrollTo(0);
	}
	
	
	console.log(commentForm.commentStore);
	$('#canvas .commentSpot').commentSpot();
	commentForm.init();
	// do the background color;
	$('body').css('backgroundColor','rgb('+view.screenData[screenId].rgb.red+','+view.screenData[screenId].rgb.green+','+view.screenData[screenId].rgb.blue+')');
	$('html').css('backgroundColor','rgb('+view.screenData[screenId].rgb.red+','+view.screenData[screenId].rgb.green+','+view.screenData[screenId].rgb.blue+')');
	view.spotState();
}

var view = {
	visibleSpots:false,
	hotspotData:<?php echo $hotspotData; ?>,
	screenData:<?php echo $screenData; ?>,
	screenDataSize:<?php echo $screenDataSize; ?>,
	spotState:function(){
		(view.visibleSpots) ? view.showSpots() : view.hideSpots();
	},
	showSpots:function(pinSpots){
		if(pinSpots!=undefined)
			view.visibleSpots = pinSpots
		jQuery('#canvas .hotspot').addClass('viewspot');
	},
	hideSpots:function(){
		jQuery('#canvas .hotspot').removeClass('viewspot');
		view.visibleSpots = false;
	},
	togglePinSpots:function(){
		if($('#canvas .hotspot').is('.viewspot')){
			view.hideSpots();
		}else{
			view.showSpots(true);
		}
	}
}



var preloader = {
	preload:function(){
		var done=0;;
		var percent;
		var $preloadDiv = $('#canvas');
		$("#progress .bar").progressbar({value: 1});
		$.each(view.screenData, function(i,val){
			var img = new Image();
			// wrap our new image in jQuery, then:
			$(img)
				.hide()
				.attr('data-id',val.id)
				.attr('src', val.src)
				.load(function () {
					// set the image hidden by default
					$(img).prependTo($preloadDiv);
					done += 1;
					// might load in different order so
					// lets just count the number done in the done array
					percent = done * (100/view.screenDataSize);
					$("#progress .bar").progressbar({value: percent});
					$('#progress .percent').html(Math.floor(percent) + '%');
					if(percent>99.9){
						preloader.displayInfo();
					}
				})
				.error(function () {
					// show broken image graphic here
					alert('oops broken image');
				});
		});
	},
	displayInfo:function(){
		$('#progress').fadeTo(500,0);
		$('#infobtn').fadeIn();
		// Since the event is only triggered when the hash changes, we need to trigger
		// the event now, to handle the hash the page may have loaded with.
		$(window).trigger( 'hashchange' );
	}
}


var commentForm = {
	defaultHeight:60,
	$form:null,
	$canvas:null,
	$textarea:null,
	$save:null,
	$cancel:null,
	commentStore:null,
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

$(function(){

	$(window).bind("hashchange", function(e) {
		// In jQuery 1.4, use e.getState( "url" );
		var i = e.getState("i");
		_doLoadScreen(i);
	});
	
	$('#canvasWrap').delegate('.hotspot', 'click', function(){
		var $spot = $(this);
		var sId = $spot.attr('data-id');
		loadScreen(sId);
		return false
	});

	jQuery(document).bind('keypress', 'h', function (evt){
		view.togglePinSpots();
		return false; 
	});
	jQuery(window).bind('keydown', 'shift', function (evt){
		view.showSpots(); return false; 
	});
	jQuery(window).bind('keyup', 'shift', function (evt){
		view.hideSpots(); return false; 
	});
	
	
	$('#dialog').dialog({
		width:650,
		height:400,
		position:{my:'center',at:'center',of:$(window),offset:'0px -100px'},
		modal:true,
		draggable:false,
		resizable:false,
		open: function(event, ui) { 
			$(".ui-dialog-titlebar-close").hide(); 
		}
	});
	$('.ui-widget-overlay').css('opacity',0.8);
	
	preloader.preload();
	
	$('#commentMode').click(function(){
		$('#canvas-comments .commentSpot').show();
	});
	
});



</script>