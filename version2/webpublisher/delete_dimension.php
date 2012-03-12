<?php

include('cfg.php');
include('fn.php');

if(isset($_POST['id'])) {
	
	$id = $_POST['id'];


	mysql_connect ($cfg['db']['address'], $cfg['db']['username'], $cfg['db']['password']);
	mysql_select_db ($cfg['db']['name']);
	$sql = 'DELETE FROM floorplan_dimensions WHERE id = ' . $id;
	dbq($sql);
} else {
	echo 'no id supplied';
}
