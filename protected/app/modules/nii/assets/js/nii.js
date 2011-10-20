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
 * Handy setup, initialisation and other nii related goodies.
 *
 * Copyright (c) 2011 Newicon
 * Dual licensed under the MIT and GPL licenses.
 * Uses the same license as jQuery, see:
 * http://docs.jquery.com/License
 */
(function($) {
	$.fn.nii = {
		/**
		 * find all elements that have tooltips and activate tipsy!
		 * add data-tip="{-tipsy options-}" title="tooltip text" to any element
		 */
		tipsy:function(){
			$('*[data-tip]').tipsy($(this).metadata({type:'attr',name:'data-tip'}));
		},
		/**
		 * initialise form elements
		 */
		form:function(){
			// focus 
			$('.niiform').unbind();
			$('body').delegate(':input','focusin.niiform',function(){$(this).closest(".field").addClass("focus");});
			$('body').delegate(':input','focusout.niiform',function(){$(this).closest(".field").removeClass("focus");});
			$('.inFieldLabel').inFieldLabels({fadeDuration:0});
		}
	};
})(jQuery);



jQuery(function($){
	// add tipsy
	$.fn.nii.tipsy();
	// form stuff
	$.fn.nii.form();
});


/**
 * Overrides and adds functions to the standard yiiactiveform js 
 * 
 * 
 */
(function()
{
	/**
	 * makes drawing an individual form fields error message slightly more sexy
	 */
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
			
		/**
		 * The form to draw the validation on.
		 * Draws the validatiion for each field
		 * 
		 * @param $form the jquery form object
		 * @param data the json validation result (as returned by CActiveForm::validate)
		 */
		$.fn.yiiactiveform.drawValidation = function($form, data){
			var hasError=false;
			$.each($form.data('settings').attributes, function(){
				hasError = $.fn.yiiactiveform.updateInput(this, data, $form) || hasError;
				var attribute = this;
				if(attribute.afterValidateAttribute!=undefined) {
					afterValidateAttribute($form,attribute,data,hasError);
				}
			});
		}
		
		/**
		 * Validates the form in its entirety, 
		 * the successCallback is ONLY called if no validation messages are returned.
		 * 
		 * @form string|jquery form the form to validate
		 * @successCallback function the function to call on successful validation
		 * @errorCallback functon optional the ajax error callback
		 */
		$.fn.yiiactiveform.doValidate = function(form, successCallback, errorCallback){
			var $form = $(form);
			var settings = $form.data('settings');
			console.log(settings);
			var messages = {};
			var needAjaxValidation = false;
			$.each(settings.attributes, function(){
				var msg = [];
				//if (this.clientValidation != undefined && (settings.submitting || this.status == 2 || this.status == 3)) {
					var value = $('#'+this.inputID, $form).val();
					this.clientValidation(value, msg, this);
					if (msg.length) {
						messages[this.id] = msg;
					}
				//}
				if (this.enableAjaxValidation)
					needAjaxValidation = true;
			});
			
			if(needAjaxValidation){
				$.ajax({
					url : settings.validationUrl,
					type : $form.attr('method'),
					data : $form.serialize()+'&'+settings.ajaxVar+'='+$form.attr('id'),
					dataType : 'json',
					success : function(data) {
						if (data != null && typeof data == 'object') {
							$.each(settings.attributes, function() {
								if (!this.enableAjaxValidation)
									delete data[this.id];
							});
							$.fn.yiiactiveform.drawValidation($form, $.extend({}, messages, data));
						}

						// we only call the success callback if the form is valid!
						if (data.length==0 && successCallback!=undefined)
							successCallback();

					},
					error : function() {
						if (errorCallback!=undefined) {
							errorCallback();
						}
					}
				});
			}else{
				$.fn.yiiactiveform.drawValidation($form, messages);
				// we only call the success callback if the form is valid!
				if (data.length==0 && successCallback!=undefined)
					successCallback();
			}
		}
	}
})();
