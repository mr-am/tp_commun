<?php

$table_name = "member";
//$next_program = $_SERVER['HTTP_REFERER'];
$redirection2 = false; // patpack. récup le program d'origine avec un champ caché pour savoir ou l'envoyer

$login = "";
$password = "";
if (isset($_POST['login'])) { $login = $_POST["login"];}
if (isset($_POST['password'])) { $password = $_POST["password"];}

if (isset($_POST['validation'])) { 

	// booléen de vérif
    $champsOK = true;

    // tableau des champs obligatoires vides
    $tabVide = array();

    // tableau des champs incorrects
    $badFormat = array();

    // tableau des champs à controler
    $labels = array("login" => "login",
                    "password" => "password");

    // vérif 1 : vérif des champs vides
    foreach ($_POST as $champ => $valeur) {
        // vérification des champs vide : Tous les champs obligatoires vides alimenteront le tableau $tabVide
        if ($champ == "login" || $champ == "password") {
            if ($valeur == "") {
                $tabVide[] = $champ;
            }
        }
    }

    // si il y a des champs obligatoires vides
    if (sizeof($tabVide) > 0) {
        echo "tous les champs obligatoires n'ont pas été saisie. veuillez saisir : <br>";
        foreach ($tabVide as $valeur2) {
            echo "{$labels[$valeur2]}<br>";
        }
        $champsOK = false;
    }

    // vérif 2 : vérif du format des champs
    if ($champsOK == true) { 

        if (isset($_POST['login'])) {
            if (!preg_match("/^[A-Za-z0-9' -]{1,32}$/", $_POST['login'])) {
                $badFormat[] = "login";
            }
        }

        if (sizeof($badFormat) > 0) {
            echo "certains champs contiennent des données invalides. veuillez ressaisir les champs : <br>";
            foreach ($badFormat as $valeur3) {
                echo "{$labels[$valeur3]}<br>";
            }
            $champsOK = false;
        }
    }

    if ($champsOK == true) { 

		// recherche le login dans la table membre
	    $requestLogin = "SELECT id as myid, pseudo, password as mypassword FROM $table_name WHERE pseudo = '$login'";
	   
	    // mettre le résultat de la requête dans une variable de façon à pouvoir compter le nombre de ligne 
	    // => un login dois être unique
	    if ($result = $db->query($requestLogin)) {

	    	if ($result->rowCount()  == 0) 
	    	{ 
	    		echo "login inexact"; 
	    	}
	    	else if ($result->rowCount() > 1) 
	    	{ 
	    		echo "plusieurs login idendiques existent. Cas théorique impossible"; 
	    	} 

	    	// si on trouve un seul enreg, on vérifie que le password correspond
	    	else if ($result->rowCount() == 1) 
	    		{ 
    			// si on ne veux pas faire une 2ème requête
	    		// $result contient des tas d'infos renvoyées par mysql. ce n'est pas exploitable
	    		// on passe donc par un fetch pour renvoyer une ligne (toute si dans une boucle) 
	    		// ou un fetchall pour les avoir toutes	
    			$resultExploitable = $result->fetch();
    			$mypassword = $resultExploitable["mypassword"];
    			$myid = $resultExploitable["myid"];
    			//echo "$password : " .$password . "<br>";
    			//echo "md5($password) : " .md5($password) . "<br>";
    			//echo "$mypassword : " .$mypassword . "<br>";

   		        /*$requestPassword = "SELECT pseudo FROM $table_name WHERE pseudo = '$login' AND password = '$password' ";*/
		        if ( $mypassword == md5($password))  // md5 car par défaut un password est formaté avec ceci
		        {
			       $_SESSION["auth"]= true;
			       $_SESSION["login"] = $login;
			       $_SESSION["id"] = $myid;


			       	/*if(isset($_GET['redirect'])){
			       		echo "toto1";
				        header('location: ?page=' . $_GET['redirect']); // avant appel à du html patpack a voir */
				        $redirection2 = true;
				        require('apps/livredor.php');
				        
		       	}
			        // echo "$next_program";
			        //require('apps/livredor.php');
		           
		         else 
	         	{
	         		echo "mot de passe inexact"; 
	         	}
		    } 
		}			    
	    else{ echo "echec de la requête" . $requestLogin ; } 
	}

}
if ($redirection2 == false) {
	require('./views/login.phtml');
}
?>

