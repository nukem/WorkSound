<?php
ini_set('max_execution_time', 600);

/**
 * Soundbooka
 * 
 * @author     Chathura Payagala <chathupayagala@gmail.com>
 */
class mArtist extends CI_Model {

  function __construct() {
    parent::__construct();
  }
	// Date: 30 Nov'11 EM code starts here
  function savevent($form_data) {
  	$newId = 0;
  	$id = $form_data['id'];
   	if($id > 0){
   		$this->db->where('id', $id);
			$this->db->delete('user_event');		
			
			$this->db->where('parenteventid', $id);
			$this->db->delete('user_event_detail');
   	}
   	
    //if ($form_data['id'] == 0) {
      
      // starts event insertion here
	  $rd = "";
       //$st = $_POST["event_start_date"]." ".$_POST["event_start_time"];
     // $et = $_POST["event_to_date"]." ".$_POST["event_to_time"]; 
      
    $st = $_POST["event_start_date"];
    $et = $_POST["event_to_date"]; 
	  if (!empty($_POST["radio_daily"]))
	  {
		$rd =	$_POST["radio_daily"];
	  }
	  	
	  	
	  	$errorflag=0;
      $ret = $this->addDetailedCalendar($st, $et,                    
                $_POST["event_title"], isset($_POST["repeater"])?1:0, $_POST["event_desc"], 
                $_POST["event_loc"], $rd,$_POST["daily"],
                $_POST["select_weekly"],$_POST["weekly"],$_POST["select_monthly"],
                $_POST["monthly"],$_POST["select_yearly"],
                $_POST["selectmonth"],$_POST["event_occ"],
                $_POST["event_start_time"],$_POST["event_end_time"],
                $errorflag,$_POST["repeat_start_date"]);
      // event insertion ends here
      
   // } 
/*	else {
      $form_data['modified'] = date('Y-m-d H:i:s');
      $this->db->where('id', $form_data['id']);
      $this->db->update('artist', $form_data);
      $newId = $form_data['id'];
    }*/

    return $newId;
  }
  // EM Code ends here
  
  // Date: 30 Nov'11 EM Code starts for function of Event inerstion
  function addDetailedCalendar($st, $et, $sub, $re, $dscr, $loc, $radio_daily,$daily,$select_weekly,$weekly,$select_monthly,$monthly,$select_yearly,$selectmonth,$occur,$starttime,$endtime,$flag,$repeat_start_date){
	 if($flag=="0")
	 {
	  	$ret = array();
		
			if(isset($_POST['repeater'])&& trim($_POST['repeater'])=="1")
			{
				$arr=explode("/",$_POST["event_start_date"]);
				$tempdt2=$arr[2]."-".$arr[1]."-".$arr[0];		
				
				$arr=explode("/",$_POST["event_to_date"]);
				$tempdt1=$arr[2]."-".$arr[1]."-".$arr[0];		
				
				
				
				$arrDateDiff= getDateDifference($tempdt2,$tempdt1);
				
				$msgError = 0;
				$daily1 = 0;
				$weekly1 = 0;
				$monthly1= 0;
				$yearly1= 0;
				
				switch($radio_daily)
				{
					case 1:
					if($arrDateDiff['days']==0 && intval($occur)>0)
					{
					$daily1=1;				
					}
					else
					{
						$daily1 = 0;
						$msgError="Invalid Repeat format";
					}
						break;
					case 2:
					if($arrDateDiff['days']<7 && intval($occur)>0)
					{
					$weekly1=1;
					}
					else
					{
						$weekly1 = 0;
						$msgError="Invalid Repeat format";
					}
					break;
					case 3:
					if($arrDateDiff['months']==0 && intval($occur)>0)
					{
					$monthly1=1;
					}
					else
					{
						$monthly1 = 0;
						$msgError="Invalid Repeat format";
					}
						break;
					case 4:
					if($arrDateDiff['years']==0 && intval($occur)>0)
					{
						$yearly1=1;
					}
					else
					{
						$yearly1 = 0;
						$msgError="Invalid repeat format";
					}
					break;
				}
			}
		//$msgError = 0;
		//$daily1 = "";
	//	$weekly1 = "";
		//$monthly1 = "";
		//$yearly1 = "";
		
		if(trim($msgError)==0)
		{
				$query = $this->db->query("INSERT INTO  `user_event` (
`event_title` , `event_loc` , `event_desc` , `start_date` , `to_date` , `start_time`, `end_time`, `event_occ` ,
`daily` , `weekly` , `monthly` , `yearly` , `daily_interval` , `weekly_interval` ,
`weekly_interval_day` , `monthly_interval` , `monthly_interval_date` ,
`yearly_interval_date` , `yearly_interval_month`,`repeat_start_date`)
VALUES (
'".$sub."' , '".$loc."' , '".$dscr."' , '".$st."' , '".$et."' , '".$starttime."', '".$endtime."', '".$occur."' ,  
'".$daily1."',  '".$weekly1."',  '".$monthly1."',  '".$yearly1."',  '".$daily."',  
'".$select_weekly."',  '".$weekly."',  '".$select_monthly."',  '".$monthly."',  '".$select_yearly."',  '".$selectmonth."',  '".$repeat_start_date."')");

				/*if(mysql_query($sql)==false)
				{
					  $ret['IsSuccess'] = false;
					  $ret['Msg'] = mysql_error();
				}else
				{ */
					//echo 'add success';
				  $ret['IsSuccess'] = true;
				  $ret['Msg'] = 'Event has been added successfully';
				  $ret['Data'] =$this->db->insert_id();
				  $this->createdetailevents($ret['Data']);
			//	}
		}
		else
		{
			$ret['IsSuccess'] = false;
			 $ret['Msg'] = $msgError;
		}
	
 }
 else
 {

		$ret['IsSuccess'] = false;
		if($flag == "1")
			$ret['Msg'] = "From date must be earlier than to date";
		else
			$ret['Msg'] = "Event date must be for future only.";
 }
 // $todaydate = date("m/d/Y");
//  listCalendar($todaydate, "month");

  return $ret;
}
  // EM Code ends here
  
  // EM Code function for insert event detail table starts here
  // function for creating the detail events base on the parent event
function createdetailevents($parenteventid)
{
	$sql="select * from user_event where id=".$parenteventid;
	mysql_query($sql);
	$handle = mysql_query($sql) or die(mysql_error());
	
	/*$this->db->where('id', $parenteventid);
  $q = $this->db->get('user_event');
  if ($q->num_rows() > 0):
  $row = $q->row();
  endif;*/
  
	$arr;
	while ($row = mysql_fetch_object($handle)) 
	{	
		$arr["_ID"]=$row->id;
		$arr["_EventName"]=$row->event_title;
		$arr["_Location"]=$row->event_loc;
		$arr["_Description"]=$row->event_desc;
		$arr["_StartDate"]=$row->start_date;
		$arr["_EndDate"]=$row->to_date;
		$arr["_Daily"]=$row->daily;
		$arr["_Weekly"]=$row->weekly;
		$arr["_Monthly"]=$row->monthly;
		$arr["_Yearly"]=$row->yearly;
		$arr["_Daily_interval"]=$row->daily_interval;
		$arr["_Weekly_interval"]=$row->weekly_interval;
		$arr["_Weekly_interval_day"]=$row->weekly_interval_day;
		$arr["_Monthly_interval"]=$row->monthly_interval;
		$arr["_Monthly_interval_date"]=$row->monthly_interval_date;
		$arr["_Yearly_interval_date"]=$row->yearly_interval_date;
		$arr["_Yearly_interval_month"]=$row->yearly_interval_month;
		$arr["_Occurence"]=$row->event_occ; 
		$arr["repeat_start_date"]=$row->repeat_start_date;
		
		
		if(trim($arr["_Daily"])=="0" && trim($arr["_Monthly"])=="0" && trim($arr["_Weekly"])=="0" && trim($arr["_Yearly"])=="0")
		{
			
			
			$startdate = $arr['_StartDate'];
			$start_exp = explode("/", $startdate);
			$arr["_StartDate"] = $start_exp[2]."-".$start_exp[1]."-".$start_exp[0];
			$enddate = $arr['_EndDate'];
			$end_exp = explode("/", $enddate);
			$arr["_EndDate"] = $end_exp[2]."-".$end_exp[1]."-".$end_exp[0];
			
			$strFieldsName="parenteventid,startDate,endDate";
			$strInsertValue="'".$arr["_ID"]."','".$arr["_StartDate"]."','".$arr["_EndDate"]."'";
			$this->insertdetailevent($strFieldsName,$strInsertValue);
		}
		else
		{
				
					$startdate = $arr['_StartDate'];
					$start_exp = explode("/", $startdate);
					$startdate = $start_exp[2]."-".$start_exp[1]."-".$start_exp[0];
					$enddate = $arr['_EndDate'];
					$end_exp = explode("/", $enddate);
					$enddate = $end_exp[2]."-".$end_exp[1]."-".$end_exp[0];
					$repeat_start_date = $arr['repeat_start_date'];
					$repeat_exp = explode("/", $repeat_start_date);
					$repeat_start_date = $repeat_exp[2]."-".$repeat_exp[1]."-".$repeat_exp[0];
					
					$date_difference = strtotime($repeat_start_date) - strtotime($startdate );
					
					
					if(trim($arr["_Daily"])=="1")
					{
						// Start Code
						$strFieldsName="parenteventid,startDate,endDate";
						$strInsertValue="";
						
						$arr["_Occurence"] = $date_difference / (60*60*24);
						
						
						if(trim($arr["_Daily_interval"])!="")
						{
							if(intval($arr["_Daily_interval"])<=0)
							{
								$arr["_Daily_interval"]=1;
							}
							$icounter=-1;
							$blnloop=1;
							while($blnloop==1)
							{
								$icounter++;
								$strInsertValue="'".$arr["_ID"]."'";
									
									$interval = intval(trim($arr["_Daily_interval"]))*$icounter;
									
									$startresult = mysql_fetch_array(mysql_query("SELECT ADDDATE('".$startdate."', INTERVAL ".$interval." DAY) as startdate"));
									$endresult = mysql_fetch_array(mysql_query("SELECT ADDDATE('".$enddate."', INTERVAL ".$interval." DAY) as enddate"));
									
									$strNewDate = $startresult['startdate'];
									$strEndDate = $endresult['enddate'];
									//$strNewDate=adddays($arr["_StartDate"],(intval(trim($arr["_Daily_interval"]))*$icounter),"day");									
									//$strEndDate=adddays($arr["_EndDate"],(intval(trim($arr["_Daily_interval"]))*$icounter),"day");
									$strInsertValue.=",'".$strNewDate."','".$strEndDate."'";
									$this->insertdetailevent($strFieldsName,$strInsertValue);
									if(($icounter+1)>=intval($arr["_Occurence"]))
									{
										$blnloop=0;
									}
							}
							
							
						}
						// End Code
					}
					// weekly
					if(trim($arr["_Weekly"])=="1")
					{
						
						$arr["_Occurence"] = $date_difference / (60*60*24*7);
						
						// Start Code
						$strFieldsName="parenteventid,startDate,endDate";
						$strInsertValue="";
						if(trim($arr["_Weekly_interval"])=="")
						{
							$startdate = $arr['_StartDate'];
			$start_exp = explode("/", $startdate);
			$arr["_StartDate"] = $start_exp[2]."-".$start_exp[1]."-".$start_exp[0];
			
							$arr["_Weekly_interval"]=getCurrentWeeklyDay($arr["_StartDate"]);
							
						}
						
						if(trim($arr["_Weekly_interval"])!="")
						{
							$icounter=-1;
							$blnloop=1;
							$strNewDate="";
							$strNewEndDate="";	
							$startdate = $arr['_StartDate'];
			$start_exp = explode("/", $startdate);
			$arr["_StartDate"] = $start_exp[2]."-".$start_exp[1]."-".$start_exp[0];
			$enddate = $arr['_EndDate'];
			$end_exp = explode("/", $enddate);
			$arr["_EndDate"] = $end_exp[2]."-".$end_exp[1]."-".$end_exp[0];
							
							
							while($blnloop==1)
							{
								$strInsertValue="'".$arr["_ID"]."'";
								$icounter++;					
								if($icounter==0)
								{
									
							$strNewDate=getWeeklyDay($arr["_StartDate"],trim($arr["_Weekly_interval"]));
							
								}
								else
								{
									$intWeekInterval=1;
									if(trim($arr["_Weekly_interval_day"])!="")
									{
										$intWeekInterval=intval(trim($arr["_Weekly_interval_day"]));
									}
									if($intWeekInterval<=0)
									{
										$intWeekInterval=1;	
									}
									$strNewDate=adddays($strNewDate,$intWeekInterval,"week");
								}
								
								
								$arrTempCompare=getDateDifference($arr["_StartDate"],$strNewDate);	
								$strNewEndDate=adddays($arr["_EndDate"],intval($arrTempCompare["days"]),"day");								
								$exp_new = explode("-", $strNewDate);
								if(strlen($exp_new[2]) == 1):
									$exp_new[2] = "0".$exp_new[2];
								endif;
								
								$exp_newend = explode("-", $strNewEndDate);
								if(strlen($exp_newend[2]) == 1):
									$exp_newend[2] = "0".$exp_newend[2];
								endif;
								
								$strNewDate = $exp_new[0]."-".$exp_new[1]."-".$exp_new[2];
								$strNewEndDate = $exp_newend[0]."-".$exp_newend[1]."-".$exp_newend[2];
								$strInsertValue.=",'".$strNewDate."','".$strNewEndDate."'";
								$this->insertdetailevent($strFieldsName,$strInsertValue);
								if(($icounter+1)>=intval($arr["_Occurence"]))
									{
										$blnloop=0;
									}
							}
							
						}
						// End Code
					}
					// Monthly
					if(trim($arr["_Monthly"])=="1")
					{
						// Start Code
						
						$arr["_Occurence"] = $date_difference / (60*60*24*30);
						
						
						$strFieldsName="parenteventid,startDate,endDate";
						$strInsertValue="";
						$startdate = $arr['_StartDate'];
			$start_exp = explode("/", $startdate);
			$arr["_StartDate"] = $start_exp[2]."-".$start_exp[1]."-".$start_exp[0];
			$enddate = $arr['_EndDate'];
			$end_exp = explode("/", $enddate);
			$arr["_EndDate"] = $end_exp[2]."-".$end_exp[1]."-".$end_exp[0];
								
					
						if(trim($arr["_Monthly_interval"])=="")
						{
							$arr["_Monthly_interval"]=getCurrentMonthDay($arr["_StartDate"]);
						}
						
						if(trim($arr["_Monthly_interval"])!="")
						{
							$icounter=-1;
							$blnloop=1;
							$strNewDate="";
							
							while($blnloop==1)
							{
								$strInsertValue="'".$arr["_ID"]."'";
								$icounter++;					
									$intMonthInterval=1;
									if(trim($arr["_Monthly_interval_date"])!="")
									{
										$intMonthInterval=intval(trim($arr["_Monthly_interval_date"]));
									}
									if($intMonthInterval<=0)
									{
										$intMonthInterval=1;	
									}
									if($icounter==0)
									{
										$strNewDate=getMonthDay($arr["_StartDate"],trim($arr["_Monthly_interval"]),$intMonthInterval,1);
									}
									else
									{
										$strNewDate=getMonthDay($strNewDate,trim($arr["_Monthly_interval"]),$intMonthInterval);
									}
								if($strNewDate!="")
								{
								$arrTempCompare=getDateDifference($arr["_StartDate"],$strNewDate);								
								$strNewEndDate=adddays($arr["_EndDate"],intval($arrTempCompare["days"]),"day");		
								
								$exp_new = explode("-", $strNewDate);
								if(strlen($exp_new[2]) == 1):
									$exp_new[2] = "0".$exp_new[2];
								endif;
								
								$exp_newend = explode("-", $strNewEndDate);
								if(strlen($exp_newend[2]) == 1):
									$exp_newend[2] = "0".$exp_newend[2];
								endif;
								
								$strNewDate = $exp_new[0]."-".$exp_new[1]."-".$exp_new[2];
								$strNewEndDate = $exp_newend[0]."-".$exp_newend[1]."-".$exp_newend[2];
								
								$strInsertValue.=",'".$strNewDate."','".$strNewEndDate."'";
								$this->insertdetailevent($strFieldsName,$strInsertValue);								
								}
								if(($icounter+1)>=intval($arr["_Occurence"]))
									{
										$blnloop=0;
									}
							}
						}
						// End Code
					}
					// Yearly
					if(trim($arr["_Yearly"])=="1")
					{
						
						// Start Code
						
						$arr["_Occurence"] = $date_difference / (60*60*24*365);
						
						
						$startdate = $arr['_StartDate'];
			$start_exp = explode("/", $startdate);
			$arr["_StartDate"] = $start_exp[2]."-".$start_exp[1]."-".$start_exp[0];
			$enddate = $arr['_EndDate'];
			$end_exp = explode("/", $enddate);
			$arr["_EndDate"] = $end_exp[2]."-".$end_exp[1]."-".$end_exp[0];
						
						// Start Code
						$strFieldsName="parenteventid,startDate,endDate";
						$strInsertValue="";
						if(trim($arr["_Yearly_interval_date"])=="" && intval(trim($arr["_Yearly_interval_date"]))<=0)
						{
							$arr["_Yearly_interval_date"]=getCurrentMonth($arr["_StartDate"]);
						}
						
						
						if(trim($arr["_Yearly_interval_month"])=="" && intval(trim($arr["_Yearly_interval_month"]))<=0)
						{
							$arr["_Yearly_interval_month"]=getCurrentMonthDay($arr["_StartDate"]);
						}
						if(trim($arr["_Yearly_interval_month"])!="")
						{
							$icounter=-1;
							$blnloop=1;
							$strNewDate="";
							
							while($blnloop==1)
							{
								$strInsertValue="'".$arr["_ID"]."'";
								$icounter++;					
									if($icounter==0)
									{
										$strNewDate=getYearDay($arr["_StartDate"],trim($arr["_Yearly_interval_date"]),trim($arr["_Yearly_interval_month"]),1);
									}
									else
									{
											
										$strNewDate=getYearDay($strNewDate,trim($arr["_Yearly_interval_date"]),trim($arr["_Yearly_interval_month"]));
										
									}
									
								if($strNewDate!="")
								{
									$arrTempCompare=getDateDifference($arr["_StartDate"],$strNewDate);								
									$strNewEndDate=adddays($arr["_EndDate"],intval($arrTempCompare["days"]),"day");								
									$exp_new = explode("-", $strNewDate);
								if(strlen($exp_new[2]) == 1):
									$exp_new[2] = "0".$exp_new[2];
								endif;
								
								$exp_newend = explode("-", $strNewEndDate);
								if(strlen($exp_newend[2]) == 1):
									$exp_newend[2] = "0".$exp_newend[2];
								endif;
								
								$strNewDate = $exp_new[0]."-".$exp_new[1]."-".$exp_new[2];
								$strNewEndDate = $exp_newend[0]."-".$exp_newend[1]."-".$exp_newend[2];
									$strInsertValue.=",'".$strNewDate."','".$strNewEndDate."'";
									
									
									$this->insertdetailevent($strFieldsName,$strInsertValue);								
								}
								if(($icounter+1)>=intval($arr["_Occurence"]))
									{
										$blnloop=0;
									}
								
							}
						}
						// End Code
					}
		
	}
}
}

function insertdetailevent($strFieldsName,$strInsertValue)
{
	$query = $this->db->query("insert into user_event_detail(".$strFieldsName.") values(".$strInsertValue.")");
	
	
}
  // EM Code ends here
  
   function save($form_data,$data=array()) {
    $newId = 0;
    if ($form_data['id'] == 0) {
      $form_data['created'] = date('Y-m-d H:i:s');
	  $this->db->insert('artist', $form_data);
      $newId = $this->db->insert_id();
	  //echo '<div style="display:none;">';echo 'goes if';echo '</div>';
	  $sql_structure = "insert wp_structure set type = 'user', parent = '970', title = '".$data['email']."', online = 1, modified = '2011-12-03 17:18:16', viewRights = '(2)', createRights = '(2)', editRights = '(2)', deleteRights = '(2)'";
	  $this->db->query($sql_structure);
	  $str_id = $this->db->insert_id();
	  $password = md5 ($data['password']);
	  $sql_user = "insert wp_user set  password = '".$password."',email = '".$data['email']."',name = '".$data['email']."',link='".$str_id."',login_id = '".$newId."' ";
	  $this->db->query($sql_user);
    } 
	else {
	  //echo '<div style="display:none;">';echo 'goes else';echo '</div>';
      $form_data['modified'] = date('Y-m-d H:i:s');
      $this->db->where('id', $form_data['id']);
      $this->db->update('artist', $form_data);
      $newId = $form_data['id'];
    }

    return $newId;
  }

  function get($id) {
    $user = new stdClass();

    $this->db->where('id', $id);
    $q = $this->db->get('artist');
    if ($q->num_rows() > 0): 
      $user = $q->row();
	  $user->plots = $this->getPlots($user->id);
	  $user->artist_instruments = $this->getArtistInstruments($user->id);
	  $user->images = $this->getArtistImages($user->id);
	  $user->artist_media->audio = $this->getArtistMedia($user->id,'audio');
	  $user->artist_media->video = $this->getArtistMedia($user->id,'video');
	  $user->artist_availability = $this->getAvailability($user->id);
	  $user->artist_gigs = $this->getGigs($user->id);
	  $user->artist_availability_array = $this->getAvailabilityArray($user->artist_availability);
	  $user->artist_gigs_array = $this->getGigsArray($user->artist_gigs);
      return $user;
    else :
      return $user;
    endif;
  }
   function getByName($profile_name) {
    $user = new stdClass();
	echo $profile_name;
    $this->db->where('profile_name', $profile_name);
    $q = $this->db->get('artist');
    if ($q->num_rows() > 0): 
      $user = $q->row();
	  $user->plots = $this->getPlots($user->id);
	  $user->artist_instruments = $this->getArtistInstruments($user->id);
	  $user->images = $this->getArtistImages($user->id);
	  $user->artist_media->audio = $this->getArtistMedia($user->id,'audio');
	  $user->artist_media->video = $this->getArtistMedia($user->id,'video');
	  $user->artist_availability = $this->getAvailability($user->id);
	  $user->artist_gigs = $this->getGigs($user->id);
	  $user->artist_availability_array = $this->getAvailabilityArray($user->artist_availability);
	  $user->artist_gigs_array = $this->getGigsArray($user->artist_gigs);
      return $user;
    else :
      return $user;
    endif;
  }
  function getPlots($id) {
	  $this->db->select('');
	  $this->db->where('artist_id', $id);
	  $res = $this->db->get('plots');
	  return $res->result();
  }
  function getArtistInstruments($id) {
	  $this->db->select('artist_Instruments.*, instrument.instrument as title,instrument.instrument_category as category_id');
	  $this->db->join('instrument', 'instrument.instrument_id = artist_Instruments.instrument_id');
	  $this->db->where('artist_id', $id);
	  $res = $this->db->get('artist_Instruments');
	  return $res->result();
  }
  
  function getArtistImages($id) {
	  $this->db->where('parent', $id);
	  $this->db->order_by('position');
	  $res = $this->db->get('wp_image_gallery');
	  return $res->result();
  }
  function getRating($id) {
	  $rate_sql = "SELECT CEIL(AVG(`star_rate`)) AS star_rate FROM rating where `artist_id`=".$id;
	  $rate_result = $this->db->query($rate_sql);
	  return $rate_result->result_array();
  }
  
  function getArtistMedia($id, $type = null) {
	  $this->db->where('artist_id', $id);
	  if ($type) {
		$this->db->where('type', $type);  
	  }
	  $this->db->order_by('position');
	  $res = $this->db->get('artist_media');
	  return $res->result();
  }
  
  function saveMedia($data) {
	  	$newId = $data['am_id'];
	    $ins['artist_id'] = $data['artist_id'];
		$ins['url'] = $data['url'];
		$ins['type'] = $data['type'];
		$ins['title'] = $data['title'];
		$ins['date_recorded'] = $data['date_recorded'];
		$ins['description'] = $data['description'];
		if ($data['am_id']) {
			$this->db->where('id', $data['am_id']);
			$this->db->update('artist_media', $ins);
		} else {
			$this->db->insert('artist_media', $ins);
			$newId = $this->db->insert_id();
		}
		return $newId;
  }
  
  function saveInstrument($data) {
	  	$newId = $data['ai_id'];
	    $ins['artist_id'] = $data['artist_id'];
		//$ins['instrument_id'] = $data['instrument_id'];
		$ins['instrument_name'] = $data['instrument_name'];
		$ins['comment'] = $data['comment'];
		if ($data['ai_id']) {
			$this->db->where('id', $data['ai_id']);
			$this->db->update('artist_Instruments', $ins);
		} else {
			$this->db->insert('artist_Instruments', $ins);
			$newId = $this->db->insert_id();
		}
		return $newId;
  }
  
  function getAvailability($id) {
	  $this->db->where('artist_id', $id);
	  $q = $this->db->get('artist_availability');
	  return $q->result();
  }
  
  function getGigs($id) {
	  $this->db->where('artist_id', $id);
	  $q = $this->db->get('artist_gig');
	  return $q->result();
  }
  
  function saveGigs($id,$data) {
	$this->db->where('artist_id', $id);
	$this->db->delete('artist_gig');
	$data = (array) $data;
	foreach ($data as $d) {
		$ins = array();
		$ins['artist_id'] = $id;
		$ins['gig_id'] = $d;
		$this->db->insert('artist_gig', $ins);		
	}
  }
  
  function saveAvailability($id,$data) {
	$this->db->where('artist_id', $id);
	$this->db->delete('artist_availability');
	$data = (array) $data;
	foreach ($data as $d) {
		$d = explode('_', $d);
		$ins = array();
		$ins['artist_id'] = $id;
		$ins['day'] = $d[0];
		$ins['time'] = $d[1];
		$this->db->insert('artist_availability', $ins);		
	}
  }
  
  function getAvailabilityArray($data) {
	  $ret = array();
	  foreach ($data as $d) {
		  $ret[] = $d->day . '_' . $d->time;
	  }
	  return $ret;
  }
  
  function getGigsArray($data) {
	  $ret = array();
	  foreach ($data as $d) {
		  $ret[] = $d->gig_id;
	  }
	  return $ret;
  }
  //ADDED ON 19 DEC FOR OTHER PROFILES
  function other_profile($email){
	/*$res=$this->db->query("SELECT a.id as id, u.email from artist a, user u WHERE u.email='{$email}' AND a.user_id=u.id");
	$profiles=$res->result_array();*/
	$res=$this->db->query("SELECT a.id as id, u.email,a.profile_name,a.profile_type,a.status, a.views from artist a, user u WHERE u.email='{$email}' AND a.user_id=u.id");
	$profiles=$res->result_array();
	return $profiles;
  }
  function searchArtist($post){
	$sql="SELECT * FROM artist a ";
	if(!empty($post['instrument']))  $sql.=" LEFT JOIN artist_Instruments ai ON a.id=ai.artist_id ";
	if(!empty($post['pref_gigs'])) $sql.=" LEFT JOIN artist_gig ag ON a.id=ag.artist_id ";
	
	$sql.=" WHERE 1=1 ";
	if(!empty($post['start_time'])) $stt=$post['start_time'].':00:00';
	else $stt='00:00:00';
	if(!empty($post['end_time'])) $ent=$post['end_time'].':00:00';
	else $ent='00:00:00';
	 if(!empty($post['start_date']) && !empty($post['end_date'])) {
		$st=explode('/',$post['start_date']);$en=explode('/',$post['end_date']);
		$st=$st[2].'-'.$st[1].'-'.$st[0].' '.$stt;
		$en=$en[2].'-'.$en[1].'-'.$en[0].' '.$ent;
	 
	 }
	if(!empty($post['profile_type'])) $sql.=" && a.profile_type='{$post['profile_type']}'";
	if(!empty($post['profile_type']) and isset($post['genre'])){
		$sql.=" && (  a.genre1 = 'text'";
	 foreach($post['genre'] as $v){
		$sql.=" || a.genre1 LIKE '%{$v}%'";	 
	 }
		$sql.=")";
	 }
	 if(!empty($post['instrument'])) $sql.=" && ai.instrument_name LIKE '%{$post['instrument']}%'";
	 if(!empty($post['artist_name'])) $sql.=" && a.profile_name LIKE '%{$post['artist_name']}%'";
	 if(!empty($post['suburb'])) $sql.=" && a.suburb LIKE '%{$post['suburb']}%'";
	 if(!empty($post['country'])) $sql.=" && a.country LIKE '%{$post['country']}%'";
	 if(!empty($post['state'])) $sql.=" && a.state LIKE '%{$post['state']}%'";
	 if(!empty($post['postcode'])) $sql.=" && a.postcode LIKE '%{$post['postcode']}%'";
	 if(!empty($post['pref_gigs'])) $sql.=" && ag.gig_id = '{$post['pref_gigs']}'";
	 
	 //$sql.=" && (a.travel_city = '{$post['travel_city']}' OR a.travel_state = '{$post['travel_state']}' OR a.travel_interstate = '{$post['travel_interstate']}' OR a.travel_international = '{$post['travel_international']}') ";

	 if(!empty($post['availability'])){
		$s1="SELECT b.artist_id FROM artist_availability b WHERE ";
		$size=count($post['availability']);$i=0;
		foreach($post['availability'] as $v){
			list($day,$time)=explode('_',$v);
			$s1.=" (b.`day`='$day' && b.`time`='$time') ";
			$i++;
			if($i!=$size) $s1.="  ||  ";
		}
		$sql.=" && a.id IN ( $s1 ) ";
	 }
	 if(!empty($post['start_date']) && !empty($post['end_date'])) $sql.=" && ( a.created BETWEEN '{$st}' AND '{$en}' )";
	 if(!empty($post['fee_hour'])){
	 $sql.=" && ( a.fee_hour <=  '{$post['fee_hour']}')";
	 }
	 if( !empty($post['gig_hours'])){
	 $sql.=" && ( gig_hours <= '{$post['gig_hours']}' )";
	 }
	 if(!empty($post['fee_gig'])){
	 $sql.=" && ( a.fee_gig <= '{$post['fee_gig']}')";
	 }
	 $sql.=" GROUP BY a.id";
	 echo '<div style="display:none;">';
	 echo $sql;
	 echo '</div>';
	 $q=$this->db->query($sql);
	 $result=$q->result_array();
	 return $result;
  }
  function allgenres(){
	$q=$this->db->query("SELECT * FROM genre WHERE active=1 && user_id=0 && genre NOT LIKE '%other%' ORDER BY genre");
	$r=$q->result_array();
	
	return $r;
  }

}

// Date : 30 Nov'11 EM Code starts here
function adddays($dt,$interval,$type)
{
		$strValue= "+".$interval." ".$type;
		$strnewtimestamp=strtotime("$strValue",gettimestampofdate($dt));
		$dtnew=getdate($strnewtimestamp);
	//	$returnDate=$dtnew['year']."-".$dtnew['mon']."-".$dtnew['mday']." ".$dtnew['hours'].":".$dtnew['minutes'].":".$dtnew['seconds'];
	$returnDate=$dtnew['year']."-".$dtnew['mon']."-".$dtnew['mday'];
	  return $returnDate;
}
function adddayswithdateOnly($dt,$interval,$type,$additiontype="+")
{
		$strValue= $additiontype."".$interval." ".$type;
	  $strnewtimestamp=strtotime("$strValue",gettimestampofdate($dt));
	  $dtnew=getdate($strnewtimestamp);
	  if(strlen($dtnew['mon'])==1)
	  {
	  	$dtnew['mon']="0".$dtnew['mon'];
	  }
	  if(strlen($dtnew['mday'])==1)
	  {
	  	$dtnew['mday']="0".$dtnew['mday'];
	  }
	  $returnDate=$dtnew['year']."-".$dtnew['mon']."-".$dtnew['mday'];
	  return $returnDate;
}
function comparedatenew($d1,$d2)
{
	$blnReturn=false;
	
	if(gettimestampofdate($d1)<=gettimestampofdate($d2))
	{
	 $blnReturn=true;
	}
	return $blnReturn;
}
function gettimestampofdate($d1)
{
	$strTimeStamp="";
	if(trim($d1)!="")
	{
		$arr=explode(" ",$d1);
		$arrDate=explode("-",$arr[0]);
		//$arrTime=explode(":",$arr[1]);
		$strTimeStamp=mktime(0,0,0,$arrDate[1],$arrDate[2],$arrDate[0]);
	}
	return $strTimeStamp;
}

function getDateDifference($dt1,$dt2)
{
	$date1=gettimestampofdate($dt1);
	$date2=gettimestampofdate($dt2);
	$years = floor(($date2-$date1)/31536000);
	$months = floor(($date2-$date1)/2628000);
	$days = floor(($date2-$date1)/86400);
	$arr;
	$arr["days"]=intval($days);
	$arr["months"]=intval($months);
	$arr["years"]=intval($years);
	return $arr;
}
function getWeeklyDay($dt,$intday)
{
	$dtnewdate=getdate(gettimestampofdate($dt));
	$arr["Sunday"]=1;
	$arr["Monday"]=2;
	$arr["Tuesday"]=3;
	$arr["Wednesday"]=4;
	$arr["Thursday"]=5;
	$arr["Friday"]=6;
	$arr["Saturday"]=7;
	$strCurrentDay=trim($dtnewdate["weekday"]);
	
	if($arr[$strCurrentDay]==$intday)
	{
		return $dt;
	}
	else if ($intday>$arr[$strCurrentDay])
	{
		$intNextDay=$intday-intval($arr[$strCurrentDay]);
		return adddays($dt,$intNextDay,"day");
	}
	else
	{
		$intNextDay=7-intval($arr[$strCurrentDay])+$intday;
		return adddays($dt,$intNextDay,"day");
	}
}
function getCurrentWeeklyDay($dt)
{
	$dtnewdate=getdate(gettimestampofdate($dt));
	$arr["Sunday"]=1;
	$arr["Monday"]=2;
	$arr["Tuesday"]=3;
	$arr["Wednesday"]=4;
	$arr["Thursday"]=5;
	$arr["Friday"]=6;
	$arr["Saturday"]=7;
	$strCurrentDay=trim($dtnewdate["weekday"]);	
	return $strCurrentDay;
}
function getCurrentWeeklyDayNumber($dt)
{
	$dtnewdate=getdate(gettimestampofdate($dt));
	$arr["Sunday"]=1;
	$arr["Monday"]=2;
	$arr["Tuesday"]=3;
	$arr["Wednesday"]=4;
	$arr["Thursday"]=5;
	$arr["Friday"]=6;
	$arr["Saturday"]=7;
	$strCurrentDay=trim($dtnewdate["weekday"]);	
	return $arr[$strCurrentDay];
}
function getCurrentMonthDay($dt)
{
	$dtnewdate=getdate(gettimestampofdate($dt));	
	return $dtnewdate["mday"];
}
function getCurrentMonth($dt)
{
	$dtnewdate=getdate(gettimestampofdate($dt));	
	return $dtnewdate["mon"];
}
function validatedate($dt,$monthday,$intAddMonth)
{
	
	$returnDate=$dt;
	
	$dtnewdate=getdate(gettimestampofdate($dt));	
	
	$intMonth=intval($dtnewdate["mon"])+$intAddMonth;
	
		$intYear=$dtnewdate["year"];
	if($intMonth>12)
	{
		$intMonth=$intMonth-12;
		$intYear=$intYear+1;
	}
	$blncheck=true;
	while($blncheck)
	{	
		
		if(checkdate($intMonth,$monthday,$intYear))
		{
			if($intAddMonth==0)
			{
				$intAddMonth=1;
			}
			$blncheck=false;
			$returnDate=mktime($dtnewdate["hours"],$dtnewdate["minutes"],$dtnewdate["seconds"],$intMonth,$monthday,$intYear);
			$dtnew=getdate($returnDate);
	  //$returnDate=$dtnew['year']."-".$dtnew['mon']."-".$dtnew['mday']." ".$dtnew['hours'].":".$dtnew['minutes'].":".$dtnew['seconds'];
	  $returnDate=$dtnew['year']."-".$dtnew['mon']."-".$dtnew['mday'];
	  break;
		}
		$intMonth=$intAddMonth+$intMonth;
		
	}
	return $returnDate;
}
function getMonthDay($dt,$intmonthday,$intNextMonth,$intFirst=0)
{ 
	$ReturnDate=$dt;
	$dtnewdate=getdate(gettimestampofdate($dt));
	
	if($intFirst==1)
	{
		if($dtnewdate["mday"]==$intmonthday)
		{
		$ReturnDate=$dt;
		}
		else if($dtnewdate["mday"]< $intmonthday)
		{
			$ReturnDate=validatedate($dt,$intmonthday,0);
		}
		else
		{
			$ReturnDate=validatedate($dt,$intmonthday,$intNextMonth);
		}
	}
		else
		{
		$ReturnDate=validatedate($dt,$intmonthday,$intNextMonth);
		}
	
	return $ReturnDate;
}
function getYearDay($dt,$intMonth,$intMonthDay,$intFirst=0)
{
	$ReturnDate="";
	$dtnewdate=getdate(gettimestampofdate($dt));
	$intYear=1;
	if($intFirst==1)
	{
		if($dtnewdate["mon"]==$intMonth && $dtnewdate["mday"]==$intMonthDay)
		{
			$ReturnDate=$dt;
		}
		else
		{
			if($dtnewdate["mon"]< $intMonth)
			{
				$intYear=0;
			}
			else if($dtnewdate["mon"]==$intMonth && $dtnewdate["mday"]<=$intMonthDay)
			{
				$intYear=0;
			}
			$ReturnDate=getnextyeardate($dt,$intMonth,$intMonthDay,$intYear);
		}
	}
	else
	{
		$ReturnDate=getnextyeardate($dt,$intMonth,$intMonthDay,$intYear);
	}
	
	return $ReturnDate;
}
function getnextyeardate($dt,$intMonth,$intMonthDay,$intYear)
{
	$ReturnDate="";
		$dtnewdate=getdate(gettimestampofdate($dt));
		$intCurYear=$dtnewdate['year'];
		$intCurYear=$intCurYear+$intYear;
	$blnchk=true;
	
	
	while($blnchk)
	{
			if(checkdate($intMonth,$intMonthDay,$intCurYear))
			{
				$intYear=1;
				$blnchk=false;
				$returnDate=mktime($dtnewdate["hours"],$dtnewdate["minutes"],$dtnewdate["seconds"],$intMonth,$intMonthDay,$intCurYear);
				$dtnew=getdate($returnDate);
	  		$returnDate=$dtnew['year']."-".$dtnew['mon']."-".$dtnew['mday'];
	  		break;			
			}
			else
			{
				
				if(intval($intMonth)!=2 && intval($intMonthDay)!=29)
				{
					
					$blnchk=false;	
				}
				else
				{
					$intYear=1;
					$intCurYear=$intCurYear+$intYear;
				}
			}
			$blnchk=false;	
	}
	return $returnDate;
}
// EM Code ends here