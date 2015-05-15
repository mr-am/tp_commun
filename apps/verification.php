<?php
 session_start();

// booléen de vérif
$champsOK = true;

// tableau des champs obligatoires vides
$tabVide = array();

// tableau des champs incorrects
$badFormat = array();

// tableau des champs à controler
$labels = array("prenom" => "prenom",
                "nom" => "nom",
                "email" => "email",
                "commentaire" => "commentaire",
                "captcha" => "captcha");

foreach($_POST as $champ => $valeur) {
    // echo $champ . ": " . $valeur . "<br>";

    // vérification des champs vide
    // Tous les champs obligatoires vides alimenteront le tableau $tabVide

    if ($champ == "nom" || $champ == "prenom" || $champ == "commentaire" || $champ == "captcha") {
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
    // réafficher la page livreor.php
}


if ($champsOK == true) { // tous les champs obligatoires sont renseignés
    // vérif si le champs nom ne contient que des lettres, tiret, apostrophes et espaces
    if (isset($_POST['nom'])) {
        if (!preg_match("/^[A-Za-z' -]{1,37}$/", $_POST['nom'])) {
            // ^ 1er caractère
            // {,} repète 37 fois le test => test tous les caractères
            // [] caractères facultatifs
            // $ fin de ligne
            // tout ceci dois être contenu entre "//"
            // echo "le champ nom comporte des caractères invalides";
            $badFormat[] = "nom";
        }
    }

    // vérif si le champs prénom ne contient que des lettres, tiret, apostrophes et espaces
    if (isset($_POST['prenom'])) {
        if (!preg_match("/^[A-Za-z' -]{1,37}$/", $_POST['prenom'])) {
            //echo "le champ nom comporte des caractères invalides";
            $badFormat[] = "prenom";
        }
    }

    // pas besoin de tester l'email car on a choisis un champ input type = mail

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

if ($champsOK == true) {
    if (isset($_POST['captcha'])) {
        if ($_POST['captcha'] !== $_SESSION['captcha']) {
            $champsOK = false;
            echo "captcha erroné<br>";
        }
    }
}

if ($champsOK == true) {
        echo "tout est Ok, insertion en base de données";
        //echo "<meta http-equiv='refresh' content='0; url=livreor.php?nom=nom&prenom=prenom&email=email&commentaire=commentaire&captcha=captcha'>";
        // toutes les infos sont corrects
        // formattage pour mise en base :
        //    - on récupère les données dans $_POST et on rajouteras la date
        //    - nettoyer les données : trim pour virer les espaces avant et après, strip_tags() ou html specialchars()
        //    - échapper les ' et les "" lors de l'insertion dans la base avec mysql_real_escape_string()
        // mise en base
        // réaffichage page livreor.php avec un message de remerciement dans la zone message

}

?>
<!--

if (isset($_POST['captcha'])) {
if ($_POST['captcha'] !== $_SESSION['captcha']) {
echo '<br> Code incorrect! fuck. renvoyer sur la page livreor.phtml avec un message en dessous pour dire que incorrect';
//$_SESSION['captcha'] = "KO";
//$_POST['hidden'] = "toto";
//header("Location: livreor.phtml?hidden=KO");
//echo ("<br>".$_POST['captcha']);
echo("<br>" . $_SESSION['captcha']);


} else {
echo 'code correct! enregistrer dans la base et message de confirmation';
//$_SESSION['captcha'] = "OK";
//header("Location: livreor.phtml?hidden=OK");
}
}
-->