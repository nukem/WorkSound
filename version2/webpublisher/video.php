<?php

if (! isset ($errorsChecked)) {
 if (! preg_match('.+', $_POST['title']))
  $errors[] = $lang[103];
 if (dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND title = '" . addslashes ($_POST['title']) . "' AND title <> ''"))
  $errors[] = $lang[104];
 $uri = strtolower (preg_replace('[^A-Za-z0-9]+', '-', strip_accents ($_POST['title'])));
 if (! isset ($errors) && dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND uri = '$uri' AND uri <> ''"))
  $errors[] = $lang[105];
 if (! isset ($_POST['online']) && $id == $user['parent'])
  $errors[] = $lang[107];
 $errorsChecked = true;
} else {
 if ($record['position'] != $_POST['position'])
	 dbq ("UPDATE {$cfg['db']['prefix']}_structure SET position = position + 1 WHERE position >= {$_POST['position']} ORDER BY position DESC");

if(isset($_POST['featured']) && $_POST['featured'] == '1') {
		$_POST['featured'] = '1"';
	} else {
		$_POST['featured'] = '0';
	} 

 if(isset($_POST['recent']) && $_POST['recent'] == '1') {
		$_POST['recent'] = '1';
	} else {
		$_POST['recent'] = '0';
	}

 if(isset($_POST['sold']) && $_POST['sold'] == '1') {
		$_POST['sold'] = '1';
	} else {
		$_POST['sold'] = '0';
	}

  if(isset($_POST['other']) && $_POST['other'] == '1') {
		$_POST['other'] = '1';
	} else {
		$_POST['other'] = '0';
	}



 dbq ("UPDATE
   {$cfg['db']['prefix']}_structure,
   {$cfg['db']['prefix']}_video
  SET
   title = '" . addslashes ($_POST['title']) . "',
   videourl = '{$_POST['videourl']}',
   agent_1 = '{$_POST['agent_1']}',
   agent_2 = '{$_POST['agent_2']}',
   suburb = '{$_POST['suburb']}',
   embed = '{$_POST['embed']}',
   address = '{$_POST['address']}',
   featured = '{$_POST['featured']}',
   recent = '{$_POST['recent']}',
   sold = '{$_POST['sold']}',
   other = '{$_POST['other']}',
   uri = '$uri',
   online = $online,
   sort = '{$_POST['sort']}',
   position = {$_POST['position']},
   modified = '$time',
   viewRights = '$viewRights',
   createRights = '$createRights',
   editRights = '$editRights',
   deleteRights = '$deleteRights'
  WHERE
   link = id AND
   id = $id");
}

