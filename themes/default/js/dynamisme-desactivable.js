J(function(){

	var larg_fenetre = J(window).width();
	if(J.browser.msie){ larg_fenetre = larg_fenetre+17; } // IE

	// BLOCKS
	// ------
	if(J('.lien-dynamisme-block').length > 0){

		var nb_blocks = J('.contenu-dynamisme-block').length;
		
		// Cookie n'existe pas, tout activer
		if(J.cookie('etat_blocks') == null){
		
			var chaine_etats = '';
		
			J('.titre-dynamisme-block h3').each(function(y){
			
				var titre_block = J(this).text();
				titre_block = titre_block.replace(/[ '"]/g,""); // Espaces, guillemets, apostrophes
				titre_block = titre_block.toLowerCase().replace(/[ùûü]/g,"u").replace(/[îï]/g,"i").replace(/[àâä]/g,"a").replace(/[ôö]/g,"o").replace(/[éèêë]/g,"e").replace(/ç/g,"c"); // Accents
				
				if(y==(nb_blocks-1)){
				chaine_etats = chaine_etats+titre_block+'-1';
				}
				else{
				chaine_etats = chaine_etats+titre_block+'-1_';
				}
				
			})
		
			// Création cookie
			J.cookie('etat_blocks', chaine_etats, { expires: 7, path: '/' });
		}
		
		// Explode
		var etats_blocks = J.cookie('etat_blocks').split('_');

		J('.lien-dynamisme-block').each(function(x){
		
			// Définition des états
			var titre_block = J('.titre-dynamisme-block:eq('+ x +') h3').text();
			titre_block = titre_block.replace(/[ '"]/g,""); // Espaces, guillemets, apostrophes
			titre_block = titre_block.toLowerCase().replace(/[ùûü]/g,"u").replace(/[îï]/g,"i").replace(/[àâä]/g,"a").replace(/[ôö]/g,"o").replace(/[éèêë]/g,"e").replace(/ç/g,"c"); // Accents
		
			var bloc_est_nouveau = true;
			
			for(var i= 0; i<etats_blocks.length; i++){
			
				var etats = etats_blocks[i].split('-');
				
				// Présent dans la liste
				if(etats[0] == titre_block){
				
					bloc_est_nouveau = false;
				
					if(etats[1] == 0){
						J('.contenu-dynamisme-block:eq('+ x +')').css('display', 'none');
						var contenu_bouton = J('.lien-dynamisme-block:eq('+ x +')').html();
						var contenu_bouton = contenu_bouton.replace('-up', '-down');
						J('.lien-dynamisme-block:eq('+ x +')').html(contenu_bouton);
					}
				}
				
			}
			
			// Ajout bloc et Maj cookie
			if(bloc_est_nouveau){	
				var chaine_etats = J.cookie('etat_blocks')+'_'+titre_block+'-1';
				J.cookie('etat_blocks', chaine_etats, { expires: 7, path: '/' });
			}
		
			
			// Clic Bouton
			J(this).click(function(){
			
				etats_blocks = J.cookie('etat_blocks').split('_');
				
				for(var i= 0; i<etats_blocks.length; i++){
			
					var etats = etats_blocks[i].split('-');
					
					// Présent dans la liste
					if(etats[0] == titre_block)
					{
					
						if(etats[1] == 0){
					
							// Slide
							J('.contenu-dynamisme-block:eq('+ x +')').slideDown(vitesse_ouverture);
							
							// Modif btn
							var contenu_bouton = J('.lien-dynamisme-block:eq('+ x +')').html();
							var contenu_bouton = contenu_bouton.replace('-down', '-up');
							J('.lien-dynamisme-block:eq('+ x +')').html(contenu_bouton);
							
							// Etat
							etats[1] = 1;
						}
						else{
							J('.contenu-dynamisme-block:eq('+ x +')').slideUp(vitesse_fermeture);
							var contenu_bouton = J('.lien-dynamisme-block:eq('+ x +')').html();
							var contenu_bouton = contenu_bouton.replace('-up', '-down');
							J('.lien-dynamisme-block:eq('+ x +')').html(contenu_bouton);
							etats[1] = 0;
						}
					
					}
					
					// Fusionner nom bloc et valeur
					etats_blocks[i] = etats.join('-');
		
				}
				
				// Fusionner en chaîne puis créer cookie
				var chaine_etats = etats_blocks.join('_');
				J.cookie('etat_blocks', chaine_etats, { expires: 7, path: '/' });
				
			});
			
			
			// Clic Titre
			J('.titre-dynamisme-block:eq('+ x +')').click(function(){
			
				etats_blocks = J.cookie('etat_blocks').split('_');
				
				for(var i= 0; i<etats_blocks.length; i++){
			
					var etats = etats_blocks[i].split('-');
					
					// Présent dans la liste
					if(etats[0] == titre_block)
					{
					
						if(etats[1] == 0){
					
							// Slide
							J('.contenu-dynamisme-block:eq('+ x +')').slideDown(vitesse_ouverture);
							
							// Modif btn
							var contenu_bouton = J('.lien-dynamisme-block:eq('+ x +')').html();
							var contenu_bouton = contenu_bouton.replace('-down', '-up');
							J('.lien-dynamisme-block:eq('+ x +')').html(contenu_bouton);
							
							// Etat
							etats[1] = 1;
						}
						else{
							J('.contenu-dynamisme-block:eq('+ x +')').slideUp(vitesse_fermeture);
							var contenu_bouton = J('.lien-dynamisme-block:eq('+ x +')').html();
							var contenu_bouton = contenu_bouton.replace('-up', '-down');
							J('.lien-dynamisme-block:eq('+ x +')').html(contenu_bouton);
							etats[1] = 0;
						}
					
					}
					
					// Fusionner nom bloc et valeur
					etats_blocks[i] = etats.join('-');
				}
				
				// Fusionner en chaîne puis créer cookie
				var chaine_etats = etats_blocks.join('_');
				J.cookie('etat_blocks', chaine_etats, { expires: 7, path: '/' });
				
			});
		});
	}
	
	
	// NEWS
	// ------
	if(J('.lien-dynamisme-news').length > 0){
	
		var image_btn = J('.lien-dynamisme-news').html();
		
		function agrandirNews()
		{
			image_btn = image_btn.replace('news-large', 'news-moitie');
			J('.lien-dynamisme-news').html(image_btn);
			J('.block-news-moitie').attr('class', 'block-news-large');
			J('.block-news-large').attr('style', 'border-top-width:1px');
			J('.block-news-large:lt(1)').attr('style', 'border-top-width:0');
		}
		
		function diviserNews()
		{
			image_btn = image_btn.replace('news-moitie', 'news-large');
			J('.lien-dynamisme-news').html(image_btn);
			J('.block-news-large').attr('class', 'block-news-moitie');
			J('.block-news-moitie:lt(2)').attr('style', 'border-top-width:0');
		}
		
		if(J.cookie('etat_news') == 1){ diviserNews(); }
		else if(J.cookie('etat_news') == 2){ agrandirNews(); }
		
		J('.lien-dynamisme-news').click(function(){
		
			image_btn = J('.lien-dynamisme-news').html();
			
			if(image_btn.indexOf('news-large') != -1) 
			{
				agrandirNews();
				J.cookie('etat_news', 2, { expires: 7, path: '/' });
			}
			else if(image_btn.indexOf('news-moitie') != -1) 
			{
				diviserNews();
				J.cookie('etat_news', 1, { expires: 7, path: '/' });
			}

		});
	
	}
	
	// CONTENU MULTIPLE
	// ------
	var nb_contenus_multiples = J('.contenu-multiple').length;

	for(var m=1; m<=nb_contenus_multiples; m++){	
		
		if(J('.contenu-multiple-'+ m).length > 0){
		
			if(J.cookie('etat_block_multiple-'+ m) == null)
			{
				J.cookie('etat_block_multiple-'+ m, 1, { expires: 7, path: '/' });
			}

			var nb_contenus = J('.contenu-multiple-'+ m).length;

			for(var k=0; k<nb_contenus; k++){
			
				if(k == J.cookie('etat_block_multiple-'+ m)-1)
				{
					J('.contenu-multiple-'+ m +':eq('+ k +')').slideDown();
					J('.lien-multiple-'+ m +':eq('+ k +')').attr('style', 'cursor:default;color:#8397AC;');
				}
				else{
					J('.contenu-multiple-'+ m +':eq('+ k +')').attr('style', 'display:none');
					J('.lien-multiple-'+ m +':eq('+ k +')').attr('style', 'color:#fff');
				}
			
			}
			
			// Closure pour avoir fonctions click fonctionnelles avec chaque contenu multiple
			(function(n){
			
				J('.lien-multiple-'+ n).click(function(){

					var x = J('.lien-multiple-'+ n).index(this); // Recup id du bouton
				
					// Slide
					J('.contenu-multiple-'+ n +':eq('+ x +')').slideDown();
					J('.contenu-multiple-'+ n +':not(.contenu-multiple-'+ n +':eq('+ x +'))').slideUp();
					
					// Style
					J('.lien-multiple-'+ n).attr('style', 'cursor:pointer;color:#fff');
					J(this).attr('style', 'cursor:default;color:#8397AC;');
					J(this).children().attr('style', 'border:1px solid red');

					J.cookie('etat_block_multiple-'+ n, x+1, { expires: 7, path: '/' });
					
				});
				
			})(m);
		
		}
	}
	
});