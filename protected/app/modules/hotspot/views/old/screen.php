<style type="text/css" media="screen">
	body{background-color: rgb(<?php echo $rgb['red']; ?>,<?php echo $rgb['green']; ?>,<?php echo $rgb['blue']; ?>);}
	html{background-color: rgb(<?php echo $rgb['red']; ?>,<?php echo $rgb['green']; ?>,<?php echo $rgb['blue']; ?>);}
	#canvas{margin: 0 auto;width:<?php echo $width; ?>px;position:relative;cursor:crosshair;}
</style>

<div id="mainToolbar" class="toolbar screen" style="width:100%;">
	<div class="line plm">
		<div class="unit titleBarText">
			<span class="hotspot-logo"><a href="<?php echo NHtml::url('/hotspot/index/index'); ?>"><strong>HOT</strong>SPOT</a></span>
		</div>
		<div class="unit toolbarArrow"></div>
		<div class="unit titleBarText">
<!--			<a href="<?php echo NHtml::url(array('/hotspot/details/index','project'=>$project->name)); ?>"><?php echo $project->name; ?></a>-->
			<?php echo $project->name; ?>
		</div>
<!--		<div class="unit toolbarArrow"></div>
		<div class="unit lastUnit titleBarText" >
			<span id="screenName" style="white-space:nowrap;overflow:hidden;"><?php echo $screen->getName(); ?></span>
		</div>-->
	</div>
	<div id="titleBarRightMenu" class="menu">
		<ul>
			<li><div class="menuDivider"></div></li>
			<li><a id="pickfiles" class="btn aristo upload" data-tip="" title="Upload screens to this project" href="#"><span class="icon hotspot-upload man"></span></a></li>
<!--			<li><a id="deletefiles" class="btn aristo delete" data-tip="" title="Delete this project" href="#"><span class="icon hotspot-trash man"></span></a></li>-->
			<li><div class="menuDivider"></div></li>
<!--				<li><a class="btn aristo sidebar selected" href="#"><span class="icon fugue-application-sidebar man"></span></a></li>-->
			<li><a class="btn aristo template" data-tip="" title="Apply a template" href="#"><span class="icon fugue-template man"></span></a></li>
			<li><div class="menuDivider"></div></li>
			<li>
				<div class="btnGroup">
					<a class="btn aristo btnToolbarLeft comments" data-tip="" title="View comments" href="#"><span class="icon fugue-balloon-white-left man"></span></a><a class="btn aristo btnToolbarMid edit selected" data-tip="" title="Add links" href="#"><span class="icon fugue-layer-shape man"></span></a><a class="btn aristo preview btnToolbarRight" data-tip="" title="Preview your project" href="#"><span class="icon fugue-magnifier man"></span></a>
				</div>
			</li>
			<li><div class="menuDivider"></div></li>
			<li><a class="btn aristo share" data-tip="" title="Share your project" href="#"><span class="icon fugue-arrow-curve man"></span></a></li>
<!--				<li><a class="btn aristo" data-tip="" title="Configure" href="#"><span class="icon fugue-gear man"></span></a></li>-->
			<li><div class="menuDivider"></div></li>
			<li><a id="userBox" href="#" class="btn aristo"><?php echo Yii::app()->user->getName(); ?><span class="icon fam-bullet-arrow-down mls mrn " style="padding-left:14px;"></span></a></li>
		</ul>
	</div>
</div>

<div id="drop" class="dropzone" style="display:none;"></div>
<br />

<?php $this->widget('nii.widgets.plupload.PluploadWidget', array(
    'config' => array(
        'runtimes' => 'html5,flash,silverlight',
        'url' => NHtml::url(array('/hotspot/details/upload/','projectId'=>$project->id)),
		'filters'=>array(
			array('title'=>'Image files', 'extensions'=>"jpg,gif,png")
		),
		'autostart'=>true,
		'callbacks'=>array(
			'UploadProgress'=>'js:function(){alert(\'oi\');}'
		)
	),
    'id' => 'uploader'
 )); ?>

<div id="progress" class="pam blackpop">
	<div class="bar"></div>
	<div class="qty">Uploading <span class="current" style="font-weight:bold;"></span> of <span class="total" style="font-weight:bold;"></span> - <span class="percent"></span> <span class="size"></span></div>
</div>

<div id="closePreview" style="position:absolute;top:10px;left:10px;">
	<button class="btn aristo editMode" data-tip="{gravity:'nw'}" title="Close preview and return to edit mode" href="#"><span class="icon fugue-arrow-180"></span> Back to edit mode</button>
</div>

<?php $this->renderPartial('old/_template-form',array('screen'=>$screen)); ?>
<?php $this->renderPartial('old/_share-form',array('screen'=>$screen,'project'=>$project)); ?>

<div id="screenWrap" style="position:absolute;width:200px;top:48px;height:400px;border-right:1px solid #000;">
	<div id="screenPane" class="unit" style="overflow: auto;z-index:300;width:200px;">
		<?php foreach($project->getScreens() as $s): ?>
			<div class="sidebarImg txtC <?php echo ($s->id == $screen->id)?'selected':''; ?>" id="sideSscreen-<?php echo $s->id; ?>">
				<div class="screen">
					<a href="#" onclick="return false;" style="display:block" title="<?php echo $s->name; ?>" class="loading sideImg" data-id="<?php echo $s->id; ?>" data-src="<?php echo NHtml::urlImageThumb($s->file_id, 'projectSidebarThumb'); ?>"></a>
					<a class="btn aristo info" data-tip="" title="Click for more information" href="#">i</a>
					<div class="screenFlip" style="display:none;">
						More info
						<a class="btn aristo revertInfo" data-tip="" title="Click to view screen" href="#">i</a>
					</div>
				</div>
				<span class="imageTitle"><?php echo $s->name; ?></span>
			</div>
		<?php endforeach; ?>
	</div>
	<div id="sidebarButtons">
		<a class="sidebarOpen disabled" href="#">&#9654;</a>
		<a class="sidebarClose" href="#">&#9664;</a>
	</div>
</div>

<div id="canvasWrap" style="position: absolute; top:48px; overflow: auto; left:200px; height: 400px;">
	<div class="canvasContent">
		<?php $this->renderPartial('old/_canvas',array('screen'=>$screen, 'onlyLinked'=>false)); ?>
	</div>
	<span id="screenName" style="position:absolute;left:10px;bottom:10px"><?php echo $screen->getName(); ?></span>
</div>


<div id="userMenu" class="toolbarForm pas" style="width:100px;display:none;">
	<div style="top:-19px;" class="triangle-verticle"></div>
	<ul class="noBull menuLinks man">
		<li><a href="#" class="account-link">My Account</a></li>
		<li><a href="<?php echo NHtml::url('/logout'); ?>" class="logout-link">Log Out</a></li>
	</ul>
</div>

<div id="accountDialog" style="display:none;padding:0" class="tabs-left">
	<?php
		$this->widget('zii.widgets.jui.CJuiTabs', array(
			'tabs'=>array(
				'My Plan'=>array('ajax'=>CHtml::normalizeUrl(array('/hotspot/account/plan'))),
				'My Profile'=>array('ajax'=>CHtml::normalizeUrl(array('/hotspot/account/profile'))),
			),
			'headerTemplate'=>'<li class="ui-corner-left"><a href="{url}">{title}</a></li>',
			//'options'=>array(),
		));
	?>
</div>

<script>
	$(function(){

		$('#projectList').delegate('.projectBox','mouseenter',function(){
			$(this).addClass('hover');
		});
		
		$('#projectList').delegate('.projectBox','mouseleave',function(){
			$(this).removeClass('hover');
		});
		
		var userMenu = {
			open:function(){
				$('#userMenu').show().position({my:'center top',at:'center bottom', of:$('#userBox'),offset:'0px 10px;'});
				$('#userBox').addClass('selected');
				$('#userMenu').click(function(e){e.stopPropagation();});
				$('body').bind('click.userMenu',function(){
					userMenu.close();
				});
			},
			close:function(){
				$('#userMenu').hide();
				$('body').unbind('click.userMenu');
				$('#userBox').removeClass('selected');
			}
		}
		
		$('#userBox').click(function(){
			userMenu.open();
			return false;
		});
		
		$('#userMenu .account-link').click(function(){
			$('#accountDialog').dialog({
				width: 800,
				height: 400,
				modal: true,
				title: 'My HOTSPOT Account',
				resizable: false
			});
			userMenu.close();
			return false;
		});
		
		$('#screenPane').delegate('.info','click',function(){
			var $screen = $(this).closest('.screen');
			$screen.addClass('noShadow').flip({
				direction:'rl',
				speed:150,
				color:'#fff',
				content:$screen.find('.screenFlip'),
				onEnd:function(){
					$screen.removeClass('noShadow');
					resizer();
				}
			});
			return false;
		});
		
		$('#screenPane').delegate('.revertInfo','click',function(){
			var $screen = $(this).closest('.screen');
			$screen.addClass('noShadow').revertFlip();
			return false;
		});
		
		var timer = {};
		window.addEventListener("dragenter", function(e){
			//$('#dropzone').show();
			clearTimeout(timer);
			$('#dropzone').addClass('dragging');
			$('#drop').show().addClass('dragging').width($(window).width()-40).height($(window).height()-40)
				.position({'my':'center','at':'center','of':$(window)})
		}, false);

		window.addEventListener( 'dragover', function(){
			clearTimeout(timer);
			timer = setTimeout(function(){
				$('#drop').fadeOut('fast');
				$('#dropzone').removeClass('dragging');
			},150);
			$('#dropzone').addClass('dragging');
			$('#drop').show();
		}, true );

		window.addEventListener("dragleave", function(e){
			if(timer)
				clearTimeout(timer);
			timer = setTimeout(function(){
				$('#drop').fadeOut('fast');
				$('#dropzone').removeClass('dragging');
			},150);
		}, false);



		var uploader = new plupload.Uploader({
			runtimes : 'html5,flash,silverlight',
			browse_button : 'pickfiles',
			//container : 'container',
			max_file_size : '10mb',
			url : '<?php echo NHtml::url(array('/hotspot/details/upload/','projectId'=>$project->id)) ?>',
			flash_swf_url:"/newicon/Nii/assets/79029962/plupload.flash.swf",
			silverlight_xap_url:"/newicon/Nii/assets/79029962/plupload.silverlight.xap",
			filters : [
				{title : "Image files", extensions : "jpg,gif,png"},
				{title : "Zip files", extensions : "zip"}
			],
			drop_element:'drop'
			//resize : {width : 320, height : 240, quality : 90}
		});


		uploader.bind('Init', function(up, params) {
			//$('#filelist').html("<div>Current runtime: " + params.runtime + "</div>");
		});

		$('#uploadfiles').click(function(e) {
			uploader.start();
			e.preventDefault();
		});

		uploader.init();

		var totalPercent;
		var totalImages;
		var currentImage;
		var doPercent = function(){
			//$('#progress .percent').html(totalPercent+'%');
			if(currentImage+1 <= totalImages)
			$('#progress .current').html(currentImage+1);
			$('#progress .total').html(totalImages);
			$("#progress .bar").progressbar({value: totalPercent});
			$("#progress .percent").html(totalPercent + '% complete');
		};

		uploader.bind('FilesAdded', function(up, files) {
			$('#no-screens-info').fadeOut();
			//if (up.files.length > $max_file_number) up.splice($max_file_number, up.files.length-$max_file_number)
			if(!$('#progress').is(':visible'))
				$('#progress').fadeIn().position({'my':'center','at':'center','of':$(window)});
			$.each(files.reverse(), function(i, file) {
				screenName = file.name.replace(/\.[^\.]*$/, '');
				screenName = screenName.replace(/-/g, " ");
				screenName = screenName.replace(/_/g, " ");
				var content = '<li><div class="projectBox pending" id="' + file.id + '">' +
					'<a class="projImg loading-fb" href="#"></a>' +
					'<div class="projName"><div class="name">'+screenName+'</div></div>' +
					'<div class="progress" style="height:10px;position:absolute;bottom:10px;width:180px;left:10px;"></div>' +
				'</div></li>';

				// lookup the name
				// remove the file name

				$exists = $('.projectBox[data-name="'+screenName+'"]');
				if($exists.length!=0){
					$exists.closest('li').replaceWith(content);
				}else{
					$('.projList').prepend(content);
				}
			});
			totalPercent = 0;
			currentImage = 0;
			totalImages = files.length;
			//doPercent();
			up.refresh(); // Reposition Flash/Silverlight
			if(up.files.length > 0) uploader.start();
		});

		uploader.bind('UploadProgress', function(up, file) {
			//alert(file.percent);
			var $box = $('#' + file.id);
			if(!$box.is('uploading')){
				$box.removeClass('pending').addClass('uploading');
				$box.animate({backgroundColor: "#fff"});
			}

			$('#'+file.id+' .progress').progressbar({value:file.percent});
			currentPercent = file.percent;
			
			// work out total upload progress
			totalPercent = uploader.total.percent;
			doPercent();
		});

		uploader.bind('Error', function(up, err) {
			$('body').append("<div>Error: " + err.code +
				", Message: " + err.message +
				(err.file ? ", File: " + err.file.name : "") +
				"</div>"
			);
			up.refresh(); // Reposition Flash/Silverlight
		});

		uploader.bind('FileUploaded', function(up, file, info) {
			currentImage = currentImage + 1;
			doPercent();

			var r = $.parseJSON(info.response);
			if(r.error != undefined){
				alert(r.error.message);
			}

			if(r.replacement){
				$('.projectBox[data-id="'+r.id+'"]').closest('li').hide('normal', function(){$(this).remove();});
			}
			var $box = $(r.result);
			$('#' + file.id).replaceWith($box);
			$box.addClass('uploaded');
			$box.find('.projImg').addClass('loading');
			// check to see if it is a replacement

			// when the DOM is ready
			var img = new Image();
			// wrap our new image in jQuery, then:
			$(img).load(function () {
				// set the image hidden by default    
				$(this).hide();
				$box.find('.projImg')
				// remove the loading class (so no background spinner), 
				.removeClass('loading')
				// then insert our image
				.append(this);
				 $(this).fadeIn();
			})
			.error(function () {
				// show broken image graphic here
				alert('oops broken image');
			})
			.attr('src', r.src);
			//$('#' + file.id).remove();
			//$('.projList').append('<li>'+r.result+'</li>')

		});
		uploader.bind('UploadComplete', function(up, file, info) {
			$('#progress').fadeOut();
		});
	
	});
</script>

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
			
			$.post("<?php echo NHtml::url('/hotspot/old/saveComment'); ?>",
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
				$.post("<?php echo NHtml::url('/hotspot/old/deleteComment') ?>",
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
 * snapy plugin
 */
(function($){

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
					start:function(event, ui){
						// very cool if dragging with alt key pressed would copy the current spot.
						if(event.altKey || event.shiftKey){
							// you wana copy spot? okey doaky then..
							$this.clone().removeAttr('data-id')
								.appendTo($('#canvas-hotspots'))
								.hotspot().hotspot('update')
						};
					},
					drag: function(event, ui) {
						if($('#spotForm').is(':visible')){
							// make the spotForm follow the hotspot being dragged
							spotForm.position($this);
						}
					},
					stop:function(e,ui){
						$this.hotspot('update');
					}
				})
				.resizable({
					handles:'all',
					resize:function(){
						if($('#spotForm').is(':visible')){
							spotForm.position($this);
						}
					},
					stop:function(e,ui){
						$this.hotspot('update');
					}
				})
				.click(function(e){
					return $this.hotspot('click',e);
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
			// get the screen id
			if($spot.is('[data-screen]')){
				screenId = $spot.attr('data-screen');
				$spot.addClass('linked');
			}else{
				$spot.removeClass('linked');
			}
			
			var fixedScroll = 0;
			if($spot.is('[data-fixed-scroll]')){
				var fixedScroll = 1;
			}
			
			$.post("<?php echo NHtml::url('/hotspot/details/saveHotspot'); ?>",
				{HotspotHotspot:{
					hotspot_id:id,
					screen_id:$('#canvas').attr('data-id'),
					width:$spot.width(),
					height:$spot.height(),
					left:offset.left,
					top:offset.top,
					screen_id_link:screenId,
					fixed_scroll:fixedScroll
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
			$.post("<?php echo NHtml::url('/hotspot/details/deleteSpot'); ?>",{id:$spot.attr('data-id')});
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
				location.href = "<?php echo NHtml::url('/hotspot/old/index'); ?>/id/"+$spot.attr('data-screen');
			}
		},
		linkAjax:function(){
			// hotspots may not have a defined screen id, so be careful
			var $spot = $(this);
			if($spot.is('[data-screen]')){
				var maintainScroll = ($spot.is('[data-fixed-scroll]'))?1:0;
				loadScreen($spot.attr('data-screen'),maintainScroll);
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
				$spot.hotspot('linkAjax');
			}else{
				if($spot.is('.link')){
					$spot.hotspot('linkAjax');
				}else{
					$spot.hotspot('showForm');
				}
			}
			return false;
		},
		fixedScroll:function(bool){
			if(bool){
				this.attr('data-fixed-scroll','true');
			}else{
				this.removeAttr('data-fixed-scroll');
			}
			this.hotspot('update');
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
		this.$form.delegate('.save','click.commentForm',function(e){if($(e.target).is('.disabled')){return false;}$cSpot.commentSpot('save');return false;});
		this.$form.delegate('.cancel','click.commentForm',function(){commentForm.cancel($cSpot);return false;});
		this.$form.delegate('.close','click.commentForm',function(){commentForm.close($cSpot);return false;});
		this.$form.delegate('.edit','click.commentForm',function(){commentForm.edit($cSpot);return false;});
		this.$form.delegate('.delete','click.commentForm',function(){$cSpot.commentSpot('deleteComment');return false;});
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

var spotForm = {
	screens:<?php echo json_encode($project->getScreenList()); ?>,
	$spot:null,
	$form:null,
	showForm:function($spot){
		spotForm.$spot = $spot;
		// show and position the popup form
		spotForm.$form = $('#spotForm');
		spotForm.position($spot);
		// unbind all previously set events
		spotForm.$form.unbind('.spotForm');
		// ok spot link
		spotForm.$form.delegate('#okSpot','click.spotForm',function(){$('#spotForm').hide();});
		// delete spot link
		spotForm.$form.delegate('#deleteSpot','click.spotForm',function(){$spot.hotspot('deleteSpot');return false;});
		
		spotForm.$form.delegate('#fixedScroll','click.spotForm',function(){spotForm.fixScroll($spot);});
		// if fixed scroll
		$spot.is('[data-fixed-scroll]')?$('#fixedScroll').attr('checked','checked'):$('#fixedScroll').removeAttr('checked');
		$spot.is('[data-screen]')?$('#followlink').show().attr('href','#i='+$spot.attr('data-id')):$('#followlink').hide();
		spotForm.$form.delegate('#followlink','click.spotForm',function(){loadScreen($spot.attr('data-screen'));return false;})
		spotForm.$form.delegate('#fixedScroll','click.spotForm',function(){spotForm.fixScroll($spot);});

		spotForm.autocomplete();
		spotForm.initTemplates();
		spotForm.$form.delegate('#hotspotTemplate','change.spotForm',function(){spotForm.applyTemplate()});
	},
	windowResize:function(){
		if(spotForm.$form!=null && spotForm.$spot!=null){
			if(spotForm.$form.is(':visible')){
				spotForm.position(spotForm.$spot);
			}
		}
	},
	position:function($spot){
		// hide the screen select drop down
		$("#screenList input").autocomplete("close");
		spotForm.$form.show()
			.position({my:'left top',at:'right top',of:$spot,offset:"18 -30",collision:'none'});
	},
	fixScroll:function($spot){
		$spot.hotspot('fixedScroll',$('#fixedScroll').is(':checked'));
	},
	applyTemplate:function(){
		var val = $('#hotspotTemplate').find(':selected').val();
		if(val==0) {
			// we have selected no template so if the current spot is a template we want to unlink it.
			spotForm.$spot.removeAttr('data-template').removeClass('spot-template');
			// update db to unlink spot from template
			$.post("<?php echo NHtml::url('/hotspot/old/addTemplateSpot') ?>",
				{'spot':spotForm.$spot.attr('data-id'), 'template':val});
			return false;
		}
		// save it
		$.post("<?php echo NHtml::url('/hotspot/old/addTemplateSpot') ?>",
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
				spotForm.showForm(spotForm.$spot);
				return false;
			},
			position:{'my':'left top','at':'left bottom','of':'#screenList','collision':'flip'}
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
var state = {
	editMode:1,
	previewMode:2,
	commentsMode:3
};
var toolbar = {
	$mainToolbar:null,
	$btnPreview:null,
	$btnEdit:null,
	$btnEditMode:null,
	$btnTemplate:null,
	$btnComments:null,
	$btnShare:null,
	$btnConf:null,
	sidebarWidth:200,
	state:null,
	beforePreviewState:null,
	init:function(){
		this.$mainToolbar = $('#mainToolbar');
		this.$btnPreview = this.$mainToolbar.find('.preview');
		this.$btnEditMode = $('#closePreview .editMode');
		this.$btnEdit = this.$mainToolbar.find('.edit');
		this.$btnTemplate = this.$mainToolbar.find('.template');
		this.$btnComments = this.$mainToolbar.find('.comments');
		this.$btnShare = this.$mainToolbar.find('.share');
		this.$btnConf = this.$mainToolbar.find('.config');
		this.templateForm.init();
		this.shareForm.init();
		// toolbar button events
		this.$btnPreview.click(function(){toolbar.previewMode();return false;});
		this.$btnEditMode.click(function(){toolbar.showSpots();toolbar.closePreview();return false;});
		this.$btnTemplate.click(function(e){toolbar.templateForm.open(e);return false;});
		this.$btnShare.click(function(e){toolbar.shareForm.open(e);return false;});
		this.$btnComments.click(function(){toolbar.commentsMode();return false;});
		this.$btnEdit.click(function(){toolbar.editMode();return false;});
		this.$btnConf.click(function(){toolbar.configClick();return false;});

		$('#mainToolbar .btnGroup .btn').click(function(){
			$('#mainToolbar .btnGroup .btn').removeClass('selected');
			$(this).addClass('selected');
			return false;
		});
		$('#sidebarButtons .sidebarClose').click(function(){
			toolbar.sidebarClose();
			return false;
		});
		$('#sidebarButtons .sidebarOpen').click(function(){
			toolbar.sidebarOpen();
			return false;
		});
	},
	configClick:function(){
		
	},
	showSpots:function(){
		$('#canvas .hotspot').stop(true, true).show().removeAttr('data-disabled').find('.ui-resizable-handle').show();
	},
	fadeSpots:function(){
		$('#canvas .hotspot').fadeOut(250).attr('data-disabled','true').find('.ui-resizable-handle').hide();
	},
	showComments:function(){
		$('#canvas .commentSpot').stop(true, true).show();
	},
	fadeComments:function(){
		$('#canvas .commentSpot').fadeOut(250);
	},
	previewMode:function(){
		toolbar.sidebarClose();
		// if we are already in preview mode don't bother animating'
		if(toolbar.state != state.previewMode){
			this.$mainToolbar.animate({top:-60},500,'easeInBack');
			$('#canvasWrap').animate({top:0,height:'+=48'},500,'swing');
		}
		$('#canvas').find('.hotspot').hotspot('setStateLink');
		this.templateForm.close();
		$('#canvas').css('cursor','default');
		toolbar.selectButton(toolbar.$btnPreview);
		toolbar.fadeComments();
		// set the state before preview loaded
		toolbar.beforePreviewState = toolbar.state;
		toolbar.state = state.previewMode;
	},
	closePreview:function(){
		// if we are in preview mode we need to swish stuff back in
		toolbar.sidebarOpen();
		$('#screenWrap').show('fast')
		this.$mainToolbar.animate({top:0},500,'easeInBack');
		$('#canvasWrap').find('.hotspot').hotspot('setStateEdit');
		toolbar.showSpots();
		$('#canvasWrap').animate({top:48},500,'easeInBack', function(){
			resizer();
		});
		if(toolbar.beforePreviewState==state.previewMode){
			toolbar.setState(state.editMode);
		}else{
			toolbar.setState(toolbar.beforePreviewState);
		}
	},
	/**
	 * must be a state object property
	 */
	setState:function(toolbarState){
		switch(toolbarState){
			case state.commentsMode:
				toolbar.commentsMode();
				break;
			case state.editMode:
				toolbar.editMode();
				break;
			case state.previewMode:
				toolbar.previewMode();
				break;
			default:
				toolbar.editMode();
		}
	},
	editMode:function(){
		// ensure the edit button is selected
		$('#canvas').css('cursor','crosshair');
		toolbar.showSpots();
		toolbar.fadeComments();
		toolbar.selectButton(toolbar.$btnEdit);
		toolbar.state = state.editMode;
	},
	commentsMode:function(){
		toolbar.fadeSpots();
		toolbar.showComments();
		$('#canvas').css('cursor','help');
		toolbar.selectButton(toolbar.$btnComments);
		toolbar.state = state.commentsMode;
	},
	selectButton:function($btnToSelect){
		toolbar.$btnEdit.removeClass('selected');
		toolbar.$btnPreview.removeClass('selected');
		toolbar.$btnComments.removeClass('selected');
		$btnToSelect.addClass('selected');
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
		$('#sidebarButtons .sidebarOpen').addClass('disabled');
		$('#sidebarButtons .sidebarClose').removeClass('disabled');
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
		$('#sidebarButtons .sidebarClose').addClass('disabled');
		$('#sidebarButtons .sidebarOpen').removeClass('disabled');
		resizer();
		//$('#screenWrap').hide();
	},
	shareForm:{
		init:function(){
			//$('#shareForm .templateOk').click(function(){toolbar.shareForm.close();return false;});
			$('#shareLinkForm :input').change(function(){toolbar.shareForm.save();});
		},
		open:function(e){
			if($('#shareForm').is(':visible')){
				toolbar.shareForm.close();
				return false;
			}
			$('#shareForm').show();
			toolbar.$btnShare.addClass('selected');
			$('#shareForm').position({'my':'center top','at':'center bottom','of':toolbar.$btnShare,'offset':'0px 12px','collision':'none'});
			$('#shareForm').click(function(e){
				e.stopPropagation();
			});
			$('body').bind('click.shareForm',function(){
				toolbar.shareForm.close();
				toolbar.shareForm.save();
			});
			// hide tipsy hint
			toolbar.$btnShare.tipsy('hide');
			e.stopPropagation();
		},
		close: function(){
			toolbar.$btnShare.removeClass('selected');
			$('body').unbind('click.shareForm');
			$('#shareForm').hide();
			return false;
		},
		save:function(){
			var pf = $.deparam($('#shareLinkForm').serialize());
			$.post("<?php echo NHtml::url('/hotspot/old/projectLink'); ?>", 
			pf, function(r){});
			return false;
		}
	},
	templateForm: {
		init:function(){
			$('#newTemplateSubmit').click(function(){toolbar.templateForm.newTemplate();return false;});
			$('#templateForm .templateOk button').click(function(){toolbar.templateForm.close(); return false;});
			$('#templateForm').delegate('input:checkbox','click',function(){
				toolbar.templateForm.applyTemplate($(this));
			});
			$('#templateForm').delegate('.deleteTemplate','click',function(){
				toolbar.templateForm.deleteTemplate($(this));
				return false;
			});
			$('#templateForm').delegate('.saveTemplate','click',function(){
				toolbar.templateForm.doRename($(this));
				return false;
			});
			// handle the enter key
			$('#templateForm').delegate('.template .rename','keyup',function(e){
				if((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)){
					toolbar.templateForm.doRename($(this));
				}
			});
			$('#templateForm').delegate('.template .edit','click',function(e){
				var $editBtn = $(this);
				var $tpl = $editBtn.closest('.template');
				$tpl.find('.display').hide();
				$tpl.find('.editForm').show();
				$tpl.find('input.rename').val($tpl.find('.templateName').html()).focus();
				return false;
			});
		},
		doRename:function($saveButton){
			var $tpl = $saveButton.closest('.template');
			var id = $tpl.attr('data-id');
			var name = $('#template-'+id+'-rename').val();
			$tpl.find('.display').show();$tpl.find('.editForm').hide();
			$tpl.find('.templateName').html(name);
			$.post("<?php echo NHtml::url('/hotspot/old/renameTemplate'); ?>",{"id":id,"name":name},function(r){
				// update the spotForm templates select box
				spotForm.initTemplates();
				$('#template-'+id+'-rename').val('');
			},'json');
		},
		/**
		 * the jquery delete ".deleteTemplate" button object clicked identifying the template row
		 */
		deleteTemplate:function($deleteButton){
			
			var $tpl = $deleteButton.closest('.template');
			$('#deleteOverlay').width($tpl.width()-10);
			$('#deleteOverlay').height($tpl.height()+10);
			$('#deleteOverlay').fadeTo(0,0.1,function(){
				$(this).position({'my':'left top','at':'left top','of':$tpl,'offset':'0 -1px'}).fadeTo(250,1);
			});
			$('#deleteOverlay .delete').one('click',function(){
				var id = $tpl.attr('data-id');
				$.post("<?php echo NHtml::url('/hotspot/old/deleteTemplate'); ?>",{"id":id},function(r){
					if(r.result.success){
						$('#deleteOverlay').fadeOut();
						$tpl.fadeOut().remove();
						$('#canvas').find('[data-template="'+id+'"]').remove();
						// update the spotForm templates select box
						spotForm.initTemplates();
					}
				},'json');
			});
		},
		newTemplate:function(){
			if($('#newTemplate').val() == '')
				return false;
			$.post("<?php echo NHtml::url('/hotspot/old/addTemplate') ?>",
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
			if($('#templateForm').is(':visible')){
				this.close();
				e.stopPropagation();
				return false;
			}
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
		/**
		 * will also remove the template if the passed checkbox is not checked
		 */
		applyTemplate:function($checkBox){
			var templateId = $checkBox.val();
			if($checkBox.is(':checked')){
				$.post("<?php echo NHtml::url('/hotspot/old/applyTemplate') ?>",
				{'template':templateId,'screen':$('#canvas').attr('data-id')},function(hotspots){
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
				$.post("<?php echo NHtml::url('/hotspot/old/removeTemplate') ?>",
				{'template':templateId,'screen':$('#canvas').attr('data-id')},function(){
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
	
	commentForm.init();
	
	$("#canvas").droppable({
		accept:'.sidebarImg',
		drop: function(event, ui) {
			// we are creating a hotspot so we need to be in edit mode!
			toolbar.editMode();
			// we have dropped onto the canvas so we want to create a hotspot here
			var helper = $(document.createElement('a'))
			$('#canvas').append(helper);
			helper.css({
				"z-index": 100,
				"position": "absolute",
				"left": event.clientX-$('#canvas').offset().left-75,
				"top": event.clientY-$('#canvas').offset().top-15,
				"width": 150,
				"height": 30
			}).addClass('hotspot')
			.hotspot()
			.hotspot('update')
			.attr('data-screen', $(ui.draggable).find('[data-id]').attr('data-id'))
			.hotspot('showForm')
		}
	});
	$('#canvas .hotspot').hide();
	// lets code the toolbar
	toolbar.setState(toolbar.state);
}
var resizer = function(){
	$('#canvasWrap').snapy({'snap':$(window)});
	$('#screenWrap').snapy({'snap':$(window)});
	$('#screenPane').snapy({'snap':'#screenWrap'});
	$('#canvasWrap').css('width',($('body').width()-$('#screenWrap').width()+$('#screenWrap').border().right-2) + 'px');
	$('#canvasWrap').css('left',$('#screenWrap').width()+$('#screenWrap').border().right);
	
	var imgs = $('#screenPane img');
	if(imgs.length>0)
		$('#screenPane img').attr('width',$('#screenPane .sidebarImg').width()-22).width($('#screenPane .sidebarImg').width()-22);
	spotForm.windowResize();
	$('#screenPane a.sideImg').width($('#screenPane .sidebarImg').width()-20);
}


/**
 * Load in a screen and its hotspots and comments by ajax
 */
var loadScreen = function(screenId, maintainScroll){
	// select the sidebar image
	if(maintainScroll==undefined){maintainScroll=0};
	$.bbq.pushState({ i: screenId, s:maintainScroll });
}
var initialScreen = <?php echo $screen->id; ?>;

var _doLoadScreen = function(screenId, maintainScroll){
	if(screenId==undefined)
		screenId = initialScreen;
	$('#screenPane .sidebarImg').removeClass('selected')
	$('#sideSscreen-'+screenId).addClass('selected');
	$.get("<?php echo NHtml::url('/hotspot/old/load') ?>",{'id':screenId},function(r){
		$('#canvasWrap .canvasContent').html(r.canvas);
		
		commentForm.commentStore = r.commentsJson;
		initCanvas();
		$('#md-comments').markdown();
		// set background color
		$('body').css('backgroundColor','rgb('+r.bgRgb.red+','+r.bgRgb.green+','+r.bgRgb.blue+')');
		$('html').css('backgroundColor','rgb('+r.bgRgb.red+','+r.bgRgb.green+','+r.bgRgb.blue+')');

		$('#screenName').html(r.name);
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


$(function($){
	
	toolbar.init();
	initCanvas();
	
	$(window).resize(function(){
		resizer();
	});
	$('#screenWrap').snapy({'snap':$(window)});
	$('#screenWrap').resizable({
		handles:'e',
		minWidth:100,
		maxWidth:400,
		alsoResize:'#screenPane',
		resize:function(){
			resizer();
		},
		stop:function(){
			resizer();
		}
	});
	
	resizer();
	
	$('#screenPane .sidebarImg').draggable({
		zIndex:5000,
		revert:'invalid',
		appendTo:'body',
		helper:'clone'
	});
	$("#screenPane .sidebarImg").disableSelection();
	
	$('#screenPane .sidebarImg a').click(function(){
		var screenId = $(this).attr('data-id');
		loadScreen(screenId, 1);
	});
	//
	// load sidebar images
	//	
	var loadSideImage = function($div){
		var src = $div.attr('data-src');
		var img = new Image();
		// wrap our new image in jQuery, then:
		$(img).load(function () {
			// set the image hidden by default
			$div.show();
			$(this).hide().width($div.width()-2);	
			$div.append(this).removeClass('loading');
			$(this).fadeIn();
			$(this).width($div.width()-2);
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
		setTimeout(function(){loadSideImage($div)},1);
	});
	
	
	$(window).bind( "hashchange", function(e) {
		// In jQuery 1.4, use e.getState( "url" );
		var url = e.getState();
		_doLoadScreen(url.i, url.s);
	});
	

});

	
</script>