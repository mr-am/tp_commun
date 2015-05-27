<?php 

// Gestion des droits. DEFINE ("nom", "valeur") donne une valeur à la constante nom. 
define ('PUBLIER_ARTICLES',         0x01);
define ('MODIFIER_ARTICLES',        0x02);
define ('SUPPRIMER_ARTICLES',       0x04);
define ('MODIFIER_TOUT_ARTICLES',   0x08);
define ('SUPPRIMER_TOUT_ARTICLES',  0x10);
define ('GERER_MEMBRES',            0x20);
define ('GERER_DROITS',             0x40);

$table_name = "groupes";

//define ('ECRIRE_ARTICLE', 0x01); // Nous définissons les constantes de droits
$description = "";
$droits = "";
$nom = "";


// patpack. le nom du groupe doit être unique. Sinon on le jete

if(isset($_POST['description'])) {$description = $_POST['description'];}
 
if(isset($_POST['Nom'])) // Si le formulaire a été validé, on peut effectuer les actions PHP
{
 
        $nom = $_POST['Nom']; // Le nom du groupe

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
        var_dump($droits);
        $nom         = trim($nom);
        $droits      = decbin($droits);
        $description = trim($description);
        var_dump($droits);

 
        /*$request = 'INSERT INTO group(nom, description, rights_group) 
                    VALUES ('.$nom.'", "'.$droits.'", "'.@$description.'")'; */


        /* 2 façons de gerer ces bits
        - mettre les données dans la base sous forme de bit (0100...) en précisant dans la table qu'on stocke du binary
        - stocker en tant que int (comme d'habitude) en le précisant à la base. Pas de diificulté pour gerer derrière
        patpack on peux afficher dans la base en gerant attribut binary dans la base de données 
        il existe un moyen de transformer un nombre en nombre binaire (decbin)
        on peux décaler n'importe quel nombre, quel que soit le format*/
                    
        echo "nom : ". $nom . " droits : " . $droits . "description : " . $description;

        $request5 = 'INSERT INTO groupes (name, description, rights_group) 
                     VALUES ('.$db->quote($nom).','. $db->quote($description).','.$db->quote(@$droits).')';
        $db->exec($request5);
        // '. $db->quote($phone)     .', 
        // NOW() )';
        //$_SESSION['droits'] = $droits;

        /*** formattage 2 : insertion avec pdo::quote qui vas gérer les quotes qui peuvent trainer ***/
        /*$request = 'INSERT INTO member(pseudo, password, civility, firstname, lastname, email, street, zipcode, city, country, phone, time_register) 
                VALUES('. $db->quote($login)     .', 
                       '. $db->quote($password)  .', 
                       '. $db->quote($civility)  .', 
                       '. $db->quote($firstname) .', 
                       '. $db->quote($lastname)  .', 
                       '. $db->quote($email)     .',                       
                       '. $db->quote($street)    .', 
                       '. $db->quote($zipcode)   .', 
                       '. $db->quote($city)      .', 
                       '. $db->quote($country)   .', 
                       '. $db->quote($phone)     .', 
                        NOW() )';*/

        /* voir si il faut vérifier que la requête a bien été exécutée*/
}
require('./views/creationgroupe.phtml');
?>