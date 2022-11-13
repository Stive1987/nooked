<?php
defined("INDEX_CHECK") or die ('<div class="center">Vous ne pouvez pas accéder à cette page directement.</div>');

translate("modules/Forum/lang/" . $language . ".lang.php");

global $db;
// CONNECT TO DB.		
connect();

echo"\n";

$nb = nbvisiteur();

    $sql_tmessage = mysqli_query($db, "SELECT id FROM " . FORUM_MESSAGES_TABLE . " ");
    $nb_tmessage = mysqli_num_rows($sql_tmessage);
    
    $sql_tusers = mysqli_query($db, "SELECT id FROM " . USER_TABLE . " ");
    $nb_tusers = mysqli_num_rows($sql_tusers);
    
    $sql_luser = mysqli_query($db, "SELECT pseudo FROM " . USER_TABLE . " ORDER BY date DESC LIMIT 1");
    list($last_user) = mysqli_fetch_array($sql_luser);
?>
<?php
echo "\n"
  . "". _WEHAVE ."&nbsp;<b>" . $nb_tusers . "</b>&nbsp;" . _REGISTEREDUSERS . ".<br />\n"
  . "". _LASTREGISTEREDUSER ."&nbsp;:<br /><a href=\"index.php?file=Members&amp;op=detail&amp;autor=" . $last_user . "\"><b>" . $last_user . "</b></a><br /><br />\n"
  . $nb[0] . "&nbsp;" . _FVISITORS . ",&nbsp;<br />" . $nb[1] . "&nbsp;" . _FMEMBERS . "&nbsp;<br />" . _AND . "&nbsp;" . $nb[2] . "&nbsp;" . _FADMINISTRATORS . "<br />" . _ONLINE . "\n";

if ($nuked['profil_details'] == "on")
{   
echo "<br />" . _MEMBERSONLINE . " : ";

$i = 0;
$online = mysqli_query($db, "SELECT username FROM " . NBCONNECTE_TABLE . " WHERE type > 0 ORDER BY date");
while (list($name) = mysqli_fetch_row($online))
{
    $i++;
    if ($i == $nb[3])
    {
        $sep = "";
    } 
    else
    {
        $sep = ", ";
    } 

$sql_user_details = mysqli_query($db, "SELECT pseudo, count, avatar, country FROM " . USER_TABLE . " WHERE pseudo = '" . $name . "'");
   
    while (list($pseudof, $userfcount, $avatar, $country) = mysqli_fetch_array($sql_user_details))
    {
        echo "<img src=\"images/flags/". $country ."\" alt=\"" . $country ."\" style=\"margin-bottom:-2px;\" />\n";
  	}
        if ($nuked['profil_details'] == "on")
        {  	
              $sq_user1 = mysqli_query($db, "SELECT rang FROM " . USER_TABLE . " WHERE pseudo = '" . $name . "'");
              list($rang2) = mysqli_fetch_array($sq_user1);
              $sql_rank_team = mysqli_query($db, "SELECT couleur FROM " . TEAM_RANK_TABLE . " WHERE id = '" . $rang2 . "'");
              list($lacouleur) = mysqli_fetch_array($sql_rank_team);
              $rank_color = "style=\"color: #" . $lacouleur . ";\"";
        } else {$rank_color = "";}

    echo "<a href=\"index.php?file=Members&amp;op=detail&amp;autor=" . urlencode($name) . "\" " . $rank_color . ">" . $name . "</a>" . $sep;
}

if (mysqli_num_rows($online) == NULL) echo '<em>' . _NONE . '</em>';
  
echo "<br />" . _RANKLEGEND . "&nbsp;:&nbsp;\n";

$sql_rank_team = mysqli_query($db, "SELECT titre, couleur FROM " . TEAM_RANK_TABLE . " ORDER BY ordre LIMIT 0, 20");
  while (list($rank_titre, $rank_color) = mysqli_fetch_array($sql_rank_team))
  {	
      $rank_color1 = "style=\"color: #" . $rank_color . ";\"";
      echo "[&nbsp;<span " . $rank_color1 . "><b>" . $rank_titre . "</b></span>&nbsp;]&nbsp;";
  }    
}
echo "<br /><br />\n"
  . "". _MEMBERTOTALMESSAGES ."&nbsp;<b>" . $nb_tmessage . "</b>&nbsp;" . _MESSAGES2 . ".\n";
  
  // Les anniversaires //
if ($nuked['birthday_forum'] == "on")
{
	  $y = date("Y");
	  $m = date("m");
	  $d = date("d");
	  
	  if ($d < 10){$d = str_replace("0", "", $d);}
	  if ($m < 10){$m = str_replace("0", "", $m);}
	  
	  $sqlaniv1 = mysqli_query($db, "SELECT age FROM " . USER_DETAIL_TABLE . " WHERE age LIKE '%$d/$m%'");
	  $nb_aniv = mysqli_num_rows($sqlaniv1);
	  
		while (list($anivjourn) = mysqli_fetch_array($sqlaniv1))
		{
			list ($journ, $moisn, $ann) =  split ('[/]', $anivjourn);
			if ($d != $journ || $m != $moisn)
			{		
			$nb_aniv = $nb_aniv - 1;
			}
		}	  
		echo "<br />" . _TODAY . ", ";
		if ($nb_aniv == 0)
		echo "" . _BIRTHDAY1 . "";
		elseif ($nb_aniv == 1)
		echo "" . _BIRTHDAY2 . "";
		else
		echo "" . _THEREARE2 . " $nb_aniv " . _BIRTHDAY3 . "";
			$a = 0;
			$sqlaniv = mysqli_query($db, "SELECT user_id, age, pseudo, rang FROM " . USER_DETAIL_TABLE . " INNER JOIN " . USER_TABLE . " ON user_id = id WHERE niveau > 0 ");
			while (list($anivid, $anivjour, $anivpseudo, $rang2) = mysqli_fetch_array($sqlaniv))
			{
			list ($jour, $mois, $an) = split ('[/]', $anivjour);
				$age = $y - $an;
				if ($m < $mois)
				{
					$age = $age - 1;
				} 
				if ($d < $jour && $m == $mois)
				{
					$age = $age - 1;
				} 

			if ($d == $jour && $m == $mois)
			{
			if ($lacouleur1) $rank_color1 = "style=\"color: #" . $lacouleur1 . ";\"";
			else $rank_color1 = "";
			$anivpseudo = stripslashes($anivpseudo);
			$a++;
			if ($a != $nb_aniv)
			{
			$virg = ", ";
			}
			else
			{
			$virg = " ";
			}
if ($nuked['profil_details'] == "on")
{ 					
			$sql_rank_team2 = mysqli_query($db, "SELECT couleur FROM " . TEAM_RANK_TABLE . " WHERE id = '" . $rang2 . "'");
			list($lacouleur2) = mysqli_fetch_array($sql_rank_team2);
			if ($lacouleur2) $rank_color2 = "style=\"color: #" . $lacouleur2 . ";\"";
			else $rank_color2 = "";
} else {$rank_color2 = "";}
		
			echo " <a href=\"index.php?file=Members&amp;op=detail&amp;autor=" . $anivpseudo . "\" " . $rank_color2 . "><b> " . $anivpseudo . "</b></a> (" . $age . " " . _ANS . ")" . $virg . "";
			}
		}
}		
// Fin anniversaire
?>