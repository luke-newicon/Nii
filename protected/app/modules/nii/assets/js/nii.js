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
			//$('*[data-tip]').twipsy($(this).metadata({type:'attr',name:'data-tip'}));
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


// Array Remove - By John Resig (MIT Licensed)
Array.prototype.remove = function(from, to) {
  var rest = this.slice((to || from) + 1 || this.length);
  this.length = from < 0 ? this.length + from : from;
  return this.push.apply(this, rest);
};

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
		 * @param form the string form id or jquery form element
		 * @param options options object
		 * - success    : function to call when the form successfully validates
		 * - error      : the ajax error callback
		 * - attributes : array of element id's to validate (defaults to undefined, meaning validate all attributes)
		 */
 		$.fn.yiiactiveform.doValidate = function(form, options){
			
			if(options == undefined)
				options = {};
			
			var $form = $(form);
			var settings = $form.data('settings');
			console.log(settings);
			var messages = {};
			var needAjaxValidation = false;
			$.each(settings.attributes, function(){
				var msg = [];
				if (this.clientValidation != undefined) {
					var value = $('#'+this.inputID, $form).val();
					this.clientValidation(value, msg, this);
					if (msg.length) {
						if (options.attributes == undefined)
							messages[this.id] = msg;
						else
							// options.attributes have been defined so only add a message to the specific fields 
							// we want to validate
							if ($.inArray(this.id,options.attributes) != -1)
								messages[this.id] = msg;
					}
				}
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
								// remove the attributes that we do not want to redraw
								if(options.attributes != undefined && ($.inArray(this.id, options.attributes) == -1))
									delete data[this.id];
								
							});
							$.fn.yiiactiveform.drawValidation($form, options.attributes, $.extend({}, messages, data));
						}

						// we only call the success callback if the form is valid!
						if (data.length==0 && options.success!=undefined)
							options.success();

					},
					error : function() {
						if (options.error!=undefined) {
							options.error();
						}
					}
				});
			}else{
				$.fn.yiiactiveform.drawValidation($form, options.attributes, messages);
				// we only call the success callback if the form is valid!
				if (data != undefined && data.length==0 && options.success!=undefined)
					options.success();
			}
		}
		
		/**
		 * The form to draw the validation on.
		 * Draws the validatiion for each field
		 * 
		 * @param $form the jquery form object
		 * @param attributes an array of field id's to draw the validation for, leave undefined for all.
		 * @param data the json validation result (as returned by CActiveForm::validate)
		 * 
		 */
		$.fn.yiiactiveform.drawValidation = function($form, attributes, data){
			var hasError=false;
			$.each($form.data('settings').attributes, function(){
				if(attributes != undefined){
					if ($.inArray(this.id, attributes) != -1) {
						hasError = $.fn.yiiactiveform.updateInput(this, data, $form) || hasError;
						if(this.afterValidateAttribute!=undefined) {
							afterValidateAttribute($form,this,data,hasError);
						}
					}
				} else {
					hasError = $.fn.yiiactiveform.updateInput(this, data, $form) || hasError;
					if(this.afterValidateAttribute!=undefined) {
						afterValidateAttribute($form,this,data,hasError);
					}
				}
			});
		}
	}
	
	if(jQuery.fn.yiiGridView != undefined){
		
		/**
		 * Performs an AJAX-based update of the grid view contents.
		 * @param id string the ID of the grid view container
		 * @param options map the AJAX request options (see jQuery.ajax API manual). By default,
		 * the URL to be requested is the one that generates the current content of the grid view.
		 */
		$.fn.yiiGridView.update = function(id, options) {
			alert('oi');
			var settings = $.fn.yiiGridView.settings[id];
			$('#'+id).addClass(settings.loadingClass);

			if(options && options.error !== undefined) {
				var customError=options.error;
				delete options.error;
			}

			options = $.extend({
				type: 'GET',
				url: $.fn.yiiGridView.getUrl(id),
				success: function(data,status) {
					$.each(settings.ajaxUpdate, function(i,v) {
						var id='#'+v;
						$(id).replaceWith($(id,'<div>'+data+'</div>'));
					});
					if(settings.afterAjaxUpdate !== undefined)
						settings.afterAjaxUpdate(id, data);
					$('#'+id).removeClass(settings.loadingClass);
					$.fn.yiiGridView.selectCheckedRows(id);
				},
				error: function(XHR, textStatus, errorThrown) {
					$('#'+id).removeClass(settings.loadingClass);
					if(XHR.readyState == 0 || XHR.status == 0)
						return;
					if(customError!==undefined) {
						var ret = customError(XHR);
						if( ret!==undefined && !ret)
							return;
					}
					var err='';
					switch(textStatus) {
						case 'timeout':
							err='The request timed out!';
							break;
						case 'parsererror':
							err='Parser error!';
							break;
						case 'error':
							if(XHR.status && !/^\s*$/.test(XHR.status))
								err='Error ' + XHR.status;
							else
								err='Error';
							if(XHR.responseText && !/^\s*$/.test(XHR.responseText))
								err=err + ': ' + XHR.responseText;
							break;
					}

					if(settings.ajaxUpdateError !== undefined)
						settings.ajaxUpdateError(XHR, textStatus, errorThrown,err);
					else if(err)
						alert(err);
				}
			}, options || {});
			if(options.data!==undefined && options.type=='GET') {
				options.url = $.param.querystring(options.url, options.data);
				options.data = {};
			}

			if(settings.ajaxUpdate!==false) {
				options.url = $.param.querystring(options.url, settings.ajaxVar+'='+id);
				if(settings.beforeAjaxUpdate !== undefined)
					settings.beforeAjaxUpdate(id, options);
				$.ajax(options);
			}
			else {  // non-ajax mode
				if(options.type=='GET') {
					window.location.href=options.url;
				}
				else {  // POST mode
					var $form=$('<form action="'+options.url+'" method="post"></form>').appendTo('body');
					if(options.data===undefined)
						options.data={};

					if(options.data.returnUrl===undefined)
						options.data.returnUrl=window.location.href;

					$.each(options.data, function(name,value) {
						$form.append($('<input type="hidden" name="t" value="" />').attr('name',name).val(value));
					});
					$form.submit();
				}
			}
		};
	}
})();
