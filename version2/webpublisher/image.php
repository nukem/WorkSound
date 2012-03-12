<?

if (! isset ($errorsChecked)) {
 if (! ereg ('.+', $_POST['title']))
  $errors[] = $lang[103];
 if (dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND title = '" . addslashes ($_POST['title']) . "' AND title <> ''"))
  $errors[] = $lang[104];
 $uri = strtolower (ereg_replace ('[^A-Za-z0-9]+', '-', strip_accents ($_POST['title'])));
 if (! isset ($errors) && dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND uri = '$uri' AND uri <> ''"))
  $errors[] = $lang[105];
 if (! is_file ($cfg['data'] . $id . "-s.jpg") && ! is_uploaded_file ($_FILES['fileId']['tmp_name']))
  $errors[] = $lang[48];
 if (is_uploaded_file ($_FILES['fileId']['tmp_name'])) {
  move_uploaded_file ($_FILES['fileId']['tmp_name'], $cfg['data'] . $id);
  $imageinfo = getimagesize ($cfg['data'] . $id);
  if (! in_array ($imageinfo[2], array (1, 2, 3)))
   $errors[] = $lang[113];
	 if (isset ($errors))
   unlink ($cfg['data'] . $id);
 }
 $errorsChecked = true;
} else {
 if (is_file ($cfg['data'] . $id)) {
  $imglist = glob($cfg['data'] . "{$id}-*.jpg");
  if (count($imglist)) foreach ($imglist as $delimg)
  {
   unlink($delimg);
  }
  /*
  if (is_file ($cfg['data'] . "$id-s.jpg")) {
   unlink ($cfg['data'] . "$id-s.jpg");
   unlink ($cfg['data'] . "$id-m.jpg");
   unlink ($cfg['data'] . "$id-l.jpg");
  }
  */
  foreach ($cfg['img'] as  $img_key => $img_val)
  {
   resize_img ($cfg['data'] . $id, $cfg['data'] . "{$id}-{$img_key}.jpg", $cfg['img'][$img_key][0], $cfg['img'][$img_key][1], $cfg['img'][$img_key][2], $cfg['img'][$img_key][3], $cfg['img'][$img_key][4], $cfg['img'][$img_key][5], $cfg['img'][$img_key][6], $cfg['img'][$img_key][7]);
  }
  /*
  resize_img ($cfg['data'] . $id, $cfg['data'] . "$id-s.jpg", $cfg['img']['small'][0], $cfg['img']['small'][1], $cfg['img']['small'][2], $cfg['img']['small'][3], $cfg['img']['small'][4], $cfg['img']['small'][5], $cfg['img']['small'][6], $cfg['img']['small'][7]);
  resize_img ($cfg['data'] . $id, $cfg['data'] . "$id-m.jpg", $cfg['img']['medium'][0], $cfg['img']['medium'][1], $cfg['img']['medium'][2], $cfg['img']['medium'][3], $cfg['img']['medium'][4], $cfg['img']['medium'][5], $cfg['img']['medium'][6], $cfg['img']['medium'][7]);
  resize_img ($cfg['data'] . $id, $cfg['data'] . "$id-l.jpg", $cfg['img']['large'][0], $cfg['img']['large'][1], $cfg['img']['large'][2], $cfg['img']['large'][3], $cfg['img']['large'][4], $cfg['img']['large'][5], $cfg['img']['large'][6], $cfg['img']['large'][7]);
  */
  unlink ($cfg['data'] . $id);
 }
 if ($record['position'] != $_POST['position'])
  dbq ("UPDATE {$cfg['db']['prefix']}_structure SET position = position + 1 WHERE position >= {$_POST['position']} ORDER BY position DESC");
 dbq ("UPDATE
   {$cfg['db']['prefix']}_structure,
   {$cfg['db']['prefix']}_image
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
   deleteRights = '$deleteRights'
  WHERE
   link = id AND
   id = $id");
}

?>