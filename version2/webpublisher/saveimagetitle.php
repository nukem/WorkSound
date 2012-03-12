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

$type = $_GET['t'];

if (isset($_GET['nt']) && isset($_GET['id']) && preg_match('/^[0-9]+$/', $_GET['id'])) {
    
    $new_name = mysql_real_escape_string($_GET['nt']);
    $id = $_GET['id'];
    
    if ($type == 'image') {
        
        if (!dbq("SELECT `id` FROM `wp_image_gallery` WHERE `id` = '$id' AND `title` = '$new_name' LIMIT 1")) {
            if (!dbq("UPDATE `wp_image_gallery` SET `title` = '$new_name' WHERE `id` = '$id' LIMIT 1")) {
                $msg = 'ERROR';
                $title = 'Database Error';
            } else {
                $msg = 'SUCCESS';
                $title = $new_name;
            }
        } else {
            $msg = 'SUCCESS';
            $title = $new_name;
        }
        
    } else if ($type == 'file') {
        
        if (!dbq("SELECT `id` FROM `wp_file_gallery` WHERE `id` = '$id' AND `title` = '$new_name' LIMIT 1")) {
            if (!dbq("UPDATE `wp_file_gallery` SET `title` = '$new_name' WHERE `id` = '$id' LIMIT 1")) {
                $msg = 'ERROR';
                $title = 'Database Error';
            } else {
                $msg = 'SUCCESS';
                $title = $new_name;
            }
        } else {
            $msg = 'SUCCESS';
            $title = $new_name;
        }
        
    }
    
} else {
    
    $msg = 'ERROR';
    $title = 'Input Error';
    
}
echo "titleDetails = {msg: '$msg', title: '$title'};";
?>