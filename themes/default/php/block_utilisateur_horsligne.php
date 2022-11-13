<?php defined("INDEX_CHECK") or die ('<div style="text-align:center">Vous ne pouvez pas accéder à cette page directement.</div>'); ?>
<form action="index.php?file=User&amp;nuked_nude=index&amp;op=login" method="post" style="margin:0">
	<span class="hide-pc-pclow"><a href="index.php?file=User&amp;op=login_screen" title="<?php echo _USER_CONNEXION_TITRE; ?>"><?php echo _USER_CONNEXION; ?></a> |</span>
	<a href="index.php?file=User&amp;op=reg_screen" title="<?php echo _USER_ENREGISTREMENT_TITRE; ?>"><?php echo _USER_ENREGISTREMENT; ?></a> |
	<a href="index.php?file=User&amp;op=oubli_pass" title="<?php echo _USER_PASSPERDU_TITRE; ?>" style="margin-right:15px"><?php echo _USER_PASSPERDU; ?></a>
	<input type="text" name="pseudo" value="Pseudo" onclick="this.value=''" class="hide-phone-pad" />
	<input type="password" name="pass"  value="Mot de passe" onclick="this.value=''" class="hide-phone-pad" />
	<input type="submit" value="<?php echo _USER_OK; ?>" class="hide-phone-pad" />
</form>