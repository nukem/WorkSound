<?php
ini_set("display_errors",1);
define("DATE_ATOM","Y-m-d\TH:i:sP",true);
require_once 'Zend/Loader.php';
require_once('tpl/class.calendar.php');
Zend_Loader::loadClass('Zend_Gdata');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Gdata_Calendar');
Zend_Loader::loadClass('Zend_Http_Client');
$cal=new GCalendar('soundbooka@gmail.com','soundbooka123');
require ("tpl/inc/head.php"); ?>
<body>
<link type="text/css" rel="stylesheet" href="css/jscal2.css">
<link type="text/css" rel="stylesheet" href="css/border-radius.css">
<script src="js/jscal2.js"></script>
<script src="js/en.js"></script>

<div id="page"> 
<?php require ("tpl/inc/header.php"); ?> 
<?php require ("tpl/inc/path.php"); ?> 
  <div id="content"> 
	  <div id="left-col"> 
		  <div id="left-col-border"> 
<?php if (isset ($errors)) require ("tpl/inc/error.php"); ?> 
<?php if (isset ($messages)) require ("tpl/inc/message.php"); ?> 
<?php if (isset ($_SESSION['epClipboard'])) require ("tpl/inc/clipboard.php"); ?> 
<?php require ("tpl/inc/structure.php"); ?> 
			</div> 
		</div> 
		<div id="right-col"> 
			<h2 class="bar green"><span><?php echo  $record['title'] ?></span></h2> 
			<form action=".?id=<?php echo  $id ?>" method="post" enctype="multipart/form-data" >
		  <div class="right-col-padding1"> 
			
			<div style="float:left; width:75%;">
			<iframe src="http://www.google.com/calendar/embed?src=soundbooka%40gmail.com&ctz=Australia/Sydney" style="border: 0" width="650" height="430" frameborder="0" scrolling="no"></iframe>
			</iframe>
			</div>
			<div style="float:right; width:25%">
			<?php
			if($_POST[submit]=='add event')
			$cal->add_event('server');
			else
			$cal->add_event('local');
			?>
			</div>
        </div> 
      </form>
    </div> 
    <?php require ("tpl/inc/footer.php"); ?> 
  </div> 
</div> 
</body>
</html>


