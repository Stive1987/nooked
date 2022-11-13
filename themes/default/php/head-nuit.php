<?php
defined("INDEX_CHECK") or die ('<div class="center">Vous ne pouvez pas accéder à cette page directement.</div>');
?>
<!DOCTYPE html>
<!--[if IE 9 ]> <html class="ie9" lang="fr"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="fr"> <!--<![endif]-->
<head>
<title><?php echo $nuked['name'] ." - ". $nuked['slogan']; ?></title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="keywords" content="<?php echo $nuked['keyword']; ?>" />
<meta name="description" content="<?php echo $nuked['description']; ?>" />
<link rel="icon" type="image/x-icon" href="<?php echo $nuked['url']; ?>/images/favicon.ico" />  
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $nuked['url']; ?>/images/favicon.ico" /> 
<link rel="alternate" type="application/rss+xml" href="<?php echo $nuked['url']; ?>/rss/news_rss.php" title="<?php echo $nuked['name']; ?> : <?php echo _RSS_ACTU; ?>" />
<link rel="alternate" type="application/rss+xml" href="<?php echo $nuked['url']; ?>/rss/sections_rss.php" title="<?php echo $nuked['name']; ?> : <?php echo _RSS_ARTICLES; ?>" />
<link rel="alternate" type="application/rss+xml" href="<?php echo $nuked['url']; ?>/rss/download_rss.php" title="<?php echo $nuked['name']; ?> : <?php echo _RSS_TELECHARGEMENTS; ?>" />
<link rel="alternate" type="application/rss+xml" href="<?php echo $nuked['url']; ?>/rss/links_rss.php" title="<?php echo $nuked['name']; ?> : <?php echo _RSS_LIENS; ?>" />
<link rel="alternate" type="application/rss+xml" href="<?php echo $nuked['url']; ?>/rss/gallery_rss.php" title="<?php echo $nuked['name']; ?> : <?php echo _RSS_GALERIE; ?>" />
<link rel="alternate" type="application/rss+xml" href="<?php echo $nuked['url']; ?>/rss/forum_rss.php" title="<?php echo $nuked['name']; ?> : <?php echo _RSS_FORUM; ?>" />
<!-- -------------- CSS --------------- -->
<link rel="stylesheet" href="<?php echo $tpl; ?>/css/nivo-slider.css?date=<?php echo filemtime($tpl.'/css/nivo-slider.css'); ?>" />
<link rel="stylesheet" href="<?php echo $tpl; ?>/css/menu.css?date=<?php echo filemtime($tpl.'/css/menu.css'); ?>" />
<link rel="stylesheet" href="<?php echo $tpl; ?>/style.css?date=<?php echo filemtime($tpl.'/style.css'); ?>" /> 
<style>
<?php 
// Fond page
?>
body{ background: <?php echo $cfg_general['bg_nuit']['Couleur']; ?> url("<?php echo $tpl; ?>/images/bg_nuit.<?php echo $cfg_general['bg_nuit']['Extension']; ?>") <?php echo $cfg_general['bg_nuit']['Position']; ?> <?php echo $cfg_general['bg_nuit']['Répétition']; ?> }
#footer{ background: url("<?php echo $tpl; ?>/images/bas.<?php echo $cfg_general['bas']['Extension']; ?>") <?php echo $cfg_general['bas']['Position']; ?> <?php echo $cfg_general['bas']['Répétition']; ?> }	
<?php

// Affichage éléments page accueil
if($_REQUEST['file'] == 'News' && $_REQUEST['op'] == 'index'){ ?>
.partout-sauf-accueil{ display:none !important }
<?php 
}
else{ ?>
.accueil-seulement{ display:none !important }
@media (max-width: 767px){ .accueil-seulement-mobile{ display:none !important } }
@media (min-width: 768px){ .accueil-seulement-large{ display:none !important } }
<?php 
} 

// Marge conteneur news en détails
if($_REQUEST['file'] == 'News' && $_REQUEST['op'] == 'index_comment'){ ?>
#centre-contenu{ padding:20px 0 20px 0 }
<?php
}

// Style selon colonnes
if($cfg_colonnes['Afficher la colonne']['Position'] == 'A gauche'){ ?>
.side{ width:310px; padding-right:10px  }
.haut-blocks .gauche h3{ font-size:24px  }
.block-news-moitie{ width:290px }
<?php
}
else if($cfg_colonnes['Afficher la colonne']['Position'] == 'A droite'){ ?>
.side{ width:320px; padding-left:4px  }
.haut-blocks .gauche h3{ font-size:24px  }
.block-news-moitie{ width:290px }
<?php 
}
else{ ?>
.haut-blocks .gauche h3{ font-size:20px  }
.side#gauche{ width:210px; padding-right:10px }
.side#droite{ width:210px; padding-left:10px }
.block-news-moitie{ width:235px }
<?php 
} 

// Fond mobile
if($cfg_divers["Afficher l image de fond sur mobile"]["Etat"] == '0'){ ?>
@media(max-width: 767px){ body{ background-image:none; background: linear-gradient(to bottom, #284C8B, #080A0F 30%, #080A0F); } }
<?php 
}

// Désactivation éléments du dynamisme
if($cfg_blocks['Désactiver le dynamisme des blocks']['Dynamisme'] == 'on'){ ?>
button.lien-dynamisme-block,
button.lien-dynamisme-news,
button.lien-multiple-1,
button.lien-multiple-2,
button.lien-multiple-3{ display:none !important }
button.titre-dynamisme-block{ cursor:default }
<?php }
?>
</style>
<!-- Dégradés arrondies ie9 -->
<!--[if gte IE 9]>
<style>
.fond1{ filter:none !important }
.fond2{ filter:none !important }
</style>
<![endif]-->
<?php if($cfg_divers['Patch amélioration nk sur mobile']['Etat'] == 'on'){ ?>
<link rel="stylesheet" href="<?php echo $tpl; ?>/css/patch-mobile.css?date=<?php echo filemtime($tpl.'/css/patch-mobile.css'); ?>" /> 
<?php }?>
</head>