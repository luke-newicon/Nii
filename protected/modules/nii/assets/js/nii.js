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
		var $ops = {'live':true,'gravity':'s'};
		if($(t).has('[title]')){
			$el.tipsy({'live':true});
		}else{
			$ops.title='data-tip';
		}
		
		$el.tipsy($ops);
	});
	$el.tipsy({'title':'data-tip','live':true});
	
});