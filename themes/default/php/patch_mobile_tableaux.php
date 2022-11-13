<?php 
defined("INDEX_CHECK") or die ('<div class="center">Vous ne pouvez pas accéder à cette page directement.</div>');

// Colonnes à masquer dans l'ordre des priorités
$colonnes_a_masquer = array (
    'Archives;index' => '5, 4, 2, 3',
    'Forum;index' => '4, 3, 5',
    'Forum,viewforum' => '6, 5, 3, 4',
    'Forum,search' => '4, 3',
	'Members;index' => '7, 6, 4, 5, 8, 3, 1',
    'Stats;index' => '4',
	'Survey;index' => '3, 2, 4',
	'Team;index' => '7, 6, 4, 5, 3, 8',
    'Userbox;index' => '5, 3, 4, 2',
	'Wars;index' => '7, 5, 4, 1, 2',
	// Vieille admin
	'Admin,user' => '4, 3, 2, 6',
	'Admin;main_rank' => '3',
	'Admin;main_valid' => '3, 2, 4',
	'Admin;main_op' => '3, 2, 5',
	'Admin,modules' => '4, 3, 2',
	'Admin,block' => '4, 5, 3, 2, 7',
	'Admin,menu' => '3, 2, 4',
	'Admin;edit_menu' => '6, 5, 7, 4',
	'Admin,smilies' => '3, 2, 5',
	'Sections,admin;index' => '2, 3, 4, 6',
	'Sections,admin;main_cat' => '3, 2, 5',
	'Calendar,admin;main' => '3, 2, 5',
	'Comment,admin;index' => '3, 2, 5',
	'Contact,admin;index' => '3, 2, 5',
	'Forum,admin;index' => '3, 2, 5',
	'Forum,admin;main_cat' => '2, 4',
	'Forum,admin;main_rank' => '2, 3, 5',
	'Gallery,admin;index' => '3, 2, 5',
	'Gallery,admin;main_cat' => '3, 2, 5',
	'Links,admin;index' => '3, 2, 5',
	'Links,admin;main_cat' => '3, 2, 5',
	'Links,admin;main_broken' => '3, 2, 5',
	'Guestbook,admin;index' => '3, 2, 5',
	'News,admin;index' => '2, 4, 3, 5',
	'News,admin;main' => '2, 4, 3, 5',
	'News,admin;main_cat' => '3',
	'Page,admin;index' => '3, 2, 5',
	'Survey,admin;index' => '2, 4',
	'Suggest,admin;index' => '4, 3',
	'Textbox,admin;index' => '3, 2, 5',
	'Download,admin;main_cat' => '3, 2, 5',
	'Download,admin;main_broken' => '4, 3, 6'
); 
?>
<script>
<?php
foreach($colonnes_a_masquer as $key => $col){
	
	$presence_virgule = substr_count($key,',');
	$presence_pointvirgule = substr_count($key,';');
	if($presence_virgule != false and $presence_pointvirgule == false) // page
	{
		$elements = explode(',', $key);
	   
		if ($_REQUEST['file'] == $elements[0] and $_REQUEST['page'] == $elements[1] and $_REQUEST['op'] == 'index'){ ?>
		var colonnes_a_masquer = [<?php echo $col; ?>];
		<?php }	
	}
	elseif($presence_pointvirgule != false and $presence_virgule == false) // op
	{
		$elements2 = explode(';', $key);
	   
		if ($_REQUEST['file'] == $elements2[0] and $_REQUEST['op'] == $elements2[1]){ ?>
		var colonnes_a_masquer = [<?php echo $col; ?>];
		<?php }	
	}
	elseif($presence_virgule != false and $presence_pointvirgule != false) // page and op
	{
		$elements2 = explode(',', $key);
		$elements3 = explode(';', $elements2[1]);
	   
		if ($_REQUEST['file'] == $elements2[0] and $_REQUEST['page'] == $elements3[0] and $_REQUEST['op'] == $elements3[1]){ ?>
		var colonnes_a_masquer = [<?php echo $col; ?>];
		<?php }	
	}
	else{	
		if ($_REQUEST['file'] == $key and $_REQUEST['page'] == 'index'){ ?>
		var colonnes_a_masquer = [<?php echo $col; ?>];
		<?php }
	}

}?>

J(window).load(function() {

	if(typeof colonnes_a_masquer != 'undefined'){
	
		var largeur_container = J(container).width();
		
		J(container+' table:not(table table)').each(function(){
		
			for (var i = 0; i < colonnes_a_masquer.length; i++) {
			
				var largeur_tab = J(this).width();
				var col = colonnes_a_masquer[i]-1;
				
				if(largeur_tab > largeur_container)
				{		
					J(this).find('> tbody > tr').each(function(){
						J(this).find('> td:eq('+col+')').addClass('hide-col');
					});
				}
				
				if((largeur_tab > largeur_container) && i==(colonnes_a_masquer.length-1))
				{
					J(this).addClass('word-wrap');
				}
					
			}	
		});	
	}
});

J(window).resize(function() {

	if(typeof colonnes_a_masquer != 'undefined'){
		
		var largeur_container = J(container).width();
		
		J(container+' table:not(table table)').each(function(){
		
			for (var i = 0; i < colonnes_a_masquer.length; i++) {
			
				var largeur_tab = J(this).width();
				var col = colonnes_a_masquer[i]-1;
				
				// Ca dépasse
				if(largeur_tab > largeur_container)
				{		
					J(this).find('> tbody > tr').each(function(){
						J(this).find('> td:eq('+col+')').addClass('hide-col');
					});
				}
				// Sinon il peut peut-être rester de la place
				else{
				
					// Afficher toutes les colonnes masquées et mesure du tableau
					J(this).find('> tbody > tr').each(function(){		
						J(this).find('> td:eq('+col+')').removeClass('hide-col'); //display:none				
					});
					
					largeur_container = J(container).width();
					largeur_tab = J(this).width();
					
					// Ca depasse
					if(largeur_tab > largeur_container)
					{		
						J(this).find('> tbody > tr').each(function(){
						J(this).find('> td:eq('+col+')').addClass('hide-col'); //display:none
						});
					}
				}
				
				// Ca dépasse et il n'y a plus de colonne à masquer
				largeur_container = J(container).width();
				largeur_tab = J(this).width();
				if((largeur_tab > largeur_container) && i==(colonnes_a_masquer.length-1))
				{
					J(this).addClass('word-wrap');
				}
					
			}
		});
	}
});
</script>	