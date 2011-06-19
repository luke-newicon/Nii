<style type="text/css" media="screen">
	body{background-color: rgb(<?php echo $rgb['red']; ?>,<?php echo $rgb['green']; ?>,<?php echo $rgb['blue']; ?>);}
	#canvas{margin: 0 auto;width:<?php echo $width; ?>px;}
	.hotspot{cursor:pointer;z-index: 100; position: absolute;background-color:orange;border: 1px solid red;opacity: 0.7;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";filter: alpha(opacity=70);}
	.hotspot.helper{border:1px dotted red;cursor:crosshair;opacity: 0.4;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=40)";filter: alpha(opacity=40);}
	#canvas{cursor:crosshair;position:relative;}
	
	.spotForm{border-radius:5px;z-index:3000;background-color:#f1f1f1;width:300px;height:150px;border:1px solid #535a64;box-shadow:0px 3px 10px #444,inset 0px 1px 0px 0px #fff; top:100px;left:100px;position:absolute; }
	.triangle{background:url("<?php echo ProjectModule::get()->getAssetsUrl().'/triangle.png'; ?>") no-repeat top left;width:19px;height:34px;left:-19px;top:10px;position:absolute;}
	.spotFormPart{padding:5px;}
</style>
<?php echo CHtml::linkTag('stylesheet', 'text/css', ProjectModule::get()->getAssetsUrl().'/project.css'); ?>
<div id="canvas"> 
	<img src="<?php echo NHtml::urlFile($file->id); ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />
	<?php foreach($hotspots as $hotspot): ?>
		<a data-id="<?php echo $hotspot->id; ?>" class="hotspot" style="width:<?php echo $hotspot->width; ?>px;height:<?php echo $hotspot->height; ?>px;left:<?php echo $hotspot->left; ?>px; top:<?php echo $hotspot->top; ?>px;"></a>
	<?php endforeach; ?>
</div>

<div id="spotForm" class="spotForm" style="display:none;">
	<div class="spotFormContainer" style="position:relative;">
		<div class="triangle"></div>
		<div class="spotFormPart form">
			<div class="field">
				<label for="screenSelect">Link to:</label>
				<div class="inputBox" style="padding:0px;">
					<?php echo CHtml::dropDownList('screenSelect', 0, $project->getScreensListData(),array('class'=>'input','style'=>'margin:0px;')) ?>
				</div>
				<button class="btn btnN">Browse</button>
			</div>
			<div class="field">
				<a id="cancelSpot" href="#" class="">Cancel</a>
				<a id="deleteSpot" href="#" class="">Delete</a>
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
//	$.extend($.ui.boxer, {
//		defaults: $.extend({}, $.ui.mouse.defaults, {
//			appendTo: '#canvas',
//			distance: 0
//		})
//	});
	
/**
 * Hotspot plugin
 */
(function( $ ){

	var methods = {
		init : function( options ) {
			return this.each(function(){
				var $this = $(this);
				$this.draggable({
					stop:function(e,ui){
						$this.hotspot('update');
					}
				})
				.resizable({
					stop:function(e,ui){
						$this.hotspot('update');
					}
				})
				.click(function(){
					$this.hotspot('showForm');
				});
			})
			
			return $spot;
		},
		showForm:function(){
			var $spot = $(this);
			$('#spotForm').show()
			.position({my:'left top',at:'right top',of:$spot,offset:"18 -30",collision:'none'});
			$('#spotForm .triangle').position({my:'left center',at:'right top',of:$spot,offset:"0 0",collision:'none'});
			$('#deleteSpot').unbind('.spotForm');
			$('#cancelSpot').bind('click.spotForm',function(){
				$('#spotForm').hide();
			});
			$('#deleteSpot').bind('click.spotForm',function(){
				$spot.hotspot('deleteSpot');
				return false;
			});
			$('#screenSelect').change(function(){
				
				$.post("<?php echo NHtml::url('/project/details/screenLink'); ?>", 
				{screen_id_link:$(this).val(),hotspot_id:<?php echo $hotspot->id; ?>}, function(){
					alert('done');
				});
			});
		},
		update:function(){
			var $spot = $(this);
			var offset = $spot.position();
			var id = -1;
			if($spot.is('[data-id]'))
				id = $spot.data('id');
			$.post("<?php echo NHtml::url('/project/details/saveHotspot'); ?>",
				{ProjectHotSpot:{
					hotspot_id:id,
					screen_id:"<?php echo $screen->id; ?>",
					width:$spot.width(),
					height:$spot.height(),
					left:offset.left,
					top:offset.top
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
			$.post("<?php echo NHtml::url('/project/details/deleteSpot'); ?>",{id:$spot.data('id')});
		},
		click:function(){
			alert(el.data('id'));
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
		});
		
		$('.hotspot').hotspot();
		//$('.hotspot').click(function(){alert('oi')});
	});
	

</script>