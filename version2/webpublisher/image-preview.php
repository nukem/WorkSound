<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= htmlspecialchars (urldecode ($_GET['title'])) ?></title>
<style type="text/css">
<!--
body {
 margin: 0;
 padding: 5px 0 0 5px;
	background: #333333;
}
a img {
 border: none;
	vertical-align: bottom;
}
-->
</style>
</head>
<body>
<a href=".?id=<?= $_GET['id'] ?>" onclick="window.close ()"><img src="<?= $_GET['image'] ?>" alt="<?= htmlspecialchars (urldecode ($_GET['title'])) ?>" /></a>
</body>
</html>
