<?php
/*
*
* classik_orb_blue
*
* @author ClassikD <postmaster@classik-design.com>
* @copyright (c) 2013, Royal-Template.com
*
*/

defined("INDEX_CHECK") or die ('<div class="center">Accès interdit</div>');
include('php/config.php');
include($tpl .'/php/fonctions.php');
include($tpl .'/admin/general.php');
include($tpl .'/admin/colonnes.php');
include($tpl .'/admin/blocks.php');
include($tpl .'/admin/slider.php');
include($tpl .'/admin/video.php');
include($tpl .'/admin/sons.php');
include($tpl .'/admin/divers.php');
translate($tpl .'/php/'. $language .'.lang.php');

foreach (array("1.7", "1.7.5", "1.7.6", "1.7.7", "1.7.8", "SP2", "SP3", "SP4") as $version) {
if ($nuked['version']==$version){ $_REQUEST = array('file'=>$GLOBALS['file'], 'page'=>$GLOBALS['page'], 'op'=>$GLOBALS['op']); $old_version = true; }
}
$utilisation_sp = substr_count(strtolower($nuked['version']), 'sp');

function top()
{
	global $nuked, $language, $user, $session_admin, $tpl, $utilisation_sp, $old_version, $cfg_general, $cfg_blocks, $cfg_colonnes, $cfg_divers, $cfg_video, $cfg_slider, $cfg_sons;

	include ($tpl .'/php/config.php');
	include ($tpl .'/admin/menu.php');
	 ?>
<?php
// On récupère la date d'aujourd'hui.
$date = getdate();

// Voici les conditions. L'expression à comparer est mise dans le switch
switch ($hours = $date["hours"]){
  // Puis on met les possibilités dans les case. On pense bien au break, c'est important.
  case ( $hours < 5 ):
     include ($tpl .'/php/head-nuit.php');
  // Je me répète, mais c'est vraiment important, le break
  break;

  case ($hours < 8):
    include ($tpl .'/php/head-nuit.php');
  break;

  case ($hours < 11):
    include ($tpl .'/php/head-jour.php');
  break;

  case ($hours < 19):
    include ($tpl .'/php/head-jour.php');
  break;

  case ($hours < 22):
    include ($tpl .'/php/head-nuit.php');
  break;

  default:
    include ($tpl .'/php/head-nuit.php');
  break;
}
?>
<body>
<section id="bande-haut" class="fond2">
	<div class="contenu tableau toblock">
		<p id="block-reseaux" class="cellule middle <?php classe_block('Réseaux sociaux'); ?>">
			<a href="<?php echo $cfg_general['Bouton Facebook']['Lien']; ?>" title="<?php echo $cfg_general['Bouton Facebook']['Titre']; ?>" <?php if($cfg_general['Bouton Facebook']['Nouvelle fenêtre'] == 'on'){ blank(); } ?>><img class="rounded3 middle" src="<?php echo $tpl; ?>/images/picto-fb.png" alt="" /></a>
			<a href="<?php echo $cfg_general['Bouton Twitter']['Lien']; ?>" title="<?php echo $cfg_general['Bouton Twitter']['Titre']; ?>" <?php if($cfg_general['Bouton Twitter']['Nouvelle fenêtre'] == 'on'){ blank(); } ?>><img class="rounded3 middle" src="<?php echo $tpl; ?>/images/picto-twitter.png" alt="" /></a>
			<a href="<?php echo $cfg_general['Bouton Google+']['Lien']; ?>" title="<?php echo $cfg_general['Bouton Google+']['Titre']; ?>" <?php if($cfg_general['Bouton Google+']['Nouvelle fenêtre'] == 'on'){ blank(); } ?>><img class="rounded3 middle" src="<?php echo $tpl; ?>/images/picto-gp.png" alt="" /></a>
		    <span id="message-team"><font color="#ffffff"><?php echo $cfg_general["Message haut du site"]["Message"]; ?></font></span>
		</p>
		<div id="block-login" class="cellule middle right <?php classe_block('Connexion / Enregistrement'); ?>">
		<?php
		if(!$user){ include ($tpl .'/php/block_utilisateur_horsligne.php'); }
		else{ include ($tpl .'/php/block_utilisateur_enligne.php'); }
		 ?>
		</div>
	</div>
</section>
<div id="site">

	<header role="banner" id="header" class="relative">
		<div id="infos" class="tableau toblock">
			<div class="cellule middle">
				<h1 class="hide"><?php echo $nuked['name']; ?></h1>
				<h2 class="hide"><?php echo $nuked['slogan']; ?></h2>
				<p class="hide-pc-pclow"><a href="index.php"><img src="<?php echo $tpl; ?>/images/logo.<?php echo $cfg_general['logo']['Extension']; ?>?date=<?php echo filemtime($tpl.'/images/logo.'.$cfg_general['logo']['Extension']); ?>" alt="<?php echo $nuked['name']; ?>" /></a></p>
			</div>
			<div class="cellule middle center hide-phone-pad">
			<!-- Possibilité d'insérer du contenu ici -->
			</div>
		</div>
		<?php if($cfg_general['Désactiver les effects flash']['Etat'] != 'on'){ ?>
		<div id="effets-flash" class="hide-phone-pad-pclow">
			<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="940" height="210">
			<param name="quality" value="high">
			<param name="bgcolor" value="#000000">
			<param name="wmode" value="transparent">
			<param name="movie" value="<?php echo $tpl; ?>/swf/effets.swf">
			<embed wmode="transparent" src="<?php echo $tpl; ?>/swf/effets.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" bgcolor="#000000" width="940" height="210"></embed></object>
		</div>
		<?php } ?>
	</header>
	
<nav role="navigation" id="menu-principal" class="fond2 rounded10">
			<div id="ouvrir-nav" class="couleurf2">
		<button class="police2">Menu <span class="floatr"><img src="<?php echo $tpl; ?>/images/ico-nav.png" alt="+" /></span></button>
		    </div>
	<div id="conteneur-nav">
		<?php 
		$differents_sons = array();
		foreach ($cfg_sons as $g => $groupe) 
		{
			if($groupe['Etat'] == 'on' && $g != 'Config'){
			
				if(!in_array($groupe['Son'] ,$differents_sons)){
				?>
				<audio id="son-<?php echo $groupe['Son'] ?>">
					<source src="<?php echo $tpl; ?>/sons/<?php echo $groupe['Son'] ?>.wav" type="audio/wav"></source>
					<source src="<?php echo $tpl; ?>/sons/<?php echo $groupe['Son'] ?>.ogg" type="audio/ogg"></source>
				</audio>
				<?php
				}
				$differents_sons[] = $groupe['Son'];
			}
		} ?>
		
		<ul class="nav tableau toblock">	
			<?php
			$id_categorie = 0;
			foreach ($cfg_menu as $g => $groupe) 
			{
				if($groupe['Parent'] == "0")
				{
					$id_categorie++;
					?>
					<li class="cellule middle center">
					<div> <!-- Div nécessaire car position:relative mal prit en compte sur cellule tableau, bug sur ff -->
					<a href="<?php echo $groupe['Lien']; ?>" <?php if($groupe['Nouvelle fenêtre'] == 'on'){blank();} ?> class="police2 rounded10 transition1 <?php classe_son('Boutons menu', 'survol'); ?>"><?php echo stripslashes_all($groupe['Nom']); ?></a>
					<?php
						$total_sous_elements = 0;
						foreach ($cfg_menu as $g2 => $groupe2){ if($groupe2['Parent'] == $id_categorie){$total_sous_elements++;}}
						
						$nb_sous_elements = 0;
						foreach ($cfg_menu as $g2 => $groupe2) 
						{
							if($groupe2['Parent'] == $id_categorie)
							{
								$nb_sous_elements++;
								if($nb_sous_elements == 1){ ?><ul class="rounded10 fond2"><?php } ?>
								<li><a href="<?php echo $groupe2['Lien']; ?>" <?php if($groupe2['Nouvelle fenêtre'] == 'on'){blank();} ?> class="police2 rounded5 transition1"><?php echo stripslashes_all($groupe2['Nom']); ?></a></li>
								<?php 
								if($nb_sous_elements == $total_sous_elements){ ?></ul><?php }
							}
						}
					?>
					</div>
					</li>
					<?php
				}
			} ?>	
			
		</ul>
	</div>
</nav>
<div style="background-image:url(<?php echo $tpl; ?>/images/fond_page.png); height: 100%; width: 100%; repeat-y;">
	<section class="slider-wrapper <?php classe_block('Slider'); ?> rounded10 fond-transp">
		<div id="slide-description" class="inline-block">
			<div class="nivo-caption"></div>
		</div><div id="slide-image" class="inline-block">
			<div id="slider" class="nivoSlider">
				<?php
				for($k = 1; $k<=$cfg_slider["Config"]["Nombre d images à afficher"]; $k++)
				{
					if($cfg_slider['Image '.$k]['Redirection'] != ''){ ?>
					<a href="<?php echo $cfg_slider['Image '.$k]['Redirection']; ?>" <?php if($cfg_slider['Image '.$k]['Nouvelle fenêtre'] == 'on'){ blank(); } ?>>
					<?php }
					$image_slider = $tpl.'/images/image-slider-'. $k .'.jpg';
					?>
					<img src="<?php echo $image_slider; ?>?date=<?php echo filemtime($image_slider); ?>" alt="Image slider <?php echo $k; ?>" title="#htmlcaption<?php echo $k; ?>" class="rounded10" />
					<?php 
					if($cfg_slider['Image '.$k]['Redirection'] != ''){ ?>
					</a><?php }
				} ?>
			</div>	
			<?php
			for($k = 1; $k<=$cfg_slider["Config"]["Nombre d images à afficher"]; $k++)
			{ ?>
			<div id="htmlcaption<?php echo $k; ?>" class="nivo-html-caption">
				<?php if($cfg_slider['Image '.$k]['Redirection'] != ''){ ?>
				<a href="<?php echo $cfg_slider['Image '.$k]['Redirection']; ?>" <?php if($cfg_slider['Image '.$k]['Nouvelle fenêtre'] == 'on'){ blank(); } ?>>
				<?php } ?>
				<h3 class="police2"><?php echo stripslashes_all($cfg_slider['Image '.$k]['Titre']); ?></h3>
				<?php if($cfg_slider['Image '.$k]['Redirection'] != ''){ ?>
				</a><?php } ?>
				<p>
				<?php echo stripslashes_all($cfg_slider['Image '.$k]['Légende']); ?>
				</p>
			</div>
			<?php } ?>
		</div>
		<div class="clear"></div>
	</section>

	<div id="corps" class="tableau toblock">
	
		<?php if($cfg_colonnes[$_REQUEST['file']]['Activé gauche'] != '0' && ($cfg_colonnes['Afficher la colonne']['Position'] == 'A gauche' || $cfg_colonnes['Afficher la colonne']['Position'] == 'Les deux')) { ?>
		<section id="gauche" class="cellule side" role="complementary" >	
			<?php // Ne pas afficher quand 2 colonnes
			if($cfg_colonnes['Afficher la colonne']['Position'] == 'A gauche')
			{
			block_en_ligne();
			block_forum();
			block_video();
			} ?>
			<?php get_blok('gauche'); ?>
		</section>
		<?php } ?>
		
		<section id="centre" class="cellule" role="main">
			
			<?php if ($_REQUEST['file'] != "Admin" && $_REQUEST['op'] == "index" && $_REQUEST['page'] != "admin") get_blok('centre'); ?>
			
			<?php 
			if($_REQUEST['file'] == "News" && $_REQUEST['op'] == 'index')
			{ ?>
			<div id="centre-contenu-news" class="fond-transp rounded10">
			
				<div class="haut-blocks rounded10">
					<div class="gauche cellule middle">
						<button class="titre-dynamisme-block"><h3 class="police1"><?php echo _ACTU; ?></h3></button>
					</div>
					<div class="droite cellule middle right">
						<button class="<?php classe_son('Bouton actualités', 'clic'); ?> lien-dynamisme-news btn-style1"><img src="<?php echo $tpl; ?>/images/ico-news-<?php if($cfg_divers['Format des news par défaut']['Etat'] != 'Large'){ echo 'large'; } else{ echo 'moitie'; } ?>.png" alt="+" /></button>
						<button class="lien-dynamisme-block btn-style1 <?php classe_son('Boutons blocks dépliables', 'clic'); ?>"><img src="<?php echo $tpl; ?>/images/ico-fleche-up.png" alt="+" /></button>
					</div>
				</div>
				<div class="contenu-dynamisme-block">
				
			<?php 
			}
			else{ ?>
			<div id="centre-contenu" class="fond-transp rounded10">
				<div>
			<?php
			}
			?>	
		<?php
} 
	
function footer() 
{
	global $nuked, $language, $user, $session_admin, $tpl, $utilisation_sp, $old_version, $cfg_general, $cfg_blocks, $cfg_colonnes, $cfg_divers, $cfg_video, $cfg_slider, $cfg_sons;
	?>

					<div class="clear"></div> 
				</div>

				
			</div>
			
			<?php if ($_REQUEST['file'] != "Admin" && $_REQUEST['op'] == "index" && $_REQUEST['page'] != "admin")  get_blok('bas'); ?>
			
			<aside id="block-photos" class="block-side block-unique <?php classe_block('Photos'); ?> rounded10 fond-transp">
				<div class="haut-blocks rounded10">
					<div class="gauche cellule middle">
						<button class="titre-dynamisme-block"><h3 class="police1"><?php echo _PHOTOS_DERNIERES; ?></h3></button>
					</div>
					<div class="droite cellule middle right">
						<button class="lien-dynamisme-block btn-style1 <?php classe_son('Boutons blocks dépliables', 'clic'); ?>"><img src="<?php echo $tpl; ?>/images/ico-fleche-up.png" alt="+" /></button>
					</div>
				</div>
				<div class="contenu-dynamisme-block corps-blocks">
					<?php include ($tpl .'/php/block_photos.php'); ?>
				</div>
			</aside>
				
		</section>
		
		<?php if($_REQUEST['file'] == "News" && $_REQUEST['op'] != 'index'){ $details_news = true; }?>
        <?php if($cfg_colonnes[$_REQUEST['file']]['Activé droite'] != '0' && ($details_news != true) && ($cfg_colonnes['Afficher la colonne']['Position'] == 'A droite' || $cfg_colonnes['Afficher la colonne']['Position'] == 'Les deux')) { ?>
		<section id="droite" class="cellule side2 fond-colonnes-droite <?php if($cfg_colonnes['Afficher la colonne']['Position'] == 'Les deux'){ echo 'hide-pclow'; } ?>" role="complementary" >	
			<?php block_en_ligne(); ?>
			<?php block_forum(); ?>
			<?php block_video(); ?>
			<?php get_blok('droite'); ?>	
		</section>
		<?php 
		} 
		?>
	
	</div>
	
	<section id="partenaires" class="fond2 <?php classe_block('Partenaires'); ?> rounded10 tableau toblock">
		<!-- Vous pouvez ajouter plus de 3 partenaire, la largeur des images sera automatiquement ajustée -->
	</section>
</div>
	<footer id="footer" role="contentinfo">
	
		<div id="bande" class="fond2 rounded10 tableau">
			<div class="cellule middle center">
			<button id="up" class="rounded5">&and;</button>
			</div>
		</div>
	
		<nav role="navigation" class="inline-block">
			<div class="inline-block">
				<h3 class="police2">Les partenaires</h3>
				<ul>
				  <li><a href="index.php?file=Contact">Votre site ici ?</a></li>
				  <li><a href="index.php?file=Contact">Votre site ici ?</a></li>
				  <li><a href="index.php?file=Contact">Votre site ici ?</a></li>
				  <li><a href="index.php?file=Contact">Votre site ici ?</a></li>
				  <li><a href="index.php?file=Contact">Votre site ici ?</a></li>
				  <li><a href="index.php?file=Links">Touts les partenaires</a></li>
				</ul>
			</div><div class="inline-block">
				<h3 class="police2">Les logiciels</h3>
				<ul>
				  <li><a href="index.php?file=Pagefpscreloaded&name=Description_FPS_Creator_Reloaded">FPS Creator Reloaded</a></li>
				  <li><a href="index.php?file=Pagefpscx9&name=Description_FPS_Creator_X9">FPS Creator X9</a></li>
				  <li><a href="#">Unity (en cours...)</a></li>
				  <li><a href="#">UDK (en cours...)</a></li>
				  <li><a href="#">RPG Maker XP/VISTA (en cours...)</a></li>
				</ul>
			</div><div class="inline-block">
				<h3 class="police2">Le site</h3>
				<ul>
				  <li><a href="index.php?file=Guestbook"><?php echo _LIVREDOR; ?></a></li>
				  <li><a href="index.php?file=Links"><?php echo _LIENS; ?></a></li>
				  <li><a href="index.php?file=Stats"><?php echo _STATS; ?></a></li>
				  <li><a href="index.php?file=Recruit"><?php echo _RECRUTEMENT; ?></a></li>
				  <li><a href="index.php?file=Contact">Contact</a></li>
				</ul>
			</div>
		</nav>
	</footer>
	
</div>

</body>
<!-- -------------- JS --------------- -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="<?php echo $tpl; ?>/js/jquery.js"></script>
<script>var J = jQuery.noConflict();</script>
<script>
// Détection IE9
var oldIE;
if (J('html').is('.ie9')) { oldIE = true; }

// Variables
var vitesse_ouverture = '<?php echo $cfg_blocks['Vitesse ouverture des blocks']['Vitesse']; ?>';
var vitesse_fermeture = '<?php echo $cfg_blocks['Vitesse fermeture des blocks']['Vitesse']; ?>';
var volume_sons = '<?php echo $cfg_sons['Volume des sons']['Volume']; ?>';
var container = '#opentable';
var container_news = '#centre-contenu';
var comportement_menu_deroulant = '<?php echo $cfg_divers['Comportement du menu déroulant']['Etat']; ?>';
</script>
<!-- Chargement scripts -->
<script src="<?php echo $tpl; ?>/js/jquery.cookie.js"></script>
<script src="<?php echo $tpl; ?>/js/jquery.menu.js?date=<?php echo filemtime($tpl.'/js/jquery.menu.js'); ?>"></script>
<script src="<?php echo $tpl; ?>/js/jquery.nivo.slider.js?date=<?php echo filemtime($tpl.'/js/jquery.nivo.slider.js'); ?>"></script>
<script src="<?php echo $tpl; ?>/js/dynamisme-omnipresent.js?date=<?php echo filemtime($tpl.'/js/dynamisme-omnipresent.js'); ?>"></script>
<?php if($cfg_blocks['Désactiver le dynamisme des blocks']['Dynamisme'] != 'on'){ ?>
<script src="<?php echo $tpl; ?>/js/dynamisme-desactivable.js?date=<?php echo filemtime($tpl.'/js/dynamisme-desactivable.js'); ?>"></script>
<?php }?>
<?php 
if($cfg_slider['Config']['Démarrage aléatoire'] == 'on'){ $cfg_slider['Config']['Démarrage aléatoire'] = 'true';} else{ $cfg_slider['Config']['Démarrage aléatoire'] = 'false'; }
if($cfg_slider['Config']['Pause au survol'] == 'on'){ $cfg_slider['Config']['Pause au survol'] = 'true';} else{ $cfg_slider['Config']['Pause au survol'] = 'false'; }
if($cfg_slider['Config']['Activer la navigation'] == 'on'){ $cfg_slider['Config']['Activer la navigation'] = 'true';} else{ $cfg_slider['Config']['Activer la navigation'] = 'false'; }
?>
<!-- Slider -->
<script>
J(window).load(function() {
	J('#slider').nivoSlider({
		effect: '<?php echo $cfg_slider['Config']['Effet de transition']; ?>',
		animSpeed: <?php echo $cfg_slider['Config']['Vitesse de transition (millisecondes)']; ?>,
		pauseTime: <?php echo $cfg_slider['Config']['Temps de pause (millisecondes)']; ?>,
		startSlide: <?php echo $cfg_slider['Config']['Image de départ']-1; ?>,
		controlNav: <?php echo $cfg_slider['Config']['Activer la navigation']; ?>,
		pauseOnHover: <?php echo $cfg_slider['Config']['Pause au survol']; ?>,
		randomStart: <?php echo $cfg_slider['Config']['Démarrage aléatoire']; ?>,
		slices: 12,
		boxCols: 8,
		boxRows: 4,
		directionNav: true,
		directionNavHide: true,
		controlNavThumbs: false,
		manualAdvance: false
	});
	
	J('.nivo-controlNav').appendTo('#slide-description'); // Déplacement nav
});
</script>
<!-- Vidéos -->
<script>
J(document).ready(function(){

	function envelopperVideos(container_ou_agir)
	{
		var coa = container_ou_agir;
		var cv = '<div class="video-resp"></div>';

		J(coa+' object:has(param[value*="://www.youtu"])').wrap(cv);
		J(coa+' object:has(param[value*="://youtu"])').wrap(cv);
		J(coa+' object[data*="://www.youtu"]').wrap(cv);
		J(coa+' object[data*="://youtu"]').wrap(cv);
		J(coa+' iframe[src*="://www.youtu"]').wrap(cv);
		J(coa+' iframe[src*="://youtu"]').wrap(cv);
		
		J(coa+' iframe[src*="://www.dailymotion."]').wrap(cv);
		J(coa+' iframe[src*="://dailymotion."]').wrap(cv);
		J(coa+' object[data*="://www.dailymotion."]').wrap(cv);
		J(coa+' object[data*="://dailymotion."]').wrap(cv);
		
		J(coa+' iframe[src*="://www.facebook."]').wrap(cv);
		J(coa+' iframe[src*="://facebook."]').wrap(cv);
		J(coa+' .swfObject:has(embed[flashvars*="www.facebook.com"])').wrap(cv);
		
		J(coa+' iframe[src*="://player.vimeo."]').wrap(cv);
		J(coa+' object:has(param[value*="player_server=player.vimeo."])').wrap(cv);
		
		J(coa+' iframe[src*="://www.wat."]').wrap(cv);
		J(coa+' iframe[src*="://wat."]').wrap(cv);
		J(coa+' object:has(param[value*="://www.wat"])').wrap(cv);
		J(coa+' object:has(param[value*="://wat"])').wrap(cv);
	}
	
	// Largeur fenêtre
	var larg_fenetre = J(window).width();
	if(J.browser.msie){ larg_fenetre = larg_fenetre+17; } // IE

	<?php 
	if($cfg_video['Forcer les vidéos du site à occuper la largeur maximale']['Etat'] == "on")
	{ ?>
	envelopperVideos('#site');	
	<?php 
	} 
	else
	{ ?>
	if(larg_fenetre < 980){  envelopperVideos('#site'); }
	<?php 
	} ?>
	
	// Agir sur les news, même en version large
	<?php 
	if($_REQUEST['file'] == "News")
	{ ?>
	envelopperVideos('.block-news-moitie'); 
	envelopperVideos('.block-news-large'); 
	<?php 
	} ?>
	
});
</script>
<?php 
// Etat blocks paginables
if($cfg_blocks["Enregistrer l état des blocks paginables"]["Dynamisme"] == "0")
{ ?>
<script>
var nb_contenus_multiples = J('.contenu-multiple').length;
for(var q=1; q<=nb_contenus_multiples; q++){	
	J.cookie('etat_block_multiple-'+q, 1, { expires: 7, path: '/' });
}
</script>
<?php }?>

<?php 
// Partenaires hover
if($cfg_divers["Changement des images de partenaire au survol"]["Etat"] == "on")
{ ?>
<script>
	J('#partenaires img')
	.mouseover(function() { 
		var src = J(this).attr('src').match(/[^\.]+/) + '-survol.png';
		J(this).attr('src', src);
	})
	.mouseout(function() {
		var src = J(this).attr('src').replace('-survol.png', '.png');
		J(this).attr('src', src);
	});
</script>
<?php }?>

<?php // Patchs
if($cfg_divers['Patch amélioration nk sur mobile']['Etat'] == 'on'){
include ($tpl .'/php/patch_mobile_tableaux.php');
include ($tpl .'/php/patch_mobile_general.php'); 
}
?>
</html>
<?php
exit;
mysql_close();
} 

$nb_news = 1;

function news($data)
{
	global $nuked, $tpl, $nb_news, $cfg_divers;
	include ('php/config.php');
	?>
	<?php 
	if($_REQUEST['file'] == "News" && $_REQUEST['op'] == 'index' && $cfg_divers['Format des news par défaut']['Etat'] != 'Large'){ 
	$classe = 'block-news-moitie'; }
	else{
	$classe = 'block-news-large'; }
	?>
	<article role="article" class="<?php echo $classe; ?>">
		<h2 class="titre-news police2 tableau toblock">
		<a href="index.php?file=News&amp;op=index_comment&amp;news_id=<?php echo $data['id']; ?>" title="" class="cellule middle"><?php echo $data['titre']; ?></a>
		</h2>
		
		<?php if($cfg_divers["Affichage de l image des news"]["Etat"] == "Personnalisé"){  ?>
		<a href="index.php?file=News&amp;op=index_comment&amp;news_id=<?php echo $data['id']; ?>" class="img-news rounded10">
			<?php 
			$data['image'] = preg_replace(array("(<a[^>]+[^>]*>)" , "(</a>)"), "", $data['image']);
			echo $data['image']; 
			// <img src="http://placekitten.com/g/600/172" alt="" class="middle" />
			?>
		</a>
		<?php } ?>
		
		<div class="news-infos">
			<?php echo _ACTU_AUTEUR; ?> <a href="index.php?file=Members&amp;op=detail&amp;autor=<?php echo urlencode($data['auteur']); ?>"><?php echo $data['auteur']; ?></a> <?php echo _ACTU_DATE .' '. $data['date']; ?> <span class="picto-com inline-block center"><a href="index.php?file=News&amp;op=index_comment&amp;news_id=<?php echo $data[id]; ?>" title="<?php echo "$data[nb_comment]"; ?> commentaire(s)"><?php echo "$data[nb_comment]"; ?></a></span>
		</div>

		<div class="justify">
		<?php 
		if($cfg_divers["Affichage de l image des news"]["Etat"] == "Par défaut"){ echo $data['image']; }

		echo $data['texte']; 
		?>
		</div>
		<div class="clear"></div>	
	</article>
	<?php 
	// Nombre pair
	if($nb_news%2 == 0){ ?>
	<div class="clear"></div> 
	<?php
	}
		
	$nb_news++;
} 

function block_gauche($block) 
{
	global $tpl;
	?>
	<aside class="block-side <?php classe_block('Blocks de gauche'); ?> rounded10 fond-transp">
		<div class="haut-blocks rounded10">
			<div class="gauche cellule middle">
				<button class="titre-dynamisme-block"><h3 class="police1"><?php echo $block['titre']; ?></h3></button>
			</div>
			<div class="droite cellule middle right">
				<button class="lien-dynamisme-block btn-style1 <?php classe_son('Boutons blocks dépliables', 'clic'); ?>"><img src="<?php echo $tpl; ?>/images/ico-fleche-up.png" alt="+" /></button>
			</div>
		</div>
		<div class="contenu-dynamisme-block corps-blocks">
			<?php echo $block['content']; ?>
		</div>
	</aside>
	<?php
} 

function block_droite($block) 
{
	global $tpl;
	?>
	<aside class="block-side <?php classe_block('Blocks de droite'); ?> rounded10 fond-transp">
		<div class="haut-blocks rounded10">
			<div class="droitemenu cellule middle">
				<button class="titre-dynamisme-block"><h3 class="police1"><?php echo $block['titre']; ?></h3></button>
			</div>
			<div class="droite cellule middle right">
				<button class="lien-dynamisme-block btn-style1 <?php classe_son('Boutons blocks dépliables', 'clic'); ?>"><img src="<?php echo $tpl; ?>/images/ico-fleche-up.png" alt="+" /></button>
			</div>
		</div>
		<div class="contenu-dynamisme-block corps-blocks">
			<?php echo $block['content']; ?>
		</div>
	</aside>
	<?php
} 

function block_centre($block) 
{
	global $tpl;
	?>
	<section class="block-side <?php classe_block('Blocks du centre'); ?> rounded10 fond-transp">
		<div class="haut-blocks rounded10">
			<div class="gauche cellule middle">
				<button class="titre-dynamisme-block"><h3 class="police1"><?php echo $block['titre']; ?></h3></button>
			</div>
			<div class="droite cellule middle right">
				<button class="lien-dynamisme-block btn-style1 <?php classe_son('Boutons blocks dépliables', 'clic'); ?>"><img src="<?php echo $tpl; ?>/images/ico-fleche-up.png" alt="+" /></button>
			</div>
		</div>
		<div class="contenu-dynamisme-block corps-blocks">
			<?php echo $block['content']; ?>
		</div>
	</section>
	 <?php 
}

function block_bas($block)
{
	global $tpl;
	?>
	<section class="block-side <?php classe_block('Blocks du bas'); ?> rounded10 fond-transp">
		<div class="haut-blocks rounded10">
			<div class="gauche cellule middle">
				<button class="titre-dynamisme-block"><h3 class="police1"><?php echo $block['titre']; ?></h3></button>
			</div>
			<div class="droite cellule middle right">
				<button class="lien-dynamisme-block btn-style1 <?php classe_son('Boutons blocks dépliables', 'clic'); ?>"><img src="<?php echo $tpl; ?>/images/ico-fleche-up.png" alt="+" /></button>
			</div>
		</div>
		<div class="contenu-dynamisme-block corps-blocks">
			<?php echo $block['content']; ?>
		</div>
	</section>
	<?php 
}

function opentable() 
{
?>
	<div id="opentable" class="fond-transp rounded10">
	<?php 
}

function closetable() 
{
 ?>
	</div>
	<?php 
}

function block_en_ligne() 
{
global $nuked, $language, $user, $session_admin, $tpl, $utilisation_sp, $old_version, $cfg_blocks, $cfg_colonnes, $cfg_divers, $cfg_video, $cfg_slider, $cfg_sons;
 ?>
<aside id="block-en-ligne" class="block-side block-unique <?php classe_block('En Ligne'); ?> rounded10 fond-transp contenu-multiple">
	<div class="haut-blocks rounded10">
		<div class="droitemenu cellule middle right">
			<button class="titre-dynamisme-block"><h3 class="police1"><?php echo _EN_LIGNE_BLOCK; ?></h3></button>
		</div>
		<div class="droite cellule middle right">
		  <button class="lien-dynamisme-block btn-style1 <?php classe_son('Boutons blocks dépliables', 'clic'); ?>"><img src="<?php echo $tpl; ?>/images/ico-fleche-up.png" alt="+" /></button>
		</div>
	</div>
	<div class="contenu-dynamisme-block corps-blocks">
		<div class="contenu-multiple-1">		
			<?php include ($tpl .'/php/block_en_ligne.php'); ?>
		</div>
	</div>
</aside>
<?php 
}

function block_forum() 
{
global $nuked, $language, $user, $session_admin, $tpl, $utilisation_sp, $old_version, $cfg_blocks, $cfg_colonnes, $cfg_divers, $cfg_video, $cfg_slider, $cfg_sons;
 ?>
<aside id="block-forum" class="block-side block-unique <?php classe_block('Messages forum'); ?> rounded10 fond-transp">
	<div class="haut-blocks rounded10">
		<div class="droitemenu cellule middle">
			<button class="titre-dynamisme-block"><h3 class="police1"><?php echo _FORUM_DERNIERS; ?></h3></button>
		</div>
		<div class="droite cellule middle right">
			<button class="lien-dynamisme-block btn-style1 <?php classe_son('Boutons blocks dépliables', 'clic'); ?>"><img src="<?php echo $tpl; ?>/images/ico-fleche-up.png" alt="+" /></button>
		</div>
	</div>
	<div class="contenu-dynamisme-block corps-blocks">
			<?php include ($tpl .'/php/block_forum.php'); ?>
	</div>
</aside>
<?php 
} 

function block_video() 
{
global $nuked, $language, $user, $session_admin, $tpl, $utilisation_sp, $old_version, $cfg_blocks, $cfg_colonnes, $cfg_divers, $cfg_video, $cfg_slider, $cfg_sons;
 ?>
<aside id="block-video" class="block-side block-unique <?php classe_block('Vidéo du moment'); ?> rounded10 fond-transp">
	<div class="haut-blocks rounded10">
		<div class="droitemenu cellule middle">
			<button class="titre-dynamisme-block"><h3 class="police1"><?php echo _VIDEO_MOMENT; ?></h3></button>
		</div>
		<div class="droite cellule middle right">
			<button class="lien-dynamisme-block btn-style1 <?php classe_son('Boutons blocks dépliables', 'clic'); ?>"><img src="<?php echo $tpl; ?>/images/ico-fleche-up.png" alt="+" /></button>
		</div>
	</div>
	<div class="contenu-dynamisme-block corps-blocks">
		<div class="video-resp">
		<!-- <iframe width="560" height="315" src="http://www.youtube.com/embed/zXHD2tDUJxA" frameborder="0" allowfullscreen></iframe> -->
		<?php afficher_video($cfg_video['Vidéo']['Lien']); ?>
		</div>
	</div>
</aside>
<?php 
} 
?>