<?
if (! isset ($errorsChecked)) {
 if (! preg_match ('/.+/', $_POST['title']))
  $errors[] =  $lang[103];
 if (dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND title = '" . addslashes ($_POST['title']) . "' AND title <> ''"))
  $errors[] = $lang[104];
 $uri = strtolower (preg_replace ('/[^A-Za-z0-9]+/', '-', strip_accents ($_POST['title'])));
 if (! isset ($errors) && dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND uri = '$uri' AND uri <> ''"))
  $errors[] = $lang[105];
 if ( $_POST['sms_content'] == '')
	$errors[] = $lang[122];
 $errorsChecked = true;
} else {


 if ($record['position'] != $_POST['position'])
  dbq ("UPDATE {$cfg['db']['prefix']}_structure SET position = position + 1 WHERE position >= {$_POST['position']} ORDER BY position DESC");
 dbq ("UPDATE
   {$cfg['db']['prefix']}_structure,
   {$cfg['db']['prefix']}_email_template
  SET
   title = '" . addslashes ($_POST['title']) . "',
   subject = '" . addslashes ($_POST['subject']) . "',
   email_from = '" . addslashes ($_POST['email_from']) . "',
   cc = '" . addslashes ($_POST['cc']) . "',
   bcc = '" . addslashes ($_POST['bcc']) . "',
   uri = '$uri',
   online = $online,
   sort = '{$_POST['sort']}',
   position = {$_POST['position']},
   modified = '$time',
   viewRights = '$viewRights',
   createRights = '$createRights',
   editRights = '$editRights',
   deleteRights = '$deleteRights',
   content = '" . addslashes (preg_replace('/src="..\//', 'src="', $_POST['content'])) . "',
   sms_content = '" . strip_tags ( $_POST['sms_content'] ) . "'
  WHERE
   link = id AND
   id = $id");
   
}

?>
