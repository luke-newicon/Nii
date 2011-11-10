<style type="text/css" media="screen">
	body{background-color: rgb(<?php echo $rgb['red']; ?>,<?php echo $rgb['green']; ?>,<?php echo $rgb['blue']; ?>);}
	html{background-color: rgb(<?php echo $rgb['red']; ?>,<?php echo $rgb['green']; ?>,<?php echo $rgb['blue']; ?>);}
	.main{padding-top:0px;}
	#canvas{margin: 0 auto;position:relative;cursor:default;width:<?php echo $screen->getWidth(); ?>px}
	
	.hotspot{position:absolute;cursor:pointer;background-color:transparent;border:0px;}
	.hotspot.viewspot{background-color:#75ff4b;border-radius:5px; opacity:0.6;filter: alpha(opacity=50);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";}
	
	.ui-progressbar{background:-webkit-gradient(linear,center bottom,center top,from(#aaa), to(#666));background:-moz-linear-gradient(center top,#666, #aaa);border:1px solid #bbb;height:22px;}
	
	.ui-widget-overlay{background:#000;}
	.preload,.preload .ui-dialog-content{background:none;border-bottom:0px;box-shadow:none;}
	.preload .ui-widget-header.ui-dialog-titlebar{border-bottom:0px;background: none repeat scroll 0 0 transparent;}
	.preload h1,.preload,.preload .ui-widget-content,.preload .ui-widget-header{color:#fff;text-shadow:0px 1px 0px #000;}
	.percent{font-weight:bold;}
	
	#preload{width:100%;}
	
	.spotForm{border-radius:5px;z-index:3000;background-color:#f1f1f1;background:-moz-linear-gradient(bottom, #ddd, #f1f1f1);background:-webkit-gradient(linear, left bottom, left top, from(#ddd), to(#f1f1f1));width:300px;border:1px solid #535a64;box-shadow:0px 3px 10px #444,inset 0px 1px 0px 0px #fff; top:100px;left:100px;position:absolute; }
</style>


<div id="canvasWrap">
	<?php $this->renderPartial('/screen/_canvas',array('screen'=>$screen,'onlyLinked'=>true)); ?>
</div>


<div id="preload-dialog" title="" style="display:none;">
	<div id="preload">
		<h1 style="padding-bottom:8px;">Visuals have been shared with you for review.</h1>
		<div class="line">
			<div class="unit size2of7"><img style="display:inline;" src="<?php echo HotspotModule::get()->assetsUrl; ?>/keys.png" /></div>
			<div class="lastUnit"><h1 style="font-size:22px;padding-top:8px;">Tap the Shift or H key to show hotspots</h1></div>
		</div>
		<ul class="ptl" style="font-size:11px;">
			<li>The ‚ÄúH‚Äù key will hold the hotspots on the screen, you can tap ‚ÄúH‚Äù again or the shift key to hide the hotspots.</li>
			<li>The Shift key will show the hotspots only whilst it is pressed down.</li>
		</ul>
	</div>
	<div id="progress" style="display:block;position:absolute;top:175px;width:600px;">
		<div class="bar"></div>
		<div style="padding-top:3px;">Loading visuals: <span class="percent"></span></div>
	</div>
	<div id="infobtn" style="display:none;">
		<button onclick="$('.ui-widget-overlay').fadeOut();$('#preload-dialog').fadeOut(function(){$('#preload-dialog').dialog('close');});" style="font-size:200%;width:100%;" class="btn aristo primary mtm">Ok</button>
	</div>
</div>


<!--<div id="commentMode" style="height:40px;padding:3px 10px;cursor:pointer;position:fixed;bottom:-20px;right:0px;background-color:#000;color:white">
	<span id="commentMode-num"></span> Comments <span id="commentMode-state" >OFF</span>
</div>-->

<div id="helloStranger" title="Who are you?">
	<div id="stranger-form">
		<div class="field">
			<label for="name" class="inFieldLabel">Your Name</label>
			<div class="inputBox">
				<input name="name" id="name" type="text"/>
			</div>
		</div>
		<div class="field">
			<label for="email" class="inFieldLabel">Email Address</label>
			<div class="inputBox">
				<input type="text" name="email" id="email"/>
			</div>
		</div>
		<div class="field">
			<a id="stranger-ok" href="#" class="btn aristo primary">Ok</a> <a id="stranger-cancel" href="#" class="btn aristo">Cancel</a> 
		</div>
	</div>
</div>

<script>



(function($){
	var methods = {
		init : function(options) {
			return this.each(function(){
				
				var $this = $(this);
				//$this.unbind('.commentSpot');
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
				.bind('click.commentSpot',function(e){
					$this.commentSpot('click',e);
				});
			});
		},
		save:function(hideForm){
			if(view.user.name == null && view.user.email == null)
				return;
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
			
			$.post("<?php echo NHtml::url('/project/view/saveComment'); ?>",
				{
					"hash":"<?php echo $hash; ?>",
					"screen":$('#canvas').attr('data-id'),
					"comment":commentForm.$textarea.val(),
					"id":id,
					"top":$spot.position().top,
					"left":$spot.position().left,
					"number":$spot.text(),
					"name":view.user.name,
					"email":view.user.email
				},
				function(r){
					// on save i want to get the id. store it in an array as the key with the comment being the value
					// so i don't have to ajax in the comment all the time'
					$spot.attr('data-id', r.id);
					commentForm.commentStore[r.id] = {'comment':comment,'view':r.comment, 'data':r.data};
					commentForm.formModel = false;
					commentForm.$form.find('.save').text('Save');
					commentForm.afterSave();
					if(hideForm){
						$('#commentForm').hide();
						$('#commentView').html(r.comment);
						$('#commentViewWrap').show();
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
				$spot.hide();
				commentForm.$form.fadeOut('fast');
			}else{
				if(view.user.name==null&&view.user.email==null)
					return false;
				$('#commentMode-num').html($('#commentMode-num').html()-1);
				$.post("<?php echo NHtml::url('/project/view/deleteComment') ?>",
					{
						"id":$spot.attr('data-id'),
						'hash':"<?php echo $hash; ?>",
						'email':view.user.email
					},
					function(r){
						//if(r)
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
 * The main page object responsible for maintaining page state.
 * Loading screens and the like
 */
var view = {
	user:{
		email:null,
		name:null
	},
	startScreen:<?php echo $screen->id; ?>,
	visibleSpots:false,
	hotspotData:<?php echo $hotspotData; ?>,
	screenData:<?php echo $screenData; ?>,
	screenDataSize:<?php echo $screenDataSize; ?>,
	visibleComments:false,
	init:function(){
		// Since the event is only triggered when the hash changes, we need to trigger
		// the event now, to handle the hash the page may have loaded with.
		$(window).trigger('hashchange');
		//$('#canvas .commentSpot').commentSpot();
		commentForm.init();
	},
	toggleCommentState:function(){
		view.visibleComments = !view.visibleComments;
		view.commentState();
	},
	commentState:function(){
		if(view.visibleComments) {
			// lets show all the comments
			$('#canvas .commentSpot').show();
			$('#commentMode-state').html('ON')
			$('#commentMode').fadeTo(0,1);
			$('#canvas').css('cursor','crosshair');
		} else {
			$('#canvas .commentSpot').hide();
			$('#commentMode-state').html('OFF')
			$('#canvas').css('cursor','');
		}
	},
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
	},
	/**
	 * this loods in a new screen based on the hotspot id
	 * It also updates the # url in the address bar.
	 * This function in fact only updates the url address bar appropriately, the hashchange event is then triggered as a result 
	 * The hashchange event then calls doLoadScreen that performs the heavy lifting
	 */
	loadScreen:function(hotspotId){
		$.bbq.pushState({i:hotspotId});
	},
	loadScreenData:function(screenId){
		var $canvas = $('#canvas');
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
		});
		
		commentForm.commentStore = view.screenData[screenId].comments;
		$('#commentMode-num').html(cNum-1);
		
		view.commentState();
		commentForm.init();

		$canvas.attr('data-id',screenId);
		$canvas.width($newImg);
		
		// do the background color;
		$('body').css('backgroundColor','rgb('+view.screenData[screenId].rgb.red+','+view.screenData[screenId].rgb.green+','+view.screenData[screenId].rgb.blue+')');
		$('html').css('backgroundColor','rgb('+view.screenData[screenId].rgb.red+','+view.screenData[screenId].rgb.green+','+view.screenData[screenId].rgb.blue+')');
	},
	/**
	 * Loads in a screen based on a HOTSPOT id
	 * This function uses the array data stored in the view object to switch screens
	 * It draws all of the:
	 * - Hotspots for the screen
	 * - Comments for the screen
	 * 
	 * It then makes sure the state is maintained.
	 */
	doLoadScreen:function(hsId){
		if (hsId==undefined){
			// if the hotspot id is empty then we want to load the start screen
			view.loadScreenData(view.startScreen);
			return false;
		};
		
		var screenId = view.hotspotData[hsId].screen_id_link
		view.loadScreenData(screenId);

		// lookup hotspot data. see if it should fix scroll position
		if(view.hotspotData[hsId].fixed_scroll == 0){
			$(document).scrollTo(0);
		}

		view.spotState();
	},
	preloader:{
		/**
		 * Displays the overlay that loads in the screens
		 * displays a nice progress bar
		 */
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
							view.preloader.displayInfo();
						}
					})
					.error(function () {
						// show broken image graphic here
						//alert('oops broken image');
					});
			});
		},
		/**
		 * Initialises the view and displays the "OK" button to complete the loading
		 */
		displayInfo:function(){
			$('#progress').fadeTo(500,0).delay(1).hide();
			$('#infobtn').fadeIn();
			view.init();
		}
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
		if($(e.target).is('.hotspot')){
			return false;
		}
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
		
		
		// if i can edit?
		if($cSpot.is('[data-id]')){
			var com = commentForm.commentStore[$cSpot.attr('data-id')];
			if(com.data.email == view.user.email){
				this.$form.find('.edit').show();
			}else{
				this.$form.find('.edit').hide();
			}
		}
		
		
		this.setTextarea($cSpot);
		
		this.$form.show();
		this.$textarea.focus();
		
		this.position($cSpot);
		
		
		// attach events
		this.$form.unbind('.commentForm');
		this.$form.delegate('.save','click.commentForm',function(e){if($(e.target).is('.disabled')){return false;}commentForm.save($cSpot);});
		this.$form.delegate('.cancel','click.commentForm',function(){commentForm.cancel($cSpot)});
		this.$form.delegate('.close','click.commentForm',function(){commentForm.close($cSpot)});
		this.$form.delegate('.edit','click.commentForm',function(){commentForm.edit($cSpot)});
		this.$form.delegate('.delete','click.commentForm',function(){$cSpot.commentSpot('deleteComment')});
	},
	afterSave:function(){
		// update comment count
		$('#commentMode-num').html($('#canvas-comments .commentSpot').length);
	},
	save:function(){
		if(view.user.name == null && view.user.email == null){
			// identify the chappy!
			$('#helloStranger').dialog('open');
			$('#commentForm .field:first').after($('#strangerForm').html());
			$('#stranger-ok').bind('click',function(){
				view.user.name = $('#name').val();
				view.user.email = $('#email').val();
				commentForm.$currentSpot.commentSpot('save');
				$('#helloStranger').dialog('close');
				$('#name').val('');
				$('#email').val('');
			});
		}else{
			commentForm.$currentSpot.commentSpot('save');
		}
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
		$('#canvas-comments').append($spot);
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
		if($cSpot!=undefined && !$cSpot.is('[data-id]')){
			$cSpot.remove();
		}
		this.$form.hide();
	},
	closeCurrent:function(){
		commentForm.close(commentForm.$currentSpot)
	}
}




$(function(){

	$(window).bind("hashchange", function(e) {
		// In jQuery 1.4, use e.getState( "url" );
		var i = e.getState("i");
		view.doLoadScreen(i);
	});
	
	$('#canvasWrap').delegate('.hotspot', 'click', function(){
		var $spot = $(this);
		commentForm.closeCurrent();
		var sId = $spot.attr('data-id');
		view.loadScreen(sId);
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
	
	
	$('#preload-dialog').dialog({
		dialogClass:'preload',
		width:650,
		height:400,
		position:{my:'center',at:'center',of:$(window),offset:'0px -100px'},
		modal:true,
		draggable:false,
		resizable:false,
		open: function(event, ui) { 
			$("#preload-dialog .ui-dialog-titlebar-close").hide(); 
		}
	});
	$('.ui-widget-overlay').css('opacity',0.8);
	
	view.preloader.preload();
	
	$('#commentMode').fadeTo(0,0.5).hover(function(){
		$(this).stop().fadeTo(500,1);
	},function(){
		if(!view.visibleComments){
			$(this).stop().fadeTo(500,0.5);
		}
	}).click(function(){
		view.toggleCommentState();
	});
	
	$('#canvas').click(function(e){
		if(view.visibleComments){
			commentForm.canvasClick(e);
		}
	});
	
	// the hello stranger form
	$('#helloStranger').dialog({
		autoOpen:false,
		modal:true,
		zIndex:3999,
		open:function(){
			$('.ui-widget-overlay').show();
		}
	});
	$('#stranger-cancel').bind('click',function(){
		$('#helloStranger').dialog('close');
	});
	
});



</script>