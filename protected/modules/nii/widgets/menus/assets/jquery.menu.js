var menuHover = function(menu){
	menu.find('li').hover(function(){
		$(this).addClass("over");
	},function(){
		$(this).removeClass("over");
	});
}
var menuClick = function(menu){
	alert(menu.attr('id'));
	menu.find('li').click(function(e){
		$menu = $(this).addClass("over");
		$(document).one('click',function(e){
			$menu.removeClass('over');
		});
		e.stopPropagation();
	});
}