<?php
ini_set("display_errors", 1);
/*echo $sql = "select *, artist_type.type as artist_type_name from artist 
            LEFT JOIN artist_type 
            ON artist.profile_type=artist_type.artist_id 
            where manager_email LIKE '%" . $_POST['email'] . "%' AND (first_name LIKE  '%" . $_POST['name'] . "%' OR last_name LIKE '%" . $_POST['name'] . "%') AND manager_email LIKE '%" . $_POST['email'] . "%' AND phone_number LIKE '%" . $_POST['email'] . "%' AND (artist.status LIKE '%" . $_POST['join_status']. "%') ";
if(isset($_POST['type']) && $_POST['type'] != ''){
    $sql .= " AND profile_type = '" . $_POST['type'] . "'";
}
$artist_result = mysql_query($sql);
*/
$sql = "select artist_id, type from artist_type";
$result = mysql_query($sql);

$sql = "select * from state";
$state_result = mysql_query($sql);

$sql = "select * from country";
$country_result = mysql_query($sql);
//die($_REQUEST['aid']);
$aid = $_REQUEST['aid'];
if($_POST['is_submit'] == 1) {

    $sql ="UPDATE `soundbooka`.`artist` SET 
        `first_name` = '{$_POST['first_name']}',
`last_name` = '{$_POST['last_name']}',
`gender` = '{$_POST['gender']}',
`address` = '{$_POST['address']}',
`suburb` = '{$_POST['suburb']}',
`state` = '{$_POST['state']}',
`country` = '{$_POST['country']}',
`travel_distance` = '{$_POST['travel_distance']}',
`phone_code` = '{$_POST['phone_code']}',
`phone_number` = '{$_POST['phone_number']}',
`phone_alternate` = '{$_POST['phone_alternate']}',
`postcode` = '{$_POST['postcode']}',
`profile_name` = '{$_POST['profile_name']}',
`profile_type` = '{$_POST['profile_type']}',
`equipment` = '{$_POST['equipment']}',
`gig` = '{$_POST['gig']}',
`fee_hour` = '{$_POST['fee_hour']}',
`fee_gig` = '{$_POST['fee_gig']}',
`gig_hours` = '{$_POST['gig_hours']}',
`available_mon` = '{$_POST['available_mon']}',
`available_tue` = '{$_POST['available_tue']}',
`available_wed` = '{$_POST['available_wed']}',
`available_thu` = '{$_POST['available_thu']}',
`available_fri` = '{$_POST['available_fri']}',
`available_sat` = '{$_POST['available_sat']}',
`available_sun` = '{$_POST['available_sun']}',
`has_manager` = '{$_POST['has_manager']}',
`manager_name` = '{$_POST['manager_name']}',
`manager_email` = '{$_POST['manager_email']}',
`manager_phone` = '{$_POST['manager_phone']}',
`has_insurance` = '{$_POST['has_insurance']}',
`info1` = '{$_POST['info1']}',
`info2` = '{$_POST['info2']}',
`info3` = '{$_POST['info3']}',
`info4` = '{$_POST['info4']}',
`facebook` = '{$_POST['facebook']}',
`twitter` = '{$_POST['twitter']}',
`status` = '{$_POST['artist_status']}' 
WHERE `artist`.`id` ={$aid};";
//echo $sql;
$result = mysql_query($sql);
$i=0;
foreach($_POST['media_id'] as $media_id){
	
	if($media_id > 0)
		$sql = "update artist_media set title='{$_POST['media_title'][$i]}', description='{$_POST['media_description'][$i]}', url='{$_POST['media_link'][$i]}', date_recorded='{$_POST['date_recorded'][$i]}' where id='{$_POST['media_id'][$i]}'  ";
	else
		$sql = "insert into artist_media set title='{$_POST['media_title'][$i]}', description='{$_POST['media_description'][$i]}', url='{$_POST['media_link'][$i]}', date_recorded='{$_POST['date_recorded'][$i]}' ,  type='{$_POST['type'][$i]}', artist_id='{$aid}'  ";
	
	mysql_query($sql);
	$i++;
	
} 
mysql_query('DELETE FROM artist_availability WHERE artist_id = '.$aid);



foreach($_POST['availability'] as $k=>$value){
	foreach($value as $time=>$v)
		mysql_query('INSERT artist_availability SET artist_id = '.$aid.', day = "'.$k.'", time = "'.$time.'"');
}

mysql_query("insert into event (event_title,event_description,start_date,artist_id) values('{$_POST['event_title']}','{$_POST['event_description']}','{$_POST['start_date']}','$aid')");
	

}
if (isset($_REQUEST['aid']) && $_REQUEST['aid'] != '') {
    
	$aid = $_REQUEST['aid'];
    //if (isset($_REQUEST['aid']))
        //$aid = substr($_REQUEST['aid'], 1, 10);
    $sql = "select * from artist where id={$aid}";
    $artist_result = mysql_query($sql);
    $artist_data = mysql_fetch_array($artist_result);
	
	// Availability
	$sql = "select * from artist_availability where artist_id={$aid}";
    $artist_availability_result = mysql_query($sql);
    while($row = mysql_fetch_array($artist_availability_result)){
		$artist_availability[$row['day']][$row['time']] = 1; 
	}
	//print_r($artist_availability);
}

require ("tpl/inc/head.php");
?>

<?php class submit {
					
	  function show_form()
	  {
	  ob_start();		
	  $sql = "select *, artist_type.type as artist_type_name from artist 
            LEFT JOIN artist_type 
            ON artist.profile_type=artist_type.artist_id 
            where manager_email LIKE '%" . $_POST['email'] . "%' AND (first_name LIKE  '%" . $_POST['name'] . "%' OR last_name LIKE '%" . $_POST['name'] . "%') AND manager_email LIKE '%" . $_POST['email'] . "%' AND phone_number LIKE '%" . $_POST['phone'] . "%' AND (artist.status LIKE '%" . $_POST['join_status']. "%') ";
if(isset($_POST['type']) && $_POST['type'] != ''){
    $sql .= " AND profile_type = '" . $_POST['type'] . "'";
}

$sql .='  order by first_name ';
//echo $sql;
$artist_result = mysql_query($sql);

$sql = "select artist_id, type from artist_type";
$result = mysql_query($sql);

$sql = "select * from state";
$state_result = mysql_query($sql);

$sql = "select * from country";
$country_result = mysql_query($sql);
//die($_REQUEST['aid']);


						  ?>
					  
                        <form action=".?id=<?php echo $_REQUEST['id'] ?>" method="post" enctype="multipart/form-data" > 
                            <table width="95%" style="color:black; margin: 30px 30px 0px 30px">
                                <tr>
                                    <td width="18%">
                                        <strong>Name</strong><br />
                                        <input type="text" name="name" value="<?= $_POST['name'] ?>" id="name" />
                                    </td>
                                    <td width="18%">
                                        <strong>Email</strong><br />
                                        <input type="text" name="email" value="<?= $_POST['email'] ?>" id="email" />
                                    </td>
                                    <td width="18%">
                                        <strong>Phone</strong><br />
                                        <input type="text" name="phone" value="<?= $_POST['phone'] ?>" id="phone" />
                                    </td>
                                    <td width="22%">
                                        <strong>Artist Type</strong><br />
                                        <select name="type">
                                            <option value="">Select Artist Type</option>
                                            <? while ($types = mysql_fetch_array($result)) { ?>
                                                <option value="<?= $types['artist_id'] ?>" <?= ($types['artist_id'] == $_POST['type']) ? "selected" : "" ?>><?= $types['type'] ?></option>
                                            <? } ?>
                                        </select>
                                    </td>
									<td width="18%">
									<strong>Status</strong><br/>
									<select name="join_status"><option value="" <?php if(''==$_POST['join_status']) echo 'selected="selected"';  ?>>Select Status</option>
											<option value="new" <?php if('new'==$_POST['join_status']) echo 'selected="selected"';  ?>>New</option>
											<option value="approved" <?php if('approved'==$_POST['join_status']) echo 'selected="selected"';  ?>>Approved</option>
											<!--<option value="wait for 3 months" <?php if('wait for 3 months'==$_POST['join_status']) echo 'selected="selected"';  ?>>Wait 3 Months</option>-->
											<option value="reject" <?php if('reject'==$_POST['join_status']) echo 'selected="selected"';  ?>>Reject</option> </select>
											
									</td>
                                    <td width="6%"><input type="submit" name="search" value="Search" class="button" /></td>
                                </tr>
								<tr>
                                    <td colspan="6" style="padding: 10px 0px 10px 0px">&nbsp;</td>                                        
                                 </tr>
								<? while ($artist = mysql_fetch_array($artist_result)) { ?>
                                    <tr>
                                        <td width="18%"  style="padding: 0px"><a href=".?id=<?php echo $_REQUEST['id'] ?>&aid=<?= $artist['id'] ?>"><?= $artist['first_name'] . " " . $artist['last_name'] ?></a></td>
                                        <td width="18%"  style="padding: 0px"><?php if ($artist['manager_email']!=''){?><a href='mailto:<?php echo $artist['manager_email']; ?>'><?php echo  $artist['manager_email'];  }?></td>
                                        <td width="18%"  style="padding: 0px"><?= $artist['phone_number'] ?></td>
                                        <td width="22%"  style="padding: 0px"><?= $artist['artist_type_name'] ?></td>
										<td width="18%"  style="padding: 0px"><select name="status" id="join_status" onChange="javascript: 
									update_artist_status(this.value,'<?php echo $artist['id']; ?>');" >
											<option value="" <?php if(''==$artist['status']) echo 'selected="selected"';  ?>>Select Status</option>
											<option value="new" <?php if('new'==$artist['status']) echo 'selected="selected"';  ?>>New</option>
											<option value="approved" <?php if('approved'==$artist['status']) echo 'selected="selected"';  ?>>Approved</option>
											<!--<option value="wait for 3 months" <?php if('wait for 3 months'==$artist['status']) echo 'selected="selected"';  ?>>Wait 3 Months</option>-->
											<option value="reject" <?php if('reject'==$artist['status']) echo 'selected="selected"';  ?>>Reject</option>
										</select><div id="show_details" style="display:none;"></div></td><td></td>
										
                                    </tr>
                                <? } ?>
                            </table>
                        </form>
                    <?php 
					 $html=ob_get_contents();
					 ob_end_clean();
					 return $html;
					 } 
					 
					function update_status($status,$artist_id){
						$sql="update artist set status='$status' where id='$artist_id'";
						mysql_query($sql);
						if($status == 'approved'){
						// send mail for approval
						
						}
						elseif($status == 'reject')
						{
						
						}
						
					 }
					 
					 
					 function returnDropdown($name='',$id='',$group='',$selected='',$event=''){
						ob_start();
						?>
						<select id="<?php echo $id;?>" name="<?php echo $name;?>" <?php echo $event;?>>
							<?php 
							$sql= "select * from xbasetypes where basgroup1='$group' and active=1";
							//echo $sql;
							$result = mysql_query($sql);
							while($row = mysql_fetch_array($result)){
								?>
									<option value="<?php echo $row['baseid'];?>" 
									<?php if($selected==$row['baseid']) echo 'selected="selected"'?>>
									<?php echo $row['bascode1'];?></option>
								<?php
							} ?>
						</select>
						<?php
						$html=ob_get_contents();
						ob_end_clean();
						return $html;
					 
					 }
					 
					 function showHideCode($element_id=''){
						ob_start();
						?>
						<a style="margin-right:auto" onClick="javascript: if(this.innerHTML=='Show Detail') {
															document.getElementById('<?php echo $element_id;?>').style.display='block';
															this.innerHTML='Hide Detail';
															}
														else{
															document.getElementById('<?php echo $element_id;?>').style.display='none';
															this.innerHTML='Show Detail';
															}" href="javascript: void(0);">Show Detail</a>
						<?php 
						$html=ob_get_contents();
						ob_end_clean();
						return $html;
					 }
					 
					function deleteMedia($media_id=0){
						ob_start();
						mysql_query("delete from artist_media where id=$media_id");
						?><script> window.location='<?php echo 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>';</script><?php
						$html=ob_get_contents();
						ob_end_clean();
						return $html;
					}
					function deleteInstrumet($inst_id=0){
						ob_start();
						mysql_query("delete from artist_Instruments where id=$inst_id");
						?><script> window.location='<?php echo 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>';</script><?php
						$html=ob_get_contents();
						ob_end_clean();
						return $html;
					}
				 } ?>


<?php require ("tpl/PHPLiveX.php"); ?>
<?php
//require ('tpl/phplivex.js');
//require ('class.addsaloon.php');
$ajax = new PHPLiveX();
$obj=new submit();
$ajax->AjaxifyObjects(array("obj"));
$ajax->run('tpl/phplivex.js');
?>

<style>
    #artist_data tr td {padding: 10px;}
	#tbl_availability tr td{ padding: 5px;}
	.form_row label{ display:block;}
	.form_row div{ float:left; margin:0 10px 10px 0;}
</style>
<body> 
    <div id="page"> 
        <?php require ("tpl/inc/header.php"); ?> 
        <?php require ("tpl/inc/path.php"); ?> 
        <div id="content"> 
            <div id="left-col"> 
                <div id="left-col-border"> 
                    <?php if (isset($errors))
                        require ("tpl/inc/error.php"); ?> 
                    <?php if (isset($messages))
                        require ("tpl/inc/message.php"); ?> 
                    <?php if (isset($_SESSION['epClipboard']))
                        require ("tpl/inc/clipboard.php"); ?> 
                    <?php require ("tpl/inc/structure.php"); ?> 
                </div> 
            </div> 
            <div id="right-col"> 
                <h2 class="bar green"><span><?php echo $record['title'] ?></span></h2> 
                <div>
                    <?  if (isset($_REQUEST['aid']) && $_REQUEST['aid'] != '') { ?>

                        <form action=".?id=<?php echo $_REQUEST['id'] ?>&aid=<?=$_REQUEST['aid']?>" method="post" enctype="multipart/form-data" > 
						<input type="hidden" id="parent_id" onchange="alert('passed');">
							<p class="buttons">
							<input type="hidden" name="id" value="<?=$id ?>" />
                            <input type="hidden" name="aid" value="<?=$_REQUEST['aid'] ?>" />
                            <input type="hidden" name="is_submit" value="1" />
							<input type="submit" name="update" value="Update" class="button" />
							<input type="button" name="personal" id="per-btn" style="border:1px solid #66CC00; width:100px;" value="Personal Info" class="button" onclick="jQuery('#artist_data').show();jQuery('#calendar').hide(); jQuery(this).css('border', '1px solid #66CC00');jQuery('#cal-btn').css('border', '1px solid #fff');" />
							<input type="button" name="calender" id="cal-btn" value="Calendar" class="button" onclick="jQuery('#artist_data').hide();jQuery('#calendar').show(); jQuery(this).css('border', '1px solid #66CC00');jQuery('#per-btn').css('border', '1px solid #fff');"/>
							<input type="button" name="viewprofile" id="cal-btn" value="View Profile" 
							class="button" onclick="window.open('http://www.soundbooka.com/version1/profile/view/<?php 
							echo $aid; ?>','mywindow','menubar=1,resizable=1,width=600,height=600,left=500,top=300,scrollbars=1');"/>
							</p>
							<table id="artist_data"  style="color:black; margin: 30px 30px 0px 30px;" width="94%">
								<tr><th style="text-align:left; padding-top: 20px;  border-bottom: 2px dotted #CCCCCC;" >Personal Info:</th>
								<th style="text-align:left; padding-top: 20px;  border-bottom: 2px dotted #CCCCCC;"><?php echo $obj->showHideCode('tbl_perinfo');?></th>
								</tr>

								<tr><td>
								<table width="100%">
									<tr>
										<td width="23%">First Name<br><input type="text" name="first_name" value="<?= $artist_data['first_name'] ?>" /></td>
										<td width="25%">Last Name<br><input type="text" name="last_name" value="<?= $artist_data['last_name'] ?>" /></td>
										<td width="26%">Gender<br><?php echo $obj->returnDropdown('gender','gender','Gender',$artist_data['gender']);?></td>
										<td width="24%">Address<br><input type="text" name="address" value="<?= $artist_data['address'] ?>" /></td>
									</tr>
								</table>
								</td></tr>	
								
								<tr><td>
								<table width="100%" style="display:none;" id="tbl_perinfo">
                                <tr>
								
                                    <td  width="25%">Suburb<br><input type="text" name="suburb" value="<?= $artist_data['suburb'] ?>" /></td>
                                    <td  width="25%">State<br>
                                        <select name="state">
                                            <option value="">Select State</option>
                                            <? while ($state = mysql_fetch_array($state_result)) { ?>
                                                <option value="<?= $state['state_id'] ?>" <?= ($state['state_id'] == $artist_data['state']) ? "selected" : "" ?>><?= $state['state'] ?></option>
                                            <? } ?>
                                        </select> 
                                   
                                    </td>
                                    <td  width="25%">Country<br>
                                        <select name="country">
                                            <option value="">Select Country</option>
                                            <? while ($country = mysql_fetch_array($country_result)) { ?>
                                                <option value="<?= $country['country_id'] ?>" <?= ($country['country_id'] == $artist_data['country']) ? "selected" : "" ?>><?= $country['country_name'] ?></option>
                                            <? } ?>
                                        </select>                                  
                                    </td>
                                    <td  width="25%">Travel Distance<br><input type="text" name="travel_distance" value="<?= $artist_data['travel_distance'] ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Phone Code<br><input type="text" name="phone_code" value="<?= $artist_data['phone_code'] ?>" /></td>
                                    <td>Phone Number<br><input type="text" name="phone_number" value="<?= $artist_data['phone_number'] ?>" /></td>
                                    <td>Phone Alternate<br><input type="text" name="phone_alternate" value="<?= $artist_data['phone_alternate'] ?>" /></td>
                                    <td>Postcode<br><input type="text" name="postcode" value="<?= $artist_data['postcode'] ?>" /></td>
                                </tr> 
                                <tr>
                                    <td>Profile Name<br><input type="text" name="profile_name" value="<?= $artist_data['profile_name'] ?>" /></td>
                                    <td>Profile Type<br>
                                        <select name="profile_type">
                                            <option value="">Select Artist Type</option>
                                            <? while ($types = mysql_fetch_array($result)) { ?>
                                                <option value="<?= $types['artist_id'] ?>" <?= ($types['artist_id'] == $artist_data['profile_type']) ? "selected" : "" ?>><?= $types['type'] ?></option>
                                            <? } ?>
                                        </select>
                                    
                                    </td>
                                    <td>Equipment<br>
									<select id="equipment" name="equipment" >
										<option value="1" <?php if($artist_data['equipment']!=2) echo 'selected="selected"'?>>I perform on my own equipment</option>
										<option value="2" <?php if($artist_data['equipment']==2) echo 'selected="selected"'?>>I require equipment to perform</option>
									</select>
									</td>
                                    <td>Status<br>
										<select name="artist_status">
                                                <option value="1" <?= ($artist_data['status'] == 1) ? "selected" : "" ?>>Approved</option>
                                                <option value="2" <?= ($artist_data['status'] == 2) ? "selected" : "" ?>>Try again in 3 months</option>
                                                <option value="3" <?= ($artist_data['status'] == 3) ? "selected" : "" ?>>Try again in 6 months</option>
                                                <option value="0" <?= ($artist_data['status'] == 0) ? "selected" : "" ?>>Rejected</option>
                                        </select>
									</td>
                                </tr> 
								</td></tr>
								</table>
                                
								<tr><th style="text-align:left; padding-top: 20px;  border-bottom: 2px dotted #CCCCCC;" >Availability Info:</th>
								<th style="text-align:left; padding-top: 20px;  border-bottom: 2px dotted #CCCCCC;" colspan=3><?php echo $obj->showHideCode('tbl_availability');?></th>
								</tr>
								<tr><td colspan="4" style="padding: 5px;">
									<table width="100%" style="display:none;" id="tbl_availability"><tr>
                                    
                                        <td> 
											<table border="1" BORDERCOLOR ="#DDDDDD">
												<tr>
													<td colspan="2" align="center">Monday</td>
												</tr>
												<tr>
													<td>
														<input type="checkbox" name="availability[mon][day]" value="1" <? if ($artist_availability['mon']["day"] == 1) { ?>checked <? } ?> /> Day
													</td>
													<td>
														<input type="checkbox" name="availability[mon][night]" value="1" <? if ($artist_availability['mon']["night"] == 1) { ?>checked <? } ?> /> Night
													</td>
												</tr>
											</table>
										</td>
										
										<td> 
											<table border="1" BORDERCOLOR ="#DDDDDD">
												<tr>
													<td colspan="2" align="center">Tuesday</td>
												</tr>
												<tr>
													<td>
														<input type="checkbox" name="availability[tue][day]" value="1" <? if ($artist_availability['tue']["day"] == 1) { ?>checked <? } ?> /> Day
													</td>
													<td>
														<input type="checkbox" name="availability[tue][night]" value="1" <? if ($artist_availability['tue']["night"] == 1) { ?>checked <? } ?> /> Night
													</td>
												</tr>
											</table>
										</td>
										<td> 
											<table border="1" BORDERCOLOR ="#DDDDDD">
												<tr>
													<td colspan="2" align="center">Wednesday</td>
												</tr>
												<tr>
													<td>
														<input type="checkbox" name="availability[wed][day]" value="1" <? if ($artist_availability['wed']["day"] == 1) { ?>checked <? } ?> /> Day
													</td>
													<td>
														<input type="checkbox" name="availability[wed][night]" value="1" <? if ($artist_availability['wed']["night"] == 1) { ?>checked <? } ?> /> Night
													</td>
												</tr>
											</table>
										</td>
										<td> 
											<table border="1" BORDERCOLOR ="#DDDDDD">
												<tr>
													<td colspan="2" align="center">Thursday</td>
												</tr>
												<tr>
													<td>
														<input type="checkbox" name="availability[thu][day]" value="1" <? if ($artist_availability['thu']["day"] == 1) { ?>checked <? } ?> /> Day
													</td>
													<td>
														<input type="checkbox" name="availability[thu][night]" value="1" <? if ($artist_availability['thu']["night"] == 1) { ?>checked <? } ?> /> Night
													</td>
												</tr>
											</table>
										</td>
										<td> 
											<table border="1" BORDERCOLOR ="#DDDDDD">
												<tr>
													<td colspan="2" align="center">Friday</td>
												</tr>
												<tr>
													<td>
														<input type="checkbox" name="availability[fri][day]" value="1" <? if ($artist_availability['fri']["day"] == 1) { ?>checked <? } ?> /> Day
													</td>
													<td>
														<input type="checkbox" name="availability[fri][night]" value="1" <? if ($artist_availability['fri']["night"] == 1) { ?>checked <? } ?> /> Night
													</td>
												</tr>
											</table>
										</td>
										<td> 
											<table border="1" BORDERCOLOR ="#DDDDDD">
												<tr>
													<td colspan="2" align="center">Saturday</td>
												</tr>
												<tr>
													<td>
														<input type="checkbox" name="availability[sat][day]" value="1" <? if ($artist_availability['sat']["day"] == 1) { ?>checked <? } ?> /> Day
													</td>
													<td>
														<input type="checkbox" name="availability[sat][night]" value="1" <? if ($artist_availability['sat']["night"] == 1) { ?>checked <? } ?> /> Night
													</td>
												</tr>
											</table>
										</td>
										<td> 
											<table border="1" BORDERCOLOR ="#DDDDDD">
												<tr>
													<td colspan="2" align="center">Sunday</td>
												</tr>
												<tr>
													<td>
														<input type="checkbox" name="availability[sun][day]" value="1" <? if ($artist_availability['sun']["day"] == 1) { ?>checked <? } ?> /> Day
													</td>
													<td>
														<input type="checkbox" name="availability[sun][night]" value="1" <? if ($artist_availability['sun']["night"] == 1) { ?>checked <? } ?> /> Night
													</td>
												</tr>
											</table>
										</td>
										
										<!--
                                        <td>Tuesday <input type="checkbox" name="available_tue" value="1" <? if ($artist_data['available_tue'] == 1) { ?>checked <? } ?> /></td>
                                        <td>Wednesday <input type="checkbox" name="available_wed" value="1" <? if ($artist_data['available_wed'] == 1) { ?>checked <? } ?> /></td>
                                        <td>Thursday <input type="checkbox" name="available_thu" value="1" <? if ($artist_data['available_thu'] == 1) { ?>checked <? } ?> /></td>
                                        <td>Friday <input type="checkbox" name="available_fri" value="1" <? if ($artist_data['available_fri'] == 1) { ?>checked <? } ?> /></td>
                                        <td>Saturday <input type="checkbox" name="available_sat" value="1" <? if ($artist_data['available_sat'] == 1) { ?>checked <? } ?> /></td>
                                        <td>Sunday <input type="checkbox" name="available_sun" value="1" <? if ($artist_data['available_sun'] == 1) { ?>checked <? } ?> /></td>
                                    </td>-->
									</tr></table>
                                </td></tr>
								
								<tr><th style="text-align:left; padding-top: 20px;  border-bottom: 2px dotted #CCCCCC;">Audio Info:</th>
								<th style="text-align:left; padding-top: 20px;  border-bottom: 2px dotted #CCCCCC;" colspan=3><?php echo $obj->showHideCode('tbl_audio');?></th></tr>
								<tr><td colspan=4>
									<table width="100%" style="display:none;" id="tbl_audio">
									<?php 
									$sql_audio = "select * from artist_media where artist_id='$artist_data[id]' and type='Audio'";
									$result_audio = mysql_query($sql_audio);
									$i=0;
									$id_audio = 0;
									while($row_audio= mysql_fetch_array($result_audio)){
									$i++;
									?>
										<tr>
											<input type="hidden" name="media_id[]" value="<?php echo $row_audio['id'];?>"/>
											<input type="hidden" name="type[]" value="<?php echo $row_audio['type'];?>"/>
											<td width="200px">Title-<a href="" onClick='window.open("<?php echo $row_audio['url'];?>","mywindow","menubar=1,resizable=1,width=350,height=250,left=500,top=400");'>Play</a><br><input type="text" name="media_title[]" value="<?php echo $row_audio['title'];?>"/></td>
											<td width="200px">Description<br><input type="text" name="media_description[]" value="<?php echo $row_audio['description'];?>"/></td>
											<td width="200px">Link<br><input type="text" name="media_link[]" value="<?php echo $row_audio['url'];?>"/></td>
											<td width="200px">Date Recorded<br><input class="date_pick"
											id="date_aud_<?php echo $i; $id_audio = $i + 1;?>" 
											type="text" name="date_recorded[]" value="<?php echo $row_audio['date_recorded'];?>"/></td>
										
											<td><a href="javascript: void(0);" onClick="if(confirm('Are You Sure To Delete?')) obj.deleteMedia('<?php echo $row_audio['id'];?>',{});">Remove</a></td>
										</tr>
									<?php } ?>
									<tr><td colspan=4><a href="javascript:void(0)" onClick="addMedia('tbl_audio',<?php echo $id_audio;?>)">Add More Audio</a></td></tr>
									</table>
									
                                </td></tr>
								
								<tr><th style="text-align:left; padding-top: 20px;  border-bottom: 2px dotted #CCCCCC;">Video Info:</th>
								<th style="text-align:left; padding-top: 20px;  border-bottom: 2px dotted #CCCCCC;" colspan=3><?php echo $obj->showHideCode('tbl_video');?></th>
								</tr>
								<tr><td colspan=4>
									<table width="100%" style="display:none;" id="tbl_video">
									
									<?php 
									$sql_video = "select * from artist_media where artist_id='$artist_data[id]' and type='Video'";
									$result_video = mysql_query($sql_video);
									$i=0;
									$id_video = 0;
									while($row_video= mysql_fetch_array($result_video)){
									$i++;									
									?>
										<tr>
											<input type="hidden" name="media_id[]" value="<?php echo $row_video['id'];?>"/>
											<input type="hidden" name="type[]" value="<?php echo $row_video['type'];?>"/>
											<td width="200px">Title-<a  href="" onClick='window.open("<?php echo $row_video['url'];?>","mywindow","menubar=1,resizable=1,width=350,height=250");'>Play</a><br><input type="text" name="media_title[]" value="<?php echo $row_video['title'];?>"/></td>
											<td width="200px">Description<br><input type="text" name="media_description[]" value="<?php echo $row_video['description'];?>"/></td>
											<td width="200px">Link<br><input  type="text" name="media_link[]"  value="<?php echo $row_video['url'];?>"/></td>
											<td width="200px">Date Recorded<br><input type="text" 
											name="date_recorded[]" class="date_pick" id="date_vid_<?php echo $i; $id_video = $i + 1;?>"
											value="<?php echo $row_video['date_recorded'];?>"/></td>
											<td><a href="javascript: void(0);" onClick="if(confirm('Are You Sure To Delete?')) obj.deleteMedia('<?php echo $row_video['id'];?>',{});">Remove</a></td>
											
										</tr>
									<?php } ?>
									
									<tr><td colspan=4><a href="javascript:void(0)" onClick="addMedia('tbl_video',<?php echo $id_video;?>)">Add More Video</a></td></tr>
									</table>
									
                                </td></tr>
								
								<tr><th style="text-align:left; padding-top: 20px;  border-bottom: 2px dotted #CCCCCC;">GIG Info:</th>
								<th style="text-align:left; padding-top: 20px;  border-bottom: 2px dotted #CCCCCC;" colspan=3><?php echo $obj->showHideCode('tbl_gig');?></th>
								</tr>
								<tr><td colspan=4>
									<table width="100%" style="display:none; " id="tbl_gig"><tr>
                                    <td width="200px">GIG<br><input type="text" name="gig" value="<?= $artist_data['gig'] ?>" /></td>
									<td width="200px">Fee Hour<br><input type="text" name="fee_hour" value="<?= $artist_data['fee_hour'] ?>" /></td>
                                    <td width="200px">Fee gig<br><input type="text" name="fee_gig" value="<?= $artist_data['fee_gig'] ?>" /></td>
                                    <td width="200px">Gig Hours<br><input type="text" name="gig_hours" value="<?= $artist_data['gig_hours'] ?>" /></td>
									</tr></table>
                                </td></tr>
                      
                                <tr><th style="text-align:left; padding-top: 20px;  border-bottom: 2px dotted #CCCCCC;">Manager Info:</th>
								<th style="text-align:left; padding-top: 20px;  border-bottom: 2px dotted #CCCCCC;" colspan=3><?php echo $obj->showHideCode('tbl_manager');?></th>
								</tr>
								<tr><td colspan=4>
									<table width="100%" style="display:none;" id="tbl_manager"><tr>
									<td width="200px">Has Manager<br><input type="checkbox" name="has_manager" value="1" <? if ($artist_data['has_manager'] == 1) { ?>checked <? } ?></td>
                                    <td width="200px">Manager Name<br><input type="text" name="manager_name" value="<?= $artist_data['manager_name'] ?>" /></td>
                                    <td width="200px">Manager Email<br><input type="text" name="manager_email" value="<?= $artist_data['manager_email'] ?>" /></td>
                                    <td width="200px">Manager Phone<br><input type="text" name="manager_phone" value="<?= $artist_data['manager_phone'] ?>" /></td>
									</tr></table>
                                </td></tr>
                               
								
								<tr><th style="text-align:left; padding-top: 20px; border-bottom: 2px dotted #CCCCCC;">Instrument Info:</th>
								<th style="text-align:left; padding-top: 20px; border-bottom: 2px dotted #CCCCCC;" colspan=3><?php echo $obj->showHideCode('tbl_instrument');?></th>
								</tr>
								<tr><td colspan=4>
									<table width="100%" style="display:none;" id="tbl_instrument">								
									<?php 
									$sql_inst = "select a.*,b.bascode1 from artist_Instruments a,xbasetypes b where a.instrument_id=b.baseid and a.artist_id='$artist_data[id]'";
									$result_inst = mysql_query($sql_inst);
									while($row_inst= mysql_fetch_array($result_inst)){?>
										<tr>
											<input type="hidden" name="inst_id[]" value="<?php echo $row_inst['id'];?>"/>
											<td width="200px">Instrument<br><input type="text" name="instrument_id[]" style="width: 304px;" value="<?php echo $row_inst['bascode1'];?>"/></td>
											<td width="200px"><p style="width: 314px;margin-left:78px">Comment</p><input type="text" name="comment[]" style="width: 304px;margin-left:78px;" value="<?php echo $row_inst['comment'];?>" /></td>
											<td><a href="javascript: void(0);" onClick="if(confirm('Are You Sure To Delete?')) obj.deleteInstrumet('<?php echo $row_inst['id'];?>',{});">Remove</a></td>
										</tr>
									<?php } ?>
									</table>
                                </td></tr>
								
								<tr><th style="text-align:left; padding-top: 20px; border-bottom: 2px dotted #CCCCCC;">Social Info:</th>
								<th style="text-align:left; padding-top: 20px; border-bottom: 2px dotted #CCCCCC;" colspan=3><?php echo $obj->showHideCode('tbl_social');?></th>
								</tr>
								<tr><td colspan=4>
									<table width="100%" style="display:none;" id="tbl_social">
										<tr>
											<td width="200px">Twitter<br>
											<div style="width:314">
												<div style="float:left">
													<input type="text" name="twitter" value="<?php echo $artist_data['twitter']; ?>" style="width: 304px;"/>
												</div>
												<div style="float:right;margin-top:-25px;margin-right:-25px;cursor:pointer;">
													<?php if(!empty($artist_data['twitter'])){?><a onClick="window.open('<?php echo $artist_data['twitter']; ?>','mywindow','menubar=1,resizable=1,width=600,height=600,left=500,top=300,scrollbars=1');"><?php } ?><img width="26" height="24" alt="twitter" src="../../version1/images/buttons/twitter.png"><?php if(!empty($artist_data['twitter'])){?></a><?php } ?></td>
												</div>
											</div>
											<!--<td width="200px">
											<p style="width: 314px;margin-left:78px">FaceBook</p>
											<div style="width:314">
												<div style="float:left">
												<input type="text" style="width: 310px;margin-left:76px" value="http://www.facebook.com/max" name="facebook">
												</div>
												<div style="float:right;margin-top:-2px;margin-right:-25px">
												<img width="26" height="24" src="../../version1/images/buttons/facebook.jpg" alt="twitter">
												</div></td>-->
											<td width="200px">&nbsp;</td><td width="200px">&nbsp;</td>
										</tr>
								
									</table>
                                </td></tr>
								
								
								
								
								<tr><th style="text-align:left; padding-top: 20px;  border-bottom: 2px dotted #CCCCCC;">Performance History:</th>
								<th style="text-align:left; padding-top: 20px;  border-bottom: 2px dotted #CCCCCC;" colspan=3><?php echo $obj->showHideCode('performance');?></th>
								</tr>
								<tr><td colspan=4>
									<div id="performance" style="display:none;">
										<div class="form_row">
                    						<div class="form_item">
												<label>Experience</label>
												<textarea title="Add more information so that people know more about you. (Max. 50 words)" id="info1" name="info1" class="textarea2 infotext" cols="60" rows="5" ><?= $artist_data['info1'] ?></textarea>
											</div>
											
											<div class="form_item2">
												<label>Releases</label>
												<textarea title="Hold down any residencies? List them here. (Max. 50 words)" id="info2" name="info2" class="textarea2 infotext" cols="60" rows="5"><?= $artist_data['info2'] ?></textarea>
											</div>
											<br class="cl">
										</div>
										<div class="form_row">
											<div class="form_item">
												<label>Festival</label>
												<textarea title="List festivals appearances here. (Max. 50 words)" id="info3" name="info3" class="textarea2 infotext" cols="60" rows="5"><?= $artist_data['info3'] ?></textarea>
											</div>
											
											<div class="form_item2">
												<label>Highlights so far</label>
												<textarea title="Performed anywhere special or with someone amazing? (Max. 50 words)" id="info4" name="info4" class="textarea2 infotext" cols="60" rows="5"><?= $artist_data['info4'] ?></textarea>
											</div>
											<br class="cl">
										</div>
									</div>
                                </td></tr>
								
                            </table>
						<div id="calendar" style="display:none;">
                        <?php
						require ("tpl/fn.cal.php");
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
						
						<!--<table>
						<tr><th valign="top" align="left" width="120">Title:</th><td><input name="event_title" size="90" type="text" /></td></tr>
						<tr><th valign="top" align="left" >&nbsp;</th><td>&nbsp;</td></tr>
						<tr><th valign="top" align="left">Event Description:</th><td><textarea name="event_desciption" cols="80" rows="5"></textarea></td></tr>
						<tr><th valign="top" align="left" >&nbsp;</th><td>&nbsp;</td></tr>
						<tr><th valign="top" align="left">Due Date:</th><td><input name="start_date" type="text" /></td></tr>
						</table> -->
						

<h2><a style="text-decoration:underline;" onClick="window.open('tpl/edit_calendar.php?aid=<?php echo $aid; ?>','mywindow','menubar=1,resizable=1,width=450,height=450,left=500,top=300');"> ADD NEW EVENTS</a></h2>

						
						<table style="margin:5px 0px;"><tr>
							<th><?=date('F',mktime(0,0,0,$month,1,$year)).' '.$year;?></th>
							<td><?=$controls;?></td>
						</tr></table>
						<?php
						//echo '<h2 style="float:left; padding-right:30px;">'.date('F',mktime(0,0,0,$month,1,$year)).' '.$year.'</h2>';
						//echo '<div style="float:left; margin-bottom:10px;">'.$controls.'</div>';
						//echo '<div style="clear:both;"></div>';
						echo draw_calendar($month,$year,$events);
						?></div>
						</form>
                    <? }
					else { 
					 echo $obj->show_form(); }
					?>
					</div>
					  </div>

            </div> 
            <?php require ("tpl/inc/footer.php"); ?> 
        </div> 
    </div> 
					
              

    <script type="text/javascript">
	var gFiles = 0;
	function addMedia(tbl_id,add_id) {
		var tr = document.createElement('tr');
		tr.setAttribute('id', 'file-' + tbl_id +gFiles);
		var td = document.createElement('td');
		
		if(tbl_id=='tbl_audio') 
			td.innerHTML = '<input type="hidden" name="type[]" value="Audio"/><input type="hidden" name="media_id[]" />Title<br><input type="text" name="media_title[]" />';
		else
			td.innerHTML = '<input type="hidden" name="type[]" value="Video"/><input type="hidden" name="media_id[]" />Title<br><input type="text" name="media_title[]" />';
		
		tr.appendChild(td);
		var td = document.createElement('td');
		td.innerHTML = 'Description<br><input type="text" name="media_description[]" />';
		tr.appendChild(td);
		var td = document.createElement('td');
		td.innerHTML = 'Link<br><input type="text" name="media_link[]" />';
		tr.appendChild(td);
		var td = document.createElement('td');
		td.innerHTML = 'Date Recorded<br><input type="text" id="date_aud_' + add_id + '" class="date_pick" name="date_recorded[]" />';
		tr.appendChild(td);
		var td = document.createElement('td');
		td.innerHTML = '<a href="javascript:void(0)" onclick="removeMedia(\'file-' + tbl_id + gFiles + '\')" style="cursor:pointer;">Clear</a>';
		tr.appendChild(td);
		document.getElementById(tbl_id).appendChild(tr);
		date_pick();
		gFiles++;
	}
	function removeMedia(aId) {
		var obj = document.getElementById(aId);
		obj.parentNode.removeChild(obj);
	}
        $(function(){
            remover();date_pick();
            $('#add_row').click(function(){
                $('.this').removeClass('this');
                $tr=$('.add').clone();
                var tr='<tr class="empty"><td>&nbsp;</td></tr><tr class="additional this">'+$tr.html()+'</tr>';
                $('#featured_properties').append(tr);
                $('.this').find('select option').removeAttr('selected');
                $('.this').find('input:text').val('');
                remover();
            });
        });
		function date_pick(){
			$( ".date_pick" ).datepicker( { dateFormat: 'yy/mm/dd' } );	
		}

        function remover(){
            $('#featured_properties a').click(function(){
                if($('#featured_properties .additional').size()<=1) return false;
                $(this).parents('.additional').remove();
            });
        }
        
        $('#name').click(function() {
            if($('#name').val() == 'Name'){
                $('#name').val('')
            }
        });
        
        $('#email').click(function() {
            if($('#email').val() == 'Email'){
                $('#email').val('')
            }
        });
        
        $('#phone').click(function() {
            if($('#phone').val() == 'Phone'){
                $('#phone').val('')
            }
        });
		
		function update_artist_status(status, Id){
			
			
			$.post("http://www.soundbooka.com/version1/artist/updateArtistStatus/",{aAtatus :status, AId:Id});
		
		}
    </script>
	<?php if (!empty($_REQUEST['year'])) { ?>						  
<script type="text/javascript">	
     $(function(){					  
	$('#calendar').show();
     $('#cal-btn').click();
	
	});
</script>	
<?php } ?>
	
</body>
</html>

