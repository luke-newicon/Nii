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
	<?php $this->renderPartial('_canvas',array('screen'=>$screen)); ?>
</div>



<div id="dialog">
<div id="progress" class="pam blackpop" style="display:block">
	<div class="bar"></div>
	<div class="percent"></div>
</div>
</div>


<div id="preloadImages" style="display:none;"></div>
<script>



/**
 * Load in a screen and its hotspots and comments by ajax
 */
var loadScreen = function(screenId, maintainScroll){
	// select the sidebar image
	if(maintainScroll==undefined){maintainScroll=0};
	$.bbq.pushState({ i: screenId, s:maintainScroll });
}

var _doLoadScreen = function(screenId, maintainScroll){
	
	$.get("<?php echo NHtml::url('/project/screen/load') ?>",{'id':screenId},function(r){
		$('#canvasWrap').html(r.canvas);
		commentForm.commentStore = r.commentsJson;
		initCanvas();
		// set background color
		$('body').css('backgroundColor','rgb('+r.bgRgb.red+','+r.bgRgb.green+','+r.bgRgb.blue+')');
		$('html').css('backgroundColor','rgb('+r.bgRgb.red+','+r.bgRgb.green+','+r.bgRgb.blue+')');
		r.bgRgb.red

		// set applied templates where the id refers to the template id
		// first uncheck all of them
		$('#templateForm .template input:checkbox').removeAttr('checked');
		$.each(r.templates,function(index,id){
			$('#template-'+id).attr('checked','checked');
		})
		$('#canvas').width(r.size[0]);
		if(maintainScroll == 0){
			$('#canvasWrap').scrollTo(0);
		}
	},'json')
}


$(function(){

	$(window).bind( "hashchange", function(e) {
		// In jQuery 1.4, use e.getState( "url" );
		var url = e.getState();
		_doLoadScreen(url.i, url.s);
	});
	
	$('#canvas').delegate('.hotspot', 'click', function(){
//		var $spot = $(this);
//		var sId = $spot.attr('data-screen');
//		// get image from preloaded set
//		alert(sId)
//		var $newImg = $('#preloadImages [data-screen="'+sId+'"] img');
//		// alert($newImg.attr('src'));
//		$('#canvas').find('img').replaceWith($newImg);
	});

	jQuery(document).bind('keypress', 'h', function (evt){
		if($('#canvas .hotspot').is('.viewspot')){
			jQuery('#canvas .hotspot').removeClass('viewspot');
		}else{
			jQuery('#canvas .hotspot').addClass('viewspot');
		}
		return false; 
	});
	jQuery(document).bind('keydown', 'shift', function (evt){
		jQuery('#canvas .hotspot').addClass('viewspot'); return false; 
	});
	jQuery(document).bind('keyup', 'shift', function (evt){
		jQuery('#canvas .hotspot').removeClass('viewspot'); return false; 
	});
	
	
	$('#dialog').dialog({modal:true})
	
	var preloadImages = <?php echo json_encode($project->getScreenList()); ?>;
	
	var total = preloadImages.length
	var done = [];
	var percent;
	var $preloadDiv = $('#preloadImages');
	$("#progress .bar").progressbar({value: 1});
	$.each(preloadImages, function(i,val){
		
		var $div = $('<div data-screen="'+val.value+'"></div>');
		var img = new Image();
		// wrap our new image in jQuery, then:
		$(img)
			.attr('src', val.bigSrc)
			.load(function () {
				// set the image hidden by default
				$div.appendTo($preloadDiv);
				$(img).appendTo($div);
				done[i] = true;
				
				// might load in different order so
				// lets just count the number done in the done array
				var current = done.length
				percent = current * (100/total);
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