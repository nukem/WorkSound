<?php

if (! isset ($errorsChecked)) {
	if (! preg_match('.+', $_POST['title']))
		$errors[] = $lang[103];
	if (dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND title = '" . addslashes ($_POST['title']) . "' AND title <> ''"))
		$errors[] = $lang[104];
	$uri = strtolower (preg_replace('[^A-Za-z0-9]+', '-', strip_accents ($_POST['title'])));
	if (! isset ($errors) && dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND uri = '$uri' AND uri <> ''"))
		$errors[] = $lang[105];
	$errorsChecked = true;
} else {

	
	if ($record['position'] != $_POST['position'])
		dbq ("UPDATE {$cfg['db']['prefix']}_structure SET position = position + 1 WHERE position >= {$_POST['position']} ORDER BY position DESC");

	$page_title = '';
	if(isset($_POST['page_title'])){
		$page_title = "page_title = '" . addslashes ($_POST['page_title']) . "', meta_words = '" . addslashes ($_POST['meta_words']) . "', meta_description = '" . addslashes ($_POST['meta_description']) . "',";
	}

	dbq ("UPDATE
	{$cfg['db']['prefix']}_structure,
	{$cfg['db']['prefix']}_featured
	SET
	title = '" . addslashes ($_POST['title']) . "',
	uri = '$uri',
	online = $online,
	sort = '{$_POST['sort']}',
	position = {$_POST['position']},
	modified = '$time',
	viewRights = '$viewRights',
	createRights = '$createRights',
	editRights = '$editRights',
	deleteRights = '$deleteRights',
	property = '" . $_POST['property'] . "'
	WHERE
	link = id AND
	id = $id");
}

?>
