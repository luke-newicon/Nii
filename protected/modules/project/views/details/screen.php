<style type="text/css" media="screen">
	body{background-color: rgb(<?php echo $rgb['red']; ?>,<?php echo $rgb['green']; ?>,<?php echo $rgb['blue']; ?>);}
	#canvas{margin: 0 auto;width:<?php echo $width; ?>px;}
	.hotspot{cursor:pointer;z-index: 100; position: absolute;background-color:orange;border: 1px solid red;opacity: 0.7;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";filter: alpha(opacity=70);}
	.hotspot.helper{border:1px dotted red;cursor:crosshair;opacity: 0.4;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=40)";filter: alpha(opacity=40);}
	#canvas{cursor:crosshair;position:relative;}
	
	.spotForm{border-radius:5px;z-index:3000;background-color:#f1f1f1;width:300px;border:1px solid #535a64;box-shadow:0px 3px 10px #444,inset 0px 1px 0px 0px #fff; top:100px;left:100px;position:absolute; }
	.triangle{background:url("<?php echo ProjectModule::get()->getAssetsUrl().'/triangle.png'; ?>") no-repeat top left;width:19px;height:34px;left:-19px;top:10px;position:absolute;}
	.spotFormPart{padding:5px;}
	a.delete, a.btn.btnN.delete {color:#cc0000;}
	
	/*  */
	.toolbar{height:50px;background-color:#000;}
	.screenItem{background-color:#fff;cursor:pointer;}
	.screenItem .img{width:48px;height:48px;background-color:#f9f9f9;border:1px solid #ccc;margin:2px;}
	.ui-autocomplete {border:1px solid #666;max-height: 300px;overflow-y: auto;overflow-x: hidden;width:300px;background-color:#fff;}
	/* IE 6 doesn't support max-height
	 * we use height instead, but this forces the menu to always be this tall
	 */
	* html .ui-autocomplete {height: 250px;}
</style>
<?php echo CHtml::linkTag('stylesheet', 'text/css', ProjectModule::get()->getAssetsUrl().'/project.css'); ?>
<div class="toolbar">
	<a href="<?php echo NHtml::url(array('/project/details/index','project'=>$project->name)); ?>" style="color:white;"><?php echo $project->name; ?></a>
</div>
<div id="canvas"> 
	<img src="<?php echo NHtml::urlFile($file->id, $file->original_name); ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />
	<?php foreach($hotspots as $hotspot): ?>
		<a data-id="<?php echo $hotspot->id; ?>" <?php if($hotspot->screen_id_link): ?> data-screen="<?php echo $hotspot->screen_id_link; ?>" <?php endif; ?> class="hotspot" style="width:<?php echo $hotspot->width; ?>px;height:<?php echo $hotspot->height; ?>px;left:<?php echo $hotspot->left; ?>px; top:<?php echo $hotspot->top; ?>px;"></a>
	<?php endforeach; ?>
</div>

<div id="spotForm" class="spotForm" style="display:none;">
	<div class="spotFormContainer" style="position:relative;">
		<div class="triangle"></div>
		<div class="spotFormPart form">
			<div class="field">
				<label for="screenSelect">Link to:</label>
<!--					<div class="inputBox" style="padding:3px;width:200px;">
					<?php //echo CHtml::dropDownList('screenSelect', 0, $project->getScreensListData(),array('class'=>'input','style'=>'margin:0px;')) ?>
				</div>-->
<!--					<div id="screenList" class="inputBox" style="padding:3px;width:200px;">
					<a class="select" href="" onclick="$('#screenList .items').toggle();return false;">- select linking screen -</a>
					<div class="items" style="display:none;position:absolute;z-index:100;background-color:#fff;height:250px;overflow:auto;border:1px solid #ccc;">
						<ul class="noBull" style="margin-bottom:0px;">
							<?php foreach($project->getScreens() as $miniScreen): ?>
								<li class="screenItem" data-id="<?php echo $miniScreen->id; ?>">
									<div class="media" style="border-bottom:1px solid #ccc;margin-bottom:0px;">
										<div class="img txtC" style="width:48px;height:48px;background-color:#f9f9f9;border:1px solid #ccc;margin:2px;"><img style="display:inline;" src="<?php echo NHtml::urlImageThumb($miniScreen->file_id, 'project-drop-down-48-crop'); ?>"/></div>
										<div class="bd pls"><p><?php echo $miniScreen->name; ?></p></div>
									</div>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>-->
				<div id="screenList" class="line">
					<div class="unit inputBox" style="width:215px;"><input /></div>
					<div class="lastUnit"><a href="#" class="btn btnN btnToolbarRight">drop</a></div>
				</div>

			</div>
			<div class="field">
				<a id="cancelSpot" href="#" class="btn btnN">Cancel</a>
				<a id="deleteSpot" href="#" class="btn btnN delete">Delete</a>
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
		init : function( options ) {
			return this.each(function(){
				var $this = $(this);
				$this.draggable({
					drag: function(event, ui) {
						if($('#spotForm:visible').index){
							// make the spotForm follow the hotspot being dragged
							$('#spotForm').position({my:'left top',at:'right top',of:$this,offset:"18 -30",collision:'none'});
							$('#spotForm .triangle').position({my:'left center',at:'right top',of:$this,offset:"0 0",collision:'none'});
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
			var $spot = $(this);
			// show and position the popup form
			$('#spotForm').show()
			.position({my:'left top',at:'right top',of:$spot,offset:"18 -30",collision:'none'});
			$('#spotForm .triangle').position({my:'left center',at:'right top',of:$spot,offset:"0 0",collision:'none'});
			
			// unbind all previously set events
			$('#spotForm').unbind('.spotForm');
			// cancel form link
			$('#spotForm').delegate('#cancelSpot','click.spotForm',function(){
				$('#spotForm').hide();
			});
			// delete spot link
			$('#spotForm').delegate('#deleteSpot','click.spotForm',function(){
				$spot.hotspot('deleteSpot');
				return false;
			});
			$('#spotForm').delegate('.browse','click.spotForm',function(){
				alert('show the browse popup dialog');
				return false;
			});
			var projects = [
				<?php foreach($project->getScreens() as $s):?>
				{
					value: "<?php echo $s->id; ?>",
					label: "<?php echo $s->name; ?>",
					src: "<?php echo NHtml::urlImageThumb($s->file_id, 'project-drop-down-48-crop'); ?>"
				},
				<?php endforeach; ?>
			];

		$("#screenList input").autocomplete({
			minLength: 0,
			source: projects,
			focus: function(event, ui) {
				$("#screenList").val( ui.item.label );
				return false;
			},
			select: function(event, ui) {
				alert(ui.item.value)
				return false;
			}
		})
		.data("autocomplete")._renderItem = function( ul, item ) {
			return $('<li class="screenItem"></li>')
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
		$("#spotForm").delegate('#screenList a','click.spotForm',function(){
			// close if already visible
			if ($("#screenList input").autocomplete("widget").is(":visible")) {
				$("#screenList input").autocomplete("close");
				return;
			}

			// work around a bug (likely same cause as #5265)
			$(this).blur();

			// pass empty string as value to search for, displaying all results
			$("#screenList input").autocomplete("search", "");
			$("#screenList input").focus();
		});
		$('#screenList a')
			.attr("tabIndex", -1)
			.attr("title", "Show All Items")

			
			// screen link drop down box
//			$('#spotForm').delegate('#screenList .items .screenItem', 'mouseover.spotForm', function(){
//				$(this).addClass('hover');
//			}).delegate('#screenList .items .screenItem', 'mouseout.spotForm', function(){
//				$(this).removeClass('hover');
//			}).delegate('#screenList .items .screenItem', 'click.spotForm', function(){
//				$spot.attr('data-screen',$(this).attr('data-id'));
//				$spot.hotspot('update');
//			});
//			if($spot.is('[data-screen]')){
//				var screenLink = $spot.attr('data-screen');
//				$('#screenList .screen').html(screenLink);
//			}
			// old code for select box
//			$('#screenSelect').val(0);
//			if($spot.is('[data-screen]')){
//				var screenLink = $spot.attr('data-screen');
//				$('#screenSelect').val(screenLink);
//			}
//			$('#spotForm').delegate('#screenSelect','change.spotForm',function(){
//				$spot.attr('data-screen',$(this).val());
//				$spot.hotspot('update');
//			});
			
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
		//$('.hotspot').click(function(){alert('oi')});
	});
	

</script>