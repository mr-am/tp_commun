<?php


$email = '';
$city = '';
$street = '';
$code_postal ='';
$phone = '';
$pays ='';

if (isset($_GET["id"]))
{
	$identifiant  = $_GET["id"];
	$sql = "SELECT * FROM member WHERE id='".intval($identifiant)."'";
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


	if (isset($_POST['validation']))
	{

		$emailmodif = $_POST["formemail"] ; // l'email du formulaire devient la variable $email
		$phonemodif = $_POST["formphone"] ; // l'email du formulaire devient la variable $email
		$citymodif = $_POST["formcity"] ; // l'email du formulaire devient la variable $email
		$streetmodif = $_POST["formstreet"] ; // l'email du formulaire devient la variable $email
		$zipmodif = $_POST["formzip"] ; // l'email du formulaire devient la variable $email
		$paysmodif = $_POST["formpays"] ;
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

		var_dump($tab_des_modifs);

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

}

else
{
	echo "<p>L'identifiant en question n'existe pas !</p>";
	require('./views/config.phtml');
}

  		/*
  		if ($email!=$emailmodif)
		{
			echo "<div class='col-md-12'><p class='ok'>L'adresse email a été modifiée en ".$emailmodif." !</p></div>";  // message de validation
		}

		if ($phone!=$phonemodif)
		{
			echo "<div class='col-md-12'><p class='ok'>Le numéro de téléphone a été modifié en ".$phonemodif." !</p></div>"; // message de validation
		}

		if ($city!=$citymodif)
		{
			echo "<div class='col-md-12'><p class='ok'>La ville a été modifiée en ".$citymodif." !</p></div>"; // message de validation
		}

		if ($street!=$streetmodif)
		{
			echo "<div class='col-md-12'><p class='ok'>La rue a été modifiée en ".$streetmodif." !</p></div>"; // message de validation
		}

		if ($code_postal!=$zipmodif)
		{
			echo "<div class='col-md-12'><p class='ok'>Le code postal a été modifié en ".$zipmodif." !</p></div>"; // message de validation
		}

		if ($pays!=$paysmodif)
		{
			echo "<div class='col-md-12'><p class='ok'>Le pays a été modifié en ".$paysmodif." !</p></div>"; // message de validation
		}
		*/
?>

