<?
error_reporting(E_ERROR|E_USER_ERROR);
/*$base_url = 'http://paradigm.visiontechprojects.com/infinity/';
$cfg['base_url'] = $base_url;
$cfg['cookie_url'] = '.visiontechprojects.com';*/
$cfg['website_url'] = 'http://www.soundbooka.com.au/version2/';
$cfg['db']['address'] = "localhost";
$cfg['db']['username'] = "sbuserv2";
$cfg['db']['password'] = "soundbooka123#";
$cfg['db']['name'] = "soundbookaversion2";
$cfg['db']['prefix'] = "wp";
$cfg['wysiwyg_base_uri'] = "../";
$cfg['data'] = "/var/www/vhosts/soundbooka.com.au/httpdocs/version2/wpdata/";
$mce_type[] = 'article';
$mce_type[] = 'email_template';
$mce_type[] = 'agent';
$mce_type[] = 'video';
$mce_type[] = 'blog';
$mce_type[] = 'newsletter';
$cfg['blog']['id'] = 792;

$cfg['img']['thumb'] = array (68, 68, 'fit', true, 100, 0xFF, 0xFF, 0xFF);
$cfg['img']['xsmall'] = array (120, 120, 'shrink', true, 100, 0xFF, 0xFF, 0xFF);
$cfg['img']['small'] = array (150, 300, 'shrink', true, 100, 0xFF, 0xFF, 0xFF);
$cfg['img']['medium'] = array (360, 600, 'shrink', true, 100, 0xFF, 0xFF, 0xFF);
$cfg['img']['large'] = array (640, 400, 'shrink', false, 100, 0xFF, 0xFF, 0xFF);
$cfg['img']['xlarge'] = array (960, 282, 'shrink', false, 100, 0xFF, 0xFF, 0xFF);
if(preg_match('/^(localhost|192\.168\.)/', $_SERVER['HTTP_HOST'])){
	$cfg['db']['address'] = "localhost";
	$cfg['db']['username'] = "root";
	$cfg['db']['password'] = "";
	$cfg['db']['name'] = "realtc_db";
	$cfg['db']['prefix'] = "wp";
}
//$errorsChecked=false;
?>