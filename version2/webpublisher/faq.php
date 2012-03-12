<?
ini_set('display_errors', 1);
error_reporting(E_ALL);
require('cfg.php');

if(!$cnx=mysql_connect($cfg['db']['address'],$cfg['db']['username'],$cfg['db']['password'])) exit("Error");
if(!mysql_select_db($cfg['db']['name'],$cnx)) exit("Error");

if(isset($_POST['faq_title'])){
	$faq_id=$_POST['faq_id'];
	$faq_title=addslashes ($_POST['faq_title']);
	$description=addslashes ($_POST['description']);
	if($_POST['faq_id']==0 && $_POST['faq_title']!=''){
		mysql_query ("INSERT INTO faq (faq_title,description) VALUES('$faq_title','$description')");
	}
	else{
		echo "update faq set faq_title='$faq_title', description='$description' where faq_id='$faq_id'";
		mysql_query ("update faq set faq_title='$faq_title', description='$description' where faq_id='$faq_id'");
	}
}
?>

