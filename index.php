<?php
// index.php
// http://localhost/Site%20perso/PHTML/index.php?page=contact
// $_GET['page'] -> contact
// http://localhost/Site%20perso/PHTML/index.php?page=toto
// $_GET['page'] -> toto
// http://localhost/Site%20perso/PHTML/index.php?truc=bidule
// $_GET['truc'] -> bidule
// si $_GET['page'] = contact
// charger le fichier apps/contact.php
$page = '';
if (isset($_GET['page']))
	$page = $_GET['page'];
require('views/index.phtml');
?>