  <html>
  <head>
  	<script src="http://www.soundbooka.com/version1/js/jquery-1.4.1.min.js" type="text/javascript"></script>

<script src="http://www.soundbooka.com/version1/js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
<script>

$(document).ready(function() { $("start_date").datepicker(); });

</script>
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
	</head>
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
						?>
						<body onload="selsize();"> 
						<div id="my_calendar" style="margin:20px; width:90%;  ">
						<?php  $sql="select * from event where cur_date='$end_date'"; ?>
						<h2>Edit Events</h2><br>
						<table>
							<form action="http://www.soundbooka.com/version1/index.php/artist/savevent" method="post" enctype="multipart/form-data" onsubmit="return validateForm();"> 
							<!-- Date: 30 Nov'11 EM Code starts here -->
						<tr><th valign="top">Subject:</th><td><input name="event_title" type="text" value="" /></td></tr>
						<tr><th valign="top">Location:</th><td><input name="event_loc" type="text" value="" /></td></tr>
						<tr><th valign="top">Description:</th><td><textarea name="event_desc"></textarea></td></tr>
						<tr><th valign="top">From Date:</th><td><input id="start_date" name="start_date" type="text" /></td></tr>
						<tr><th valign="top">To Date:</th><td><input name="to_date" type="text" /></td></tr>
						<tr><th valign="top">Repeat</td>
								<td><input style="margin:0px;" type="checkbox" value="1"  name="repeater" id="repeater" onClick="selsize();" /></td>
						</tr>
						<tr>
								<td colspan="2" valign="top">
									<table id="repeattable" border="0" width="500px" cellspacing="3" cellpadding="0">
				<tr>
					<td width="100px;" >Daily&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>	
				<?php
			 	if($event->_Daily=="1")
			 	{
			 		if(trim($event->_Daily_interval)!="")			 		
			 		{
			 			if(intval($event->_Daily_interval)>0)
			 			{
			 				$strDaily=trim($event->_Daily_interval);
			 			}
			 		}
			 	}				
			 	?>
					<td > <input <?php if($event->_Daily=="1") echo "checked='checked'"; ?> style="margin:0 5px 0 0;float:left" type="radio" name="radio_daily" value="1" id="RadioGroup1_0" class="radio" onClick="toggletd(this);"/> &nbsp;&nbsp;
<div id="dailytd" style="float:left;">					
						<input MaxLength="2"  id="daily" name="daily" style="width:30px;float:left;margin:0 5px 0 0;" type="text" value="<?php echo $strDaily;?>" /> <span style="float:left;margin:0 5px 0 0;">Day(s)</span></div> 
					</td>
				</tr>
				<tr>
				<td width="100px;">Weekly&nbsp;</td>
				<?php
			 	$selected="";
			 	$strDaily="0";
			 	$str_weekly_Day="";
			 	if($event->_Weekly==1)
			 	{			 		
			 		if(trim($event->_Weekly_interval)!="")			 		
			 		{
			 			if(intval($event->_Weekly_interval)>0)
			 			{
			 				$strDaily=trim($event->_Weekly_interval);
			 			}			 			
			 		}
			 		if(trim($event->_Weekly_interval_day)!="")			 		
			 		{
			 			if(intval($event->_Weekly_interval_day)>0)
			 			{
			 				$str_weekly_Day=trim($event->_Weekly_interval_day);
			 			}			 			
			 		}
			 		
			 	}
				
				
			 	?>
				<td > <input <?php if($event->_Weekly=="1") echo "checked='checked'"; ?> style="float:left;margin:0 5px 0 0;" type="radio" name="radio_daily" value="2"  id="RadioGroup1_1" class="radio" onClick="toggletd(this);"/>
				<div id="weeklytd">
				<select style="width:100px;float:left;margin:0 5px 0 0;" id="select_weekly" name="select_weekly"class="cmbbox"> 
				<option value="-1">--Select-- </option>
				<?php
				$selected="";
				//echo "strDaily:".$strDaily;
				if(intval(trim($event->_Weekly_interval))==1)
				{
				$selected="selected";
				}
				?>
				<option value="1" <?php echo $selected;?> >--Sun-- </option>
				<?php
				$selected="";
				//echo "strDaily:".$strDaily;
				if(intval(trim($event->_Weekly_interval))==2)
				{
				$selected="selected";
				}
				?>
				<option value="2" <?php echo $selected;?> >--Mon-- </option>
				<?php
				$selected="";
				if(intval(trim($event->_Weekly_interval))==3)
				{
				$selected="selected";
				}
				?>
				<option value="3" <?php echo $selected;?> >--Tues-- </option>
				<?php
				$selected="";
				if(intval(trim($event->_Weekly_interval))==4)
				{
				$selected="selected";
				}
				?>
				<option value="4" <?php echo $selected;?> >--Wed-- </option>
				<?php
				$selected="";
				if(intval(trim($event->_Weekly_interval))==5)
				{
				$selected="selected";
				}
				?>
				<option value="5" <?php echo $selected;?> >--Thurs-- </option>
				<?php
				$selected="";
				if(intval(trim($event->_Weekly_interval))==6)
				{
				$selected="selected";
				}
				?>
				<option value="6" <?php echo $selected;?> >--Fri-- </option>
				<?php
				$selected="";
				if(intval(trim($event->_Weekly_interval))==7)
				{
				$selected="selected";
				}
				?>
				<option value="7" <?php echo $selected;?> >--Sat-- </option>
				</select> <span style="float:left;margin:0 5px; ">Of Every</span>
				<input MaxLength="2" class="" id="weekly" name="weekly" style="width:30px;float:left;margin:0 5px 0 0;" type="text" value="<?php echo $str_weekly_Day;?>" /><span style="float:left;margin:0 5px 0 0;"> Week(s)</span></div></td>
				</tr>
				<tr>
					<td width="100px;">Monthly</td>
					<?php
			 	$selected="";
			 	$str_Monthly="0";
			 	$str_Montly_Day="";
			 	if($event->_Monthly==1)
			 	{
			 		if(trim($event->_Monthly_interval)!="")			 		
			 		{
			 			if(intval($event->_Monthly_interval)>0)
			 			{
			 				$str_Monthly=trim($event->_Monthly_interval);
			 			}			 			
			 		}
			 		if(trim($event->_Weekly_interval_day)!="")			 		
			 		{
			 			if(intval($event->_Monthly_interval_date)>0)
			 			{
			 				$str_Monthly_Day=trim($event->_Monthly_interval_date);
			 			}			 			
			 		}
			 		
			 	}
			 	?>
					<td > <input <?php if($event->_Monthly=="1") echo "checked='checked'"; ?> type="radio" name="radio_daily" style="float:left;margin:0 5px 0 0;" value="3" id="RadioGroup1_2" class="radio" onClick="toggletd(this);"/>
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
				</select> <span style="float:left;margin:0 5px; 0 0"> Of Every</span>
				<input MaxLength="2" class="" id="monthly" name="monthly" style="width:30px;float:left;margin:0 5px 0 0;" type="text" value="<?php echo $str_Monthly_Day;?>" /> <span style="float:left;margin:0 5px 0 0;"> Month(s)</span></div></td>
				</tr>
				<tr>
					<td width="100px;">Yearly&nbsp; </td>
					<?php
			 	$selected="";
			 	$str_Yearly="0";
			 	$str_Yearly_Day="";
			 	
			 	if($event->_Yearly==1)
			 	{
			 		if(trim($event->_Yearly_interval_date)!="")			 		
			 		{
			 			if(intval($event->_Yearly_interval_date)>0)
			 			{
			 				$str_Yearly=trim($event->_Yearly_interval_date);
			 			}			 			
			 		}
			 		if(trim($event->_Yearly_interval_month)!="")			 		
			 		{
			 			if(intval($event->_Yearly_interval_month)>0)
			 			{
			 				$str_Yearly_Day=trim($event->_Yearly_interval_month);
			 			}			 			
			 		}
			 		
			 	}
			 	
			 	?>
					<td ><input <?php if($event->_Yearly=="1") echo "checked='checked'"; ?> type="radio" name="radio_daily" value="4" id="radio_yearly"  style="float:left;margin:0 5px 0 0;" <?php echo $selected;?> onClick="toggletd(this);"/>
					<div id="yearlytd">
					
				<select  style="width:100px;float:left;margin-left:5px;" id="select_yearly" name="select_yearly"class="cmbbox"> 
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
						<td><input MaxLength="2"  id="event_occ" name="event_occ" style="width:30px;float:left;margin:0 5px 0 0;" type="text" value="<?php echo $event->_Occurence;?>" /></td>
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
									<input type="submit" name="submit" value="Submit" class="button"></td>
								<td><input type="submit" name="close" value="Close" class="button"></td>
							</tr>
							</form>
						<!-- EM Code ends here -->
						</table><br><br>
						</div>
						</body>
						</html>