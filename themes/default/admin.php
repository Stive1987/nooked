<?php
defined("INDEX_CHECK") or die ('<div style="text-align: center">Accès interdit</div>');

if ($user[1] < 9){
	echo '<div style="text-align: center;padding:30px 0">Seuls les administrateurs suprêmes peuvent modifier le thème.</div>';
}
else 
{
	function index() 
	{
		global $tpl;
	?>
		<div style="text-align:center;padding-top:50px;padding-bottom:50px;width:280px;margin:auto" id="menu-principal-theme">
			<?php 
			$modules_cfg = array(
			'general' => 'Gestion générale',
			'slider' => 'Gestion slider',
			'video' => 'Gestion vidéo',
			'menu' => 'Gestion du menu',
			'blocks' => 'Gestion des blocks',
			'colonnes' => 'Gestion des colonnes',
			'sons' => 'Gestion des sons',
			'divers' => 'Divers'
			);
			foreach($modules_cfg as $cle => $module_cfg){
			?>
			<div style="margin-bottom:30px;padding:10px">
			<a href="index.php?file=Admin&amp;page=theme&amp;configuration=<?php echo $cle; ?>"><img src="<?php echo $tpl; ?>/admin/images/ico_<?php echo $cle; ?>.jpg" alt="" /></a><br /><br />
			<a href="index.php?file=Admin&amp;page=theme&amp;configuration=<?php echo $cle; ?>" style="font-weight:bold;color:#53ac00;font-size:16px"><?php echo $module_cfg; ?></a><br />
			</div>
			<?php } ?>
		</div>
	<?php
	}
	
	function general() 
	{
		global $tpl;
		
		include($tpl .'/admin/general.php');
		
		if($_GET['action'] == 'enregistrer') 
		{
			function uploadImage($cle, $tableau_image)
			{
				global $tpl;
				
				$extensions_valides = array('jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'PNG', 'gif', 'GIF');
				$nom_img = $tableau_image['name'];
				
				if ($tableau_image['error'] > 0) { $erreur = "Erreur lors du tranfsert"; }	
				
				$extension_img = substr(strrchr($nom_img, '.')  ,1);
				if(!in_array($extension_img,$extensions_valides)){ $erreur = "L'image doit être de type jpg, png ou gif."; }

				if(!isset($erreur)){	
					$extension_img = strtolower($extension_img);
					$extension_img = str_replace('jpeg', 'jpg', $extension_img);
				
					// Déplacer fichiers temporaires dans les dossiers d'upload 
					move_uploaded_file($tableau_image['tmp_name'], $tpl ."/images/". $cle .".".$extension_img);
				}
				else{
					return $erreur;
				}
			}
			//var_dump($_FILES);
			//var_dump($_POST);
			
			$erreurs_images = false;
			
			foreach($_FILES as $cle => $tableau_image)
			{
				if($tableau_image['name'] != null){
					
					// Fonction principale
					$erreur = uploadImage($cle, $tableau_image);
					
					if(!isset($erreur)){
					
						// Préparer extensions pour enregistrement
						$extension_img = substr(strrchr($tableau_image['name'], '.')  ,1);
						$extension_img = strtolower($extension_img);
						$extension_img = str_replace('jpeg', 'jpg', $extension_img);
					
						$_POST['choix_utilisateur'][$cle]['Extension'] = $extension_img;
					
					}
					else{
						echo '<br /><div style="text-align:center">Erreur sur <strong>'. $cle .'</strong>: '. $erreur .'</div><br />';
						$erreurs_images = true;
					}
				}
				else{
					// Définir extension pour enregistrement même si image nulle
					$_POST['choix_utilisateur'][$cle]['Extension'] = $cfg_general[$cle]['Extension'];
				}
			}
			
			if($erreurs_images == false){
			enregistrer_fichier(${'cfg_'.__function__}, __function__);
			}
			
			pied('&amp;configuration='.__function__);
		}
		else 
		{
				haut('Général', __function__, 'enregistrer', true);
				ouverture_tableau();
				ligne_titres_tableau(array('Logo', ''));
				
				foreach (${'cfg_'. __function__} as $g => $groupe) 
				{
					if($g == "bg_jour")
					{
					ligne_titres_tableau(array('Image de fond le jour', ''));
					}		
					if($g == "bg_nuit")
					{
					ligne_titres_tableau(array('Image de fond la nuit', ''));
					}	
					if($g == "bas")
					{
					ligne_titres_tableau(array('Image du bas', ''));
					}
					if($g == "Message haut du site")
					{
					ligne_titres_tableau(array('Options', ''));
					}
					
					if($g == "logo")
					{
						$img_logo = $tpl.'/images/logo.'. $groupe['Extension'];
						?>
						<tr>
							<td style="vertical-align:top">
								<a href="<?php echo $img_logo; ?>?date=<?php echo filemtime($img_logo); ?>" title="Aperçu en taille réelle"><img src="<?php echo $img_logo; ?>?date=<?php echo filemtime($img_logo); ?>" alt="" style="max-width: 100%;margin-bottom:5px" /></a>
							</td>						
							<td style="vertical-align:top">
								<br />
								<input type="file" name="logo" />
							</td>
						</tr>
						<?php
					}
					elseif($g == "bg_jour")
					{
						$img_fond = $tpl.'/images/bg_jour.'. $groupe['Extension'];
						?>
						<tr>
							<td style="vertical-align:top">
								<a href="<?php echo $img_fond; ?>?date=<?php echo filemtime($img_fond); ?>" title="Aperçu en taille réelle"><img src="<?php echo $img_fond; ?>?date=<?php echo filemtime($img_fond); ?>" alt="" style="max-width: 100%;margin-bottom:5px" /></a>
							</td>						
							<td style="vertical-align:top">
								<?php echo champ_texte('Couleur', 'Couleur:', $g, $groupe); ?>
								<?php echo champ_texte('Position', 'Position:', $g, $groupe); ?>
								<?php echo liste_deroulante('Répétition', 'Répétition', array('no-repeat', 'repeat', 'repeat-x', 'repeat-y'), $g, $groupe); ?>
								<br />
								<input type="file" name="bg_jour" />
							</td>
						</tr>
						<?php
					}	
					elseif($g == "bg_nuit")
					{
						$img_fond = $tpl.'/images/bg_nuit.'. $groupe['Extension'];
						?>
						<tr>
							<td style="vertical-align:top">
								<a href="<?php echo $img_fond; ?>?date=<?php echo filemtime($img_fond); ?>" title="Aperçu en taille réelle"><img src="<?php echo $img_fond; ?>?date=<?php echo filemtime($img_fond); ?>" alt="" style="max-width: 100%;margin-bottom:5px" /></a>
							</td>						
							<td style="vertical-align:top">
								<?php echo champ_texte('Couleur', 'Couleur:', $g, $groupe); ?>
								<?php echo champ_texte('Position', 'Position:', $g, $groupe); ?>
								<?php echo liste_deroulante('Répétition', 'Répétition', array('no-repeat', 'repeat', 'repeat-x', 'repeat-y'), $g, $groupe); ?>
								<br />
								<input type="file" name="bg_nuit" />
							</td>
						</tr>
						<?php
					}	
					elseif($g == "bas")
					{
						$img_fond = $tpl.'/images/bas.'. $groupe['Extension'];
						?>
						<tr>
							<td style="vertical-align:top">
								<a href="<?php echo $img_fond; ?>?date=<?php echo filemtime($img_fond); ?>" title="Aperçu en taille réelle"><img src="<?php echo $img_fond; ?>?date=<?php echo filemtime($img_fond); ?>" alt="" style="max-width: 100%;margin-bottom:5px" /></a>
							</td>						
							<td style="vertical-align:top">
								<?php echo champ_texte('Position', 'Position:', $g, $groupe); ?>
								<?php echo liste_deroulante('Répétition', 'Répétition', array('no-repeat', 'repeat', 'repeat-x', 'repeat-y'), $g, $groupe); ?>
								<br />
								<input type="file" name="bas" />
							</td>
						</tr>
						<?php
					}
					else
					{
						?>
						<tr>
							<td>
								<?php echo $g; ?>
							</td>
							<td style="text-align: center">
								<?php
								if($g == "Message haut du site")
								{ 
									champ_texte('Message', '', $g, $groupe);
								}						
								if($g == "Bouton Facebook")
								{ 
									champ_texte('Lien', 'Lien de la page', $g, $groupe);
									champ_texte('Titre', 'Texte à afficher au survol', $g, $groupe);
									case_a_cocher('Nouvelle fenêtre', 'Ouvrir dans une nouvelle fenêtre', $g, $groupe);
								}						
								if($g == "Bouton Twitter")
								{ 
									champ_texte('Lien', 'Lien de la page', $g, $groupe);
									champ_texte('Titre', 'Texte à afficher au survol', $g, $groupe);
									case_a_cocher('Nouvelle fenêtre', 'Ouvrir dans une nouvelle fenêtre', $g, $groupe);
								}						
								if($g == "Bouton Google+")
								{ 
									champ_texte('Lien', 'Lien de la page', $g, $groupe);
									champ_texte('Titre', 'Texte à afficher au survol', $g, $groupe);
									case_a_cocher('Nouvelle fenêtre', 'Ouvrir dans une nouvelle fenêtre', $g, $groupe);
								}	
								if($g == "Désactiver les effects flash") {
								case_a_cocher('Etat', '', $g, $groupe);
								}
								?>
							</td>
						</tr>	
						<?php
					}
				}
			fermeture_tableau();
			bas();
			pied('');
		}
	}
	
	function blocks() 
	{
		global $tpl;
		include($tpl .'/admin/'. __function__ .'.php');

		if($_GET['action'] == 'enregistrer') 
		{
			enregistrer_fichier(${'cfg_'.__function__}, __function__);
			pied('&amp;configuration='.__function__);
		}
		else 
		{
			haut('Gestion des blocks', __function__);
			ouverture_tableau();
			ligne_titres_tableau(array('Blocks du thème', 'Visibilité'));
	
			foreach (${'cfg_'. __function__} as $g => $groupe) 
			{
				?>
				<?php 
				// En-têtes supplémentaires
				if($g == 'Blocks de gauche')
				{ 
					ligne_titres_tableau(array('Blocks externes', 'Visibilité'));
				}
				elseif($g == 'Enregistrer l état des blocks paginables')
				{
					ligne_titres_tableau(array('Autres réglages', ''));
				}?>
				<tr>
					<td>
						<strong><?php echo $g; ?></strong>
					</td>
					<td style="text-align:center">
					
						<?php 
					  if($g == 'Réseaux sociaux' || 
						 $g == 'Connexion / Enregistrement' ||
						 $g == 'Slider' ||
						 $g == 'En Ligne' ||
						 $g == 'Photos' ||
						 $g == 'Vidéo du moment' ||
						 $g == 'Messages forum' ||
						 $g == 'Partenaires'
						 )
						 {
						liste_deroulante('Large', 'Version large', array('Toutes les pages', 'Accueil seulement', 'Désactivé'), $g, $groupe);
							?>
							<br /><br />
						<?php 
						} 
					  if($g == 'Réseaux sociaux' || 
						 $g == 'Connexion / Enregistrement' ||
						 $g == 'Slider' ||
						 $g == 'En Ligne' ||
						 $g == 'Photos' ||
						 $g == 'Vidéo du moment' ||
						 $g == 'Partenaires' ||
						 $g == 'Messages forum' ||
						 $g == 'Blocks de gauche' ||
						 $g == 'Blocks de droite' ||
						 $g == 'Blocks du centre' ||
						 $g == 'Blocks du bas'
						 )
						{ 
							liste_deroulante('Mobile', 'Version mobile', array('Toutes les pages', 'Accueil seulement', 'Désactivé'), $g, $groupe);
						} 
						if($g == 'Vitesse ouverture des blocks' ||
						   $g == 'Vitesse fermeture des blocks'
						)
						{ 
							liste_deroulante('Vitesse', '', array('slow', 'default', 'fast'), $g, $groupe);
						} 						
						if($g == "Enregistrer l état des blocks paginables")
						{ 
							case_a_cocher('Dynamisme', '', $g, $groupe);
						} 						
						if($g == 'Désactiver le dynamisme des blocks')
						{ 
							case_a_cocher('Dynamisme', '', $g, $groupe);
						} 
						?>
						
					</td>					
				</tr>	
				<?php
			}
			fermeture_tableau();
			bas();
			pied('');
		}
	}
			
	function colonnes() 
	{
		global $tpl;
		include($tpl .'/admin/'. __function__ .'.php');

		if($_GET['action'] == 'enregistrer') {
		enregistrer_fichier(${'cfg_'.__function__}, __function__);
		pied('&amp;configuration='.__function__);
		}
		else 
		{
			haut('Gestion des colonnes', __function__);
			ouverture_tableau();
			ligne_titres_tableau(array('Options', ''));
	
			foreach (${'cfg_'. __function__} as $g => $groupe) 
			{
				if($g == '404'){
				ligne_titres_tableau(array('Modules', 'Colonnes'));
				}
				?>
				<tr>
					<td>
						<strong><?php echo $g; ?></strong>
					</td>
					<td style="text-align:center">
					
						<?php 
						if($g != 'Afficher la colonne'){
						case_a_cocher('Activé gauche', 'Gauche', $g, $groupe);
						case_a_cocher('Activé droite', 'Droite', $g, $groupe);
						}
						if($g == 'Afficher la colonne'){
						liste_deroulante('Position', '', array('A gauche', 'A droite', 'Les deux'), $g, $groupe);
						}
						?>
	
					</td>					
				</tr>	
				<?php
			}
			fermeture_tableau();
			bas();
			pied('');
		}
	}
	
	function divers() 
	{
		global $tpl;
		include($tpl .'/admin/'. __function__ .'.php');

		if($_GET['action'] == 'enregistrer') {
		enregistrer_fichier(${'cfg_'.__function__}, __function__);
		pied('&amp;configuration='.__function__);
		}
		else 
		{
			haut('Divers', __function__);
			ouverture_tableau();
			ligne_titres_tableau(array('Options', ''));
	
			foreach (${'cfg_'. __function__} as $g => $groupe) 
			{
				// En-tête supplémentaire
				if($g == 'Patch amélioration nk sur mobile')
				{ 
					ligne_titres_tableau(array('Options avancées', ''));
				}
				?>
				<tr>
					<td>
						<strong><?php echo $g; ?></strong>
					</td>
					<td style="text-align:center">
					<?php 
						if($g == "Comportement du menu déroulant")
						{ 
							liste_deroulante('Etat', '', array('Ouvrir/fermer au survol', 'Ouvrir/fermer avec un clic'), $g, $groupe);
						} 							
						if($g == "Afficher l image de fond sur mobile")
						{ 
							case_a_cocher('Etat', '', $g, $groupe);
						} 						
						if($g == "Changement des images de partenaire au survol")
						{ 
							case_a_cocher('Etat', '', $g, $groupe);
						} 						
						if($g == "Patch amélioration nk sur mobile")
						{ 
							liste_deroulante('Etat', '', array('on', 'off'), $g, $groupe);
						} 						
						if($g == "Affichage de l image des news")
						{ 
							liste_deroulante('Etat', '', array('Par défaut', 'Personnalisé', 'Désactivé'), $g, $groupe);
						} 
						if($g == "Format des news par défaut")
						{ 
							liste_deroulante('Etat', '', array('2 par ligne', 'Large'), $g, $groupe);
						} 
						?>
						
					</td>					
				</tr>	
				<?php
			}
			fermeture_tableau();
			bas();
			pied('');
		}
	}
	
	function sons() 
	{
		global $tpl;
		include($tpl .'/admin/'. __function__ .'.php');

		if($_GET['action'] == 'enregistrer') {
		enregistrer_fichier(${'cfg_'.__function__}, __function__);
		pied('&amp;configuration='.__function__);
		}
		else 
		{
			haut('Sons', __function__);
			ouverture_tableau();
			ligne_titres_tableau(array('Options', ''));
	
			foreach (${'cfg_'. __function__} as $g => $groupe) 
			{
				// En-tête supplémentaire
				if($g == 'Boutons menu')
				{ 
					ligne_titres_tableau(array('Sons', ''));
				}
				?>
				<tr>
					<td>
						<strong><?php echo $g; ?></strong>
					</td>
					<td style="text-align:center">
					<?php 
						if($g == "Volume des sons")
						{ 
							champ_texte('Volume', '', $g, $groupe);
						}						
						if($g == "Boutons menu" || $g == "Boutons blocks dépliables" || $g == "Boutons blocks paginables" || $g == "Bouton actualités")
						{ 
							liste_deroulante('Son', 'Son', array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'), $g, $groupe);
							case_a_cocher('Etat', 'Activé', $g, $groupe);
						} 						
						?>
						
					</td>					
				</tr>	
				<?php
			}
			fermeture_tableau();
			bas();
			pied('');
		}
	}
	
	function menu() 
	{
		global $tpl;
		include($tpl .'/admin/'. __function__ .'.php');

		if($_GET['action'] == 'enregistrer') {
		enregistrer_fichier(${'cfg_'.__function__}, __function__);
		pied('&amp;configuration='.__function__);
		}
		elseif($_GET['action'] == 'supprimer_element') {
		enregistrer_fichier(${'cfg_'.__function__}, __function__, $_GET['cle_groupe']);
		pied('&amp;configuration='.__function__);
		}
		elseif($_GET['action'] == 'ajouter_element') 
		{
			haut('Gestion du menu', __function__, 'action_ajouter_element'); 
			?>
			<div style="text-align:center">
				<?php
				champ_texte('Nom', 'Nom', 'nouveau_groupe', '');
				champ_texte('Lien', 'Url', 'nouveau_groupe', '');
				case_a_cocher('Nouvelle fenêtre', 'Ouvrir dans une nouvelle fenêtre', 'nouveau_groupe', '', true);
				?>
				<div style="display:none">
				<?php
				liste_deroulante('Parent', 'Catégorie parente', array($_GET['id_categorie']), 'nouveau_groupe', true);
				?>
				</div>
			</div>
			<?php
			bas();
			pied('&amp;configuration='.__function__);			
		}
		elseif($_GET['action'] == 'action_ajouter_element') 
		{
		enregistrer_fichier(${'cfg_'.__function__}, __function__, null, true);
		pied('&amp;configuration='.__function__);
		}
		else 
		{
			haut('Gestion du menu', __function__); 

			$nb_cat_principales = 0;

			// Recup nombre catégories et définition des choix
			foreach (${'cfg_'. __function__} as $g => $groupe) 
			{
				if($groupe['Parent'] == '0'){
				$nb_cat_principales++;
				$tableau_choix[] = $nb_cat_principales;
				}	
			}
			
			$id_categorie = 0;
			
			foreach (${'cfg_'. __function__} as $g => $groupe) 
			{
				// Catégorie principale
				if($groupe['Parent'] == "0")
				{
					$id_categorie++;
					
					ouverture_tableau();
					?>
					<tr style="background:#4E4E4E">
						<td style="text-align:center">
						<?php
						champ_texte('Nom', '', $g, $groupe, true);
						champ_texte('Lien', '', $g, $groupe);
						?>
						<div style="display:none">
						<?php
						case_a_cocher('Nouvelle fenêtre', 'Ouvrir dans une nouvelle fenêtre', $g, $groupe);
						liste_deroulante('Parent', 'Catégorie parente', array('0'), $g, $groupe);
						?>
						</div>
						</td>
						<td style="text-align:center;vertical-align:middle">
						<a href="index.php?file=Admin&amp;page=theme&amp;configuration=<?php echo __function__; ?>&amp;action=ajouter_element&amp;id_categorie=<?php echo $id_categorie; ?>" title="Ajouter un lien dans cette catégorie"><img src="<?php echo $tpl; ?>/admin/images/picto-ajouter.png" alt="Ajouter" /></a>
						</td>
					</tr>
					<?php
						foreach (${'cfg_'. __function__} as $g2 => $groupe2) 
						{
							if($groupe2['Parent'] == $id_categorie)
							{
							?>
							<tr>
							<td style="text-align:center">
							<?php
							champ_texte('Nom', '', $g2, $groupe2, true);
							champ_texte('Lien', '', $g2, $groupe2);
							case_a_cocher('Nouvelle fenêtre', 'Ouvrir dans une nouvelle fenêtre', $g2, $groupe2, true);
							liste_deroulante('Parent', 'Catégorie parente', $tableau_choix, $g2, $groupe2, true);
							?>
							</td>
							<td style="text-align:center;vertical-align:middle">
							<a href="index.php?file=Admin&amp;page=theme&amp;configuration=<?php echo __function__; ?>&amp;action=supprimer_element&amp;cle_groupe=<?php echo $g2; ?>" title="Supprimer ce lien"><img src="<?php echo $tpl; ?>/admin/images/picto-supprimer.png" alt="Supprimer" /></a>
							</td>
							</tr>
							<?php
							}
						}

					fermeture_tableau();
				}

			}
			bas();
			pied('');
		}
	}
	
	function video() 
	{
		global $tpl;
		include($tpl .'/admin/'. __function__ .'.php');

		if($_GET['action'] == 'enregistrer') {
		enregistrer_fichier(${'cfg_'.__function__}, __function__);
		pied('&amp;configuration='.__function__);
		}
		else 
		{
			haut('Gestion de la vidéo', __function__);
			?>
			<p class="center">
				Hébergeurs supportés:<br />
				<img src="<?php echo $tpl; ?>/admin/images/picto-youtube.png" alt="Youtube" title="Youtube" style="border:none" /> 
				<img src="<?php echo $tpl; ?>/admin/images/picto-dailymotion.png" alt="Dailymotion" title="Dailymotion" style="border:none" />
				<img src="<?php echo $tpl; ?>/admin/images/picto-fb.png" alt="Facebook" title="Facebook" style="border:none" />
				<img src="<?php echo $tpl; ?>/admin/images/picto-vimeo.png" alt="Vimeo" title="Vimeo" style="border:none" />
			</p>
			<?php 
			ouverture_tableau();
			ligne_titres_tableau(array('Options', ''));
	
			foreach (${'cfg_'. __function__} as $g => $groupe) 
			{ ?>
				<tr>
					<td>
						<strong><?php echo $g; ?></strong>
					</td>
					<td style="text-align:center">
					<?php
					if($g == "Vidéo")
					{ 
						champ_texte('Lien', 'Lien de la vidéo', $g, $groupe);
					}				
					if($g == "Forcer les vidéos du site à occuper la largeur maximale")
					{ 
						case_a_cocher('Etat', '', $g, $groupe);
					}
					?>
					</td>					
				</tr>	
				<?php
			}
			
			fermeture_tableau();
			?>
			<br />
			<?php 
			afficher_video($cfg_video['Vidéo']['Lien']);
			?>
			<br /><br />
			<?php
			bas();
			pied('');
		}
	}
	
	function slider() 
	{
		global $tpl;
		
		include($tpl .'/admin/slider.php');
		
		if($_GET['action'] == 'enregistrer') 
		{
			function uploadImage($cle, $tableau_image)
			{
				global $tpl;
			
				// Paramètres validation upload		
				$extensions_valides = array('jpg', 'jpeg', 'JPG', 'JPEG');
				$nom_img = $tableau_image['name'];
				
				// Vérification du fichier
				if ($tableau_image['error'] > 0) { $erreur = "Erreur lors du tranfsert"; }	
				
				// Vérification extensions
				$extension_img = substr(strrchr($nom_img, '.')  ,1);
				if(!in_array($extension_img,$extensions_valides)){ $erreur = "L'image doit être de type jpg."; }
				
				if(!isset($erreur)){	
					// Déplacer fichiers temporaires dans les dossiers d'upload 
					move_uploaded_file($tableau_image['tmp_name'], $tpl ."/images/". $cle .".jpg");
				}
				else{
					return $erreur;
				}
			}
			//print_r($_FILES);
			$erreurs_images = false;
			
			foreach($_FILES as $cle => $tableau_image)
			{
				if($tableau_image['name'] != null){
					$erreur = uploadImage($cle, $tableau_image);
					if($erreur != null){
					echo '<br /><div style="text-align:center">Erreur sur <strong>'. $cle .'</strong>: '. $erreur .'</div><br />';
					$erreurs_images = true;
					}
				}
			}
			
			if($erreurs_images == false){
			enregistrer_fichier(${'cfg_'.__function__}, __function__);
			}
			
			pied('&amp;configuration='.__function__);
		}
		else 
		{
				haut('Slider', __function__, 'enregistrer', true);
				ouverture_tableau();
				ligne_titres_tableau(array('Options', ''));
				
				foreach (${'cfg_'. __function__} as $g => $groupe) 
				{
					// En-tête supplémentaire
					if($g == 'Image 1')
					{ 
						ligne_titres_tableau(array('Images', ''));
					}
					
					if($g == "Config") 
					{
						foreach ($groupe as $g2 => $groupe2) 
						{
						?>
						<tr>
							<td>
								<?php echo $g2; ?>
							</td>
							<td style="text-align: center">
								<?php
								if($g2 == "Activer la navigation") 
								{
								case_a_cocher('Activer la navigation', '', $g, $groupe);
								}
								if($g2 == "Démarrage aléatoire") 
								{
								case_a_cocher('Démarrage aléatoire', '', $g, $groupe);
								}
								if($g2 == "Pause au survol") 
								{
								case_a_cocher('Pause au survol', '', $g, $groupe);
								}
								if($g2 == "Effet de transition") 
								{
								liste_deroulante('Effet de transition', '', array('fade', 'fold', 'slideInLeft', 'slideInRight', 'boxRain', 'boxRainReverse', 'boxRainGrow', 'boxRainGrowReverse', 'boxRandom', 'sliceUp', 'sliceUpLeft', 'random'), $g, $groupe);
								}
								if($g2 == "Nombre d images à afficher") 
								{
								liste_deroulante("Nombre d images à afficher", "", array("2", "3", "4", "5"), $g, $groupe);
								}
								if($g2 == "Image de départ") 
								{
								liste_deroulante('Image de départ', '', array('1', '2', '3', '4', '5'), $g, $groupe);
								}							
								if($g2 == "Vitesse de transition (millisecondes)") 
								{
								champ_texte('Vitesse de transition (millisecondes)', '', $g, $groupe);
								}							
								if($g2 == "Temps de pause (millisecondes)") 
								{
								champ_texte('Temps de pause (millisecondes)', '', $g, $groupe);
								}
								?>
							</td>
						</tr>	
						<?php
						}
					}
					
					if($g == "Image 1" OR $g == "Image 2" OR $g == "Image 3" OR $g == "Image 4" OR $g == "Image 5") 
					{
						if($g == "Image 1") {$i = 1; }
						if($g == "Image 2") {$i = 2; }
						if($g == "Image 3") {$i = 3; }
						if($g == "Image 4") {$i = 4; }
						if($g == "Image 5") {$i = 5; }
						
						$img_slider = $tpl.'/images/image-slider-'. $i .'.jpg';
						?>
						<tr>
						<td style="vertical-align:top">
							<a href="<?php echo $img_slider; ?>?date=<?php echo filemtime($img_slider); ?>" title="Aperçu en taille réelle"><img src="<?php echo $img_slider; ?>?date=<?php echo filemtime($img_slider); ?>" alt="" style="max-width: 100%;margin-bottom:5px" /></a><br />
							<span style="font-style:italic">(Dimensions conseillées: 608x265px)</span>
						</td>						
						<td style="vertical-align:top">
							<?php echo champ_texte('Titre', 'Titre:', $g, $groupe); ?>
							<?php echo bloc_texte('Légende', 'Légende:', $g, $groupe); ?>
							<?php echo champ_texte('Redirection', 'Redirection:', $g, $groupe); ?>
							<?php echo case_a_cocher('Nouvelle fenêtre', 'Ouvrir dans une nouvelle fenêtre', $g, $groupe); ?>
							<br />
							<input type="file" name="image-slider-<?php echo $i; ?>" />
						</td>
						</tr>
						<?php
					}
				}
			fermeture_tableau();
			bas();
			pied('');
		}
	}
	
	function haut($titre, $nom_fonction, $nom_action = 'enregistrer', $upload_fichier = false)
	{
		global $tpl;
		?>
		<div style="text-align: center">
			<h3 style="font-size:18px;margin:40px 0 20px 0;color:#53ac00"><img src="<?php echo $tpl; ?>/admin/images/ico_<?php echo $nom_fonction; ?>.jpg" alt="" style="width:35px;height:35px;margin-right:15px;vertical-align:middle" /><?php echo $titre; ?></h3>
			<br />
			<form method="post" action="index.php?file=Admin&amp;page=theme&amp;configuration=<?php echo $nom_fonction; ?>&amp;action=<?php echo $nom_action; ?>" <?php if($upload_fichier == true){ echo 'enctype="multipart/form-data"'; } ?>>
				<div style="max-width:700px;margin:auto">
		<?php
	}	
	
	function ouverture_tableau(){ ?> <table style="margin-bottom:20px;width:100%" cellspacing="0" cellpadding="0"> <?php }		
	
	function fermeture_tableau(){ ?> </table> <?php }	
	
	function ligne_titres_tableau($tableau_titres)
	{
		?>
		<tr></tr>
		<tr style="background:#e1e1e1">
			<?php foreach ($tableau_titres as $titre){ ?>
			<td><h5 style="padding:0;text-align:center"><?php echo $titre; ?></h5></td>
			<?php }?>
		</tr>
		<?php
	}
	
	function bas()
	{
		?>
				</div>
				<input type="submit" value="Sauvegarder" />
			</form>
		</div>
		<?php
	}	
	
	function pied($direction)
	{
		global $tpl;
		?>
		<div style="text-align:center;margin:30px 0">
		<a href="index.php?file=Admin&amp;page=theme<?php echo $direction; ?>" title="Retour"><img src="<?php echo $tpl; ?>/admin/images/picto-retour.png" style="vertical-align:middle;margin-right:5px" alt="" /><strong><?php echo _BACK; ?></strong></a>
		</div>
		<?php
	}
	
	/**
	*
	* Affiche une liste déroulante
	*
	* @param string $element  Element du groupe à modifier
	* @param string $description Description de la liste
	* @param array  $liste_choix Liste des choix de la liste
	* @param string $g Nom du groupe
	* @param array  $groupe Contenu du groupe
	* @param boolean $inline Affichage en ligne si vaut true
	*/
	function liste_deroulante($element, $description, $liste_choix, $g, $groupe, $inline = false){
	
		if($description != '')
		{ ?>
		<label style="font-weight:normal;padding:0;display:inline-block;min-width:100px"><?php echo $description; ?></label>
		<?php 
		} ?>
		<select name="choix_utilisateur[<?php echo $g; ?>][<?php echo $element; ?>]">
			<?php 
			foreach($liste_choix as $choix)
			{
				if($choix == $groupe[$element]){ $selected = ' selected="selected"'; }else{ $selected = '';}
				echo '<option value="'. $choix .'"'. $selected .'>'. $choix .'</option>';
			}
			?>
		</select>		
		<?php if($inline != true){ ?>
		<br />
		<?php
		}
	}	
	
	/**
	*
	* Affiche un champ texte
	*
	* @param string $element  Element du groupe à modifier
	* @param string $description Description du champ
	* @param string $g Nom du groupe
	* @param array  $groupe Contenu du groupe
	* @param boolean $inline Affichage en ligne si vaut true
	*/
	function champ_texte($element, $description, $g, $groupe, $inline = false){
	
		if($description != '')
		{ ?>
		<label style="font-weight:normal;padding:0;display:inline-block;min-width:100px"><?php echo $description; ?></label>
		<?php 
		} ?>
		<input type="text" name="choix_utilisateur[<?php echo $g; ?>][<?php echo $element; ?>]" value="<?php echo stripslashes_all($groupe[$element]); ?>" />
		<?php if($inline != true){ ?>
		<br />
		<?php
		}
	}	
	
	/**
	*
	* Affiche un bloc de texte
	*
	* @param string $element  Element du groupe à modifier
	* @param string $description Description du bloc
	* @param string $g Nom du groupe
	* @param array  $groupe Contenu du groupe
	*/
	function bloc_texte($element, $description, $g, $groupe){
	
		if($description != '')
		{ ?>
		<label style="font-weight:normal;padding:0;display:inline-block;min-width:100px"><?php echo $description; ?></label>
		<?php 
		} ?>
		<textarea name="choix_utilisateur[<?php echo $g; ?>][<?php echo $element; ?>]"><?php echo stripslashes_all($groupe[$element]); ?></textarea>
		<?php 
	}
	
	/**
	*
	* Affiche une case à cocher
	*
	* @param string  $element  Element du groupe à modifier
	* @param string  $description Description du champ
	* @param string  $g Nom du groupe
	* @param array   $groupe Contenu du groupe
	* @param boolean $inline Affichage en ligne si vaut true
	*/
	function case_a_cocher($element, $description, $g, $groupe, $inline = false){
	
		if($groupe[$element] == 'on'){ $checked = 'checked="checked"'; } else{ $checked = ''; } 
		if($description != '')
		{ ?>
		<label style="font-weight:normal;padding:0;display:inline-block;min-width:100px"><?php echo $description; ?></label>
		<?php 
		} ?>
		<input type="hidden" name="choix_utilisateur[<?php echo $g; ?>][<?php echo $element; ?>]" value="0"> <!-- Champ caché pour transmettre variable dans POST même si nul -->
		<input type="checkbox" name="choix_utilisateur[<?php echo $g; ?>][<?php echo $element; ?>]" <?php echo $checked; ?> />
		<?php if($inline != true){ ?>
		<br />
		<?php
		}
	}
	
	/**
	*
	* Enregistre fichier de configuration
	*
	* @param array   $tableau_cfg  Tableau de configuration
	* @param string  $nom_fonction Nom de la fonction
	* @param mixed   $cle_groupe_a_suppr Clé du groupe à supprimer avant enregistrement (optionnel)
	* @param boolean $nouveau_groupe Vaut true quand il y a un groupe à ajouter (optionnel)
	*/
	function enregistrer_fichier($tableau_cfg, $nom_fonction, $cle_groupe_a_suppr = null, $nouveau_groupe = false)
	{
			global $tpl;
			include($tpl .'/admin/'. $nom_fonction .'.php');
			
			// Ajouter nouveau groupe avec une id unique comme nom
			if($nouveau_groupe == true){
			$tableau_cfg[time()]= $_POST['choix_utilisateur']['nouveau_groupe'];
			$_POST['choix_utilisateur'] = $tableau_cfg;
			}
			
			//  Si il y a un groupe à suppr, l'utilisateur est venu par un lien et donc simuler les valeurs POST
			if($cle_groupe_a_suppr != null){
			$_POST['choix_utilisateur'] = ${'cfg_'. $nom_fonction};
			}

			$fichier_cfg = $tpl ."/admin/". $nom_fonction .'.php';
			$fichier = fopen($fichier_cfg, "w+");
			
$contenu = '<?php $cfg_'. $nom_fonction .' = array(
';
	
// 1er niveau	
$nb_groupes = 0;
	
foreach ($tableau_cfg as $cle_groupe => $groupe) 
{
	$nb_groupes++;		
	$suppr_groupe = false;
	
	if($cle_groupe_a_suppr != null && $cle_groupe == $cle_groupe_a_suppr){	
	$suppr_groupe = true;
	}
	
	// Ecrire le groupe s'il n'est pas à supprimer
	if($suppr_groupe != true)
	{	
	$contenu .= '"'. $cle_groupe .'" => array(
	';
			

		// 2ème niveau
		$nb_elements = 0;
		foreach ($groupe as $cle => $element)  
		{
			$nb_elements++;
	
			$contenu .= '"'. $cle .'" => "'. addslashes(stripslashes_all($_POST['choix_utilisateur'][$cle_groupe][$cle])) .'"';
	
		if($nb_elements < sizeof($groupe)){
		$contenu .= ',
	';}
				}
				
	$contenu .= '
	)';

	}

	if($nb_groupes < sizeof($tableau_cfg) && $suppr_groupe != true){
	$contenu .= ',
';}
}
			
			
$contenu .= '
); ?>';
			
			// Ecriture 
			fwrite($fichier, $contenu);
			fclose($fichier);
			echo "<br /><div style='text-align:center'>Modifications enregistrées avec succès !</div><br />";
	}
	
	switch($_GET['configuration'])
	{
		case"index":
			index();
			break;
		case"general":
			general();
			break;				
		case"blocks":
			blocks();
			break;		
		case"colonnes":
			colonnes();
			break;
		case"divers":
			divers();
			break;		
		case"sons":
			sons();
			break;
		case"menu":
			menu();
			break;
		case"video":
			video();
			break;
		case"slider":
			slider();
			break;
		default:
			index();
			break;
	}
}
?>