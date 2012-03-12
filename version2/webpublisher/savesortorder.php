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

if (isset($_GET['image-sort']) && is_array($_GET['image-sort'])) {
    $i = 1;
    foreach ($_GET['image-sort'] as $v) {
        dbq("UPDATE `wp_image_gallery` SET `position` = '$i' WHERE `id` = '$v'");
        $i++;
    }
    echo "SUCCESS";
} else if (isset($_GET['file-sort']) && is_array($_GET['file-sort'])) {
    $i = 1;
    foreach ($_GET['file-sort'] as $v) {
        dbq("UPDATE `wp_file_gallery` SET `position` = '$i' WHERE `id` = '$v'");
        $i++;
    }
    echo "SUCCESS";
} else {
    echo "FAILED!";
}
?>