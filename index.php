<?php
$db = new PDO("mysql:dbname=tp_commun;host=127.0.0.1;charset=utf8", 'root', 'troiswa');

/** Pascal : Bien pour le dévelopemment, ne pas oublier de l'enlever lors de la mise en "live" **/
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 session_start();
// index.php
// http://localhost/Site%20perso/PHTML/index.php?page=contact
// $_GET['page'] -> contact
// http://localhost/Site%20perso/PHTML/index.php?page=toto
// $_GET['page'] -> toto
// http://localhost/Site%20perso/PHTML/index.php?truc=bidule
// $_GET['truc'] -> bidule
// si $_GET['page'] = contact
// charger le fichier apps/contact.php

/** Pascal : Pas de requete ajax ? **/

$page = 'home';
if (isset($_GET['page']))
	$page = $_GET['page'];
require('views/index.phtml');
?>