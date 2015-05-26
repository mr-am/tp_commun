 <?php

 	
 	
 	//	On se connecte à la base de données (phpMyAdmin)
 	$db = new PDO("mysql:dbname=chat;host=127.0.0.1", 'root', 'troiswa');

 	//	On récupère les données insérées dans le champs texte. !empty($_POST['chat'] sert à vérifier que la variable n'est pas vide, nulle ou non définie.
	if(isset($_POST['chat']) && !empty($_POST['chat']))
	{
		// exec permet de récupérer les données.
		$db->exec("INSERT INTO chat SET author_id=1, content=".$db->quote($_POST['chat'])."");
		// OU   --->   $db->exec("INSERT INTO chat (author_id, content) VALUES ('1',".$db->quote($_POST['chat']).")");

		// Supprime la première donnée dans la table chat.
		// $db->exec("DELETE FROM chat ORDER BY id ASC LIMIT 1");

		// query permet de récupérer les données.
		$query_chat = $db->query('SELECT author_id, content, time FROM chat ORDER BY time DESC LIMIT 0, 10');

		$lst_post = $query_chat->fetchAll();
		$lst_post = array_reverse($lst_post);	
		foreach($lst_post as $post){
			echo "<div class='chat-content'>".htmlentities($post['content'])."</div>";
			echo "<div class='chat-time'>".$post['time']."</div>";
		}
	}



// o-o-o-o-o-o-o-o-o- AUTRE FAÇON DE BOUCLER -o-o-o-o-o-o-o-o-o
/*
		$query_chat = $query_chat->fetchAll();
		foreach($query_chat as $post){
			echo $post['content']."<br>";
		}
		$query_chat = $query_chat->fetchAll();
		$i=0;
		while($i < sizeof($query_chat)){
			echo $query_chat[$i]['content']."<br>";
			$i++;
		}
*/
/*
		$query_chat = $query_chat->fetchAll();
		for($i=0;$i < sizeof($query_chat); $i++){
			echo "<div>".$query_chat[$i]['content']."</div>";
		}		
*/

	//	On créé le formulaire dans le dossier php pour éviter d'être rediriger sur une autre page (pas pratique du tout.)
 	// echo('<form method="post" action="chat.php" enctype="multipart/form-data"><input type="text" name="chat" maxlength="512" required></form>');
?>