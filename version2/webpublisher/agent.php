<?php 
if (! isset ($errorsChecked)) {
 if (! preg_match('/.+/', $_POST['title']))
  $errors[] = $lang[103];
 if (dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND title = '" . addslashes ($_POST['title']) . "' AND title <> ''"))
  $errors[] = $lang[104];
 $uri = strtolower (preg_replace('/[^A-Za-z0-9]+/', '-', strip_accents ($_POST['title'])));
 if (! isset ($errors) && dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND uri = '$uri' AND uri <> ''"))
  $errors[] = $lang[105];
 $errorsChecked = true;
} else {


 if ($record['position'] != $_POST['position'])
  dbq ("UPDATE {$cfg['db']['prefix']}_structure SET position = position + 1 WHERE position >= {$_POST['position']} ORDER BY position DESC");
 dbq ("UPDATE
   {$cfg['db']['prefix']}_structure,
   {$cfg['db']['prefix']}_agent
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
   agentid = '{$_POST['agentid']}', 
   jobtype = '{$_POST['jobtype']}',
   jobposition = '{$_POST['jobposition']}',
   mobile = '{$_POST['mobile']}',
   email = '{$_POST['email']}',
   telephone = '{$_POST['telephone']}',
   campaign = '" . addslashes(preg_replace('/src="..\//', 'src="', $_POST['campaign'])) . "',
   about = '" . addslashes(preg_replace('/src="..\//', 'src="', $_POST['about'])) . "'
  WHERE
   link = id AND
   id = $id");
}

?>

