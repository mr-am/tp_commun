<?php


$email = '';
$city = '';
$street = '';
$code_postal ='';
$phone = '';
$pays ='';

if (isset($_GET["id"]))
{
	$identifiant  = intval($_GET["id"]);
	$sql = "SELECT * FROM member WHERE id='".$identifiant."'";
	//exécution de la requête:
	$utilisateur = $db->query($sql)->fetch();
	$email = $utilisateur['email'];
	$city = $utilisateur['city'];
	$street = $utilisateur['street'];
	$code_postal = $utilisateur['zipcode'];
	$phone = $utilisateur['phone'];
	$pays = $utilisateur['country'];
	$pass = $utilisateur['password'];



	if (isset($_POST['validation']))
	{

   		$phonemodif = $_POST["formphone"]; // le tél du formulaire devient la variable $phonemodif
   	    $emailmodif = $_POST["formemail"] ; // l'email du formulaire devient la variable $emailmodif
        $citymodif = $_POST["formcity"] ; // la ville du formulaire devient la variable $citymodif
        $streetmodif = $_POST["formstreet"] ; // l'adresse du formulaire devient la variable $streetmodif
        $zipmodif = $_POST["formzip"] ; // le code postale du formulaire devient la variable $zipmodif
        $paysmodif = $_POST["formpays"] ; // le pays du formulaire devient la variable $paysmodif

		// dans la table member, le champ email est remplacé par la variable $email où le champ id vaut la variable $identifiant
		$sql = "UPDATE member SET email = '".$emailmodif."', phone = '".$phonemodif."', city = '".$citymodif."', street = '".$streetmodif."', zipcode = '".$zipmodif."', country = '".$paysmodif."'  WHERE id = '".$identifiant."' " ; 
		//exécution de la requête SQL:
	  	$requete = $db->exec($sql);

		$tab_des_modifs = array();

		if ($email!=$emailmodif)
		{
			$tab_des_modifs[] = $emailmodif;
		}
		if ($phone!=$phonemodif)
		{
			$tab_des_modifs[] = $phonemodif;
		}
		if ($city!=$citymodif)
		{
			$tab_des_modifs[] = $citymodif;
		}
		if ($street!=$streetmodif)
		{
			$tab_des_modifs[] = $streetmodif;
		}
		if ($code_postal!=$zipmodif)
		{
			$tab_des_modifs[] = $zipmodif;
		}
		if ($pays!=$paysmodif)
		{
			$tab_des_modifs[] = $paysmodif;
		}

		$i=0;
		while (isset($tab_des_modifs[$i]))
		{
			echo "<div class='col-md-12'><p class='ok'>".$tab_des_modifs[$i]." a été modifié dans vos informations personnelles !</p></div>";
			$i++;
		}
	}



/*-------------------------------
Modification du mot de passe
---------------------------------*/


	if (isset($_POST['validationmdp']))
	{
		$amdp=$_POST['ancienpassword'];
		$sql = "SELECT password FROM member WHERE id = '".$identifiant."' ";
		$utilisateur = $db->query($sql)->fetch();

		if ($amdp==$utilisateur['password'])
		{
			$nmdp=$_POST['nouveaupassword'];
			$vmdp=$_POST['confirmpassword'];
			if ($nmdp==$vmdp)
			{
				$sql = "UPDATE member SET password = '".$nmdp."' WHERE id = '".$identifiant."' " ;
				//exécution de la requête SQL:
		  		$requete = $db->exec($sql);
		  		echo "<div class='col-md-12'><p class='ok'>Votre mot de passe a été modifié !</p></div>";
			}
			else
			{
				echo "<div class='col-md-12'><p class='no'>L'ancien mot de passe et le nouveau mot de passe ne sont pas identiques !</p></div>";
			}
		}
		else
		{
			echo "<div class='col-md-12'><p class='no'>L'ancien mot de passe est incorrect !</p></div>";
		}
	}

	// Réactualisation des champs du formulaire
	$sql = "SELECT * FROM member WHERE id='".$identifiant."'";
	//exécution de la requête:
	$utilisateur = $db->query($sql)->fetch();
	$email = $utilisateur['email'];
	$city = $utilisateur['city'];
	$street = $utilisateur['street'];
	$code_postal = $utilisateur['zipcode'];
	$phone = $utilisateur['phone'];
	$pays = $utilisateur['country'];
	$pass = $utilisateur['password'];
	require('./views/config.phtml');

}

else
{
	echo "<p class='no'>L'identifiant en question n'existe pas !</p>";
	require('./views/config.phtml');
}



?>

