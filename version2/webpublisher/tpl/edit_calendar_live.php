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
					document.getElementById('weeklytd').style.display ='block';
					document.getElementById('monthlytd').style.display ='none';
					document.getElementById('yearlytd').style.display ='none';
				}	
				else if(cntrl.value=='3')
				{	
					document.getElementById('dailytd').style.display ='none';
					document.getElementById('weeklytd').style.display ='none';
					document.getElementById('monthlytd').style.display ='block';
					document.getElementById('yearlytd').style.display ='none';			
				}
				else if(cntrl.value=='4')	
				{
					document.getElementById('dailytd').style.display ='none';
					document.getElementById('weeklytd').style.display ='none';
					document.getElementById('monthlytd').style.display ='none';
					document.getElementById('yearlytd').style.display ='block';
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
	function validateForm()
		{
						var date1=document.frmedit.event_start_date.value;	
						var tmpdate1=date1.split("/");	
						var date2=document.frmedit.event_to_date.value;
						var tmpdate2=date2.split("/");
						var errormsg;
            errormsg = "";					
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
            
            if(date1!="" && date1!="DD/MM/YYYY" && date2 !="" && date2!="DD/MM/YYYY")
						{	
							var tmpdate11 = new Date(tmpdate1[2], tmpdate1[1], tmpdate1[0]);
							var tmpdate22 =new Date(tmpdate2[2], tmpdate2[1], tmpdate2[0]);
								
							if ( tmpdate22 < tmpdate11 )
								errormsg += "'Event Start Date' should be less than 'Event To Date'.\n";
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
  					$eventid = trim($_REQUEST['eventid']);
  					require ("fn.cal.php");
  					$events = getEvents($eventid);
					
					$arrStartDt = explode(" ",$events['start_date']);

					$arrEndDt = explode(" ",$events['to_date']);					
					
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
							<form target="_parent" name="frmedit" action="http://www.soundbooka.com/version1/index.php/artist/savevent" method="post" onsubmit="return validateForm();"> 

							<!-- Date: 30 Nov'11 EM Code starts here -->
						<tr><td valign="top" width="100px;" align="left">Title:</th><td><input style="width:150px;" class="textfield" name="event_title" type="text" value="<?php echo $events['event_title']; ?>" /></td></tr>
						<tr><td valign="top" width="100px;" align="left">Location:</th><td><input style="width:150px;" class="textfield" name="event_loc" type="text" value="<?php echo $events['event_loc']; ?>" /></td></tr>
						<tr><td valign="top" width="100px;" align="left">Description:</th><td><textarea style="width:150px;" class="textfield" name="event_desc"><?php echo $events['event_desc']; ?></textarea></td></tr>
						<tr><td valign="top" width="100px;" align="left">From Date & time:
						</th><td>
						
						<input class="datepicker" name="event_start_date" value="<?php echo 
						$arrStartDt[0] != "" ? $arrStartDt[0] : 'DD/MM/YYYY'; ?>" type="text" style="font-family: Arial; font-size: 11px; margin-top:2px;width:85px;"  />
						
						<input name="event_start_time" value="<?php echo $arrStartDt[1] != "" ? 
						$arrStartDt[1] : '00:00:00'; ?>" type="text" style="font-family: Arial; font-size: 11px; margin-top:2px;width:70px;"  />
						
						</td></tr>
						<tr><td valign="top" width="100px;" align="left">To Date & time:</th><td><input class="datepicker" name="event_to_date" value="<?php echo $arrEndDt[0] != "" ? $arrEndDt[0] : 'DD/MM/YYYY'; ?>" type="text" style="font-family: Arial; font-size: 11px; margin-top:2px;width:85px;"  />
						
						<input name="event_to_time" value="<?php echo $arrEndDt[1] != "" ? 
						$arrEndDt[1] : '00:00:00'; ?>" type="text" style="font-family: Arial; font-size: 11px; margin-top:2px;width:70px;"  />
						
						</td></tr>
						
						
						 <tr style="display:none;"><td valign="top" width="100px;" align="left">Repeat</td>
								<td><input style="margin:0px;" type="checkbox" value="1"  name="repeater" id="repeater" onClick="selsize();" /></td>
						</tr>
						<tr style="display:none;">
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
					<td > <input <?php if($events['daily']=="1") echo "checked='checked'"; ?> style="margin:0 5px 0 0;float:left" type="radio" name="radio_daily" value="1" id="RadioGroup1_0" class="radio" onClick="toggletd(this);"/> &nbsp;&nbsp;
<div id="dailytd" style="float:left;">					
						<input MaxLength="2"  id="daily" name="daily" style="width:30px;float:left;margin:0 5px 0 0;" type="text" value="<?php echo $strDaily;?>" /> <span style="float:left;margin:0 5px 0 0;">Day(s)</span></div> 
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
				<td > <input <?php if($events['weekly']=="1") echo "checked='checked'"; ?> style="float:left;margin:0 5px 0 0;" type="radio" name="radio_daily" value="2"  id="RadioGroup1_1" class="radio" onClick="toggletd(this);"/>
				<div id="weeklytd">
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
				<input MaxLength="2" class="" id="weekly" name="weekly" style="width:30px;float:left;margin:0 5px 0 0;" type="text" value="<?php echo $str_weekly_Day;?>" /><span style="float:left;margin:0 5px 0 0;"> Week(s)</span></div></td>
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
					<td > <input <?php if($events['monthly']=="1") echo "checked='checked'"; ?> type="radio" name="radio_daily" style="float:left;margin:0 5px 0 0;" value="3" id="RadioGroup1_2" class="radio" onClick="toggletd(this);"/>
					<div id="monthlytd">
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
				<input MaxLength="2" class="" id="monthly" name="monthly" style="width:30px;float:left;margin:0 5px 0 0;" type="text" value="<?php echo $str_Monthly_Day;?>" /> <span style="float:left;margin:0 5px 0 0;"> Month(s)</span></div></td>
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
			 	
			 	?>
					<td ><input <?php if($event->_Yearly=="1") echo "checked='checked'"; ?> type="radio" name="radio_daily" value="4" id="radio_yearly"  style="float:left;margin:0 5px 0 0;" <?php echo $selected;?> onClick="toggletd(this);"/>
					<div id="yearlytd">
					
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
				</select> <span style="float:left;margin:0 5px 0 0;">Day(s)</span> </div>
					</td>
				</tr>
				
				<tr>
				<td colspan="2">
					<table id="occurencetd" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td style="width:100px;">Occurence</td>					
						<td><input MaxLength="2"  id="event_occ" name="event_occ" style="width:30px;float:left;margin:0 5px 0 0;" type="text" value="<?php echo $events['event_occ'];?>" /></td>
					</tr>	
					</table>
				</td>
				</tr>
				
				
		 </table>				
								</td>
							</tr> 
						<tr>
								<td>
									<input type="hidden" name="is_submit" value="1" />
									<input type="hidden" name="id" value="<?php echo $events['id']; ?>" />
									<input type="submit" name="btnsubmit" value="Submit" class="button"></td>
								<td><input type="button" onclick="window.close();"  name="close" value="Close" class="button"></td>
							</tr>
							</form>
						<!-- EM Code ends here -->
						</table><br><br>
						</div>
						</body>
						</html>