<?

if (! preg_match ('/^[A-Za-z0-9-]{3,20}$/', $_POST['title']))
 $errors[] = $lang[108];
if (dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure, {$cfg['db']['prefix']}_user WHERE id = link AND title = '" . addslashes ($_POST['title']) . "' AND id <> {$user['id']}"))
 $errors[] = $lang[109];
if (($_POST['password1'] || $_POST['password2']) && (! preg_match ('/^[A-Za-z0-9]{6,20}$/', $_POST['password1']) || ! preg_match ('/^[A-Za-z0-9]{6,20}$/', $_POST['password2'])))
 $errors[] = $lang[110];
if ($_POST['password1'] != $_POST['password2'])
 $errors[] = $lang[111];
if (! preg_match ("/^[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9_\-\.]+\.[a-zA-Z]{2,}$/", $_POST['email']))
 $errors[] = $lang[88];
if (! isset ($errors)) { 
 if ($_POST['password1']) {
  $password = "password = '" . md5 ($_POST['password1']) . "',";
 } else
  $password = "";
 $time = date ('Y-m-d H:i:s');
 dbq ("UPDATE
   {$cfg['db']['prefix']}_structure,
   {$cfg['db']['prefix']}_user
  SET
   title = '" . addslashes ($_POST['title']) . "',
   modified = '$time',
   $password
   email = '{$_POST['email']}'
  WHERE
   link = id AND
   id = {$user['id']}");
 $db = dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure, {$cfg['db']['prefix']}_user  WHERE id = link AND id = {$user['id']}");
 $user = $db[0];
 $db = dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE id = {$user['parent']}");
 $user['group'] = $db[0]['title'];
 $_SESSION['epUser']['title'] = $user['title'];
 $_SESSION['epUser']['password'] = $user['password'];
 @ fwrite ($logFile, date ('Y-m-d H:i:s') . "  " . str_pad ($_SERVER['REMOTE_ADDR'], 15) . "  " . str_pad ($user['id'], 10, " ",STR_PAD_LEFT) . " " . str_pad ($user['title'], 20) . '  ' . $lang[98] . " [$id]\r\n");
 $messages[] = $lang[98];
 unset ($_POST);
}

?>