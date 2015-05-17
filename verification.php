<?php
 session_start(); 



if(isset($_POST['captcha'])) {
    if($_POST['captcha'] !== $_SESSION['captcha']) {
        echo 'Code incorrect! fuck. renvoyer sur la page livreor.phtml avec un message en dessous pour dire que incorrect';
        $_SESSION['captcha'] = "KO";
        $_POST['hidden'] = "toto";
        header("Location: livreor.phtml?hidden=KO");


    }
    else {
        echo 'code correct! enregistrer dans la base et message de confirmation';
        $_SESSION['captcha'] = "OK";
        header("Location: livreor.phtml?hidden=OK");
    }
}

?>
