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
			
			<div style="float:left; width:100%;">
			<!-- Date: 02 Dec'11 EM Code comment starts here -->
			<!--<iframe src="http://www.google.com/calendar/embed?src=soundbooka%40gmail.com&ctz=Australia/Sydney" style="border: 0" width="650" height="430" frameborder="0" scrolling="no"></iframe>-->
			<!-- EM Code ends here -->
			<!-- Date: 02 Dec'11 EM Code starts here for adding Calendar event -->
			<?php require ("tpl/fn.cal.php");
						$events = array();
						$firstday = date("Y-m-d",strtotime("$year-$month-01"));
						$lastday = date("Y-m-d",strtotime("+1 day",strtotime("$year-$month-".date("t",strtotime($firstday)))));
						$query = "SELECT event_title as title,event_description, DATE_FORMAT(start_date,'%Y-%m-%d') AS start_date,DATE_FORMAT(end_date,'%Y-%m-%d') AS end_date FROM event WHERE start_date between '$firstday' and '$lastday' and artist_id='$aid'";
						$qry = mysql_query("select event_title from user_event where start_date <= '".$event_day."' and to_date >= '".$event_day."'");
						//echo $query;
						$result = mysql_query($query) ;
						while($row = mysql_fetch_array($result)) {
						  $events[date('Y-m-d',strtotime($row['start_date']))][] = $row;
						} 
						echo '<h2 style="float:left; padding-right:30px;">'.date('F',mktime(0,0,0,$month,1,$year)).' '.$year.'</h2>';
						echo '<div style="float:left;">'.$controls.'</div>';
						echo '<div style="clear:both;"></div>';
						echo draw_calendar($month,$year,$events);	
			?>
			<!-- EM Code ends here -->
			</div>
			
			<!-- Date: 02 Dec'11 EM Code comment starts here
			<div style="float:right; width:25%">
			
			<?php
			if($_POST[submit]=='add event')
			$cal->add_event('server');
			else
			$cal->add_event('local');
			?>
			</div>
			EM Code ends here -->
			
        </div> 
      </form>
    </div> 
    <?php require ("tpl/inc/footer.php"); ?> 
  </div> 
</div> 
</body>
</html>


