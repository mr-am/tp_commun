<!-- inclusion de functions.php et connexion à la base de données MYSQL -->
<?php
	session_start();
	include('functions.php');
	$db = db_connect();
?>



<!--  On ajoute une condition pour vérifier que le visiteur est connecté. 
On ajoute ensuite une requête SQL pour modifier le statut de l'utilisateur. -->
<?php
	if(user_verified())
	{
		$insert = $db->prepare('
			UPDATE chat_online SET online_status = :status WHERE online_user = :user
		');
		$insert->execute(array(
			'status' => $_POST['status'],
			'user' => $_SESSION['id']		
		));
	}
?>