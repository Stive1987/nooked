<?php
defined("INDEX_CHECK") or die ('<div class="center">Vous ne pouvez pas accéder à cette page directement.</div>');
?>
<script>
var larg_fenetre = J(window).width();
if(J.browser.msie){ larg_fenetre = larg_fenetre+17; } // IE

function taille_images()
{
	J(container+' table').addClass('fix-maxwidth');
	J(container+' table img').attr('style', 'max-width:100%');
}

function taille_images_com()
{
	J(container+' table:has(td > img[src*=posticon])').addClass('fix-maxwidth');
	J(container+' table:has(img[src*=posticon]) img').attr('style', 'max-width:100%');
}

function emballer(objet, emballage)
{
	if(larg_fenetre < 768){
	J(container+' '+objet).wrap(emballage); 
	}	
}

function taille_inputs()
{
	if(larg_fenetre < 768){
	J(container+' input[size]').removeAttr('size');
	}	
}

function resume_utilisateur()
{
	J(container+' table:eq(0) tr:eq(1) td:eq(0) ul').attr('style', 'list-style-position:inside;margin:0;padding:0 0 0 5px'); 
	J(container+' table:eq(0) tr:eq(1) td:has(img[src^="modules/Forum/images/avatar/"]) img[src^="modules/Forum/images/avatar/"]').wrap('<div id="avatar-user" style="text-align:center;padding:10px 0 10px 0" />');
	J(container+' table:eq(0) tr:eq(1) td:has(img[src^="upload/User/"]) img[src^="upload/User/"]').wrap('<div id="avatar-user" style="text-align:center;padding:10px 0 10px 0" />');
	J(container+' #avatar-user').prependTo(container+' table:eq(0) tr:eq(1) td:eq(0)'); 
	J(container+' table:eq(0) tr:eq(1) td:eq(0)').attr('colspan', '2'); 
	J(container+' table:eq(0) tr:eq(1) td:eq(0)').next().remove();
}

function details_joueur()
{
	J(container+' table:eq(0) td:eq(1)').next().attr('id', 'celldroite');
	J(container+' #celldroite img').wrap('<div id="avatar-user" style="text-align:center;padding:10px 0 10px 0" />');
	J(container+' #avatar-user').prependTo(container+' table:eq(0) td:eq(1)'); 
	J(container+' table:eq(0) td:eq(1)').attr('colspan', '2'); 
	J(container+' #celldroite').remove(); 
	
	if(larg_fenetre <= 480){
		J(container+' table table td:nth-child(1)').attr('style', 'display:none'); 
	}
}

function liste_dl()
{
	if(larg_fenetre <= 480){
		J(container+' table img[onclick]').parent('td').attr('style', 'display:none');
	}			
	else if(larg_fenetre > 480 && larg_fenetre < 768){
		J(container+' table img[onclick]').attr('style', 'max-width:100%').parent('td').attr('style', 'width:80px');
	}		
}

function calendar_overflow()
{
	if(larg_fenetre < 768){
		var largeur_container = J(container).width();
		var largeur_tab = J(container+' table:eq(0)').width();
		
		if(largeur_tab > largeur_container)
		{		
			J(container+' table:eq(0)').wrap('<div style="overflow:auto;width:100%;margin:auto" />');
		}
	}		
}

function image_forum_contenu(objet)
{
	if(larg_fenetre <= 480){
	J(container+' '+objet).attr('style', 'max-width:120px');
	}
	else if(larg_fenetre > 480 && larg_fenetre < 768){
	J(container+' '+objet).attr('style', 'max-width:180px');
	}
	
}

function image_forum_avatar()
{
	if(larg_fenetre <= 480){
	J(container+' table img[src^="modules/Forum/images/rank/"]').parent().children('img').attr('style', 'max-width:64px');
	J(container+' table img[src^="images/flags"]').parent().children('img').attr('style', 'max-width:64px');
	}
}

function form_contact()
{
	J(container+' form label').attr('style', 'width:auto');
}
</script>	
<script> 
J(window).load(function() {

	if(larg_fenetre < 980)
	{
		<?php 
		if (
			($_REQUEST['file'] == 'Search' and $_REQUEST['op'] == 'mod_search') OR
			($_REQUEST['file'] == 'Search' and $_REQUEST['op'] == 'index') OR
			($_REQUEST['file'] == 'Defy' and $_REQUEST['op'] == 'index') OR
			($_REQUEST['file'] == 'Guestbook' and $_REQUEST['op'] == 'post_book') OR
			($_REQUEST['file'] == 'Recruit' and $_REQUEST['op'] == 'index') OR
			($_REQUEST['file'] == 'Suggest' and $_REQUEST['op'] == 'index') OR
			($_REQUEST['file'] == 'User' and $_REQUEST['op'] == 'reg_screen') OR
			($_REQUEST['file'] == 'User' and $_REQUEST['op'] == 'oubli_pass') OR
			($_REQUEST['file'] == 'Userbox' and $_REQUEST['op'] == 'post_message')
			){?>
			taille_inputs();
		<?php }
		else if ($_REQUEST['file'] == 'Forum' and $_REQUEST['page'] == 'search'){?>
			taille_inputs();
			J('input[type=text]').attr('style', 'padding-left:0px;padding-right:0px');
		<?php }
		else if ($_REQUEST['file'] == 'Forum' and $_REQUEST['page'] == 'post'){?>
			taille_inputs(); 
			emballer('input[type=file]', '<div style="width:120px;overflow:hidden" />');
		<?php }
		else if ($_REQUEST['file'] == 'Forum' and $_REQUEST['page'] == 'viewtopic'){?>
			image_forum_avatar();
			image_forum_contenu('table table tr:nth-child(3) img');
			image_forum_contenu('table table tr:nth-child(3) table img'); 
			image_forum_contenu('table table tr:nth-child(4) img');
			image_forum_contenu('table table tr:nth-child(5) img'); 
		<?php }
		else if ($_REQUEST['file'] == 'News' and $_REQUEST['op'] == 'index_comment'){?>
			container = container_news;
			taille_images_com();
		<?php }	
		else if ($_REQUEST['file'] == 'Wars' and $_REQUEST['op'] == 'detail'){?>
			taille_images_com();
			taille_inputs();
		<?php }	
		else if ($_REQUEST['file'] == 'Sections' and $_REQUEST['op'] == 'article'){?>
			taille_images_com();
			taille_inputs();
		<?php }	
		else if ($_REQUEST['file'] == 'Gallery' and $_REQUEST['op'] == 'description'){?>
			taille_images();
			taille_inputs();
		<?php }		
		else if ($_REQUEST['file'] == 'Gallery' and $_REQUEST['op'] == 'index'){?>
			taille_images();
		<?php }			
		else if ($_REQUEST['file'] == 'Gallery' and $_REQUEST['op'] == 'categorie'){?>
			taille_images();
		<?php }		
		else if ($_REQUEST['file'] == 'Survey' and $_REQUEST['op'] == 'affich_res'){?>
			taille_images_com();
			taille_inputs();
		<?php }
		else if ($_REQUEST['file'] == 'Contact' and $_REQUEST['op'] == 'index'){?>
			taille_inputs();
			form_contact();
		<?php }
		else if ($_REQUEST['file'] == 'User' and $_REQUEST['op'] == 'index'){?>
			resume_utilisateur();
			if(larg_fenetre < 768){
			taille_images();
			}
		<?php }	
		else if ($_REQUEST['file'] == 'User' and $_REQUEST['op'] == 'edit_account'){?>
			taille_inputs();
			emballer('input[type=file]', '<div style="width:120px;overflow:hidden" />');
		<?php }
		else if ($_REQUEST['file'] == 'User' and $_REQUEST['op'] == 'edit_pref'){?>
			taille_inputs();
			emballer('input[type=file]', '<div style="width:120px;overflow:hidden" />');
		<?php }
		else if ($_REQUEST['file'] == 'Team' and $_REQUEST['op'] == 'detail'){?>
			details_joueur();
		<?php }	
		else if ($_REQUEST['file'] == 'Members' and $_REQUEST['op'] == 'detail'){?>
			details_joueur();
			taille_images();
		<?php }	
		else if ($_REQUEST['file'] == 'Download' and $_REQUEST['op'] == 'index'){?>
			liste_dl();
			taille_images();
			J(container+' table td').attr('style', '');
		<?php }	
		else if ($_REQUEST['file'] == 'Download' and $_REQUEST['op'] == 'description'){?>
			taille_images_com();
			taille_inputs();
			if(larg_fenetre < 768){
			taille_images();
			}
		<?php }		
		else if ($_REQUEST['file'] == 'Links' and $_REQUEST['op'] == 'description'){?>
			taille_images_com();
		<?php }	
		else if ($_REQUEST['file'] == 'Server' and $_REQUEST['op'] == 'index'){?>
			J(container+' input:eq(0)').attr('style', 'width:50px');
		<?php }	
		else if ($_REQUEST['file'] == 'Calendar' and $_REQUEST['op'] == 'index'){?>
			calendar_overflow();	
		<?php }
		
		// Vieille admin
		if (
		   ($_REQUEST['file'] == 'Admin' and $_REQUEST['page'] == 'setting') OR
		   ($_REQUEST['file'] == 'Admin' and $_REQUEST['op'] == 'add_user') OR
		   ($_REQUEST['file'] == 'Admin' and $_REQUEST['op'] == 'edit_user') OR
		   ($_REQUEST['file'] == 'Admin' and $_REQUEST['op'] == 'add_ip') OR
		   ($_REQUEST['file'] == 'Admin' and $_REQUEST['op'] == 'add_block') OR
		   ($_REQUEST['file'] == 'Admin' and $_REQUEST['op'] == 'add_game') OR
		   ($_REQUEST['file'] == 'Calendar' and $_REQUEST['page'] == 'admin' and $_REQUEST['op'] == 'add') OR
		   ($_REQUEST['file'] == 'Calendar' and $_REQUEST['page'] == 'admin' and $_REQUEST['op'] == 'edit') OR
		   ($_REQUEST['file'] == 'Comment' and $_REQUEST['page'] == 'admin' and $_REQUEST['op'] == 'edit_com') OR
		   ($_REQUEST['file'] == 'Contact' and $_REQUEST['page'] == 'admin' and $_REQUEST['op'] == 'main_pref') OR
		   ($_REQUEST['file'] == 'Forum' and $_REQUEST['page'] == 'admin' and $_REQUEST['op'] == 'main_pref') OR
		   ($_REQUEST['file'] == 'Gallery' and $_REQUEST['page'] == 'admin' and $_REQUEST['op'] == 'edit_screen') OR
		   ($_REQUEST['file'] == 'Gallery' and $_REQUEST['page'] == 'admin' and $_REQUEST['op'] == 'add_screen') OR
		   ($_REQUEST['file'] == 'Gallery' and $_REQUEST['page'] == 'admin' and $_REQUEST['op'] == 'main_pref') OR
		   ($_REQUEST['file'] == 'Links' and $_REQUEST['page'] == 'admin' and $_REQUEST['op'] == 'edit_link') OR
		   ($_REQUEST['file'] == 'Links' and $_REQUEST['page'] == 'admin' and $_REQUEST['op'] == 'add_link') OR
		   ($_REQUEST['file'] == 'Guestbook' and $_REQUEST['page'] == 'admin' and $_REQUEST['op'] == 'edit_book') OR
		   ($_REQUEST['file'] == 'News' and $_REQUEST['page'] == 'admin' and $_REQUEST['op'] == 'edit') OR
		   ($_REQUEST['file'] == 'News' and $_REQUEST['page'] == 'admin' and $_REQUEST['op'] == 'add') OR
		   ($_REQUEST['file'] == 'News' and $_REQUEST['page'] == 'admin' and $_REQUEST['op'] == 'add_cat') OR
		   ($_REQUEST['file'] == 'News' and $_REQUEST['page'] == 'admin' and $_REQUEST['op'] == 'edit_cat') OR
		   ($_REQUEST['file'] == 'Survey' and $_REQUEST['page'] == 'admin' and $_REQUEST['op'] == 'edit_sondage') OR
		   ($_REQUEST['file'] == 'Survey' and $_REQUEST['page'] == 'admin' and $_REQUEST['op'] == 'add_sondage') OR
		   ($_REQUEST['file'] == 'Sections' and $_REQUEST['page'] == 'admin' and $_REQUEST['op'] == 'add') OR
		   ($_REQUEST['file'] == 'Sections' and $_REQUEST['page'] == 'admin' and $_REQUEST['op'] == 'edit') OR
		   ($_REQUEST['file'] == 'Download' and $_REQUEST['page'] == 'admin' and $_REQUEST['op'] == 'edit_file')
		   ){?>
			taille_inputs();	
		<?php }		
		else if ($_REQUEST['file'] == 'Admin' and $_REQUEST['op'] == 'edit_block'){?>
			taille_inputs();
			J(container+' input[type=text]:eq(0)').attr('style', 'width:78%');
			J(container+' input[type=text]:eq(1)').attr('style', 'width:20px');
		<?php }	
		else if ($_REQUEST['file'] == 'Admin' and $_REQUEST['op'] == 'edit_line'){?>
			taille_inputs();
			J(container+' input').attr('style', 'width:100%;max-width:75%');
		<?php }		
		else if ($_REQUEST['file'] == 'Admin' and $_REQUEST['page'] == 'phpinfo'){?>
			J(container+' form > div:eq(1)').attr('style', 'margin:auto').attr('class', 'overflow-full');
		<?php }					
		else if ($_REQUEST['file'] == 'Download' and $_REQUEST['page'] == 'admin' and $_REQUEST['op'] == 'index'){?>
			J(container+' table').wrap('<div class="overflow-full"></div>');
		<?php }					
		?>

		if(larg_fenetre <= 480){
		J('#textbox_texte').removeAttr('size'); // Tribune libre
		}	
	
	}	

});
</script>