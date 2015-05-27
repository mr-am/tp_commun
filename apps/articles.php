<?php
// ============== Formulaire Articles

	$message = ''; // Contient les messages d'erreur à afficher
	if (!empty($_POST['action']) AND $_POST['action'] == 'publish_article') // Si le formulaire est validé
	{
		if (!empty($_POST['category']) AND !empty($_POST['title']) AND !empty($_POST['content'])) // Si les champs requis sont remplis
		{
			$author_id = $_SESSION['id'];
			$category = $_POST['category'];
			// Suppression espaces
			$title = trim($_POST['title']);
			$content = trim($_POST['content']);
			// Sécurité
			$title = $db->quote($title);
			$content = $db->quote($content);
			$category = $db->quote($category);
			// INSERT SQL
			$query = 'INSERT INTO article (title, content, author_id, time_create, category) VALUES ('.$title.','.$content.','.$author_id.',NOW(),'.$category.')';
			$db->exec($query);
			$_SESSION['message'] = '<div class="alert alert-success" role="alert">Your article has been successfully published !</div>';
			header('Location: index.php?page=process');
		}
		else
		{
			$message = '<div class="alert alert-danger" role="alert">All fields are required in order to publish.</div>';
		}
	}
	// Requête nombre d'enregistrements
	$select1 = $db->query("SELECT COUNT(*) AS nbRows FROM article")->fetch(PDO::FETCH_ASSOC);
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
	// Requête de sélection pour affichage
	$select2 = $db->query("SELECT article.id, article.title, article.author_id, article.time_create, article.time_update, article.category, member.pseudo FROM article JOIN member ON member.id = article.author_id ORDER BY time_create DESC LIMIT ".$firstRow.','.$itemsPage)->fetchAll(PDO::FETCH_ASSOC);
	function displayLoop($select2)
	{
		foreach ($select2 as $key=>$row)
		{
			if ($row['time_update'] == '0000-00-00 00:00:00')
			{
			$select2[$key]['update'] = '-';
			}
			else
			{
			$select2[$key]['update'] = systeme_date(strtotime($row['time_update']));
			}
			$select2[$key]['create'] = systeme_date(strtotime($row['time_create']));
		}
		foreach ($select2 as $row)
		{
			echo '<tr>
			<td><a href="index.php?page=article-view&amp;id='.$row['id'].'">'.strip_tags($row['title']).'</a></td>
			<td>'.$row['pseudo'].'</td>
			<td>'.$row['create'].'</td>
			<td>'.$row['update'].'</td>
			<td>'.$row['category'].'</td>
			</tr>';
		}
	}
	require('./views/articles.phtml');
?>