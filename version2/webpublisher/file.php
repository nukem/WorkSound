<?

if (! isset ($errorsChecked)) {
 if (! preg_match ('/.+/', $_POST['title']))
  $errors[] = $lang[103];
 if (dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND title = '" . addslashes ($_POST['title']) . "' AND title <> ''"))
  $errors[] = $lang[104];
 $uri = strtolower (preg_replace ('/[^A-Za-z0-9]+/', '-', strip_accents ($_POST['title'])));
 if (! isset ($errors) && dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND uri = '$uri' AND uri <> ''"))
  $errors[] = $lang[105];
 if (! is_file ($cfg['data'] . "$id" . "." . $record['extension']) && ! is_uploaded_file ($_FILES['fileId']['tmp_name']))
  $errors[] = $lang[106];
 $errorsChecked = true;
} else {
 if (is_uploaded_file ($_FILES['fileId']['tmp_name'])) {
  if ($record['extension'] != '')
   unlink ($cfg['data'] . "$id" . "." . $record['extension']);
  $extension = strtolower (preg_replace ('/.*\.([A-Za-z0-9_-]+)$/', '\\1', $_FILES['fileId']['name']));
  move_uploaded_file ($_FILES['fileId']['tmp_name'], $cfg['data'] . "$id.$extension");
 } else 
  $extension = $record['extension'];
 if ($record['position'] != $_POST['position'])
  dbq ("UPDATE {$cfg['db']['prefix']}_structure SET position = position + 1 WHERE position >= {$_POST['position']} ORDER BY position DESC");
 dbq ("UPDATE
   {$cfg['db']['prefix']}_structure,
   {$cfg['db']['prefix']}_file
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
   extension = '$extension'
  WHERE
   link = id AND
   id = $id");
}

?>