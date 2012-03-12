<?php
set_time_limit (30000) ;
ini_set('max_execution_time', 30000); 

ini_set('display_errors', 0);
error_reporting(0);
session_start();
	$error = "";
	$msg = "";
	$insert_id = $image_title = $filetype_extension = "";
	
	if (isset($_GET['element']) && isset($_GET['parent'])) {
		$element = $_GET['element'];
		$parentID = $_GET['parent'];
	} else {
		$error = 'No element id provided!';
	}
	
	require ("cfg.php");
	require ("fn.php");
	
	if (! @ mysql_connect ($cfg['db']['address'], $cfg['db']['username'], $cfg['db']['password'])) {
		$error = 'DB connect error';
	}
	if (! @ mysql_select_db ($cfg['db']['name'])) {
		$error = 'DB select error';
	}

	if (get_magic_quotes_gpc ()) {
		$_POST = array_map ('strip_slashes_deep', $_POST);
		$_GET = array_map ('strip_slashes_deep', $_GET);
	}
	
	if ( $element == 'jq-images' ) {
		
		$file_path = $cfg['data'] . "images/";
		$temp_id = time() . mt_rand(1111, 9999);
		if (is_uploaded_file ($_FILES[$element]['tmp_name'])) {
			@move_uploaded_file ($_FILES[$element]['tmp_name'], $file_path . $temp_id);
			$imageinfo = getimagesize ($file_path . $temp_id);
			if (! in_array ($imageinfo[2], array (1, 2, 3))) {
				$error = 'Image must be in JPG, GIF or PNG format.';
				unlink ($file_path . $temp_id);
			} else if ($imageinfo[0] < 100 && $_SESSION['epUser']['parent'] != 2) {
				$error = 'Image must be wider than 100 pixels.';
				unlink ($file_path . $temp_id);
			} else {
				$image_title = mysql_real_escape_string(preg_replace(array('/\.([a-z0-9]+)$/i', '/[^a-z0-9]+/i'), array('', '-'), $_FILES[$element]['name']));
				$image_position = dbq("SELECT MAX(`position`) AS `position` FROM `wp_image_gallery` WHERE `parent` = {$parentID}");
				if (!is_array($image_position)) {
					$image_position = 1;
				} else {
					$image_position = $image_position[0]['position'] + 1;
				}
				$insert_id = dbq("INSERT INTO `wp_image_gallery` (`parent`, `title`, `position`) VALUES ('{$parentID}', '{$image_title}', '{$image_position}')");
				dbq("UPDATE wp_structure SET modified = NOW() WHERE id = {$parentID}");
				foreach ($cfg['img'] as  $img_key => $img_val)
				{
					resize_img ($file_path . $temp_id, $file_path . "{$insert_id}-{$img_key}.jpg", $cfg['img'][$img_key][0], $cfg['img'][$img_key][1], $cfg['img'][$img_key][2], $cfg['img'][$img_key][3], $cfg['img'][$img_key][4], $cfg['img'][$img_key][5], $cfg['img'][$img_key][6], $cfg['img'][$img_key][7]);
				}
				/*
				resize_img ($file_path . $temp_id, $file_path . "{$insert_id}-s.jpg", $cfg['img']['small'][0], $cfg['img']['small'][1], $cfg['img']['small'][2], $cfg['img']['small'][3], $cfg['img']['small'][4], $cfg['img']['small'][5], $cfg['img']['small'][6], $cfg['img']['small'][7]);
				resize_img ($file_path . $temp_id, $file_path . "{$insert_id}-m.jpg", $cfg['img']['medium'][0], $cfg['img']['medium'][1], $cfg['img']['medium'][2], $cfg['img']['medium'][3], $cfg['img']['medium'][4], $cfg['img']['medium'][5], $cfg['img']['medium'][6], $cfg['img']['medium'][7]);
				resize_img ($file_path . $temp_id, $file_path . "{$insert_id}-l.jpg", $cfg['img']['large'][0], $cfg['img']['large'][1], $cfg['img']['large'][2], $cfg['img']['large'][3], $cfg['img']['large'][4], $cfg['img']['large'][5], $cfg['img']['large'][6], $cfg['img']['large'][7]);
				*/
				unlink ($file_path . $temp_id);
				$msg = 'SUCCESS';
			}
		} else {
			$error = 'File upload error!';
		}
		
	} else if ( $element == 'jq-files' || $element == 'jq-files1' || $element == 'jq-files2' || $element == 'jq-files3') {
		
		$file_path = $cfg['data'] . "files/";
		if (is_uploaded_file ($_FILES[$element]['tmp_name'])) {
			$image_title = preg_replace(array('/\.([a-z0-9]+)$/i', '/[^a-z0-9]+/i'), array('', '-'), $_FILES[$element]['name']);
			$file_ext = preg_replace('/.+\.([a-z0-9]+)$/i', '$1', $_FILES[$element]['name']);
			$file_position = dbq("SELECT MAX(`position`) AS `position` FROM `wp_file_gallery` WHERE `parent` = {$parentID}");
			if (!is_array($file_position)) {
				$file_position = 1;
			} else {
				$file_position = $file_position[0]['position'] + 1;
			}
			$insert_id = dbq("INSERT INTO `wp_file_gallery` (`parent`, `title`, `extension`, `position`) VALUES ('{$parentID}', '{$image_title}', '{$file_ext}', '{$file_position}')");
			@move_uploaded_file ($_FILES[$element]['tmp_name'], $file_path . $insert_id . '.' . $file_ext);
			
			if (is_file ("img/ico-file/" . $file_ext . ".gif")) {
				$filetype_extension = $file_ext;
			} else {
				$filetype_extension = 'unknown';
			}

			dbq("UPDATE wp_structure SET modified = NOW() WHERE id = {$parentID}");
			
			$msg = 'SUCCESS';
		} else {
			$error = 'File upload error!';
		}
		
	} else {
		
		$error = 'Unspecified File Element ';
		
	}
		
	echo "{";
	echo				"error: '" . $error . "',\n";
	echo				"msg: '" . $msg . "',\n";
	echo				"insert_id: '" . $insert_id . "',\n";
	echo				"image_title: '" . $image_title . "'";
	if ($filetype_extension != '') echo ",\nfile_ext: '" . $file_ext . "'\n";
	echo "}";
?>
