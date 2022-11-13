var larg_fenetre = J(window).width();
if(J.browser.msie){ larg_fenetre = larg_fenetre+17; } // IE

J(document).ready(function() {

	J(".nav li a").each(function() {
		if (J(this).next().length > 0) {
			J(this).addClass("parent");
		};
	})
	adjustMenu();
})

J(window).bind('resize orientationchange', function() {
	var larg_fenetre = J(window).width();
	if(J.browser.msie){ larg_fenetre = larg_fenetre+17; } // IE
	adjustMenu();
});

function adjustMenu() {
	if (larg_fenetre < 768 || comportement_menu_deroulant == 'Ouvrir/fermer avec un clic') {
		J(".nav li").unbind('mouseenter mouseleave');
		J(".nav li a.parent").unbind('click').bind('click', function(e) {
			// must be attached to anchor element to prevent bubbling
			e.preventDefault();
			J(this).parent().parent().toggleClass("hover");
			J(this).toggleClass("hover"); 
		});
	} 
	else{
		J(".nav").show();
		J(".nav li").removeClass("hover");
		J(".nav li a").unbind('click');
		J(".nav li").unbind('mouseenter mouseleave').bind('mouseenter mouseleave', function() {
		 	// must be attached to li so that mouseleave is not triggered when hover over submenu
		 	J(this).toggleClass('hover');
		});
	}
}