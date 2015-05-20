<?php

/*** 1) gestion affichage captcha ***/
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

// si il est loggué on récupère son author_id, sinon on l'envoi sur la page de login
$myAuthorId = "";
if (isset($_SESSION["id"])) {
//if (1 == 2) {
    $myAuthorId = $_SESSION["id"];
}

// si pas loggué, on l'envoi sur la page de login
else{
    $redirection = true;
    header('location: ' . './index.php?page=login&redirect=livredor');
}

/*** 2) initialisation des valeurs des champs ***/
$login = "";
$commentaire = "";
$captcha = "";
$table_name = "member";
$redirection = false;
if (isset($_POST['login'])) { $login = $_POST["login"];}
if (isset($_POST['commentaire'])) { $commentaire = $_POST["commentaire"];}
if (isset($_POST['captcha'])) { $captcha = $_POST["captcha"];}

if (isset($_POST['validationLivredor'])) { // patpack. A rajouter sur register.php. regarder aussi la form action
                                    // mettre le session_start pour pouvoir tester le captcha

    /*** 3) vérification du formulaire ***/

    // booléen de vérif
    $champsOK = true;
    $captchaOK = true;

    // tableau des champs obligatoires vides
    $tabVide = array();

    // tableau des champs incorrects
    $badFormat = array();

    // tableau des champs à controler
    $labels = array("login" => "login",
                    "commentaire" => "commentaire",
                    "captcha" => "captcha");

    // vérif 1 : vérif des champs vides
    foreach ($_POST as $champ => $valeur) {
        // vérification des champs vide : Tous les champs obligatoires vides alimenteront le tableau $tabVide
        if ($champ == "login" || $champ == "commentaire" || $champ == "captcha") {
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
    if ($champsOK == true) { // tous les champs obligatoires sont renseignés
        // vérif si le champs login ne contient que des lettres, chiffres, tiret, apostrophes et espaces
        if (isset($_POST['login'])) {

            if (!preg_match("/^[A-Za-z0-9' -]{0,32}$/", $_POST['login'])) {
                // ^ 1er caractère
                // {,} repète 32 fois le test => test tous les caractères
                // [] caractères facultatifs
                // $ fin de ligne
                // tout ceci dois être contenu entre "//"
                // echo "le champ nom comporte des caractères invalides";
                $badFormat[] = "login";
            }
        }

        // vérif si le champs login ne contient que des chiffres et 6 au max
        if (isset($_POST['login'])) {
            if ((strlen($login) > 6)) { //|| (!is_nan($zipcode) )) {
                $badFormat[] = "login";
            }
        }

        // si il y a des champs au mauvais format
        if (sizeof($badFormat) > 0) {
            echo "certains champs contiennent des données invalides. veuillez ressaisir les champs : <br>";
            foreach ($badFormat as $valeur3) {
                echo "{$labels[$valeur3]}<br>";
            }
            $champsOK = false;
        }
    }

    // vérif 3 : le captcha est-il OK?
    if ($champsOK == true) {
        if (isset($_POST['captcha'])) {
            if ($_POST['captcha'] !== $_SESSION['captcha']) {
                $captchaOK = false;
                echo "captcha erroné<br>";
                echo $_POST['captcha']."<br>";
                echo $_SESSION['captcha']."<br>";
            }
        }
    }

    if ($captchaOK == false) {
        $champsOK = false;
    }

    /*** formattage 1 : trim et htmlspecialchars ***/
    if ($champsOK == true) {

        $login = trim($login);
        $commentaire = trim($commentaire);

        if ($champsOK == true)
        {

            /*** formattage 2 : insertion avec pdo::quote qui vas gérer les quotes qui peuvent trainer ***/
            $request = 'INSERT INTO guestbook(content, author_id, time)
                VALUES('. $db->quote($commentaire) .',
                       '. $db->quote($myAuthorId)       .',                
                        NOW() )';

            $db->exec($request);
            echo "Merci pour vos remarques dans notre livre d'or";
        }
    }

}

if ($redirection == false) {
    require('./views/livredor.phtml');
}

?>
<!--

'. $db->quote($_SESSION["id"])       .', 

/*** code pour tester BDD ***/
foreach($_POST as $champ => $valeur) {  echo $champ . ": " . $valeur . "<br>";}
$db = new PDO("mysql:dbname=test;host=127.0.0.1", 'root', 'troiswa');
//$db = new PDO("mysql:dbname=tp_commun;host=127.0.0.1", 'root', 'troiswa');
$requete = "SELECT guestbook.id, guestbook.title, guestbook.author_id, member.id, member.firstname, member.lastname
            FROM  guestbook, member
            where guestbook.author_id = member.id
            and   guestbook.title = 'encore un titre'";
//$requete = "SELECT 'article'.'id', 'article'.'title', 'article'.'content', 'article'.'author_id', 'member'.'id', 'member'.'name'
//FROM article, member"// where 'article'.'author_id' =  'member'.'id';"

$tab = $db->query($requete)->fetchAll(PDO::FETCH_ASSOC);
var_dump($tab);

cas de test :
1) zones vides : (login, commentaire ou captcha) : OK
2) valeurs mal renseignées (captcha erronées) : OK
3) caractères interdits (? dans le login ou dans email): OK
4) vérif trim : mettre des espaces au début/et ou à la fin
5) vérif htmlspecialchars : mettre des < , des > ou même tenter injection sql
6) vérif échappement : mettre des ' ou des ""
7) valeurs mal renseignées (login inexistants dans la base)
8) cas passable

- les messages se voit en haut car mis le require assez tôt. Dans le cas contraire,
la valeur du capcha est changé avant la comparaison et cela ne marche pas


-->
