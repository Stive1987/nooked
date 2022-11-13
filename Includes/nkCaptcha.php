<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//

if (!defined("INDEX_CHECK")) exit('You can\'t run this file alone.');

//réglage captcha (auto | on | off)
define("_NKCAPTCHA","auto");
if (isset($_SESSION['captcha']))
	$GLOBALS['nkCaptchaCache'] = $_SESSION['captcha'];

require_once (dirname(__FILE__) . '/hash.php');

/**
* Create a Captcha code
* @return string Generated code
**/
function Captcha_Generator(){
	global $cookie_captcha;
	static $code = null;
	if ($code == null)
		$code = substr(md5(uniqid()), rand(0, 25), 5);
	$_SESSION['captcha'] = $code;
	return $code;
}

/**
* Check if the code is the good captcha code
* @param string $code
* @return bool
**/
function ValidCaptchaCode($code){
	global $user;
	return _NKCAPTCHA == 'off' || ($user != null && $user[1] > 0) || strtolower($GLOBALS['nkCaptchaCache']) == strtolower($code);
}

function create_captcha($style){
    $random_code = Captcha_Generator();

    if ($style == 1){
		echo '<tr><td>&nbsp;</td></tr><tr><td><b>' , _SECURITYCODE , ' :</b>';

		if (@extension_loaded('gd')) echo '&nbsp;<img src="captcha.php" alt="" title="' , _SECURITYCODE ,'" />';
		else echo '&nbsp;<big><i>' , $random_code , '</i></big>';

		echo '</td></tr><tr><td><b>' , _TYPESECCODE , ' :</b>&nbsp;<input type="text" id="code" name="code_confirm" size="7" maxlength="5" /></td></tr>',"\n"
		, '<tr><td>&nbsp;</td></tr>',"\n";

    }
    else if ($style == 2){
		echo '<tr><td colspan="2">&nbsp;</td></tr><tr><td><b>' , _SECURITYCODE , ' :</b></td><td>';

		if (@extension_loaded('gd')) echo '<img src="captcha.php" alt="" title="' , _SECURITYCODE , '" />';
		else echo '<big><i>' , $random_code , '</i></big>';

		echo '</td></tr><tr><td><b>' , _TYPESECCODE ,' :</b></td><td><input type="text" id="code" name="code_confirm" size="6" maxlength="5" /></td></tr>',"\n"
		, '<tr><td colspan="2">&nbsp;</td></tr>',"\n";
    }
    else{
		echo '<br />';
		if (@extension_loaded('gd')) echo '<img src="captcha.php" alt="" title="' , _SECURITYCODE , '" />';
		else echo '<big><i>' , $random_code , '</i></big>';
		echo '<br />' , _TYPESECCODE , ' : <br /><input type="text" name="code_confirm" id="code" size="7" maxlength="5" /><br /><br />';
    }
	return($random_code);
}

function crypt_captcha($code){
    $temp_code = hexdec(md5($_SERVER['REMOTE_ADDR'] . $code));
    $confirm_code = substr($temp_code, 2, 5);
    return($confirm_code);
}
// Verification code recaptcha google
function Validrecaptchacode(){
	include_once('Includes/keys.php');

     if  (isset($_POST['submit_captcha'])) {
		 
    $name = $_POST['name'];

    $recaptcha = $_POST['g-recaptcha-response'];

    $secret_key = '' . $privatekey . '';

    $url = 'https://www.google.com/recaptcha/api/siteverify?secret='
          . $secret_key . '&response=' . $recaptcha;

    $response = file_get_contents($url);

    $response = json_decode($response);

    if ($response->success == true) {
        echo '';
    } else {
        echo '';
           }
        if (!$_REQUEST['g-recaptcha-response']){
																		
            echo '<p style="text-align: center">' . _NOCONTENT . '<br /><br /><a href="javascript:history.back()">[ <b>' . _BACK . '</b> ]</a></p>';
            closetable();
            footer();
            exit();
                                                }
                                            }
                               }
							   
// Verification code recaptcha google module comment
function Validrecaptchacodecomment(){
	include_once('Includes/keys.php');

     if  (isset($_POST['submit_captcha'])) {
		 
    $name = $_POST['name'];

    $recaptcha = $_POST['g-recaptcha-response'];

    $secret_key = '' . $privatekey . '';

    $url = 'https://www.google.com/recaptcha/api/siteverify?secret='
          . $secret_key . '&response=' . $recaptcha;

    $response = file_get_contents($url);

    $response = json_decode($response);

    if ($response->success == true) {
        echo '';
    } else {
        echo '';
           }
        if (!$_REQUEST['g-recaptcha-response']){
																		
            echo '<p style="text-align: center">' . _NOCONTENT . '<br />'. _REDIRECTIONENCOURS . '</p>';
            $url_redir = "javascript:history.back()";
            redirect($url_redir, 5);
            closetable();
            exit();
                                                }
                                            }
                               }
							   
// Affichage du Recaptcha google
function create_recaptcha(){
	include_once('Includes/keys.php');
     echo '<div class="g-recaptcha" data-sitekey="' . $publickey . '"></div>',"\n";
}
?>
