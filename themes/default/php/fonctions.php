<?php
/**
*
* Alternative à target="_blank"
*
*/
function blank(){
echo 'onclick="window.open(this.href); return false;"';
}

/**
*
* Fonction stripslashes fonctionnelle même avec guillemets magiques
*
* @param string $texte Texte à nettoyer
*/
function stripslashes_all($texte){
	$texte = str_replace("\\", "", $texte);
	$texte = str_replace("\'", "'", $texte);
	$texte = str_replace('\"', '"', $texte);
	$texte = str_replace('"', '&quot;', $texte);
	return $texte;
}

/**
*
* Définit la classe du block
*
* @param string $cle Nom du groupe
*
*/
function classe_block($cle){

	global $cfg_blocks;

	$etat_large = $cfg_blocks[$cle]["Large"];
	$etat_mobile = $cfg_blocks[$cle]["Mobile"];
	
	if($etat_large == "Désactivé" && $etat_mobile == "Désactivé"){$classe = 'hide';}				
	else if($etat_large == "" && $etat_mobile == "Désactivé"){$classe = 'hide-phone-pad';}				
	else if($etat_large == "" && $etat_mobile == "Accueil seulement"){$classe = 'accueil-seulement-mobile';}				
	else if($etat_large == "Désactivé" && $etat_mobile == "Toutes les pages"){$classe = 'hide-pc';}				
	else if($etat_large == "Désactivé" && $etat_mobile == "Accueil seulement"){$classe = 'hide-pc accueil-seulement-mobile';}
	elseif($etat_large == "Toutes les pages" && $etat_mobile == "Désactivé"){$classe = 'hide-phone-pad';}				
	elseif($etat_large == "Toutes les pages" && $etat_mobile == "Toutes les pages"){$classe = '';}				
	elseif($etat_large == "Toutes les pages" && $etat_mobile == "Accueil seulement"){$classe = 'accueil-seulement-mobile';}
	elseif($etat_large == "Accueil seulement" && $etat_mobile == "Désactivé"){$classe = 'accueil-seulement-large hide-phone-pad';}						
	elseif($etat_large == "Accueil seulement" && $etat_mobile == "Toutes les pages"){$classe = 'accueil-seulement-large';}				
	elseif($etat_large == "Accueil seulement" && $etat_mobile == "Accueil seulement"){$classe = 'accueil-seulement-large accueil-seulement-mobile';}
	else{$classe = '';}	
	
	echo $classe;
}

/**
*
* Définit la classe pour le son
*
* @param string $cle Nom du groupe
* @param string $event Evenement déclencheur
*
*/
function classe_son($cle, $event){

	global $cfg_sons;
	$classe = '';
	
	if($cfg_sons[$cle]['Etat'] == 'on'){ 
	$classe = 'btn-son-'. $event .'-'. $cfg_sons[$cle]['Son']; 
	}
	
	echo $classe;
}

/**
*
* Afficher vidéo
*
* @param string $video Lien absolu de la vidéo
*
*/
function afficher_video($video){

	global $tpl;
	
	// Si c'est un format d'url alternatif, transformer en lien commum
	if(strstr($video, '://youtu') || strstr($video, '://www.youtu')){
	
		if(strstr($video, '://youtu')){
			$video = str_replace('://youtu', '://www.youtu', $video);
		}
		if(strstr($video, 'youtu.be/')){
			$video = str_replace('youtu.be/', 'youtube.com/watch?v=', $video);
		}
		if(strstr($video, '/watch?feature=player_embedded&v=')){
			$video = str_replace('/watch?feature=player_embedded&v=', '/watch?v=', $video);
		}
		
		$lien_pour_lecteur = str_replace("watch?v=", "v/", $video); 
		// Iframe youtube ne fonctionne pas sur ie
		?>
		<object width="280" height="248">
		<param name="movie" value="<?php echo $lien_pour_lecteur; ?>&fs=1"></param>
		<param name="allowFullScreen" value="true"></param>
		<embed src="<?php echo $lien_pour_lecteur; ?>&fs=1" type="application/x-shockwave-flash" width="280" height="248" allowfullscreen="true"></embed>
		</object>
		<?php
	}
	else{
	
		if(strstr($video, '://www.dailymotion') || strstr($video, '://dailymotion')){
		
			if(strstr($video, '/video/') && !strstr($video, '/embed/video/')){
				$id_video = strtok(basename($video), '_');
				$video = 'http://www.dailymotion.com/embed/video/'. $id_video;
			}
			$lien_pour_lecteur = $video; 
		}
		elseif(strstr($video, '://www.vimeo') || strstr($video, '://vimeo') || strstr($video, '://player.vimeo')){
		
			$lien_pour_lecteur = 'http://player.vimeo.com/video/'. basename($video); 
		}
		elseif(strstr($video, '://facebook') || strstr($video, '://www.facebook')){
		
			if(strstr($video, '://facebook')){
				$video = str_replace('://facebook', '://www.facebook', $video);
			}
			$video = str_replace('/video/video.php?v=', '/video/embed?video_id=', $video);
			$lien_pour_lecteur = $video;
		}
		
		?>
		<iframe width="300" height="248" src="<?php echo $lien_pour_lecteur; ?>" frameborder="0" allowfullscreen></iframe>
		<?php
	
	}

}

?>