<?php
//exécution de la requête:
$requete = "SELECT id, title, content, time_create, time_update, author_id FROM article ORDER BY id DESC";
$resultat = $db->query($requete);
$tableau_res = $resultat->fetchAll();
$i = 0;
while (isset($tableau_res[$i]) && $i<=2) {
	require('./views/carroussel.phtml');
	$i++;
}

?>