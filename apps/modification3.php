<?php
  //connection au serveur:
  $db = new PDO('mysql:host=localhost;dbname=tp_commun;charset=utf8', 'root', 'troiswa');
 
  //récupération des valeurs des champs:
  //nom:
  $nom     = $_POST["pseudo"] ;
  //prenom:
  $prenom = $_POST["email"] ;
  //adresse:
  $adresse = $_POST["city"] ;
  
 
  //récupération de l'identifiant de la personne:
  $id         = $_POST["id"] ;
 
  //création de la requête SQL:
  $sql = "UPDATE members SET pseudo = '$pseudo', email = '$email', city = '$city' WHERE id = '$id' " ;
 
  //exécution de la requête SQL:
  $requete = $db->query($sql);
 
 
  //affichage des résultats, pour savoir si la modification a marchée:
  if($requete)
  {
    echo("La modification à été correctement effectuée") ;
  }
  else
  {
    echo("La modification à échouée") ;
  }
?>