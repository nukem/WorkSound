<?

if (! isset ($errorsChecked)) {
 if (! preg_match ('/.+/', $_POST['title']))
  $errors[] =  $lang[103];
  
 if ($_POST['state_id'] == '')
  $errors[] =  'State must be selected.';
 if ($_POST['postcode'] == '')
  $errors[] =  'Postcode must be filled in.';
 if ($_POST['postcode'] != '' && !is_numeric($_POST['postcode']))
  $errors[] =  'Postcode must be a numeric value.';
 if (trim($_POST['website']) != '' && ! filter_var($_POST['website'], FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED))
  $errors[] =  'Invalid website URL';
  
 if (dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND title = '" . addslashes ($_POST['title']) . "' AND title <> ''"))
  $errors[] = $lang[104];
 $uri = strtolower (preg_replace ('/[^A-Za-z0-9]+/', '-', strip_accents ($_POST['title'])));
 if (! isset ($errors) && dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND uri = '$uri' AND uri <> ''"))
  $errors[] = $lang[105];
 $errorsChecked = true;
} else {


 if ($record['position'] != $_POST['position'])
  dbq ("UPDATE {$cfg['db']['prefix']}_structure SET position = position + 1 WHERE position >= {$_POST['position']} ORDER BY position DESC");
 dbq ("UPDATE
   {$cfg['db']['prefix']}_structure,
   {$cfg['db']['prefix']}_display_centre
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
   address_1 = '" . addslashes ($_POST['address_1']) . "',
   address_2 = '" . addslashes ($_POST['address_2']) . "',
   suburb = '" . addslashes ($_POST['suburb']) . "',
   state_id = '" . addslashes ($_POST['state_id']) . "',
   postcode = '" . addslashes ($_POST['postcode']) . "',
   email = '" . addslashes ($_POST['email']) . "',
   website = '" . addslashes ($_POST['website']) . "',
   phone = '" . addslashes ($_POST['phone']) . "',
   fax = '" . addslashes ($_POST['fax']) . "',
   hours = '" . addslashes ($_POST['hours']) . "',
   map_latitude = '" . addslashes ($_POST['map_latitude']) . "',
   map_longitude = '" . addslashes ($_POST['map_longitude']) . "',
   map_zoom = '" . addslashes ($_POST['map_zoom']) . "'
  WHERE
   link = id AND
   id = $id");
}

?>
