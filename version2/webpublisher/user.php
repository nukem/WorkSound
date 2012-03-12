<?

if (! isset ($errorsChecked)) {
 if (! preg_match ('/^[A-Za-z0-9-.@_]{3,50}$/', $_POST['title']))
  $errors[] = $lang[108];
 if (dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure, {$cfg['db']['prefix']}_user WHERE id = link AND title = '{$_POST['title']}' AND id <> $id"))
  $errors[] = $lang[109];
 if (dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure, {$cfg['db']['prefix']}_user WHERE id = link AND id = $id AND password = ''") && ! ($_POST['password1'] || $_POST['password2']))
  $errors[] = $lang[114];
 if (($_POST['password1'] || $_POST['password2']) && (! preg_match ('/^[A-Za-z0-9]{6,20}$/', $_POST['password1']) || ! preg_match ('/^[A-Za-z0-9]{6,20}$/', $_POST['password2'])))
  $errors[] = $lang[110];
 if ($_POST['password1'] != $_POST['password2'])
  $errors[] = $lang[111];
 if (! isset ($_POST['online']) && $user['id'] == $id)
  $errors[] = $lang[115];
 if (! preg_match ("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9_.-]+\.[a-zA-Z]{2,}$/", $_POST['email']))
  $errors[] = $lang[88];
 $errorsChecked = true;
} else {
 if ($_POST['password1']) {
  $password = "password = '" . md5 ($_POST['password1']) . "',";
 } else
  $password = "";
 if ($record['position'] != $_POST['position'])
  dbq ("UPDATE {$cfg['db']['prefix']}_structure SET position = position + 1 WHERE position >= {$_POST['position']} ORDER BY position DESC");
 $sql = "UPDATE
   {$cfg['db']['prefix']}_structure,
   {$cfg['db']['prefix']}_user
  SET
   title = '{$_POST['title']}',
   online = $online,
   position = {$_POST['position']},
   modified = '$time',
   viewRights = '$viewRights',
   createRights = '$createRights',
   editRights = '$editRights',
   deleteRights = '$deleteRights',
   $password
   email = '{$_POST['email']}',
   name = '{$_POST['name']}'
  WHERE
   link = id AND
   id = $id";
  
 dbq ($sql);
 
 $db_pass = "update user SET password = '{$_POST['password1']}' where email = '{$_POST['name']}'";
 dbq ($db_pass);
 
 if ($user['id'] == $id) {
  $db = dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure, {$cfg['db']['prefix']}_user  WHERE id = link AND id = $id");
  $user = $db[0];
  $db = dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE id = {$user['parent']}");
  $user['group'] = $db[0]['title'];
  $_SESSION['epUser']['title'] = $user['title'];
  $_SESSION['epUser']['password'] = $user['password'];
 }
}

?>