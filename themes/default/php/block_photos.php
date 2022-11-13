<?php
defined("INDEX_CHECK") or die ('<div class="center">Vous ne pouvez pas accéder à cette page directement.</div>');

global $db;
// CONNECT TO DB.		
connect();

// Nombre d'entrées
$nblastphotos = 8;
$sql = mysqli_query($db, "SELECT sid, titre, url, url2, date FROM ". $nuked['prefix'] ."_gallery ORDER BY date DESC LIMIT 0, ".$nblastphotos);
while (list($id, $titre, $url, $url2, $date) = mysqli_fetch_array($sql))
{
	$titre = stripslashes($titre);
	$titre =  htmlspecialchars($titre);
	?>
	<a href="index.php?file=Gallery&amp;op=description&amp;sid=<?php echo $id; ?>" class="inline-block rounded10" title="<?php echo $titre; ?>"><img src="<?php echo $url2; ?>" alt="" class="middle rounded10" /></a>
	<?php
} 
?>