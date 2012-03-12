<?php

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

if (isset($_GET['type']) && isset($_GET['id']) && preg_match('/^[0-9]+$/', $_GET['id'])) { 


    if ($_GET['type'] == 'image') {
        
		$record = dbq("SELECT parent FROM wp_image_gallery WHERE id = {$_GET['id']}");
        if(!dbq("DELETE FROM `wp_image_gallery` WHERE `id` = '{$_GET['id']}' LIMIT 1")) {
            echo "ERROR";
        } else {
            @unlink($cfg['data'] . "images/" . $_GET['id'] . "-s.jpg");
            @unlink($cfg['data'] . "images/" . $_GET['id'] . "-m.jpg");
            @unlink($cfg['data'] . "images/" . $_GET['id'] . "-l.jpg");
            echo "DELETE SUCCESS";
        }
        
        
    } else if ($_GET['type'] == 'file') {
        
		$record = dbq("SELECT parent FROM wp_file_gallery WHERE id = {$_GET['id']}");
        if(!dbq("DELETE FROM `wp_file_gallery` WHERE `id` = '{$_GET['id']}' LIMIT 1")) {
            echo "ERROR";
        } else {
            $file = glob($cfg['data'] . "files/" . $_GET['id'] . ".*");
            @unlink($file[0]);
            echo "DELETE SUCCESS";
        }
        
    }
	$parentID = $record[0]['parent'];
	dbq("UPDATE wp_structure SET modified = NOW() WHERE id = {$parentID}");
	dbq("UPDATE wp_file_gallery SET modified = NOW() WHERE parent = {$parentID}");
	dbq("UPDATE wp_image_gallery SET modified = NOW() WHERE parent = {$parentID}");

    
}

?>
