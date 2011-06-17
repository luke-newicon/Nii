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
	$el.each(function(i,t){
		$ele = $(t);
		$ele.tipsy($ele.metadata({type:'attr',name:'data-tip'}));
	});
	
});