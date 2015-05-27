<?php
// ============== Formulaire livre d'or

	$message = ''; // Contient les messages d'erreur à afficher
	if (!empty($_POST['action']) AND $_POST['action'] == 'publish_guestbook') // Si le formulaire est validé
	{
		if ( !empty($_POST['content'])) // Si les champs requis sont remplis
		{
			$author_id = $_SESSION['id'];

			// Suppression espaces
			$content = trim($_POST['content']);

			// Sécurité
			$content = $db->quote($content);

			// INSERT SQL
			$query = 'INSERT INTO guestbook (content, author_id, time) VALUES ('.$content.','.$author_id.',NOW())';
			$db->exec($query);
			$_SESSION['message'] = '<div class="alert alert-success" role="alert">Your comment has been successfully published !</div>';
			header('Location: index.php?page=process');
		}
		else
		{
			$message = '<div class="alert alert-danger" role="alert">All fields are required in order to publish.</div>';
		}
	}

	// Requête nombre d'enregistrements
	$select1 = $db->query("SELECT COUNT(*) AS nbRows FROM guestbook")->fetch(PDO::FETCH_ASSOC);
	// On calcule le nombre de pages à créer
	$itemsPage = 5;
	$nbPage = ceil($select1['nbRows'] / $itemsPage);
	// Vérifie que la page demandée existe sinon choix première ou dernière page
	if (isset($_GET['pagin']))
	{
		$pagin = $_GET['pagin'];
		if ($pagin > $nbPage)
		{
		$pagin = $nbPage;
		}
		if ($pagin < 1)
		{
		$pagin = 1;
		}
	}
	else
	{
		$pagin = 1;
	}
	// On calcule le numéro de la première ligne qu'on prend pour le LIMIT de MySQL LIMIT".$firstRow.','.$itemsPage
	$firstRow = ($pagin - 1) * $itemsPage;

	// Requête de sélection pour affichage <td>'.$row['pseudo'].'</td>
	$select2 = $db->query("SELECT guestbook.id, guestbook.author_id, guestbook.content, guestbook.time, member.pseudo FROM guestbook JOIN member ON member.id = guestbook.author_id ORDER BY time DESC LIMIT ".$firstRow.','.$itemsPage)->fetchAll(PDO::FETCH_ASSOC);
	function displayLoop($select2)
	{
		foreach ($select2 as $key=>$row)
		{
			$select2[$key]['create'] = systeme_date(strtotime($row['time']));
		}
		foreach ($select2 as $row)
		{
			echo '<tr><td><a href="index.php?page=guestbook-view&amp;id='.$row['id'].'">'.strip_tags($row['pseudo']).'</a></td><td>'.$row['create'] .'</td>';
			if (strlen($row['content'])> 50)
			{   
				$row['content'] = limite(50, $row['content']);
			}
			echo '<td>'.$row['content'].'</td></tr>';
		}
	}
	require('./views/guestbook.phtml');

	$max_caracteres=50;
$texte="Ce texte doit être affiché mais il est trop long, donc il va falloir le tronquer.";
// Test si la longueur du texte dépasse la limite
if (strlen($texte)>$max_caracteres)
{
    // Séléction du maximum de caractères
    $texte = substr($texte, 0, $max_caracteres);
    // Récupération de la position du dernier espace (afin déviter de tronquer un mot)
    $position_espace = strrpos($texte, " ");
    $texte = substr($texte, 0, $position_espace);
    // Ajout des "..."
    $texte = $texte."...";
}

?>

