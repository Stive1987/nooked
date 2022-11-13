<?php defined("INDEX_CHECK") or die ('<div style="text-align:center">Vous ne pouvez pas accéder à cette page directement.</div>'); ?>
<?php 
$sql_avatar = mysql_query("SELECT avatar FROM " . USER_TABLE . " WHERE id='" . $user[0] . "'");
list($avatar) = mysql_fetch_array($sql_avatar);	
		
if(empty($avatar))
{
$avatar = $tpl ."/images/avatar.png";
}

if($user[5] == 1){
$titre_mp = _MP_VOUS . $user[5] ._MP_NONLU;
$picto_mp = "picto-mp";
 }
elseif($user[5] > 1){
$titre_mp = _MP_VOUS . $user[5] ._MP_NONLUS; 
$picto_mp = "picto-mp";
}
else{
$titre_mp = _MP_AUCUN;
$picto_mp = "picto-mp-aucun";
}

?>
<div>
	<a href="index.php?file=User" class="hide-phone-pad"><img src="<?php echo $avatar; ?>" alt="" id="avatar" class="middle rounded5" /></a>
	<a href="index.php?file=User"><?php echo $user[2]; ?></a> -
	<a href="index.php?file=Userbox" title="<?php echo $titre_mp; ?>"><img src="<?php echo $tpl; ?>/images/<?php echo $picto_mp; ?>.png" alt="" class="middle" /></a> <a href="index.php?file=Userbox" title="<?php echo $titre_mp; ?>"><?php echo $user[5]; ?></a> -
	<a href="index.php?file=User&amp;nuked_nude=index&amp;op=logout" title="<?php echo _USER_DECONNEXION_TITRE; ?>"><?php echo _USER_DECONNEXION; ?></a>
	<?php
	if($user[1] >= 3)
	{
	?>
	- <a href="index.php?file=Admin" title="<?php echo _USER_ADMIN_TITLE; ?>"><?php echo "Administration"; ?></a>
	<?php } ?>
</div>