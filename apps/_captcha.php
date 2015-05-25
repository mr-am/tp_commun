<?php
/** Pascal : doublon avec captcha.php **/

	/*function motHasard($n)
	{
	    // Séquence aléatoire de chiffres et de lettres
	    // uniqid gère un isentifiant unique
	    return substr(md5(uniqid()),0,$n);
	}*/

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
?>