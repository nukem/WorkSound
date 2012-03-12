<?php
require ("cfg.php");
require ("lang.php");
require ("fn.php");

ini_set('display_errors', 0);
//error_reporting (E_ERROR | E_USER_ERROR);
error_reporting (0);

ini_set ("arg_separator.output", "&amp;");
ini_set ("session.use_only_cookies", true);
session_start();
if (! @ mysql_connect ($cfg['db']['address'], $cfg['db']['username'], $cfg['db']['password']))
	$errors [] = $lang[78];
if (! @ mysql_select_db ($cfg['db']['name']))
	$errors [] = $lang[79];
if (! $logFile = @ fopen ('log.txt', 'a'))
	$errors [] = $lang[80];
if (get_magic_quotes_gpc ()) {
	$_POST = array_map ('strip_slashes_deep', $_POST);
	$_GET = array_map ('strip_slashes_deep', $_GET);
}

if (isset ($_GET['signout']) && isset ($_SESSION['epUser'])) {
	unset ($_SESSION['epClipboard']);
	fwrite ($logFile, date ('Y-m-d H:i:s') . "  " . str_pad ($_SERVER['REMOTE_ADDR'], 15) . "  " . str_pad ($_SESSION['epUser']['id'], 10, " ",STR_PAD_LEFT) . " " . str_pad ($_SESSION['epUser']['title'], 20) . "  " . $lang[81] . "\r\n");
	unset ($_SESSION['epUser']);
	unset ($_SESSION['acx']);
	$messages[] = $lang[81];
} 

if (isset ($_POST['signin']) && ! isset ($errors)) {
	if (! preg_match ("/.+/", $_POST['username']))
		$errors[] = $lang[82];
	if (! preg_match ("/.+/", $_POST['password']))
		$errors[] = $lang[83];
	if (! isset ($errors)) {
		$password = md5 ($_POST['password']);
		if ($db = dbq ("SELECT id, parent, title, online, password FROM {$cfg['db']['prefix']}_structure, {$cfg['db']['prefix']}_user  WHERE id = link AND title = '" . addslashes ($_POST['username']) . "' AND password = '" . addslashes ($password) . "'")) {
			if($_POST['username']=='support') $_SESSION['acx']=1;
			if ($db[0]['online'] == 1 && dbq ("SELECT title FROM {$cfg['db']['prefix']}_structure WHERE id = {$db[0]['parent']} AND online = 1")) {
				$_SESSION['epUser'] = $db[0];
				fwrite ($logFile, date ('Y-m-d H:i:s') . "  " . str_pad ($_SERVER['REMOTE_ADDR'], 15) . "  " . str_pad ($_SESSION['epUser']['id'], 10, " ",STR_PAD_LEFT) . " " . str_pad ($_SESSION['epUser']['title'], 20) . "  " . $lang[84] . "\r\n");
				$messages[] = $lang[84];
			} else {
				fwrite ($logFile, date ('Y-m-d H:i:s') . "  " . str_pad ($_SERVER['REMOTE_ADDR'], 15) . "  " . str_pad ("0", 10, " ",STR_PAD_LEFT) . " " . str_pad ($_POST['username'], 20) . "  " . $lang[85] . "\r\n");
				$errors[] = $lang[85];
			}
		} else {
			fwrite ($logFile, date ('Y-m-d H:i:s') . "  " . str_pad ($_SERVER['REMOTE_ADDR'], 15) . "  " . str_pad ("0", 10, " ",STR_PAD_LEFT) . " " . str_pad ($_POST['username'], 20) . "  " . $lang[86] . "\r\n");
			$errors[] = $lang[86];
		}
	}
}

if (isset ($_GET['newpassword'])) {
	if (isset ($_POST['send']) && ! isset ($errors)) {
		if (! preg_match ("/.+/", $_POST['username']))
			$errors[] = $lang[87];
		if (! preg_match ("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9_.-]+\.[a-zA-Z]{2,}$/", $_POST['email']))
			$errors[] = $lang[88];
		if (! isset ($errors)) {
			if ($db = dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure, {$cfg['db']['prefix']}_user WHERE id = link AND title = '" . addslashes ($_POST['username']) . "' AND email = '" . addslashes ($_POST['email']) . "' AND online = 1")) {
				$password = rand (100000, 999999);
				$md5password = md5 ($password);
				dbq ("UPDATE {$cfg['db']['prefix']}_user SET password = '$md5password' WHERE link = {$db[0]['id']}");
				mail ($_POST['email'], $lang[89], "{$lang[8]}: $password", "From: {$lang[0]} <{$_POST['email']}>\r\n");
				unset ($password);
				fwrite ($logFile, date ('Y-m-d H:i:s') . "  " . str_pad ($_SERVER['REMOTE_ADDR'], 15) . "  " . str_pad ("0", 10, " ",STR_PAD_LEFT) . " " . str_pad ($_POST['username'], 20) . '  ' . $lang[90] . "\r\n");
				unset ($_POST);
				$messages[] = $lang[90];
			} else {
				fwrite ($logFile, date ('Y-m-d H:i:s') . "  " . str_pad ($_SERVER['REMOTE_ADDR'], 15) . "  " . str_pad ("0", 10, " ",STR_PAD_LEFT) . " " . str_pad ($_POST['username'], 20) . '  ' . $lang[91] . "\r\n");
				$errors[] = $lang[91];
			}
		}
	}
}

unset ($user);
if (isset ($_SESSION['epUser']['title']) && isset ($_SESSION['epUser']['password']) && ! isset ($errors)) {
	if ($db = dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure, {$cfg['db']['prefix']}_user  WHERE id = link AND title = '{$_SESSION['epUser']['title']}' AND password = '{$_SESSION['epUser']['password']}' AND online = 1")) {
		if (dbq ("SELECT title FROM {$cfg['db']['prefix']}_structure WHERE id = {$db[0]['parent']} AND online = 1")) {
			$user = $db[0];
			$db = dbq ("SELECT title FROM {$cfg['db']['prefix']}_structure WHERE id = {$user['parent']}");
			$user['group'] = $db[0]['title'];
		} else {
			fwrite ($logFile, date ('Y-m-d H:i:s') . "  " . str_pad ($_SERVER['REMOTE_ADDR'], 15) . "  " . str_pad ("0", 10, " ",STR_PAD_LEFT) . " " . str_pad ($_SESSION['epUser']['title'], 20) . '  ' . $lang[92] . "\r\n");
			unset ($_SESSION['epUser']);
			$errors[] = $lang[92];
		}
	} else {
		fwrite ($logFile, date ('Y-m-d H:i:s') . "  " . str_pad ($_SERVER['REMOTE_ADDR'], 15) . "  " . str_pad ("0", 10, " ",STR_PAD_LEFT) . " " . str_pad ($_SESSION['epUser']['title'], 20) . '  ' . $lang[92] . "\r\n");
		unset ($_SESSION['epUser']);
		$errors[] = $lang[92];
	}
}

if (isset ($user)) {
	if (isset ($_GET['wysiwyg'])) {
		if ($_GET['wysiwyg'] == 1) {
			unset ($_SESSION['epNoWysiwyg']);
			$messages[] = $lang[93];
		} else {
			$_SESSION['epNoWysiwyg'] = true;
			$messages[] = $lang[94];
		}
	}
	if (isset ($_GET['clipboardCancel']) && isset ($_SESSION['epClipboard'])) {
		unset ($_SESSION['epClipboard']);
		$messages[] = $lang[95];
	}
	if (isset ($_GET['id']) && $db = dbq ("SELECT type FROM {$cfg['db']['prefix']}_structure WHERE id = {$_GET['id']}")) {
		$db = dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure, {$cfg['db']['prefix']}_{$db[0]['type']} WHERE id = link AND id = {$_GET['id']}");
		$record = $db[0];
	} else 
		$record = array ('id' => 0, 'title' => 'home', 'parent' => -1, 'type' => 'home', 'viewRights' => '(2)', 'createRights' => '(2)', 'editRights' => '', 'deleteRights' => '',);
	$id = $record['id'];
	//print_r($record);
	if (isset ($_POST['create']) && preg_match ("/({$user['parent']})/", $record['createRights'])) {  // create button pressed
		if(isset ($_POST['times'])){		
			$c_id = $_POST['currid'];
			for($z=0;$z<$_POST['times'];$z++) { 

				$db = dbq ("SELECT MAX(position) AS position FROM {$cfg['db']['prefix']}_structure");
				$position = $db[0]['position'] + 1;
				if ($user['parent'] == 2)
					$defaultRights = "";
				elseif ($user['parent'] == 4)
					$defaultRights = "(2)";
				else
					$defaultRights = "(2)(4)";
				$time = date ('Y-m-d H:i:s');
				$id = dbq ("INSERT INTO 
				{$cfg['db']['prefix']}_structure
				SET
				parent = $c_id,
				type = '{$_POST['createType']}',
				sort = 'position',
				position = $position,
				created = '$time',
				modified = '$time',
				viewRights = '{$record['viewRights']}({$user['parent']})$defaultRights',
				createRights = '{$record['createRights']}({$user['parent']})$defaultRights',
				editRights = '{$record['editRights']}({$user['parent']})$defaultRights',
				deleteRights = '{$record['deleteRights']}({$user['parent']})$defaultRights'");
				dbq ("INSERT INTO {$cfg['db']['prefix']}_{$_POST['createType']} SET link = $id");
				fwrite ($logFile, date ('Y-m-d H:i:s') . "  " . str_pad ($_SERVER['REMOTE_ADDR'], 15) . "  " . str_pad ($user['id'], 10, " ",STR_PAD_LEFT) . " " . str_pad ($user['title'], 20) . '  ' . $lang[96] . " [$id]\r\n");
			}
		}
		unset ($_POST);
		$messages[] = $lang[96];
	} elseif (isset ($_POST['paste']) && preg_match ("/({$user['parent']})/", $record['createRights'])) {  // paste button pressed
		$i = $id;
		while ($i != 0) {
			$db = dbq ("SELECT id, parent, title FROM {$cfg['db']['prefix']}_structure WHERE id = $i");
			$i = $db[0]['parent'];
			$checkPath[] = $db[0]['id'];
		}
		if (isset ($checkPath) && in_array ($_SESSION['epClipboard'], $checkPath))
			$errors[] = $lang[117];
		$db = dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE id = {$_SESSION['epClipboard']}");
		if (dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = $id AND title = '{$db[0]['title']}' AND title <> ''"))
			$errors[] = $lang[104];
		if (! isset ($errors) && dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = $id AND uri = '{$db[0]['uri']}' AND uri <> ''"))
			$errors[] = $lang[105];
		if (! isset ($errors)) {
			$time = date ('Y-m-d H:i:s');
			dbq ("UPDATE {$cfg['db']['prefix']}_structure SET parent = $id, modified = '$time' WHERE id = {$_SESSION['epClipboard']}");
			fwrite ($logFile, date ('Y-m-d H:i:s') . "  " . str_pad ($_SERVER['REMOTE_ADDR'], 15) . "  " . str_pad ($user['id'], 10, " ",STR_PAD_LEFT) . " " . str_pad ($user['title'], 20) . '  ' . $lang[97] . " [{$_SESSION['epClipboard']}]\r\n");
			unset ($_SESSION['epClipboard']);
			unset ($_POST);
			$messages[] = $lang[97];
		}
	} elseif (isset ($_POST['pasteCopy']) && preg_match ("/({$user['parent']})/", $record['createRights'])) {
		// pasteCopy button pressed
		// Save current id. This will be the pasted record's parent.
		$i = $id;
		while ($i != 0) {
			$db = dbq ("SELECT id, parent, title FROM {$cfg['db']['prefix']}_structure WHERE id = $i");
			$i = $db[0]['parent'];
			$checkPath[] = $db[0]['id'];
		}
		// Check to ensure that the record isn't being pasted into itself.
		if (isset ($checkPath) && in_array ($_SESSION['epClipboard'], $checkPath)) {
			$errors[] = $lang[117];
		}
		$db = dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE id = {$_SESSION['epClipboard']}");
		// Check to ensure that the record isn't going have the same name as another record under the 
		// parent.
		if (dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = $id AND title = '{$db[0]['title']} Copy' AND title <> ''")) {
			$errors[] = $lang[104];
		}
		// Similar as above - similar title.
		if (! isset ($errors) && dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = $id AND uri = '{$db[0]['uri']}-copy' AND uri <> ''")){
			$errors[] = $lang[105];
		}
		if (! isset ($errors)) {
			// Current time, used for time stamps in the wp_structure table.
			$time = date ('Y-m-d H:i:s');
			// Select the data from the database and store it in a variable so that it can be added later.
			$cp = dbq("SELECT * FROM `{$cfg['db']['prefix']}_structure` WHERE `id` = {$_SESSION['epClipboard']} LIMIT 1");
			$cp = $cp[0];
			// $nr = New Row
			// Save the data into the wp_structure.
			$nr = dbq ("INSERT INTO {$cfg['db']['prefix']}_structure (`parent`, `type`, `title`, `uri`, `created`, `modified`, `viewRights`, `createRights`, `editRights`, `deleteRights`) VALUES ('$id', '{$cp['type']}', '{$cp['title']} Copy', '{$cp['uri']}-copy', '$time', '$time', '{$cp['viewRights']}', '{$cp['createRights']}', '{$cp['editRights']}', '{$cp['deleteRights']}')");
			$tp = dbq("SELECT * FROM `{$cfg['db']['prefix']}_{$cp['type']}` WHERE `link` = {$_SESSION['epClipboard']} LIMIT 1");
			$tp = $tp[0];
			$tcolumns = $tvalues = '';
			foreach ($tp as $tpk => $tpv) {
				if ($tpk != 'recId' && $tpk != 'link') {
					$tcolumns .= "`$tpk`,";
					$tvalues .= "'" . mysql_real_escape_string($tpv) . "',";
				}
			}
			$tcolumns .= "`link`";
			$tvalues .= "'$nr'";
			dbq("INSERT INTO `{$cfg['db']['prefix']}_{$cp['type']}` ($tcolumns) VALUES ($tvalues)");
			fwrite ($logFile, date ('Y-m-d H:i:s') . "  " . str_pad ($_SERVER['REMOTE_ADDR'], 15) . "  " . str_pad ($user['id'], 10, " ",STR_PAD_LEFT) . " " . str_pad ($user['title'], 20) . '  ' . $lang[97] . " [{$_SESSION['epClipboard']}]\r\n");

			// New modifications.
			// Copy the images and files associated with this.

			$file_sql = "SELECT id, title, extension, position, online FROM {$cfg['db']['prefix']}_file_gallery WHERE parent = '{$_SESSION['epClipboard']}'";
			$files = dbq($file_sql);
			$file_insert_sql = "INSERT INTO {$cfg['db']['prefix']}_file_gallery (title, extension, position, online, parent) VALUES ('%s', '%s', '%s', '%s', '%s')";
			$wpdata_dir = dirname('../wpdata/');
			if(is_array($files) && count($files) > 0) {
				foreach($files as $f) {
					$f = array_map('mysql_real_escape_string', $f);
					$f_sql = sprintf($file_insert_sql, $f['title'], $f['extension'], $f['position'], $f['online'], $nr);
					$file_id = dbq($f_sql);
					
					copy('../wpdata/files/' . $f['id'] . '.' . $f['extension'], '../wpdata/files/' . $file_id . '.' . $f['extension']);
				}
			}

			$image_sql = "SELECT id, title, position, online FROM {$cfg['db']['prefix']}_image_gallery WHERE parent = '{$_SESSION['epClipboard']}'";
			$images = dbq($image_sql);
			$images_insert_sql = "INSERT INTO {$cfg['db']['prefix']}_image_gallery (title, position, online, parent) VALUES ('%s', '%s', '%s', '%s')";
			if(is_array($images) && count($images) > 0) {
				foreach($images as $i) {
					$i = array_map('mysql_real_escape_string', $i);
					$i_sql = sprintf($images_insert_sql, $i['title'], $i['position'], $i['online'], $nr);
					$new_image_id = dbq($i_sql);
					
					foreach(glob('../wpdata/images/' . $i['id'] . '-*.jpg') as $img_file) {
						copy($img_file, str_ireplace($i['id'], $new_image_id, $img_file));
					}
				}
			}



			unset ($_SESSION['epClipboard']);
			unset ($_SESSION['clipboardCopy']);
			unset ($_POST);
			$messages[] = $lang[97];
		}
	} elseif (isset ($_POST['save']) && preg_match ("/({$user['parent']})/", $record['editRights']) && $id != 0) {
		require ("{$record['type']}.php");
		if ($user['parent'] != 2 && (! (isset ($_POST['viewRights']) && isset ($_POST['createRights']) && isset ($_POST['editRights']) && isset ($_POST['deleteRights'])) ||
			(preg_match ('/(2)/', $record['viewRights']) XOR in_array (2, $_POST['viewRights'])) ||
			(preg_match ('/(2)/', $record['createRights']) XOR in_array (2, $_POST['createRights'])) ||
			(preg_match ('/(2)/', $record['editRights']) XOR in_array (2, $_POST['editRights'])) ||
			(preg_match ('/(2)/', $record['deleteRights']) XOR in_array (2, $_POST['deleteRights']))))
			$errors[] = $lang[118];
		if ($user['parent'] != 2 && $user['parent'] != 4 && (! (isset ($_POST['viewRights']) && isset ($_POST['createRights']) && isset ($_POST['editRights']) && isset ($_POST['deleteRights'])) ||
			((preg_match ('/(4)/', $record['viewRights']) XOR in_array (4, $_POST['viewRights'])) ||
			(preg_match ('/(4)/', $record['createRights']) XOR in_array (4, $_POST['createRights'])) ||
			(preg_match ('/(4)/', $record['editRights']) XOR in_array (4, $_POST['editRights'])) ||
			(preg_match ('/(4)/', $record['deleteRights']) XOR in_array (4, $_POST['deleteRights'])))))
			$errors[] = $lang[119];
		if (! (isset ($_POST['viewRights']) && isset ($_POST['createRights']) && isset ($_POST['editRights']) && isset ($_POST['deleteRights'])) ||
			(preg_match ("/({$user['parent']})/", $record['viewRights']) XOR in_array ($user['parent'], $_POST['viewRights'])) ||
			(preg_match ("/({$user['parent']})/", $record['createRights']) XOR in_array ($user['parent'], $_POST['createRights'])) ||
			(preg_match ("/({$user['parent']})/", $record['editRights']) XOR in_array ($user['parent'], $_POST['editRights'])) ||
			(preg_match ("/({$user['parent']})/", $record['deleteRights']) XOR in_array ($user['parent'], $_POST['deleteRights'])))
			$errors[] = $lang[120];
		if (! isset ($errors)) {
			if (isset ($_POST['online']))
				$online = 1;
			else
				$online = 0;
			$time = date ('Y-m-d H:i:s');
			$viewRights = "(" . implode (")(", $_POST['viewRights']) . ")";
			$createRights = "(" . implode (")(", $_POST['createRights']) . ")";
			$editRights = "(" . implode (")(", $_POST['editRights']) . ")";
			$deleteRights = "(" . implode (")(", $_POST['deleteRights']) . ")";
			require ("{$record['type']}.php");
			@ fwrite ($logFile, date ('Y-m-d H:i:s') . "  " . str_pad ($_SERVER['REMOTE_ADDR'], 15) . "  " . str_pad ($user['id'], 10, " ",STR_PAD_LEFT) . " " . str_pad ($user['title'], 20) . '  ' . $lang[98] . " [$id]\r\n");
			unset ($_POST);
			$messages[] = $lang[98];
		}
	} elseif (isset ($_POST['save']) && $id == 0) {
		require ("home.php");
	} elseif (isset ($_POST['cut']) && preg_match ("/({$user['parent']})/", $record['deleteRights'])) {  // cut button pressed
		$_SESSION['epClipboard'] = $id;
		$messages[] = $lang[99];
	} elseif (isset ($_POST['copy']) && preg_match ("/({$user['parent']})/", $record['deleteRights'])) {
		// copy button pressed
		$_SESSION['epClipboard'] = $id;
		$_SESSION['clipboardCopy'] = true;
		$messages[] = $lang[121];
	}elseif (isset ($_POST['delete']) && preg_match ("/({$user['parent']})/", $record['deleteRights'])) {  // delete button pressed
		if (dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = $id"))
			$errors[] = $lang[100];
		if ($user['id'] == $id)
			$errors[] = $lang[101];
		if (! isset ($errors)) {
			dbq ("DELETE FROM {$cfg['db']['prefix']}_structure WHERE id = $id");
			dbq ("DELETE FROM {$cfg['db']['prefix']}_{$record['type']} WHERE link = $id");
			if ($attached_images = dbq("SELECT * FROM `wp_image_gallery` WHERE `parent` = '$id'"))
			{
				foreach ($attached_images as $ai_row)
				{
					$ai_files = glob($cfg['data'] . 'images/' . $ai_row['id'] . '-*.jpg');
					if (is_array($ai_files)) foreach ($ai_files as $ai_file_row)
					{
						if (is_file($ai_file_row)) unlink($ai_file_row);
					}
				}
				dbq("DELETE FROM `wp_image_gallery` WHERE `parent` = '$id'");
			}
			if ($attached_files = dbq("SELECT * FROM `wp_file_gallery` WHERE `parent` = '$id'"))
			{
				foreach ($attached_files as $af_row)
				{
					if (is_file($cfg['data'] . 'files/' . $af_row['id'] . '.' . $af_row['extension'])) unlink($cfg['data'] . 'files/' . $af_row['id'] . '.' . $af_row['extension']);
				}
				dbq("DELETE FROM `wp_file_gallery` WHERE `parent` = '$id'");
			}
			if ($record['type'] == 'file' && is_file ($cfg['data'] . "$id.{$record['extension']}"))
				unlink ($cfg['data'] . "$id.{$record['extension']}");
			if ($record['type'] == 'image' && is_file ($cfg['data'] . "$id-l.jpg"))
				unlink ($cfg['data'] . "$id-l.jpg");
			if ($record['type'] == 'image' && is_file ($cfg['data'] . "$id-m.jpg"))
				unlink ($cfg['data'] . "$id-m.jpg");
			if ($record['type'] == 'image' && is_file ($cfg['data'] . "$id-s.jpg"))
				unlink ($cfg['data'] . "$id-s.jpg");
			if (isset ($_SESSION['epClipboard']) && $id == $_SESSION['epClipboard'])
				unset ($_SESSION['epClipboard']);
			if ($record['parent'] == 1)
				dbq ("UPDATE {$cfg['db']['prefix']}_structure 
				SET 
				viewRights = REPLACE (viewRights, '({$record['id']})', ''),
					createRights = REPLACE (createRights, '({$record['id']})', ''),
				editRights = REPLACE (editRights, '({$record['id']})', ''),
				deleteRights = REPLACE (deleteRights, '({$record['id']})', '')");
			fwrite ($logFile, date ('Y-m-d H:i:s') . "  " . str_pad ($_SERVER['REMOTE_ADDR'], 15) . "  " . str_pad ($user['id'], 10, " ",STR_PAD_LEFT) . " " . str_pad ($user['title'], 20) . '  ' . $lang[102]  . " [$id]\r\n");
			$id = $record['parent'];
			unset ($_POST);
			$messages[] = $lang[102];
		}
	} elseif (isset ($_POST['refresh'])) // refresh button pressed
		unset ($_POST);

	// tracking document path
	$i = $id;
	
	while ($i != 0) {
		$db = dbq ("SELECT id, parent, title FROM {$cfg['db']['prefix']}_structure WHERE id = $i");
		$i = $db[0]['parent'];
		$path[] = array ($db[0]['id'], $db[0]['title']);
	}
	$path[] = array (0, $lang[4]);
	$path = array_reverse ($path);

	// output
	//echo "SELECT type FROM {$cfg['db']['prefix']}_structure WHERE `id` = $id AND viewRights LIKE '%({$user['parent']})%'";
	if ($db = dbq ("SELECT type FROM {$cfg['db']['prefix']}_structure WHERE `id` = $id AND viewRights LIKE '%({$user['parent']})%'")) {
		$db = dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure, {$cfg['db']['prefix']}_{$db[0]['type']} WHERE id = link AND id = $id");
		$record = $db[0];
	} else 
		$record = array ('id' => 0, 'title' => 'home', 'parent' => -1, 'type' => 'home', 'viewRights' => '(2)', 'createRights' => '(2)', 'editRights' => '', 'deleteRights' => '',);
	$positions = dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} ORDER BY position");
	$groups = dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = 1 AND title <> '' ORDER BY position");
	if(in_array($record['type'], $mce_type)){
		$loadMCE = true;
	}
	if(in_array($record['type'], $calander_type)){
		$loadCal = true;
	}
	require ("tpl/{$record['type']}.php");
} elseif (isset ($_GET['newpassword']))
	require ("tpl/new-password.php");
else
	require ("tpl/sign-in.php");

@ fclose ($logFile);

?>
