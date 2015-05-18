<!-- connexion base de données -->
<?php
	function db_connect() 
	{
		// définition des variables de connexion à la base de données	
		try 
		{
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			// INFORMATIONS DE CONNEXION
			$host = 	'127.0.0.1';
			$dbname = 	'tp_commun';
			$user = 	'root';
			$password = 'troiswa';
			// FIN DES DONNEES
			
			$db = new PDO('mysql:host='.$host.';dbname='.$dbname.'', $user, $password, $pdo_options);
			return $db;
		}

		catch (Exception $e) 
		{
			die('Erreur de connexion : ' . $e->getMessage());
		}
	}
?>

<!-- Test de la connection de l'utilisateur -->
<?php
	function user_verified() 
	{
		return isset($_SESSION['id']);
	}
?>


<!-- Détection des liens du tchat -->
<?php
	function urllink($content='') 
	{
		$content = preg_replace('#(((https?://)|(w{3}\.))+[a-zA-Z0-9&;\#\.\?=_/-]+\.([a-z]{2,4})([a-zA-Z0-9&;\#\.\?=_/-]+))#i', '<a href="$0" target="_blank">$0</a>', $content);
		// Si on capte un lien tel que www.test.com, il faut rajouter le http://
		if(preg_match('#<a href="www\.(.+)" target="_blank">(.+)<\/a>#i', $content)) 
		{
			$content = preg_replace('#<a href="www\.(.+)" target="_blank">(.+)<\/a>#i', '<a href="http://www.$1" target="_blank">www.$1</a>', $content);
			//preg_replace('#<a href="www\.(.+)">#i', '<a href="http://$0">$0</a>', $content);
		}

		$content = stripslashes($content);
		return $content;
	}
?>