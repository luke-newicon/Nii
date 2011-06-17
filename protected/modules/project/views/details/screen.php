<style type="text/css" media="screen">
	body{background-color: rgb(<?php echo $rgb['red']; ?>,<?php echo $rgb['green']; ?>,<?php echo $rgb['blue']; ?>);}
	#canvas{margin: 0 auto;width:<?php echo $width; ?>px;}
	.hotspot{z-index: 100; position: absolute;background-color:orange;border: 1px solid red;opacity: 0.7;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";filter: alpha(opacity=70);}
</style>
<div id="canvas"> 
	<img src="<?php echo NHtml::urlFile($file->id); ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />
	<?php foreach($hotspots as $hotspot): ?>
		<a data-id="<?php echo $hotspot->id; ?>" class="hotspot" style="width:<?php echo $hotspot->width; ?>px;height:<?php echo $hotspot->height; ?>px;left:<?php echo $hotspot->left; ?>px; top:<?php echo $hotspot->top; ?>px;"></a>
	<?php endforeach; ?>
</div>

<script>
	// Boxer plugin
	$.widget("ui.boxer", $.ui.mouse, {
		
		_init: function() {
			this.element.addClass("ui-boxer");
			this.dragged = false;
			this._mouseInit();
			this.helper = $(document.createElement('a'))
			.css({border:'1px dotted black'})
			.addClass("ui-boxer-helper");
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
			
			$('body').append(this.helper);
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
			this.helper.css({left: x1, top: y1, width: x2-x1, height: y2-y1});
			
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
	$.extend($.ui.boxer, {
		defaults: $.extend({}, $.ui.mouse.defaults, {
			appendTo: 'body',
			distance: 0
		})
	});
	
/**
 * Hotspot plugin
 */
(function( $ ){

	var methods = {
		init : function( options ) {
			var $this = $(this);
			$this.draggable({
				stop:function(e,ui){
					methods.update($(this));
				}
			}).resizable({
				stop:function(e,ui){
					methods.update($(this));
				}
			});
			return $this;
		},
		update:function($spot){
			var offset = $spot.offset();
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
				ui.box.css({ opacity: 0.7, border: '1px solid red', background: 'orange'})
				.hotspot().hotspot('update',ui.box);// lets save our creation

			}
		});
		
		$('.hotspot').hotspot();
		
	});
	

</script>