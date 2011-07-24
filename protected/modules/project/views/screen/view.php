<style type="text/css" media="screen">
	body{background-color: rgb(<?php echo $rgb['red']; ?>,<?php echo $rgb['green']; ?>,<?php echo $rgb['blue']; ?>);}
	html{background-color: rgb(<?php echo $rgb['red']; ?>,<?php echo $rgb['green']; ?>,<?php echo $rgb['blue']; ?>);}
	#canvas{margin: 0 auto;position:relative;cursor:default;width:<?php echo $screen->getWidth(); ?>px}
	.hotspot{position:absolute;cursor:pointer;}
	.hotspot.viewspot{background-color:#75ff4b;border-radius:5px;opacity:0.8}
	
	#progress{position:fixed;display:none;z-index:10;width:300px;}
	.ui-progressbar{background:-webkit-gradient(linear,center bottom,center top,from(#aaa), to(#666));background:-moz-linear-gradient(center top,#666, #aaa);border:1px solid #bbb;height:22px;}
</style>
<div id="canvasWrap" >
	<?php $this->renderPartial('_canvas',array('screen'=>$screen,'onlyLinked'=>true)); ?>
</div>



<div id="dialog">
<div id="progress" class="pam blackpop" style="display:block">
	<div class="bar"></div>
	<div class="percent"></div>
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
	showSpots:function(){
		jQuery('#canvas .hotspot').addClass('viewspot');
	},
	hideSpots:function(){
		jQuery('#canvas .hotspot').removeClass('viewspot');
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
		if($('#canvas .hotspot').is('.viewspot')){
			jQuery('#canvas .hotspot').removeClass('viewspot');
			view.visibleSpots = false;
		}else{
			jQuery('#canvas .hotspot').addClass('viewspot');
			view.visibleSpots = true;
		}
		return false; 
	});
	jQuery(window).bind('keydown', 'shift', function (evt){
		jQuery('#canvas .hotspot').addClass('viewspot'); return false; 
	});
	jQuery(window).bind('keyup', 'shift', function (evt){
		jQuery('#canvas .hotspot').removeClass('viewspot'); return false; 
	});
	
	
	$('#dialog').dialog({modal:true,draggable:false})
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
			})
			.error(function () {
				// show broken image graphic here
				alert('oops broken image');
			});
	})

	
});
</script>