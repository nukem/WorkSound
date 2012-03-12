<?php
$agents = dbq("SELECT `id`, `title` FROM `wp_structure` WHERE `type` = 'agent'");

foreach($agents as $agent){
	$author[$agent['id']] = $agent['title'];
}

if (isset($_POST['create_blog']))
{
	$blog_errors = array();
	//Form Validation
	if(!isset($_POST['title']) || $_POST['title'] == ''){
		$blog_errors[] = 'The Title field is required';
	}
	if(!isset($_POST['author']) || $_POST['author'] == ''){
		$blog_errors[] = 'The Author field is required';
	}
	
	if(isset($_POST['online'])){
		$online = 1;
	}else{
		$online = 0;
	}
	
	if (count($blog_errors) < 1)
	{
		#edit
		if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['blog']))
		{
			dbq("UPDATE `blog_entries` SET 
			`title` =  '" . mysql_real_escape_string($_POST['title']) . "',
			`content` = '" . mysql_real_escape_string($_POST['content']) . "', 
			`author` = '" . mysql_real_escape_string($_POST['author']) . "', 
			`tags` = '" . mysql_real_escape_string($_POST['tags']) . "', 
			`online` = '" . $online . "'
			WHERE `id` = " . $_GET['blog'] . ";");
		}
		else #insert
		{
			$newid = dbq("INSERT INTO `blog_entries` (`id`, `title`, `date`, `content`, `author`, `tags`, `online`) VALUES (NULL, '" . mysql_real_escape_string($_POST['title']) . "', '" . date('Y-m-d H:i:s') . "', '" . mysql_real_escape_string($_POST['content']) . "', '" . mysql_real_escape_string($_POST['author']) . "', '" . mysql_real_escape_string($_POST['tags']) . "', '" . $online . "');");
			
			header('Location: ?id=599&action=edit&blog=' . $newid);
		}
	}
}


if (isset($_GET['entry']))
{
	require ("blog_entry.php");	
}
elseif(isset($_GET['action']) && $_GET['action'] == 'delete'){
	dbq("DELETE FROM `blog_entries` WHERE `id` = " . mysql_real_escape_string($_GET['blog']));
	header('Location: ?id=599');
}
elseif(isset($_GET['action']) && $_GET['action'] == 'comdelete'){
	dbq("DELETE FROM `blog_comments` WHERE `recId` = " . mysql_real_escape_string($_GET['comment']));
	header('Location: ?id=599&action=edit&blog=' . $_GET['blog']);
}
elseif(isset($_GET['action']) && $_GET['action'] == 'edit'){
	$edit_blog = dbq("SELECT * FROM `blog_entries` WHERE `id` = " . mysql_real_escape_string($_GET['blog']));
	$blog_comments = dbq("SELECT `recId`,`date`,`user`,`content`, `website` FROM `blog_comments` WHERE `link` = " . $_GET['blog']);
	require ("blog_entry.php");
}
else
{
	$blog_list = dbq ("SELECT `title`,`id`, `date`, `author`, `tags` FROM `blog_entries` ORDER BY `date` DESC");	
  	require ("blog_entry_list.php");
}

?>
