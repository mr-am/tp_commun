<?php
/** Pascal : fonction qui doublonne avec _captcha.php ET captcha.php, encore... **/

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

if (isset($_POST['civility'])) { $civility = $_POST["civility"]; }
else { $civility = ""; }

if (isset($_POST['firstname'])) { $firstname = $_POST["firstname"]; }
else { $firstname = ""; } 

if (isset($_POST['lastname'])) { $lastname = $_POST["lastname"]; }
else { $lastname = ""; } 

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

if (isset($_POST['validation'])) { 

    // booléen de vérif
    $champsOK = true;
    $captchaOK = true;

    $table_name = "member";

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
         //echo $champ . ": " . $valeur . "fin<br>";

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
            if (!preg_match("/^[A-Za-z0-9]{0,32}$/", $login )) {
                $badFormat[] = "login";
            }

        // pas de vérif pour le password, ni l'email, ni la civilité

        // vérif si le champs prénom ne contient que des lettres, tiret, apostrophes et espaces
        if (isset($_POST['nom'])) {
            if (!preg_match("/^[A-Za-z' -]{0,32}$/", $nom )) {
                $badFormat[] = "nom";
            }
        }

        // vérif si le champs prénom ne contient que des lettres, tiret, apostrophes et espaces
        if (isset($_POST['prenom'])) {
            if (!preg_match("/^[A-Za-z' -]{0,32}$/", $prenom )) {
                $badFormat[] = "prenom";
            }
        }

        // vérif si le champs street ne contient que des lettres, des chiffres, tiret, apostrophes et espaces
        if (isset($_POST['street'])) {
            if (!preg_match("/^[A-Za-z0-9' -]{0,64}$/", $street )) {
                $badFormat[] = "rue";
            }
        }

            // vérif si le champs zipcode ne contient que des chiffres et 5 au max
        if (isset($_POST['zipcode'])) {
            if ((strlen($zipcode) > 5)) { //|| (!is_nan($zipcode) )) {
                $badFormat[] = "code postal";
            }
        }

        // vérif si le champs city ne contient que des lettres, tiret, apostrophes et espaces
        if (isset($_POST['city'])) {
            if (!preg_match("/^[A-Za-z' -]{0,32}$/", $city )) {
                $badFormat[] = "ville";
            }
        }

        // vérif si le champs country ne contient que des lettres, tiret, apostrophes et espaces
        if (isset($_POST['country'])) {
            if (!preg_match("/^[A-Za-z' -]{0,32}$/", $country )) {
                $badFormat[] = "pays";
            }
        }

        // vérif si le champs phone ne contient que des chiffres, des espaces, des points et des tirets
        if (isset($_POST['phone'])) {
            if (!preg_match("/^[0-9. -]{0,20}$/", $phone )) {
                $badFormat[] = "téléphone";
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
                    echo $_POST['captcha']."<br>";
                    echo $_SESSION['captcha']."<br>";
                }
            }
        }

        if ($captchaOK == false) {
            $champsOK = false;
        }

        /*** verif 4 interdiction de choisir pseudo dejà existant ***/
        if ($champsOK == true) { 

            // recherche le login dans la table membre
            $requestLogin = "SELECT pseudo as mypseudo FROM $table_name WHERE pseudo = '$login'";

            if ($result = $db->query($requestLogin)) {

                if ($result->rowCount() > 0) 
                {
                    $champsOK = false;
                    echo "Ce pseudo existe déjà, veuillez en choisir un autre";
                }
            }
            else{ echo "echec de la requête" . $requestLogin ; } 
        }


    /*** formattage 1 : trim et htmlspecialchars ***/
    if ($champsOK == true) {

    // pas besoin des htmlspecialchars en entrée, on préfère garder les choses tells que renseignées
        // plus tard, en lecture, on pourras choisir entre l'utiliser ou non. le mettre au niveau de l'input
        $login = trim($login);
        $password = trim(md5($password)); //permet de crypter le mdp
        $civility = trim($civility); 
        $firstname = trim($firstname);
        $lastname = trim($lastname); 
        $street = trim($street);
        $zipcode = trim($zipcode);
        $city = trim($city); 
        $country = trim($country);
        $phone = trim($phone); 




    /*** formattage 2 : insertion avec pdo::quote qui vas gérer les quotes qui peuvent trainer ***/
    $request = 'INSERT INTO member(pseudo, password, civility, firstname, lastname, email, street, zipcode, city, country, phone, time_register) 
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
                        NOW() )';
    // faire un strtotime quand on récupère la donnée

    $db->exec($request);

    /*$db->exec('INSERT INTO member(pseudo, password, civility, firstname, lastname, street, zipcode, city, country, phone, time_register) 
                VALUES("moioiuouy", 
                       "monmdp",
                       "M",
                       "myfirstname",
                       "mylastname",
                       "mystreet",
                       10000, 
                       "strasbourg",
                       "france",
                       "0102030405",
                       NOW() 
                       )');*/

    /*** à tester ***/
    // 1) les différentes zones à vide
    // 2) les différentes format autorisés
    // 3) le captcha
    // 4) les champs avec des espaces au début ou à la fin
    // 5) les champs non controlé avec des bizarreries
    // 6) tester longueur des champs
    // 7) page pour mettre à jour les données de la table des membres


    /***  insertion en base de données ***/

    }
}
require('./views/register.phtml');
?>