<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo  $lang[0] ?></title>
<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen,projection" />
<?php if(isset($loadMCE)){ ?>
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
<!--
tinyMCE.init({
	mode: "specific_textareas",
	editor_selector : "tinymce",
	theme: "advanced",
	plugins : "advimage, table, spellchecker, paste",
	//content_css : "tiny_mce/custom_css/webskin.css?q=" + new Date().getTime(),
	doctype: '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">',
	fix_list_elements: true,
	width: "100%",
	theme_advanced_blockformats: "p,h2,h3,h4,h5,h6",
	theme_advanced_toolbar_location: "top",
	theme_advanced_toolbar_align: "left",
	//theme_advanced_styles : "Standard (11px)=font-11px,Large (14px)=font-14px",
	
	theme_advanced_buttons1: "fontselect, styleselect, formatselect, |, bold, italic, strikethrough, |, justifyleft, justifycenter, justifyright, justifyfull, |, bullist, sub, spellchecker, image, link, unlink, forecolor, backcolor, charmap, cleanup, code, removeformat ",
	theme_advanced_buttons2 : "tablecontrols, |, cut,copy,paste,pastetext,pasteword",
	theme_advanced_buttons3: "",
	content_css : '/webpublisher/tiny_mce/custom.css'

});
-->
</script>
<?php } ?>
<script type="text/javascript">
<!--
function keepAlive() {
    var imgAlive = new Image();
    var date = new Date();
    imgAlive.src = 'nonexistentfile.php?date=' + date;
}

setInterval("keepAlive()", 60*1000);
-->
</script>
<script type="text/javascript" src="js/jquery.1.2.6.js"></script>
<script type="text/javascript" src="js/interface.js"></script>
<script type="text/javascript" src="js/ajaxfileupload.js"></script>

<link rel="stylesheet" href="js/ui-lightness/jquery.ui.all.css">
<script src="js/jquery-1.6.2.js"></script>
<script src="js/jquery.ui.core.js"></script>
<script src="js/jquery.ui.widget.js"></script>
<script src="js/jquery.ui.datepicker.js"></script>

</head>
