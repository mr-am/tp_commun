<?php

//exécution de la requête:
$requete = "SELECT id, title, content, time_create, time_update, author_id FROM article ORDER BY id DESC";
$resultat = $db->query($requete);
$tableau_res = $resultat->fetchAll();


require('./views/home.phtml');

?>