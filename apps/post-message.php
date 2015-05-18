<!-- inclusion de functions.php et connexion à la base de données MYSQL -->
<?php
session_start();
include('functions.php');
$db = db_connect();
?>




<!-- On vérifie que l'utilisateur est connecté et que la zone de texte n'est pas vide. 
Si l'utilisateur n'est pas connecté, on renvoie l'erreur. 
Dans le cas contraire, on teste la zone de texte. Si elle est vide, on renvoie une nouvelle erreur, sinon, on continue ! 
On vérifie ensuite la similitude du nouveau message avec le dernier message de l'utilisateur. Si les deux messages sont trop ressemblants, alors on affiche une erreur. 
On vérifie enfin que le dernier message n'est pas trop récent pour éviter les spans. -->
<?php
if(user_verified()) {
	if(isset($_POST['message']) AND !empty($_POST['message'])) {	
		/* On teste si le message ne contient qu'un ou plusieurs points et
		qu'un ou plusieurs espaces, ou s'il est vide. 
			^ -> début de la chaine - $ -> fin de la chaine
			[-. ] -> espace, rien ou point 
			+ -> une ou plusieurs fois
		Si c'est le cas, alors on envoie pas le message */
		if(!preg_match("#^[-. ]+$#", $_POST['message'])) {	
			$query = $db->prepare("SELECT * FROM chat_messages WHERE message_user = :user ORDER BY message_time DESC LIMIT 0,1");
			$query->execute(array(
				'user' => $_SESSION['id']
			));
			$count = $query->rowCount();
			$data = $query->fetch();
			// Vérification de la similitude
			if($count != 0)
				similar_text($data['message_text'], $_POST['message'], $percent);

			if($percent < 80) {
				// Vérification de la date du dernier message.
				if(time()-5 >= $data['message_time']) {

					// A placer à l'intérieur du if(time()-5 >= $data['message_time'])

					$insert = $db->prepare('
					    INSERT INTO chat_messages (message_id, message_user, message_time, message_text) 
					    VALUES(:id, :user, :time, :text)
					');
					$insert->execute(array(
					    'id' => '',
					    'user' => $_SESSION['id'],
					    'time' => time(),
					    'text' => $_POST['message']
					));
					echo true;

				} else
					echo 'Votre dernier message est trop récent. Baissez le rythme :D';	
			} else
				echo 'Votre dernier message est très similaire.';	
		} else
			echo 'Votre message est vide.';	
	} else
		echo 'Votre message est vide.';	
} else
	echo 'Vous devez être connecté.';	
?>



