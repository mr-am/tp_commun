<?php 
  
// patpack pas de fichier en phtml => osef
// affiche les différents groupes supprimables
if(!isset($_GET['id']))
{
    $request1 = "SELECT * FROM groupes"; // Requête pour sélectionner tous les groupes
    $result = $db->query($request1);
    echo '<i>Veuillez sélectionner le groupe à supprimer : </i><br /><ul>';
    $i = 0;
    while ($groupe = $result->fetch())
    //while (isset($result[$i]))
    {
        echo '<li><a href="?page=supprimergroupe&id='.$groupe['id_group'].'">'.$groupe['name'].'</a></li><br />'; // Lien avec le nom
    }
    echo '</ul>';   
}

// Si le groupe a été sélectionné, on affiche un message de confirmation... 
if(isset($_GET['id']) && !isset($_GET['confirm'])) 
{
    echo 'Êtes-vous sûr de votre choix ?<br />
    <a href="?page=supprimergroupe&id='.$_GET['id'].'&confirm">Oui</a>';
}

// Si le groupe est choisi ET validé, on va pouvoir supprimer
if(isset($_GET['id']) && isset($_GET['confirm'])) // Si le groupe est choisi ET validé, on va pouvoir supprimer
{
    $request2 = 'DELETE FROM groupes WHERE id_group = '.$_GET['id'].''; 
    $result2 = $db->query($request2);

    if ($result2->rowCount()  == 0) 
    { 
        echo "groupe inexistant";
    }
    elseif($result2->rowCount()  > 1) 
    {
        echo "groupe multiple. cas théorique impossible";
    }
    elseif ($result2->rowCount()  == 1) 
    { 
        echo 'Le groupe a bien été supprimé !'; // Si c'est OK...
    }
}

?>