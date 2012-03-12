<?

require ("cfg.php");

/*header("Pragma: public");
header("Cache-control: private");
header("Content-type: application/octet-stream");
header("Content-disposition: attachment; filename={$_GET['filename']}");
readfile ($cfg['data'] . $_GET['file']); // prevents downloading from other than attachments directory*/

$filename = $cfg['data'] . $_GET['file'];
$file_extension = strtolower(substr(strrchr($_GET['file'],"."),1));

switch ($file_extension) {
	case "pdf": $ctype = "application/pdf"; break;
	case "exe": $ctype = "application/octet-stream"; break;
	case "zip": $ctype = "application/zip"; break;
	case "doc": $ctype = "application/msword"; break;
	case "xls": $ctype = "application/vnd.ms-excel"; break;
	case "ppt": $ctype = "application/vnd.ms-powerpoint"; break;
	case "gif": $ctype = "image/gif"; break;
	case "png": $ctype = "image/png"; break;
	case "jpe": case "jpeg": case "jpg": $ctype = "image/jpg"; break;
	default: $ctype = "application/octet-stream";
}

if (!file_exists($filename)) {
	die("File cannot be found!");
}

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Content-Type: {$ctype}");
header("Content-Disposition: attachment; filename=\"" . $_GET['filename'] . "." . $file_extension ."\";");
header("Content-Transfer-Encoding: binary");
header("Content-Length: " . @filesize($filename));
@readfile("$filename") or die("File not found!");

?>