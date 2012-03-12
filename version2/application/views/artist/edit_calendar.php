 <?php
 // EM Code starts here
 
 $eventid = trim($_REQUEST['eventid']);
 require ("fn.cal.php");
 $events = getEvents($eventid);
 ?>
  <html>
  <head>
<link rel="stylesheet" href="http://www.soundbooka.com/version1/webpublisher/css/layout.css" type="text/css" media="screen,projection" />
  <script type="text/javascript" language="javascript">
  function selsize()
		{		
			
			
			var check = document.getElementById('repeater').checked;
			if(check == true)
			{
				document.getElementById('RadioGroup1_0').disabled=false;
				document.getElementById('RadioGroup1_1').disabled=false;	
				document.getElementById('RadioGroup1_2').disabled=false;
				document.getElementById('radio_yearly').disabled=false;		
				document.getElementById('occurencetd').style.display ='block';	
			}
			else
			{
				document.getElementById('RadioGroup1_0').disabled=true;
				document.getElementById('RadioGroup1_1').disabled=true;
				document.getElementById('RadioGroup1_2').disabled=true;
				document.getElementById('radio_yearly').disabled=true;
				
				document.getElementById('RadioGroup1_0').checked =false;
				document.getElementById('RadioGroup1_1').checked =false;
				document.getElementById('RadioGroup1_2').checked =false;
				document.getElementById('radio_yearly').checked =false;
				document.getElementById('event_occ').value = '';
				document.getElementById('daily').value = '';
				document.getElementById('weekly').value = '';
				document.getElementById('monthly').value = '';
				document.getElementById('select_weekly').value = '-1';
				document.getElementById('select_monthly').value = '-1';
				document.getElementById('select_yearly').value = '-1';
				document.getElementById('selectmonth').value = '-1';
				document.getElementById('occurencetd').style.display ='none';	
			}
				
				
			if(document.getElementById('RadioGroup1_0').checked)
				toggletd(document.getElementById('RadioGroup1_0'));
			else if(document.getElementById('RadioGroup1_1').checked)	
				toggletd(document.getElementById('RadioGroup1_1'));
			else if(document.getElementById('RadioGroup1_2').checked)
				toggletd(document.getElementById('RadioGroup1_2'));
			else if(document.getElementById('radio_yearly').checked)
				toggletd(document.getElementById('radio_yearly'));
			else
				{
					document.getElementById('dailytd').style.display ='none';
					document.getElementById('weeklytd').style.display ='none';
					document.getElementById('monthlytd').style.display ='none';
					document.getElementById('yearlytd').style.display ='none';
				}
				
				
		}
		
		function toggletd(cntrl)
		{
			if(cntrl.checked)
			{
				if(cntrl.value=='1')
				{
					document.getElementById('dailytd').style.display ='block';
					
					document.getElementById('weeklytd').style.display ='none';
					document.getElementById('monthlytd').style.display ='none';
					document.getElementById('yearlytd').style.display ='none';
				}
				else if(cntrl.value=='2')	
				{
					document.getElementById('dailytd').style.display ='none';
					//document.getElementById('weeklytd').style.display ='block';
					document.getElementById('monthlytd').style.display ='none';
					document.getElementById('yearlytd').style.display ='none';
				}	
				else if(cntrl.value=='3')
				{	
					document.getElementById('dailytd').style.display ='none';
					document.getElementById('weeklytd').style.display ='none';
					//document.getElementById('monthlytd').style.display ='block';
					document.getElementById('yearlytd').style.display ='none';			
				}
				else if(cntrl.value=='4')	
				{
					document.getElementById('dailytd').style.display ='none';
					document.getElementById('weeklytd').style.display ='none';
					document.getElementById('monthlytd').style.display ='none';
					//document.getElementById('yearlytd').style.display ='block';
				}	
			}
		}
		
		
		</script>
		

<link type="text/css" href="http://www.soundbooka.com/version1/webpublisher/jquery/css/smoothness/jquery-ui-1.8.5.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="http://www.soundbooka.com/version1/webpublisher/jquery/development-bundle/jquery-1.4.2.js"></script>
<script type="text/javascript" src="http://www.soundbooka.com/version1/webpublisher/jquery/development-bundle/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="http://www.soundbooka.com/version1/webpublisher/jquery/development-bundle/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="http://www.soundbooka.com/version1/webpublisher/jquery/development-bundle/ui/jquery.ui.datepicker.js"></script>   
<script type="text/javascript">
	window.onload = function(){
	
		selsize();
	};
</script>
<script type="text/javascript" language="javascript">
	function days_between(date1, date2) {

    // The number of milliseconds in one day
    var ONE_DAY = 1000 * 60 * 60 * 24

    // Convert both dates to milliseconds
    var date1_ms = date1.getTime()
    var date2_ms = date2.getTime()

    // Calculate the difference in milliseconds
    var difference_ms = Math.abs(date1_ms - date2_ms)
    
    // Convert back to days and return
    return Math.round(difference_ms/ONE_DAY)

}

	function validateForm()
		{
						var date1=document.frmedit.event_start_date.value;	
						var tmpdate1=date1.split("/");	
						var date2=document.frmedit.event_to_date.value;
						var tmpdate2=date2.split("/");
						var tmpdate11 = new Date(tmpdate1[2], tmpdate1[1], tmpdate1[0]);
						var tmpdate22 =new Date(tmpdate2[2], tmpdate2[1], tmpdate2[0]);
						var errormsg;
            errormsg = "";
            var diff = days_between(tmpdate22, tmpdate11);
            var check = document.getElementById('repeater').checked;
			
			var startime = document.frmedit.event_start_time.value;
			var endtime = document.frmedit.event_end_time.value;
			var tmptime1  = startime.split(":");
			var tmptime2 = endtime.split(":");
			/*if(tmptime1[1] > 0)
			{
				var tmptimemin = tmptime1[1];
			}else{
				tmptimemin = "";
			}
			
			if(tmptime2[1] > 0)
			{
				var tmptime2min = tmptime2[1];
			}else{
				tmptime2min = "";
			} */
			var eventstarttime = ( tmptime1[0] * 60 * 60 ) + (tmptime1[1] * 60);
			var eventendtime = ( tmptime2[0] * 60 * 60) + (tmptime2[1] * 60);
			//var todayDate = new Date(yyyy,mm,dd);
           //alert(todayDate);
          	//return false;
            if (document.frmedit.event_title.value == "")
            {
                errormsg += "Please fill in 'Event Title'.\n";
            }
						
						if (document.frmedit.event_loc.value == "")
            {
                errormsg += "Please fill in 'Event Location'.\n";
            }
            
            if (document.frmedit.event_desc.value == "")
            {
                errormsg += "Please fill in 'Event Description'.\n";
            }
            
            if(date1 == "" || date2 == "")
            {
            	errormsg += "Please fill in 'Event Start Date and Event End Date'.\n";	
            }
            
            if(date1 == "DD/MM/YYYY" || date2 == "DD/MM/YYYY")
            {
            	errormsg += "Please fill in 'Event Start Date and Event End Date'.\n";	
            }
            
            if(date1!="" && date1!="DD/MM/YYYY" && date2 !="" && date2!="DD/MM/YYYY")
						{	
							
								
							if ( tmpdate22 < tmpdate11 )
								errormsg += "'Event Start Date' should be less than 'Event To Date'.\n";
						}
						
						if(date1 == date2)
						{
							if(eventstarttime > eventendtime)
							{
								errormsg += "'Event Start Time' should be less than 'Event End Time'.\n";
							}
						}
						if(check == true)
            {
            	if(document.getElementById('RadioGroup1_0').checked == true && diff > 0)
            	{
            			errormsg += "'Event Start Date and Event End Date' must be same for Repeat Daily Events.\n";
            	}	
            	
            	if(document.getElementById('RadioGroup1_1').checked == true && diff > 7)
            	{
            			errormsg += "Difference of 'Event Start Date and Event End Date' must not exceed 7 days for Repeat Weekly Events.\n";
            	}
            	
            	if(document.getElementById('RadioGroup1_2').checked == true && diff > 31)
            	{
            			errormsg += "Difference of 'Event Start Date and Event End Date' must not exceed 31 days for Repeat Monthly Events.\n";
            	}
            	
            	if(document.getElementById('radio_yearly').checked == true && diff > 365)
            	{
            			errormsg += "Difference of 'Event Start Date and Event End Date' must not exceed 365 days for Repeat Yearly Events.\n";
            	}
            	
            	if(document.frmedit.event_occ.value == "" || document.frmedit.event_occ.value < 1 || isNaN(document.frmedit.event_occ.value))
            	{
            			errormsg += "Please fill in Occurence greater than 0.\n";
            	}
            }
						
            if ((errormsg == null) || (errormsg == ""))
            {
                document.frmedit.btnsubmit.disabled=true;
                return true;
            }
            else
            {
                alert(errormsg);
                return false;
            }
		}
		
		$(function(){
	$('.datepicker').datepicker({
		changeDate: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd/mm/yy',
		yearRange: '1900:+0'
	});			
});
	</script>

	</head>
  <?php
  					$repeat_check = "";
  					if($events['daily'] > 0 || $events['weekly'] > 0 || $events['monthly'] > 0 || $events['yearly'] > 0)
  					{
  							$repeat_check = "checked='checked'";
  					}
  											/*$events = array();
						$firstday = date("Y-m-d",strtotime("$year-$month-01"));
						$lastday = date("Y-m-d",strtotime("+1 day",strtotime("$year-$month-".date("t",strtotime($firstday)))));
						$query = "SELECT event_title as title,event_description, DATE_FORMAT(start_date,'%Y-%m-%d') AS start_date,DATE_FORMAT(end_date,'%Y-%m-%d') AS end_date FROM event WHERE start_date between '$firstday' and '$lastday' and artist_id='$aid'";*/
						//echo $query;
						/*$result = mysql_query($query) ;
						while($row = mysql_fetch_array($result)) {
						  $events[date('Y-m-d',strtotime($row['start_date']))][] = $row;
						} */
						?>
						<body> 
						<div id="content" style="margin:20px; width:90%; padding-left:15px; padding-top:5px;">
						<?php if(!empty($eventid)) { ?>
							<h2>Edit Events</h2><br>
						<?php } else { ?>
							<h2>Add Events</h2><br>
						<?php } ?>
						<table cellpadding="5" cellspacing="5" border="0" style="border-collapse: separate;">
							<form name="frmedit" action="http://www.soundbooka.com/version1/index.php/artist/savevent" method="post" onSubmit="return validateForm();"> 
							<!-- Date: 30 Nov'11 EM Code starts here -->
						<tr><td valign="top" width="100px;" align="left">Title:</th><td><input style="width:150px;" class="textfield" name="event_title" type="text" value="<?php echo $events['event_title']; ?>" /></td></tr>
						<tr><td valign="top" width="100px;" align="left">Location:</th><td><input style="width:150px;" class="textfield" name="event_loc" type="text" value="<?php echo $events['event_loc']; ?>" /></td></tr>
						<tr><td valign="top" width="100px;" align="left">Description:</th><td><textarea style="width:150px;" class="textfield" name="event_desc"><?php echo $events['event_desc']; ?></textarea></td></tr>
						<tr><td valign="top" width="100px;" align="left">From Date:</th><td>
							<input class="datepicker" name="event_start_date" value="<?php echo $events['start_date'] != "" ? $events['start_date'] : 'DD/MM/YYYY'; ?>" type="text" style="font-family: Arial; font-size: 11px; margin-top:2px;"  />&nbsp;
							<select name="event_start_time" id="event_start_time" class="textfield" style="width:80px; padding-top:1px; padding-bottom:1px;">
												<option value="00:01">00:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="00:30")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="00:30" <?php echo $sel_endtime; ?>>00:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="01:00")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="01:00" <?php echo $sel_endtime; ?>>01:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="01:30")
												{
												$sel_endtime="selected";
												}
												?>
                          <option value="01:30" <?php echo $sel_endtime; ?>>01:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="02:00")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="02:00" <?php echo $sel_endtime; ?>>02:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="02:30")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="02:30" <?php echo $sel_endtime; ?>>02:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="03:00")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="03:00" <?php echo $sel_endtime; ?>>03:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="03:30")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="03:30" <?php echo $sel_endtime; ?>>03:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="04:00")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="04:00" <?php echo $sel_endtime; ?>>04:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="04:30")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="04:30" <?php echo $sel_endtime; ?>>04:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="05:00")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="05:00" <?php echo $sel_endtime; ?>>05:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="05:30")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="05:30" <?php echo $sel_endtime; ?>>05:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="06:00")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="06:00" <?php echo $sel_endtime; ?>>06:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="06:30")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="06:30" <?php echo $sel_endtime; ?>>06:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="07:00")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="07:00"  <?php echo $sel_endtime; ?>>07:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="07:30")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="07:30"  <?php echo $sel_endtime; ?>>07:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="08:00")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="08:00"  <?php echo $sel_endtime; ?>>08:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="08:30")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="08:30"  <?php echo $sel_endtime; ?>>08:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="09:00")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="09:00"  <?php echo $sel_endtime; ?>>09:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="09:30")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="09:30"  <?php echo $sel_endtime; ?>>09:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="10:00")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="10:00"  <?php echo $sel_endtime; ?>>10:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="10:30")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="10:30"  <?php echo $sel_endtime; ?>>10:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="11:00")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="11:00"  <?php echo $sel_endtime; ?>>11:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="11:30")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="11:30"  <?php echo $sel_endtime; ?>>11:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="12:00")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="12:00"  <?php echo $sel_endtime; ?>>12:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="12:30")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="12:30"  <?php echo $sel_endtime; ?>>12:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="13:00")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="13:00"  <?php echo $sel_endtime; ?>>13:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="13:30")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="13:30"  <?php echo $sel_endtime; ?>>13:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="14:00")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="14:00"  <?php echo $sel_endtime; ?>>14:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="14:30")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="14:30" <?php echo $sel_endtime; ?> >14:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="15:00")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="15:00" <?php echo $sel_endtime; ?> >15:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="15:30")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="15:30" <?php echo $sel_endtime; ?> >15:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="16:00")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="16:00" <?php echo $sel_endtime; ?> >16:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="16:30")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="16:30"  <?php echo $sel_endtime; ?>>16:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="17:00")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="17:00" <?php echo $sel_endtime; ?> >17:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="17:30")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="17:30" <?php echo $sel_endtime; ?> >17:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="18:00")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="18:00"  <?php echo $sel_endtime; ?>>18:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="18:30")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="18:30" <?php echo $sel_endtime; ?> >18:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="19:00")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="19:00" <?php echo $sel_endtime; ?> >19:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="19:30")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="19:30" <?php echo $sel_endtime; ?> >19:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="20:00")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="20:00" <?php echo $sel_endtime; ?> >20:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="20:30")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="20:30" <?php echo $sel_endtime; ?> >20:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="21:00")
												{
												$sel_endtime="selected";
												}
												?>
                         <option value="21:00" <?php echo $sel_endtime; ?> >21:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="21:30")
												{
												$sel_endtime="selected";
												}
												?>

                         <option value="21:30" <?php echo $sel_endtime; ?> >21:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="22:00")
												{
												$sel_endtime="selected";
												}
												?>

                         <option value="22:00" <?php echo $sel_endtime; ?> >22:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="22:30")
												{
												$sel_endtime="selected";
												}
												?>

                         <option value="22:30" <?php echo $sel_endtime; ?> >22:30</option>   
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="23:00")
												{
												$sel_endtime="selected";
												}
												?>

                         <option value="23:00"  <?php echo $sel_endtime; ?>>23:00</option>
												<?php
												$sel_endtime="";
												
												if($events["start_time"]=="23:30")
												{
												$sel_endtime="selected";
												}
												?>

                         <option value="23:30" <?php echo $sel_endtime; ?> >23:30</option>   
                         <?php $sel_endtime = ""; ?>
								</select>
							</td></tr>
						<tr><td valign="top" width="100px;" align="left">To Date:</th><td>
							<input class="datepicker" name="event_to_date" value="<?php echo $events['to_date'] != "" ? $events['to_date'] : 'DD/MM/YYYY'; ?>" type="text" style="font-family: Arial; font-size: 11px; margin-top:2px;"  />&nbsp;
							<select name="event_end_time" class="textfield" id="event_end_time" style="width:80px; padding-top:1px; padding-bottom:1px;">
											<option value="00:01">00:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="00:30")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="00:30" <?php echo $sel_endtime; ?>>00:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="01:00")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="01:00" <?php echo $sel_endtime; ?>>01:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="01:30")
											{
											$sel_endtime="selected";
											}
											?>
                        <option value="01:30" <?php echo $sel_endtime; ?>>01:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="02:00")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="02:00" <?php echo $sel_endtime; ?>>02:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="02:30")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="02:30" <?php echo $sel_endtime; ?>>02:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="03:00")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="03:00" <?php echo $sel_endtime; ?>>03:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="03:30")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="03:30" <?php echo $sel_endtime; ?>>03:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="04:00")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="04:00" <?php echo $sel_endtime; ?>>04:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="04:30")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="04:30" <?php echo $sel_endtime; ?>>04:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="05:00")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="05:00" <?php echo $sel_endtime; ?>>05:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="05:30")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="05:30" <?php echo $sel_endtime; ?>>05:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="06:00")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="06:00" <?php echo $sel_endtime; ?>>06:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="06:30")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="06:30" <?php echo $sel_endtime; ?>>06:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="07:00")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="07:00"  <?php echo $sel_endtime; ?>>07:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="07:30")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="07:30"  <?php echo $sel_endtime; ?>>07:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="08:00")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="08:00"  <?php echo $sel_endtime; ?>>08:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="08:30")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="08:30"  <?php echo $sel_endtime; ?>>08:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="09:00")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="09:00"  <?php echo $sel_endtime; ?>>09:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="09:30")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="09:30"  <?php echo $sel_endtime; ?>>09:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="10:00")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="10:00"  <?php echo $sel_endtime; ?>>10:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="10:30")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="10:30"  <?php echo $sel_endtime; ?>>10:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="11:00")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="11:00"  <?php echo $sel_endtime; ?>>11:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="11:30")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="11:30"  <?php echo $sel_endtime; ?>>11:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="12:00")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="12:00"  <?php echo $sel_endtime; ?>>12:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="12:30")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="12:30"  <?php echo $sel_endtime; ?>>12:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="13:00")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="13:00"  <?php echo $sel_endtime; ?>>13:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="13:30")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="13:30"  <?php echo $sel_endtime; ?>>13:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="14:00")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="14:00"  <?php echo $sel_endtime; ?>>14:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="14:30")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="14:30" <?php echo $sel_endtime; ?> >14:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="15:00")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="15:00" <?php echo $sel_endtime; ?> >15:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="15:30")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="15:30" <?php echo $sel_endtime; ?> >15:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="16:00")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="16:00" <?php echo $sel_endtime; ?> >16:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="16:30")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="16:30"  <?php echo $sel_endtime; ?>>16:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="17:00")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="17:00" <?php echo $sel_endtime; ?> >17:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="17:30")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="17:30" <?php echo $sel_endtime; ?> >17:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="18:00")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="18:00"  <?php echo $sel_endtime; ?>>18:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="18:30")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="18:30" <?php echo $sel_endtime; ?> >18:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="19:00")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="19:00" <?php echo $sel_endtime; ?> >19:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="19:30")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="19:30" <?php echo $sel_endtime; ?> >19:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="20:00")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="20:00" <?php echo $sel_endtime; ?> >20:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="20:30")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="20:30" <?php echo $sel_endtime; ?> >20:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="21:00")
											{
											$sel_endtime="selected";
											}
											?>
                       <option value="21:00" <?php echo $sel_endtime; ?> >21:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="21:30")
											{
											$sel_endtime="selected";
											}
											?>

                       <option value="21:30" <?php echo $sel_endtime; ?> >21:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="22:00")
											{
											$sel_endtime="selected";
											}
											?>

                       <option value="22:00" <?php echo $sel_endtime; ?> >22:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="22:30")
											{
											$sel_endtime="selected";
											}
											?>

                       <option value="22:30" <?php echo $sel_endtime; ?> >22:30</option>   
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="23:00")
											{
											$sel_endtime="selected";
											}
											?>

                       <option value="23:00"  <?php echo $sel_endtime; ?>>23:00</option>
											<?php
											$sel_endtime="";
											
											if($events["end_time"]=="23:30")
											{
											$sel_endtime="selected";
											}
											?>

                       <option value="23:30" <?php echo $sel_endtime; ?> >23:30</option>  
								</select>
							
							</td></tr>
						<tr><td valign="top" width="100px;" align="left">Repeat</td>
								<td><input style="margin:0px;" type="checkbox" value="1" <?php echo $repeat_check; ?>  name="repeater" id="repeater" onClick="selsize();" /></td>
						</tr>
						<tr>
								<td colspan="2" align="left" valign="top">
									<table id="repeattable" border="0" width="500px" cellspacing="3" cellpadding="0">
				<tr>
					<td width="100px;" align="left">Daily&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>	
				<?php
			 	if($events['daily']=="1")
			 	{
			 		if(trim($events['daily_interval'])!="")			 		
			 		{
			 			if(intval($events['daily_interval'])>0)
			 			{
			 				$strDaily=trim($events['daily_interval']);
			 			}
			 		}
			 	}				
			 	?>
					<td > <input <?php if($events['daily']=="1") echo "checked='checked'"; ?> style="margin:0 5px 0 0;float:left" type="radio" name="radio_daily" value="1" id="RadioGroup1_0" class="radio" onClick="//toggletd(this);"/> &nbsp;&nbsp;
						<div id="dailytd" style="float:left; display:none;">					
							<input MaxLength="2"  id="daily" name="daily" style="width:30px;float:left;margin:0 5px 0 0;" type="text" value="<?php echo $strDaily;?>" /> <span style="float:left;margin:0 5px 0 0;">Day(s)</span>
						</div> 
					</td>
				</tr>
				<tr>
				<td width="100px;" align="left">Weekly&nbsp;</td>
				<?php
			 	$selected="";
			 	$strDaily="0";
			 	$str_weekly_Day="";
			 	if($events['weekly']==1)
			 	{			 		
			 		if(trim($events['weekly_interval'])!="")			 		
			 		{
			 			if(intval($events['weekly_interval'])>0)
			 			{
			 				$strDaily=trim($events['weekly_interval']);
			 			}			 			
			 		}
			 		if(trim($events['weekly_interval_day'])!="")			 		
			 		{
			 			if(intval($events['weekly_interval_day'])>0)
			 			{
			 				$str_weekly_Day=trim($events['weekly_interval_day']);
			 			}			 			
			 		}
			 		
			 	}
				
				
			 	?>
				<td > <input <?php if($events['weekly']=="1") echo "checked='checked'"; ?> style="float:left;margin:0 5px 0 0;" type="radio" name="radio_daily" value="2"  id="RadioGroup1_1" class="radio" onClick="//toggletd(this);"/>
				<div id="weeklytd" style="display:none;">
				<select style="width:100px;float:left;margin:0 5px 0 0;" id="select_weekly" name="select_weekly"class="cmbbox"> 
				<option value="-1">--Select-- </option>
				<?php
				$selected="";
				//echo "strDaily:".$strDaily;
				if(intval(trim($events['weekly_interval']))==1)
				{
				$selected="selected";
				}
				?>
				<option value="1" <?php echo $selected;?> >--Sun-- </option>
				<?php
				$selected="";
				//echo "strDaily:".$strDaily;
				if(intval(trim($events['weekly_interval']))==2)
				{
				$selected="selected";
				}
				?>
				<option value="2" <?php echo $selected;?> >--Mon-- </option>
				<?php
				$selected="";
				if(intval(trim($events['weekly_interval']))==3)
				{
				$selected="selected";
				}
				?>
				<option value="3" <?php echo $selected;?> >--Tues-- </option>
				<?php
				$selected="";
				if(intval(trim($events['weekly_interval']))==4)
				{
				$selected="selected";
				}
				?>
				<option value="4" <?php echo $selected;?> >--Wed-- </option>
				<?php
				$selected="";
				if(intval(trim($events['weekly_interval']))==5)
				{
				$selected="selected";
				}
				?>
				<option value="5" <?php echo $selected;?> >--Thurs-- </option>
				<?php
				$selected="";
				if(intval(trim($events['weekly_interval']))==6)
				{
				$selected="selected";
				}
				?>
				<option value="6" <?php echo $selected;?> >--Fri-- </option>
				<?php
				$selected="";
				if(intval(trim($events['weekly_interval']))==7)
				{
				$selected="selected";
				}
				?>
				<option value="7" <?php echo $selected;?> >--Sat-- </option>
				</select> <span style="float:left;margin:0 5px; ">Of Every</span>
				<input MaxLength="2" class="" id="weekly" name="weekly" style="width:30px;float:left;margin:0 5px 0 0;" type="text" value="<?php echo $str_weekly_Day;?>" /><span style="float:left;margin:0 5px 0 0;"> Week(s)</span>
				</div>
				
				</td>
				</tr>
				<tr>
					<td width="100px;" align="left">Monthly</td>
					<?php
			 	$selected="";
			 	$str_Monthly="0";
			 	$str_Montly_Day="";
			 	if($events['monthly']==1)
			 	{
			 		if(trim($events['monthly_interval'])!="")			 		
			 		{
			 			if(intval($events['monthly_interval'])>0)
			 			{
			 				$str_Monthly=trim($events['monthly_interval']);
			 			}			 			
			 		}
			 		if(trim($events['weekly_interval_day'])!="")			 		
			 		{
			 			if(intval($events['monthly_interval_date'])>0)
			 			{
			 				$str_Monthly_Day=trim($events['monthly_interval_date']);
			 			}			 			
			 		}
			 		
			 	}
			 	?>
					<td > <input <?php if($events['monthly']=="1") echo "checked='checked'"; ?> type="radio" name="radio_daily" style="float:left;margin:0 5px 0 0;" value="3" id="RadioGroup1_2" class="radio" onClick="//toggletd(this);"/>
					<div id="monthlytd" style="display:none;">
				<select style="width:100px;float:left;margin:0 5px;" id="select_monthly" name="select_monthly"class="cmbbox"> 
				<option value="-1">--Select-- </option>
				<?php 
				for ($i=1;$i<32;$i++)
				{
				$selected="";
				if(intval($str_Monthly)==$i)
				{
				$selected="selected";
				}
				?>
				<option value="<?php echo $i;?>" <?php echo $selected;?> ><?php echo $i;?></option>
				<?php
				}
				?>
				
				</select> 
				<span style="float:left;margin:0 5px; 0 0"> Of Every</span>
				<input MaxLength="2" class="" id="monthly" name="monthly" style="width:30px;float:left;margin:0 5px 0 0;" type="text" value="<?php echo $str_Monthly_Day;?>" /> <span style="float:left;margin:0 5px 0 0;"> Month(s)</span>
				</div>
				</td>
				</tr>
				<tr>
					<td width="100px;" align="left">Yearly&nbsp; </td>
					<?php
			 	$selected="";
			 	$str_Yearly="0";
			 	$str_Yearly_Day="";
			 	
			 	if($events['yearly']==1)
			 	{
			 		if(trim($events['yearly_interval_date'])!="")			 		
			 		{
			 			if(intval($events['yearly_interval_date'])>0)
			 			{
			 				$str_Yearly=trim($events['yearly_interval_date']);
			 			}			 			
			 		}
			 		if(trim($events['yearly_interval_month'])!="")			 		
			 		{
			 			if(intval($events['yearly_interval_month'])>0)
			 			{
			 				$str_Yearly_Day=trim($events['yearly_interval_month']);
			 			}			 			
			 		}
			 		
			 	}
			 	//print_r($events);
			 	?>
					<td ><input <?php if($events['yearly']=="1") echo "checked='checked'"; ?> type="radio" name="radio_daily" value="4" id="radio_yearly"  style="float:left;margin:0 5px 0 0;" <?php echo $selected;?> onClick="//toggletd(this);"/>
					<div id="yearlytd" style="display:none;">
					
				<select  style="width:100px;float:left;margin-left:5px;" id="select_yearly" name="select_yearly" class="cmbbox"> 
				<option value="-1">--Select-- </option>
				<?php
				$selected="";
				
				if(intval($str_Yearly_Day)==1)
				{
				$selected="selected";
				}
				?>
				<option value="1" <?php echo $selected;?> >--Jan-- </option>
				<?php
				$selected="";
				if(intval($str_Yearly_Day)==2)
				{
				$selected="selected";
				}
				?>
				<option value="2" <?php echo $selected;?>>--Feb-- </option>
				<?php
				$selected="";
				if(intval($str_Yearly_Day)==3)
				{
				$selected="selected";
				}
				?>
				<option value="3" <?php echo $selected;?> >--Mar-- </option>
				<?php
				$selected="";
				if(intval($str_Yearly_Day)==4)
				{
				$selected="selected";
				}
				?>
				<option value="4" <?php echo $selected;?> >--Apr-- </option>
				<?php
				$selected="";
				if(intval($str_Yearly_Day)==5)
				{
				$selected="selected";
				}
				?>
				<option value="5" <?php echo $selected;?> >--May-- </option>
				<?php
				$selected="";
				if(intval($str_Yearly_Day)==6)
				{
				$selected="selected";
				}
				?>
				<option value="6" <?php echo $selected;?>>--Jun-- </option>
				<?php
				$selected="";
				if(intval($str_Yearly_Day)==7)
				{
				$selected="selected";
				}
				?>
				<option value="7" <?php echo $selected;?> >--Jul-- </option>
				<?php
				$selected="";
				if(intval($str_Yearly_Day)==8)
				{
				$selected="selected";
				}
				?>
				<option value="8" <?php echo $selected;?> >--Aug-- </option>
				<?php
				$selected="";
				if(intval($str_Yearly_Day)==9)
				{
				$selected="selected";
				}
				?>
				<option value="9" <?php echo $selected;?> >--Sep-- </option>
				<?php
				$selected="";
				if(intval($str_Yearly_Day)==10)
				{
				$selected="selected";
				}
				?>
				<option value="10" <?php echo $selected;?>>--Oct-- </option>
				<?php
				$selected="";
				if(intval($str_Yearly_Day)==11)
				{
				$selected="selected";
				}
				?>
				<option value="11" <?php echo $selected;?>>--Nov-- </option>
				<?php
				$selected="";
				if(intval($str_Yearly_Day)==12)
				{
				$selected="selected";
				}
				?>
				<option value="12" <?php echo $selected;?>>--Dec-- </option>
				</select> <span style="float:left;margin:0 5px;">Month </span>&nbsp;&nbsp;&nbsp;&nbsp;
				<select style="width:100px;float:left;margin:0 5px 0 0;"  id="selectmonth" name="selectmonth"class="cmbbox"> 
				<option value="-1">--Select-- </option>
				<?php 
				for ($i=1;$i<32;$i++)
				{
				$selected="";
				if(intval($str_Yearly)==$i)
				{
				$selected="selected";
				}
				?>
				<option value="<?php echo $i;?>"  <?php echo $selected;?> ><?php echo $i;?></option>
				<?php
				}
				?>
				</select> <span style="float:left;margin:0 5px 0 0;">Day(s)</span> 
				
				</div>
					</td>
				</tr>
				
				<tr>
				<td colspan="2">  
					<table id="occurencetd" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td>Repeat End Date</td> 
						<td>
							<input class="datepicker" name="repeat_start_date" value="<?php echo $events['repeat_start_date'] != "" ? $events['repeat_start_date'] : 'DD/MM/YYYY'; ?>" type="text" style="font-family: Arial; font-size: 11px; margin-top:2px;"  />&nbsp;
						</td>
					</tr>
					<tr>
						<td style="width:100px;"></td>					
						<td><input MaxLength="2"  id="event_occ" name="event_occ" style="width:30px;float:left;margin:0 5px 0 0;" type="hidden" value="1" /></td>
					</tr>	
					</table>
				</td>
				</tr>
				
				
		 </table>				
								</td>
							</tr>
						<tr>
								<td colspan="2">
									<input type="hidden" name="is_submit" value="1" />
									<input type="hidden" name="id" value="<?php echo $events['id']; ?>" />
									<input type="submit" name="btnsubmit" value="Submit" class="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="button" onClick="window.close();"  name="close" value="Close" class="button">
									</td>
								
							</tr>
							</form>
						<!-- EM Code ends here -->
						</table><br><br>
						</div>
						</body>
						</html>
						
					