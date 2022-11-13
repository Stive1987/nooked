<?php
defined("INDEX_CHECK") or die ('<div class="center">Vous ne pouvez pas accéder à cette page directement.</div>');
?>
<table cellspacing="0" cellpadding="3">
<?php
global $db;
// Nombre d'entrées
$nblastforum = 5;

$i = 1;
$sql = mysqli_query($db,"SELECT t.id id, t.titre titre, t.date datepost, t.auteur auteurpost, t.forum_id forum_id, t.last_post last_post
					FROM ". $nuked['prefix'] ."_forums_threads t
					INNER JOIN ". $nuked['prefix'] ."_forums f
					ON t.forum_id = f.id AND f.niveau <= '". $user[1]."'
					ORDER BY t.last_post DESC LIMIT 0,". $nblastforum);
	
while($entree = mysqli_fetch_assoc($sql)){	
	
	// Titre
	$titre = stripslashes($entree['titre']);
	$titre = htmlspecialchars($titre);
	if (strlen($titre) > 32 ){ 
	$titre_raccourci = substr($titre, 0, 32)."..."; 
	}
	else{
	$titre_raccourci = $titre;
	}
	
	// Date
	$date = date('d/m/y', $entree['datepost']);
	$datetime = "20". date('y-m-d', $entree['datepost']);
	
	$date_reponse = date('d/m', $entree['last_post']);
	$date_aujourdhui = time();
	$date_aujourdhui = date('d/m', $date_aujourdhui);
	
	if($date_reponse == $date_aujourdhui) { 
	$date_last_reponse = _A .' '. date('H:i', $entree['last_post']);
	}
	else{  
	$date_last_reponse = _LE .' '. date('d/m', $entree['last_post']);
	}
	
	// Nombre réponses
	$sql_reponses = mysqli_fetch_array(mysqli_query($db,"SELECT COUNT(*) FROM ". $nuked['prefix'] ."_forums_messages WHERE thread_id=". $entree['id']));
	$nb_reponses = $sql_reponses[0]-1;

	// Nature 
	if($entree['last_post'] == $entree['datepost']) // Création discussion
	{
		$sujet_message = _FORUM_SUJET_DISCUSSION;
		$auteur_last_reponse = $entree['auteurpost'];
	}
	else // Réponse à une discussion
	{
		$sql_derniere_reponse = mysqli_query($db,"SELECT auteur FROM ". $nuked['prefix'] ."_forums_messages WHERE date='" . $entree['last_post'] . "'");
		$auteur_last_reponse = mysqli_fetch_array($sql_derniere_reponse);	
		$auteur_last_reponse = $auteur_last_reponse[0];
		
		$sujet_message = _FORUM_SUJET_REPONSE;
		
		if($auteur_last_reponse == null){ // Dernière réponse n'éxiste pas ?
		 	$sujet_message = _FORUM_SUJET_DISCUSSION;
			$auteur_last_reponse = $entree['auteurpost'];
		}
	}
	
	// Bordure
	if($i == $nblastforum){
	$border = 'border-bottom:none';}
	else{
	$border = '';
	}
	
	$i++;
	?>
	<tr class="transition1">
		<td style="<?php echo $border; ?>" class="cell1">
			<div>
			<a href="index.php?file=Forum&amp;page=viewtopic&amp;forum_id=<?php echo $entree['forum_id']; ?>&amp;thread_id=<?php echo $entree['id']; ?>" title="<?php echo $titre; ?>" class="survolblanc"><?php echo $titre_raccourci; ?></a><br />
			<time datetime="<?php echo $datetime; ?>"><?php echo $sujet_message . $auteur_last_reponse; ?> <?php echo $date_last_reponse; ?></time>
			</div>
		</td>
		<td style="<?php echo $border; ?>" class="cell2 hide-pclow center">
			<a href="index.php?file=Forum&amp;page=viewtopic&amp;forum_id=<?php echo $entree['forum_id']; ?>&amp;thread_id=<?php echo $entree['id']; ?>" class="btn-lire" title="<?php echo $nb_reponses; ?> <?php echo _FORUM_REPONSES; ?>"><?php echo $nb_reponses; ?></a>
		</td>
	</tr>
	<?php
}
	
?>
</table>