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
</div>-->
<div id="messageDialog">
</div>

<div id="dialog" title="">
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


<script>



/**
 * Load in a screen and its hotspots and comments by ajax
 */
var loadScreen = function(screenId){
	// select the sidebar image
	$.bbq.pushState({i:screenId});
}

var _doLoadScreen = function(hsId, maintainScroll){
	$canvas = $('#canvas');
	var screenId = view.hotspotData[hsId].screen_id_link
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
	console.log(view.hotspotData);
	$.each(view.screenData[screenId].screenHotspots,function(i,h){
		console.log(h);
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
			.appendTo($canvasHs)
	});
	
	$canvas.attr('data-id',screenId);
	$canvas.width($newImg);
	//$('#canvas-hotspots').html(view.screenData[screenId].hotspots);
	// lookup hotspot data. see if it should fix scroll position
	$(document).scrollTo(0);
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
					if(percent==100){
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
	
});



</script>