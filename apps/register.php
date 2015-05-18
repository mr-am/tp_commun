<?php

function motHasard($n)
{
    $voyelles = array('a', 'e', 'i', 'o', 'u', 'ou', 'io','ou','ai');
    $consonnes = array('b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm','n', 'p', 'r', 's', 't', 'v', 'w',
            'br','bl', 'cr','ch', 'dr', 'fr', 'dr', 'fr', 'fl', 'gr','gl','pr','pl','ps','st','tr','vr');
                            
    $mot = '';
    $nv = count($voyelles)-1;
    $nc = count($consonnes)-1;
    for($i = 0; $i < round($n/2); ++$i)
    {
        $mot .= $voyelles[mt_rand(0,$nv)];
        $mot .= $consonnes[mt_rand(0,$nc)];
    }


    return substr($mot,0,$n); // Comme certaines syllabes font plus d'un caractère, on est obligé de couper pour avoir le nombre exact de caractères.
}

function captcha()
	{
		// récup un mot de 6 chiffres ou lettres et mets cette variable en variable de session
	    $mot = motHasard(6);
	    $_SESSION['captcha'] = $mot;
	    return $mot;
	}

/*** Initialisation des champs ***/
if (isset($_POST['login'])) { $login = $_POST["login"]; }
else { $login = ""; }

if (isset($_POST['password'])) { $password = $_POST["password"]; }
else { $password = ""; } 

if (isset($_POST['choixCivilite'])) { $choixCivilite = $_POST["choixCivilite"]; }
else { $choixCivilite = ""; }

if (isset($_POST['prenom'])) { $prenom = $_POST["prenom"]; }
else { $prenom = ""; } 

if (isset($_POST['nom'])) { $nom = $_POST["nom"]; }
else { $nom = ""; } 

if (isset($_POST['email'])) { $email = $_POST["email"]; }
else { $email = ""; }

if (isset($_POST['street'])) { $street = $_POST["street"]; }
else { $street = ""; }

if (isset($_POST['zipcode'])) { $zipcode = $_POST["zipcode"]; }
else { $zipcode = ""; }

if (isset($_POST['city'])) { $city = $_POST["city"]; }
else { $city = ""; }

if (isset($_POST['country'])) { $country = $_POST["country"]; }
else { $country = ""; }

if (isset($_POST['phone'])) { $phone = $_POST["phone"]; }
else { $phone = ""; }

if (isset($_POST['captcha'])) { $captcha = $_POST["captcha"]; }
else { $captcha = ""; }


// booléen de vérif
$champsOK = true;

$hidden = "";

// tableau des champs obligatoires vides
$tabVide = array();

// tableau des champs incorrects
$badFormat = array();

// tableau des champs à controler
$labels = array("login" => "login",
                "password" => "password",
                "civility" => "civility",
                "firstname" => "firstname",
                "lastname" => "lastname",
                "email" => "email",
                "street" => "street",
                "zipcode" => "zipcode",
                "city" => "city",
                "country" => "country",
                "phone" => "phone",                
                "captcha" => "captcha");

/*** verif 1 : champs vides ***/
foreach($_POST as $champ => $valeur) {
     //echo $champ . ": " . $valeur . "<br>";

    // vérification des champs vide
    // Tous les champs obligatoires vides alimenteront le tableau $tabVide

    if ($champ == "login" || $champ == "password" || $champ == "civility" || $champ == "firstname" || $champ == "lastname" || $champ == "captcha") {
        if ($valeur == "") {
            $tabVide[] = $champ;
        }
    }
}

// si il y a des champs obligatoires vides
if(sizeof($tabVide) > 0) {
    echo "tous les champs obligatoires n'ont pas été saisie. veuillez saisir : <br>";
    foreach ($tabVide as $valeur2) {
        echo "{$labels[$valeur2]}<br>";
    }
    $champsOK = false;
}

/*** verif 2 : valeurs incorrextes ***/
if ($champsOK == true)
{

    // vérif si le champs login ne contient que des lettres et des chiffres
        if (!preg_match("/^[A-Za-z0-9]{1,32}$/", $_POST['login'])) {
            $badFormat[] = "login";
        }
    }

    // pas de vérfif pour le password, ni l'email

    // vérif si le champs prénom ne contient que des lettres, tiret, apostrophes et espaces
    if (isset($_POST['nom'])) {
        if (!preg_match("/^[A-Za-z' -]{1,32}$/", $_POST['nom'])) {
            $badFormat[] = "nom";
        }
    }

    // vérif si le champs prénom ne contient que des lettres, tiret, apostrophes et espaces
    if (isset($_POST['prenom'])) {
        if (!preg_match("/^[A-Za-z' -]{1,32}$/", $_POST['prenom'])) {
            $badFormat[] = "prenom";
        }
    }

    // vérif si le champs street ne contient que des lettres, des chiffres, tiret, apostrophes et espaces
    if (isset($_POST['street'])) {
        if (!preg_match("/^[A-Za-z0-9' -]{1,64}$/", $_POST['street'])) {
            $badFormat[] = "street";
        }
    }

        // vérif si le champs zipcode ne contient que des chiffres et 5 au max
    if (isset($_POST['zipcode'])) {
        if ((length($_POST['zipcode']) > 5) || (!is_nan($_POST['zipcode']) ))
        {
            $badFormat[] = "zipcode";
        }
    }

    // vérif si le champs city ne contient que des lettres, tiret, apostrophes et espaces
    if (isset($_POST['city'])) {
        if (!preg_match("/^[A-Za-z' -]{1,32}$/", $_POST['city'])) {
            $badFormat[] = "city";
        }
    }

    // vérif si le champs country ne contient que des lettres, tiret, apostrophes et espaces
    if (isset($_POST['country'])) {
        if (!preg_match("/^[A-Za-z' -]{1,32}$/", $_POST['country'])) {
            $badFormat[] = "country";
        }
    }

    // vérif si le champs phone ne contient que des chiffres, des espaces, des points et des tirets
    if (isset($_POST['phone'])) {
        if (!preg_match("/^[0-9. -]{1,20$/", $_POST['phone'])) {
            $badFormat[] = "phone";
        }
    }

    // si il y a des champs au mauvais format
    if (sizeof($badFormat) > 0) {
        echo "certains champs contiennent des données invalides. veuillez ressaisir les champs : <br>";
        foreach ($badFormat as $valeur3) {
            echo "{$labels[$valeur3]}<br>";
        }
        $champsOK = false;
        // réafficher la page livreor.php
    }

}

/*** verif 3 : captcha ***/
if ($champsOK == true) {
    if (isset($_POST['captcha'])) {
        if ($_POST['captcha'] !== $_SESSION['captcha']) {
            $champsOK = false;
            echo "captcha erroné<br>";
        }
    }
}

/*** formattage 1 : trim et htmlspecialchars ***/

$login = trim(htmlspecialchars($_POST['login'] ));

/*** formattage 2 pdo:quote : virer les '***/

/***  insertion en base de données ***/


require('./views/register.phtml');
?>