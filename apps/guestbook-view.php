<?php
// Requête de sélection pour affichage
	$select = $db->query("SELECT content, author_id, time FROM guestbook WHERE id = ".$_GET['id'])->fetchAll(PDO::FETCH_ASSOC);
	foreach ($select as $row)
	{

		$keepTags = '<h1><h2><h3><h4><h5><h6><p><ul><ol><li><strong><em><br>';
		$content = $row['content'],$keepTags;
		$author_id = $row['author_id'];
		$create = systeme_date(strtotime($row['time']));
	}
	require('./views/guestbook-view.phtml');
?>