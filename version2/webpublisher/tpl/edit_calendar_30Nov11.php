  <?php
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
						?><div id="my_calendar" style="margin:20px; width:90%;  ">
						<?php  $sql="select * from event where cur_date='$end_date'"; ?>
						<h2>Edit Events</h2><br>
						<table>
						<tr><th valign="top">Title:</th><td><input name="event_title" type="text" value="" /></td></tr>
						<tr><th valign="top">Event Description:</th><td><textarea name="event_desciption"></textarea></td></tr>
						<tr><th valign="top">Due Date:</th><td><input name="start_date" type="text" /></td></tr>
						</table><br><br>
						</div>