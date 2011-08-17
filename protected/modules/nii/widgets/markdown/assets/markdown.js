/* 
 * markdow plugin
 * @author Steven OBrien
 * @company Newicon
 */
(function($){
	var settings = {
		// the controller action that processes the preview ajax request
		'ajaxAction':""
	};
	var methods = {
		_buttonState:function($md, $button){
			$md.find('.active').removeClass('active');
			$button.addClass('active');
		},
		edit:function(){
			var $md = this;
			methods._buttonState($md, $md.find('.edit'));
			var $textArea = $md.find('textarea');
			$md.find('.previewBox').hide();
			$md.find('.editBox').show();
			$textArea.focus();
			return false;
		},
		preview:function(){
			var $md = this;
			var $textArea = $md.find('textarea');
			var $previewBox = $md.find('.previewBox')
			$md.find('.editBox').hide();
			methods._buttonState($md, $md.find('.preview'));
			$previewBox.show();
			if($textArea.val() == ''){
				$previewBox.html("<p>Nothing to preview.</p>");
			}else{
				if($textArea.val() == $md.data('lastPreview')){
					$previewBox.html(methods._lastPreview);
				}else{
					$previewBox.html("<p>Loading...</p>");
					$.post(settings.ajaxAction, "text="+$textArea.val(), function(msg){
						$previewBox.html(msg);
						$md.data('lastPreview',msg);
					});
				}
			}
			return false;
		},
		init : function(options) {
			var $md = this;
			
			$.extend(settings,options);
			
			$md.find(".preview").bind('click.markdown',function(){
				return $md.markdown('preview');
			});
			$md.find('.edit').bind('click.markdown',function(){
				return $md.markdown('edit');
			});
		}
	};
	$.fn.markdown = function( method ) {
		if ( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.markdown' );
		}    
	};
})(jQuery);