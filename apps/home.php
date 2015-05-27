<?php

//exécution de la requête:
$requete = "SELECT id, title, content, time_create, time_update FROM article ORDER BY id DESC";
$resultat = $db->query($requete);
$tableau_res = $resultat->fetch();

//echo "<article class='col-md-12 jumbotron news'><h1>".$tableau_res['title']."</h1><h2>".$tableau_res['time_create']."</h2><p>".$tableau_res['content']."</p></article>";


require('./views/home.phtml');

?>