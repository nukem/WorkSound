<?php if (! isset ($errorsChecked)) {
 if (! preg_match('.+', $_POST['title']))
  $errors[] = $lang[103];
 if (! preg_match('.+', $_POST['code']))
  $errors[] = 'Product code is required';
 if (! preg_match('.+', $_POST['price']))
  $errors[] = 'Price must be filled in';
 if (! preg_match('/^[0-9]+\.?[0-9]{0,2}$', $_POST['price']))
  $errors[] = 'Price should only contain numbers. (format 9.85)';
 if ( $_POST['price'] == '0.00' || ( (float)$_POST['price'] == 0) )
  $errors[] = 'Price should not be 0';
 if (! preg_match('/^[0-9]+$', $_POST['weight']))
  $errors[] = 'Weight is required and must be numeric';
 if (! preg_match('/^[0-9]+$', $_POST['available']))
  $errors[] = 'Available quantity is required and must be numeric';
 if (dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND title = '" . addslashes ($_POST['title']) . "' AND title <> ''"))
  $errors[] = $lang[104];
 $uri = strtolower (preg_replace('[^A-Za-z0-9]+', '-', strip_accents ($_POST['title'])));
 $uri = preg_replace('-+', '-', $uri);
 if (! isset ($errors) && dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND uri = '$uri' AND uri <> ''"))
  $errors[] = $lang[105];
 $errorsChecked = true;
} else {
 if(!isset($_POST['girlshoe'])){ $_POST['girlshoe'] = 0;}
 if(!isset($_POST['boyshoe'])){$_POST['boyshoe'] = 0;}
 if(!isset($_POST['onsale'])){$_POST['onsale'] = 0;}
 if ($record['position'] != $_POST['position'])
  dbq ("UPDATE {$cfg['db']['prefix']}_structure SET position = position + 1 WHERE position >= {$_POST['position']} ORDER BY position DESC");
 dbq ("UPDATE
   {$cfg['db']['prefix']}_structure,
   {$cfg['db']['prefix']}_product
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
   price = '". addslashes($_POST['price']) ."',
   description = '". addslashes($_POST['description']) ."',
   code = '". addslashes($_POST['code']) ."',
   girlshoe = ". addslashes($_POST['girlshoe']) .",
   boyshoe = ". addslashes($_POST['boyshoe']) .",
   onsale = ". addslashes($_POST['onsale']) .",
   weight = ".addslashes($_POST['weight']).",
   available = ". addslashes($_POST['available']) ."
  WHERE
   link = id AND
   id = $id");
}
?>