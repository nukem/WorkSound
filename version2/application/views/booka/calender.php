<div id="calendar" style="display:block;">
	<?php
	$aid = $this->session->userdata('artist_id');
	$today = getdate();
	if(!isset($_REQUEST['year'])){
	$year = $today['year'];
	$month = $today['mon'];
	}
	require ("fn.cal.php");
	
	
	$events = array();
	$firstday = date("Y-m-d",strtotime("$year-$month-01"));
	$lastday = date("Y-m-d",strtotime("+1 day",strtotime("$year-$month-".date("t",strtotime($firstday)))));
	$query = "SELECT event_title as title,event_description, DATE_FORMAT(start_date,'%Y-%m-%d') AS start_date,DATE_FORMAT(end_date,'%Y-%m-%d') AS end_date FROM event WHERE start_date between '$firstday' and '$lastday' and artist_id='$aid'";
	//echo $query;
	$result = mysql_query($query) ;
	while($row = mysql_fetch_array($result)) {
	  $events[date('Y-m-d',strtotime($row['start_date']))][] = $row;
	}
	?><div id="my_calendar" style="margin:10px; width:100%;  ">
	
	<input class="input_continue" type="button" onClick="window.open('<?=base_url()?>booka/editcalender?aid=<?php echo $aid; ?>&eventid=','mywindow','menubar=1,resizable=1,width=450,height=450,left=500,top=300');" name="event" value="Add Event" style="background-image:none;width: 145px !important;">
	


	<table style="margin:5px 0px;"><tr>
		<!--<th><?=date('F',mktime(0,0,0,$month,1,$year)).' '.$year;?></th>-->
		
		
		<td><?=$controls;?></td>
		
	</tr></table>
	<?php
	echo draw_calendar($month,$year,$events);
	?></div>
	</form>
	
</div>