<?php

include('cfg.php');
include('fn.php');

mysql_connect ($cfg['db']['address'], $cfg['db']['username'], $cfg['db']['password']);
mysql_select_db ($cfg['db']['name']);


// id of the image.
$id = $_POST['id'];
$img_id = $_POST['img_id'];

$image_sql = "SELECT id, title, position, online FROM {$cfg['db']['prefix']}_image_gallery WHERE id = '{$img_id}'";
$images = dbq($image_sql);
$images_insert_sql = "INSERT INTO {$cfg['db']['prefix']}_image_gallery (title, position, online, parent) VALUES ('%s', '%s', '%s', '%s')";
if(is_array($images) && count($images) > 0) {
	foreach($images as $i) {
		$i = array_map('mysql_real_escape_string', $i);
		$i_sql = sprintf($images_insert_sql, $i['title'], $i['position'], $i['online'], $id);
		$new_image_id = dbq($i_sql);

		foreach(glob('../wpdata/images/' . $i['id'] . '-*.jpg') as $img_file) {
			copy($img_file, str_ireplace($i['id'], $new_image_id, $img_file));
		}
	}
}

$json['insert_id'] = $new_image_id;
$json['image_title'] = $i['title'];

echo json_encode($json);
