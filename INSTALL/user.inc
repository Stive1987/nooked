<?php
    function nk_hash($hash, $pass, $decal = null){
        $builder = '';
        $decal = $decal === null?rand(0, 15):$decal;
        $pass = sha1($pass);
        for ($i = 0; $i < strlen($pass) * 2; $i++){
            if ($i % 2 == 0){
                $builder .= $pass[$i / 2];
            }
            else{
                $builder .= substr($hash , ($i / 2 + $decal) % 20, 1);
            }
        }
        return '#'.dechex($decal).md5($builder);
    }
    
    function saveConfig($type){
        if($type == 'install'){
            $_SESSION['hash'] = addslashes(@sha1(uniqid(''), true));
            $pass = nk_hash($_SESSION['hash'] , $_REQUEST['pass']);
            $date = time();
            $ip = $_SERVER['REMOTE_ADDR'];
        
            $taille = 20;
            $lettres = "abCdefGhijklmNopqrstUvwXyz0123456789";
            srand(time());
        
            $pseudo = htmlentities($_REQUEST['pseudo'], ENT_QUOTES);
            $user_id = '';
			$signature = '';
            for ($i=0;$i<$taille;$i++){
                $user_id .= substr($lettres,(rand()%(strlen($lettres))), 1);
            }
            global $db;
            $mail = $_REQUEST['mail'];
			
            $sql = 'TRUNCATE TABLE'.$_SESSION['db_prefix'].'_users';		
			
            if (mysqli_query($db, $sql));


            $sql = 'INSERT INTO `'. $_SESSION['db_prefix'] .'_users`
            (`id`, `pseudo`, `mail`, `pass`, `niveau`, `date`, `signature`, `game`, `country`, `token_time`) VALUES
            (\''. $user_id .'\', \''. $pseudo .'\', \''. $mail .'\', \''. $pass .'\', 9, \''. $date .'\', \''. $signature .'\', 1, \'France.gif\', \'0\')';
			
            if (mysqli_query($db, $sql));
			
            $sql = 'INSERT INTO `'. $_SESSION['db_prefix'] .'_news`
            (`id`, `cat`, `titre`, `auteur`, `auteur_id`, `texte`, `date`, `published`, `niveau`, `allow_comments`) VALUES
			(1, 1, \''._FIRSTNEWSTITLE.'\', \''.$pseudo.'\', \''.$user_id.'\', \''._FIRSTNEWSCONTENT.'\', \''.$date.'\', 1, 0, 1)';

            if (mysqli_query($db, $sql));	
			
            $sql = 'INSERT INTO `'. $_SESSION['db_prefix'] .'_shoutbox`
            (`id`, `auteur`, `ip`, `texte`, `date`) VALUES
			(1, \''.$pseudo.'\', \''.$ip.'\', \''. _FIRSTNEWSTITLE .'\', \''.$date.'\')'; 

            if (mysqli_query($db, $sql));				
			
            $sql = 'UPDATE `'. $_SESSION['db_prefix'] .'_config`
            SET value = \''. $mail .'\'
            WHERE name = \'contact_mail\' OR name = \'mail\'';		
			
            if (mysqli_query($db, $sql));
        }
        
        if (@extension_loaded('zlib') && !@ini_get('zlib.output_compression') && @phpversion() >= "4.0.4" && stripos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) define('GZIP_COMPRESS', 'true');
        else define('GZIP_COMPRESS', 'false');
               
        $content="<?php\n"
                    . "//-------------------------------------------------------------------------//\n"
                    . "//  Nuked-KlaN - PHP Portal                                                //\n"
                    . "//  http://www.nuked-klan.org                                              //\n"
                    . "//-------------------------------------------------------------------------//\n"
                    . "//  This program is free software. you can redistribute it and/or modify   //\n"
                    . "//  it under the terms of the GNU General Public License as published by   //\n"
                    . "//  the Free Software Foundation; either version 2 of the License.         //\n"
                    . "//-------------------------------------------------------------------------//\n"
                    . "\$nk_version = '1.7.9';\n"
                    . "\n"
                    . "\$global['db_host']  = '".$_SESSION['host']."';\n"
                    . "\$global['db_user']  = '".$_SESSION['user']."';\n"
                    . "\$global['db_pass']  = '".$_SESSION['pass']."';\n"
                    . "\$global['db_name'] = '".$_SESSION['db_name']."';\n"
                    . "\$db_prefix = '".$_SESSION['db_prefix']."';\n"
                    . "\n"
                    . "define('NK_INSTALLED', true);\n"
                    . "define('NK_OPEN', true);\n"
                    . "define('NK_GZIP', " . GZIP_COMPRESS . ");\n"
                    . "// NE PAS SUPPRIMER! / DO NOT DELETE\n"
                    . "define('HASHKEY', '".$_SESSION['hash']."');\n"
                    . "\n"
                    . "?>";
        $path = dirname(dirname(__FILE__)).'/';
        @chmod ($path.'conf.inc.php', 0666);
        @chmod ($path, 0755);
        $errors = 0;
        $_SESSION['content'] = $content;
        if (is_writable($path.'conf.inc.php') || (!file_exists($path.'conf.inc.php') && is_writable($path))){               
                try{
                    $fp = @fopen($path.'conf.inc.php', 'w');
                    if(!@fwrite($fp, $content)) $errors++;
                    if(!@fclose($fp)) $errors++;
                    if(!@chmod($path.'conf.inc.php', 0644)) throw new Exception ('CHMOD');
                    if(!@copy($path.'conf.inc.php', $path.'config_save_'.date('%Y%m%d%H%i').'.php')) throw new Exception ('COPY');
                }
                catch(exception $e){
                    $_SESSION['content_web'] = nl2br(htmlentities($content));
                    return $e->getMessage();
                }
            if($errors > 0){
                $_SESSION['content_web'] = nl2br(htmlentities($content));
                    return 'CONF.INC';
            }
            else{
                return true;
            }            
        }
        else{
            $_SESSION['content_web'] = nl2br(htmlentities($content));
            return 'CONF.INC';
        }
    }   
?>