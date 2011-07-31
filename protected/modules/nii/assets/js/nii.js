/**
 * In-Field Label jQuery Plugin
 * http://fuelyourcoding.com/scripts/infield.html
 *
 * Copyright (c) 2009 Doug Neiner
 * Dual licensed under the MIT and GPL licenses.
 * Uses the same license as jQuery, see:
 * http://docs.jquery.com/License
 */
(function(d){d.InFieldLabels=function(e,b,f){var a=this;a.$label=d(e);a.label=e;a.$field=d(b);a.field=b;a.$label.data("InFieldLabels",a);a.showing=true;a.init=function(){a.options=d.extend({},d.InFieldLabels.defaultOptions,f);if(a.$field.val()!==""){a.$label.hide();a.showing=false}a.$field.focus(function(){a.fadeOnFocus()}).blur(function(){a.checkForEmpty(true)}).bind("keydown.infieldlabel",function(c){a.hideOnChange(c)}).bind("paste",function(){a.setOpacity(0)}).change(function(){a.checkForEmpty()}).bind("onPropertyChange",
function(){a.checkForEmpty()})};a.fadeOnFocus=function(){a.showing&&a.setOpacity(a.options.fadeOpacity)};a.setOpacity=function(c){a.$label.stop().animate({opacity:c},a.options.fadeDuration);a.showing=c>0};a.checkForEmpty=function(c){if(a.$field.val()===""){a.prepForShow();a.setOpacity(c?1:a.options.fadeOpacity)}else a.setOpacity(0)};a.prepForShow=function(){if(!a.showing){a.$label.css({opacity:0}).show();a.$field.bind("keydown.infieldlabel",function(c){a.hideOnChange(c)})}};a.hideOnChange=function(c){if(!(c.keyCode===
16||c.keyCode===9)){if(a.showing){a.$label.hide();a.showing=false}a.$field.unbind("keydown.infieldlabel")}};a.init()};d.InFieldLabels.defaultOptions={fadeOpacity:0.5,fadeDuration:300};d.fn.inFieldLabels=function(e){return this.each(function(){var b=d(this).attr("for");if(b){b=d("input#"+b+"[type='text'],input#"+b+"[type='search'],input#"+b+"[type='tel'],input#"+b+"[type='url'],input#"+b+"[type='email'],input#"+b+"[type='password'],textarea#"+b);b.length!==0&&new d.InFieldLabels(this,b[0],e)}})}})(jQuery);


/**
 * Nii jQuery Plugin
 *
 * Copyright (c) 2011 Newicon
 * Dual licensed under the MIT and GPL licenses.
 * Uses the same license as jQuery, see:
 * http://docs.jquery.com/License
 */
(function($) {
	$.nii = {
		form : function () {
			alert('oi');
		}
	};
})(jQuery);
jQuery(function($){
	// add tipsy
	var $el = $('*[data-tip]');
	$el.each(function(i,t){
		$ele = $(t);
		$ele.tipsy($ele.metadata({type:'attr',name:'data-tip'}));
	});
	
	// form stuff
	$('body').delegate(':input','focusin',function(){$(this).closest(".field").addClass("focus");})
	$('body').delegate(':input','focusout',function(){$(this).closest(".field").removeClass("focus");})
		
	// infield labels
	$('.inFieldLabel').inFieldLabels({fadeDuration:0});
});


(function()
{
	// Define overriding method.
	if(jQuery.fn.yiiactiveform != undefined){
		jQuery.fn.yiiactiveform.updateInput = function(attribute, messages, form) 
		{
				attribute.status = 1;
				var hasError = messages!=null && $.isArray(messages[attribute.id]) && messages[attribute.id].length>0;
				var $error = $('#'+attribute.errorID, form);
				var $container = $.fn.yiiactiveform.getInputContainer(attribute, form);
				$container.removeClass(attribute.validatingCssClass)
						.removeClass(attribute.errorCssClass)
						.removeClass(attribute.successCssClass);

				if(hasError) {
						$error.html(messages[attribute.id][0]).hide().fadeIn('slow');
						$container.addClass(attribute.errorCssClass);
				}
				else if(attribute.enableAjaxValidation || attribute.clientValidation) {
						$container.addClass(attribute.successCssClass);
				}
				if(!attribute.hideErrorMessage)
						$error.toggle(hasError);

				attribute.value = $('#'+attribute.inputID, form).val();

				return hasError;

		}
	}
})();