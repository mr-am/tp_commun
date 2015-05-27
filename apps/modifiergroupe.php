
<?php 

// 

// Gestion des droits. DEFINE ("nom", "valeur") donne une valeur à la constante nom. 
define ('PUBLIER_ARTICLES',         0x01);
define ('MODIFIER_ARTICLES',        0x02);
define ('SUPPRIMER_ARTICLES',       0x04);
define ('MODIFIER_TOUT_ARTICLES',   0x08);
define ('SUPPRIMER_TOUT_ARTICLES',  0x10);
define ('GERER_MEMBRES',            0x20);
define ('GERER_DROITS',             0x40);

$table_name = "groupes";

if(isset($_POST['description'])) { $description = $_POST['description']; }
else { $description = ""; }


//$select = 'SELECT * FROM groupes'; WHERE id_group = "'.$_REQUEST['id'].'" '; // On sélectionne les infos
$select = 'SELECT * FROM groupes '; //WHERE id_group = 1'; // On sélectionne les infos

$result = $db->query($select);

$donnees = $result->fetchAll();



if(!isset($_REQUEST['id'])) // Si on n'a pas choisi le groupe à modifier
{

        $select2 = 'SELECT * FROM groupes';

        $result2 = $db->query($select2);

        echo 'Veuillez sélectionner le groupe à modifier : <br /><ul>';

          //while($nom = mysql_fetch_assoc($select))
          while ($nom = $result2->fetch())//(PDO::FETCH_ASSOC))
        {
                //echo "nom0 : " . $nom[0] . " nom1 : " . $nom[1] . " nom2 : " . $nom[2] . " nom3 : " . $nom[3] . "<br>";
                echo '<li><a href="?page=modifiergroupe&id='.$nom[0].'">'.$nom[1].'</a></li><br />';
        }
        echo '</ul>';
}

//elseif(!isset($_POST['id'])) // Si le formulaire n'est pas posté // patpack à voir
elseif(!isset($_POST['Nom'])) 
{
        $select4 = 'SELECT * FROM groupes WHERE name = $nom[1]'; // On sélectionne les infos

        $result4 = $db->query($select4);

        $donnees34= $result4->fetch();

    foreach ($_POST as $field => $value) { echo "$field = $value<br />\n";}

        //$donnees = $donnees[0]; // récupération de la 1ère ligne
        if ((int)$donnees4['rights_group'] & PUBLIER_ARTICLES) 
          { $selected_add_article = 1; }
        else { $selected_add_article = 0; }

        if ((int)$donnees4['rights_group'] & MODIFIER_ARTICLES) 
          { $selected_mod_article = 1; }
        else { $selected_mod_article = 0; }

        if ((int)$donnees4['rights_group'] & SUPPRIMER_ARTICLES) 
          { $selected_del_article = 1; }
        else { $selected_del_article = 0; }

        if ((int)$donnees4['rights_group'] & MODIFIER_TOUT_ARTICLES) 
          { $selected_mod_all_article = 1; }
        else { $selected_mod_all_article = 0; }

        if ((int)$donnees4['rights_group'] & SUPPRIMER_TOUT_ARTICLES) 
          { $selected_del_all_article = 1; }
        else { $selected_del_all_article = 0; }

        if ((int)$donnees4['rights_group'] & GERER_MEMBRES) 
          { $selected_gerer_membre = 1; }
        else { $selected_gerer_membre = 0; }

        if ((int)$donnees4['rights_group'] & GERER_DROITS) 
          { $selected_gerer_droits = 1; }
        else { $selected_gerer_droits = 0; }

        require('./views/creationgroupe.phtml');

}
else
{

        $nom = $_POST['Nom']; // Le nom du groupe
        
        $droits = ''; // On déclare la variable qui va contenir toutes les permissions
        
        if( $_POST['Add_article'] == 'add_article_oui')  // Si dans le formulaire, on a indiqué que ce groupe pouvait ajouter un article...
        {
                $droits |= PUBLIER_ARTICLES; // On ajoute la permission dans la variable $droits
        }

        if( $_POST['Mod_article'] == 'mod_article_oui') 
        {
                $droits |= MODIFIER_ARTICLES;
        }

        if( $_POST['Del_article'] == 'del_article_oui')  
        {
                $droits |= SUPPRIMER_ARTICLES;
        }

        if( $_POST['Mod_all_article'] == 'mod_all_article_oui') 
        {
                $droits |= MODIFIER_TOUT_ARTICLES;
        }

        if( $_POST['Del_all_article'] == 'del_all_article_oui')  
        {
                $droits |= SUPPRIMER_TOUT_ARTICLES;
        }

                if( $_POST['gerer_membre'] == 'gerer_membre_oui')  // Si dans le formulaire, on a indiqué que ce groupe pouvait ajouter un article...
        {
                $droits |= GERER_MEMBRES; // On ajoute la permission dans la variable $droits
        }

        if( $_POST['gerer_droits'] == 'gerer_droits_oui')  
        {
                $droits |= GERER_DROITS;
        }

        $select3 = "SELECT * FROM groupes WHERE name = '$nom'";

        $result3 = $db->query($select3);

        $tab = $result3->fetch();

        if ($result3->rowCount()  == 0) 
        { 
            echo "utilisateur inexistant";
            require('./views/creationgroupe.phtml');
        }
        elseif($result3->rowCount()  > 1) {
            echo "utilisateur multiple. cas théorique impossible";
            require('./views/creationgroupe.phtml');
        }

        elseif ($result3->rowCount()  == 1) 
        { 
            $request =  'UPDATE groupes 
                         SET rights_group   = "'.$droits.'",
                             description    = "'.$description.'" 
                             WHERE id_group = '.$tab[0][0].'';

            echo $request;
            $db->exec($request);
            

            echo "vos modifications ont bien été prises en compte";
        }

       
        //$requete = 'UPDATE permissions SET nom = "'.$nom.'", permissions = "'.$droits.'" WHERE id = "'.htmlspecialchars($_GET['id']).'" '; // On prépare la requête
 


}
?>