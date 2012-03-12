<style>
/* calendar */
table.calendar    { border-left:1px solid #999; }
tr.calendar-row  {  }
td.calendar-day  { min-height:80px; font-size:11px; position:relative; } * html div.calendar-day { height:80px; }
td.calendar-day:hover  { background:#eceff5; }
td.calendar-day-np  { background:#D1D1D1; min-height:80px; } * html div.calendar-day-np { height:80px; }
td.calendar-day-head { background:#FF5C32; font-weight:bold; text-align:center; width:120px; padding:5px; border-bottom:1px solid #999; border-top:1px solid #999; border-right:1px solid #999; }
div.day-number    { background:#999; padding:5px; color:#fff; font-weight:bold; float:right; margin:-5px -5px 0 0; width:20px; text-align:center; }
/* shared */
td.calendar-day, td.calendar-day-np { width:120px; padding:5px; border-bottom:1px solid #999; border-right:1px solid #999; }
div.day-number   { 
  background:#999; 
  position:absolute; 
  z-index:2; 
  top:-5px; 
  right:-25px; 
  padding:5px; 
  color:#fff; 
  font-weight:bold; 
  width:20px; 
  text-align:center; 
}
td.calendar-day, td.calendar-day-np { 
  width:120px; 
  padding:5px 25px 5px 5px; 
  border-bottom:1px solid #999; 
  border-right:1px solid #999; 
}
.event{
	background:#eee;
	height; 100%;
	margin: 5px;
}
</style>
<script type="text/javascript" src="<?=base_url()?>js/jquery.lightbox.js"></script>
<script type="text/javascript" language="javascript">
	// Date: 06 Dec'11 EM Code starts here
		function openwindow1(ev)
		{
			window.open('../editcalender?aid=','mywindow','menubar=1,resizable=1,width=500,height=450,left=500,top=300');
			return false;
		}
		
		function openwindow(e, eventid)
		{
			window.open('../editcalender?aid=&eventid='+eventid,'mywindow','menubar=1,resizable=1,width=500,height=450,left=500,top=300');
			if (e.stopPropagation){
       	e.stopPropagation();
   		}
   			else if(window.event){
      	window.event.cancelBubble=true;
   		}
			return false;
		}
		
		function blockwindow(e)
		{
			if (e.stopPropagation){
      	e.stopPropagation();
   		}
   			else if(window.event){
      	window.event.cancelBubble=true;
   		}
		}
		// EM Code ends here
</script>
<?php
if(isset($_REQUEST['month'])){
$aid = $_REQUEST['aid'];
}else{
$aid = $this->session->userdata('artist_id');
}
// Date: 05 Dec'11 EM Code starts here
function getEvents($eventid)
{
		require ('configevent.php');
		$qry = mysql_query("select * from user_event where id= '".$eventid."'");
		$row_event = mysql_fetch_array($qry);
		return $row_event;
}
// EM Code ends here
function draw_calendar($month,$year,$events = array()){

  /* draw table */
  $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

  /* table headings */
  $headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
  $calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

  /* days and weeks vars now ... */
  $running_day = date('w',mktime(0,0,0,$month,1,$year));
  $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
  $days_in_this_week = 1;
  $day_counter = 0;
  $dates_array = array();

  /* row for week one */
  $calendar.= '<tr class="calendar-row">';

  /* print "blank" days until the first of the current week */
  for($x = 0; $x < $running_day; $x++):
    $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
    $days_in_this_week++;
  endfor;

  /* keep going with days....
  
    $calendar.= '<td class="calendar-day" onClick=alert(\"aman\"); window.open(\"\www.facebook.com\"\,"\"\mywindow\"\,\"\menubar=1,resizable=1,width=350,height=250,left=500,top=400\"\);">
	alert(\'sd\');
   */
   
  for($list_day = 1; $list_day <= $days_in_month; $list_day++):
  // Date: 30 Nov 2011 EM Code starts here

    $calendar.= '<td class="calendar-day" id="calendarclick">&nbsp;<div style="position:relative;height:100px;">';
    // EM Code ends here
      /* add in the day number */
      $calendar.= '<div class="day-number">'.$list_day.'</div>';
      
      
      // Date: 01 Dec'11 EM Code starts here
     if(strlen($list_day) == 1):
      	$list_day = "0".$list_day;
      endif;
	  if(strlen($month) == 1):
      	$month = "0".$month;
      endif;
	  $event_day = $year.'-'.$month.'-'.$list_day;
     // $event_day = $list_day.'/'.$month.'/'.$year;
	    echo '<div style="display:none;">';
		echo $sql = "select u.id,u.event_title,u.start_date,u.start_time from user_event as u  left join user_event_detail as u_d on u.id = u_d.parenteventid where u_d.startDate <= '".$event_day."' and u_d.endDate >= '".$event_day."'";
		$qry = mysql_query($sql);
		$count = mysql_num_rows($qry);
		echo '</div>';
	  	$i = 1;
      while($row_qry = mysql_fetch_array($qry))
      {
      	//<a href="#" onclick="window.open(\'tpl/edit_calendar.php?aid='.$aid.'&eventid='.$row_qry['id'].'\',\'mywindow\',\'menubar=1,resizable=1,width=450,height=450,left=500,top=300\');">'.$row_qry['event_title'].'</a>
     	if($i < 3)
     	{
			$eventid = $row_qry['id'];
			$calendar.= '<div class="event">
			  <a href="#" onclick="return openwindow(event, \''.$eventid.'\');">'.$row_qry['start_time'].'&nbsp;'.$row_qry['event_title'].'</a>
			</div>';
			}
     
      $i++;
    	}
    	
    	// Date: 07 Dec'11 EM Code starts here
    	if($i > 2):
    	$calendar.= '<div class="event">
			<a href="javascript:void(0);" onclick="return blockwindow(event);">More...</a>
		</div>';	
      endif;
      //$this->db->select("select event_title from user_event where start_date <= '".$event_day."' and to_date >= '".$event_day."'");
			//$query = $this->db->get('mytable');
			//print_r($query);
      // EM Code ends here
      
      if(isset($events[$event_day])) {
        foreach($events[$event_day] as $event) {
          $calendar.= '<div class="event">'.$event['title'].'</div>';
        }
        
      }
      else {
        $calendar.= str_repeat('<p>&nbsp;</p>',2);
      }
    $calendar.= '</div></td>';
    if($running_day == 6):
      $calendar.= '</tr>';
      if(($day_counter+1) != $days_in_month):
        $calendar.= '<tr class="calendar-row">';
      endif;
      $running_day = -1;
      $days_in_this_week = 0;
    endif;
    $days_in_this_week++; $running_day++; $day_counter++;
  endfor;

  /* finish the rest of the days in the week */
  if($days_in_this_week < 8):
    for($x = 1; $x <= (8 - $days_in_this_week); $x++):
      $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
    endfor;
  endif;

  /* final row */
  $calendar.= '</tr>';
  

  /* end the table */
  $calendar.= '</table>';

  /** DEBUG **/
  $calendar = str_replace('</td>','</td>'."\n",$calendar);
  $calendar = str_replace('</tr>','</tr>'."\n",$calendar);
  
  /* all done, return result */
  return $calendar;
}

function random_number() {
  srand(time());
  return (rand() % 7);
}
/* date settings */
$today = getdate();
$year = $today['year'];


if(isset($_REQUEST['month'])){
$month = (int) ($_REQUEST['month'] ? $_REQUEST['month'] : date('m'));
}else{
$month = $today['mon'];
}
if(isset($_REQUEST['month'])){
$year = (int)  ($_REQUEST['year'] ? $_REQUEST['year'] : date('Y'));
}else{
$year = $today['year'];
}
echo '<form method="post">';
echo '<input type="hidden" name="aid" value="'.$this->session->userdata('artist_id').'">';
/* select month control */
$select_month_control = '<div class="simu_select3">';
$select_month_control .= '<select name="month" id="month">';
for($x = 1; $x <= 12; $x++) {
  $select_month_control.= '<option value="'.$x.'"'.($x != $month ? '' : ' selected="selected"').'>'.date('F',mktime(0,0,0,$x,1,$year)).'</option>';
}
$select_month_control .= '</select>';
$select_month_control .= '</div>';

/* select year control */
$select_year_control = '<div class="simu_select4">';
$year_range = 7;
$select_year_control .= '<select name="year" id="year">';
for($x = ($year-floor($year_range/2)); $x <= ($year+floor($year_range/2)); $x++) {
  $select_year_control.= '<option value="'.$x.'"'.($x != $year ? '' : ' selected="selected"').'>'.$x.'</option>';
}
$select_year_control.= '</select>';
$select_year_control .='</div>';


/* "next month" control */
$next_month_link = '<a href=".?aid='.$aid.'&month='.($month != 12 ? $month + 1 : 1).'&year='.($month != 12 ? $year : $year + 1).'" class="control">Next Month &gt;&gt;</a>';

/* "previous month" control */
$previous_month_link = '<a href=".?aid='.$aid.'&month='.($month != 1 ? $month - 1 : 12).'&year='.($month != 1 ? $year : $year - 1).'" class="control">&lt;&lt;   Previous Month</a>';

/* bringing the controls together */
/*$controls = '<div style="margin-left:215px;">
			<div class="input_continue" style="background-image:none;float:left;margin-right: 8px;padding-top: 5px;text-indent: 5px;">'.$previous_month_link.'</div><div style="float:left;margin:5px 0 0 5px;">'.$select_month_control.$select_year_control.'<input  class="input_continue" type="button" value="Go" style="width: 35px !important;"/></div>
			<div class="input_continue" style="background-image:none;margin-right: 8px;padding-top: 5px;text-indent: 5px;margin-left:10px;width:105px !important; >'.$next_month_link.'</div></div>';*/
			
$controls = $select_month_control.$select_year_control.'&nbsp;<input type="submit" name="submit" value="Go" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$previous_month_link.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$next_month_link;
	
/* get all events for the given month */
