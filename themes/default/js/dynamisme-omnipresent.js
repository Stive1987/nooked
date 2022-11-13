J(function(){

	var larg_fenetre = J(window).width();
	if(J.browser.msie){ larg_fenetre = larg_fenetre+17; } // IE

	// OUVRIR ELEMENTS
	// --------------------
	J('#ouvrir-nav button').click(function(){ J('#conteneur-nav').slideToggle('fast'); });	

	// DESACTIVER BORDURES
	// --------------------
	if(larg_fenetre < 980){ J('.block-news-moitie:lt(1)').attr('style', 'border-top-width:0'); }
	else{ J('.block-news-moitie:lt(2)').attr('style', 'border-top-width:0'); }
	J('.block-news-large:lt(1)').attr('style', 'border-top-width:0');
	
	// SON BTN
	// -------
	if(oldIE != true){ // Pas besoin sur ie7 ...
	
		volume_sons = volume_sons.replace(' ', '');
		volume_sons = volume_sons.replace('%', '');
		volume_sons = volume_sons/100;
		
		for(var m=1; m<=12; m++)
		{		
			if(J(".btn-son-survol-"+m).length > 0)
			{	 
				(function(p){	// Closure 
					var son = J("#son-"+p)[0];
					J(".btn-son-survol-"+p).mouseover(function(){ son.volume=volume_sons; son.play(); });
				})(m);
			}
			if(J(".btn-son-clic-"+m).length > 0)
			{	
				(function(p){	// Closure 
					var son = J("#son-"+p)[0];
					J(".btn-son-clic-"+p).click(function(){ son.volume=volume_sons; son.play(); });
				})(m);
			}			
		}
	
	}
	
	// ANCRE
	// -----
	J('footer #up').click(function(){
		J('html,body').animate({scrollTop: J("body").offset().top}, 'slow');	
	});	
	
});