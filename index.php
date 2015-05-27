<?php
$db = new PDO("mysql:dbname=tp_commun;host=127.0.0.1", 'root', 'troiswa');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 session_start();

define ('PUBLIER_CONTENU', 0x01);
define ('MODIFIER_CONTENU', 0x02);
define ('SUPPRIMER_CONTENU', 0x04);
define ('VALIDER_TOUT_CONTENU', 0x08);
define ('MODIFIER_TOUT_CONTENU', 0x10);
define ('SUPPRIMER_TOUT_CONTENU', 0x20);
define ('GERER_MEMBRES', 0x40);
define ('GERER_PERMISSIONS', 0x80);
require('apps/functions.php');


if(isset($_GET['logout']) && $_GET['logout']==1){
	$_SESSION['id'] = $_SESSION['login'] = $_SESSION['auth'] = $_SESSION['captcha'] = false;
	unset($_SESSION['id']);
	unset($_SESSION['login']);
	unset($_SESSION['auth']);
	unset($_SESSION['captcha']);
}

$page = 'home';
if (isset($_GET['page']))
	$page = $_GET['page'];
require('views/index.phtml');
?>