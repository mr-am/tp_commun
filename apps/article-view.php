<?php
// Requête de sélection pour affichage
	$select = $db->query("SELECT title, content, author_id, time_create, time_update, category FROM article WHERE id = ".$_GET['id'])->fetchAll(PDO::FETCH_ASSOC);
	foreach ($select as $row)
	{
		if ($row['time_update'] == '0000-00-00 00:00:00')
		{
			$update = '-';
		}
		else
		{
			$update = systeme_date(strtotime($row['time_update']));
		}
		$title = $row['title'];
		$keepTags = '<h1><h2><h3><h4><h5><h6><p><ul><ol><li><strong><em><br>';
		$content = $row['content'],$keepTags;
		$author = $row['author_id'];
		$create = systeme_date(strtotime($row['time_create']));
		$category = $row['category'];
	}
	require('./views/article-view.phtml');
?>