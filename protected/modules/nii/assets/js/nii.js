/**
 *
 */

;(function($) {

$.nii = {
	version : '1.0',

	form : function () {
		$('.field')
	}
};

})(jQuery);

jQuery(function($){
	var $el = $('*[data-tip]');
	

	$el.tipsy();
	
//	$el.each(function(i,t){
//
//		var $data = $(t).data("tip");
//		console.log($data);
//		$.extend($options, $data);
//		console.log($options);
//		$el.tipsy($options);
//	});
	
});