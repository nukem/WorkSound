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

    $sql ="UPDATE `artist` SET 
        `first_name` = '{$_POST['first_name']}',
		`last_name` = '{$_POST['last_name']}',
		`gender` = '{$_POST['gender']}',
		`status` = '{$_POST['artist_status']}' 
		WHERE `artist`.`id` ={$aid};";		
		
//echo $sql;
$result = mysql_query($sql);

$varDOB = $_POST['dobyear']."-".$_POST['dobmonth']."-".$_POST['dobday'];

$sqlUserUp = "update user set secret_question = '".$_POST['secretques']."',
			  secret_answer='".$_POST['secretans']."',
			  dob = '".$varDOB."' WHERE  id = '".$_POST['userid']."' ";
$result = mysql_query($sqlUserUp);

if (!empty($_POST['password1'])) {

mysql_query("UPDATE wp_user wp, user u SET wp.password =MD5('".$_POST['password1']."'), u.password = '".$_POST['password1']."' WHERE u.id = '".$_POST['userid']."' AND wp.email = u.email");

}

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
	
	$sqlUser = "select * from user where id = '{$artist_data['user_id']}'";
	$user_result = mysql_query($sqlUser);
    $user_data = mysql_fetch_array($user_result);
	
	$arrDob = explode ("-",$user_data['dob']);
	
}

require ("tpl/inc/head.php");
?>
<?php class submit {
					
					function showEmailTemplate( $is_summary = false ) {
					?>
							<script type="text/javascript">
								function _chk( dom_id ) {
									if ( !$("#"+dom_id).length )
										return "DONE";
									if ( !$("#"+dom_id).is(":checked") )
										return "";	
									return $("#"+dom_id).val();	
								}
								
								function _onSend() {
									var et = $.trim($("#email_template").val());
									if ( et == "" ) {
										alert("Please select e-mail template to use.");
										return false;
									}	
									var s = "";
									<?php if ( $is_summary ) { ?>
										var type_s = "";
									<?php } ?>	
									for ( var i = 0; i < 999999; i++ ) {
										<?php if ( $is_summary ) { ?>
											var chk_s = _chk("chk_status_"+i);
											if ( chk_s != "" && chk_s != "DONE" ) {
												if ( s != "" )
													s += ",";
												s += "'"+chk_s+"'";	
											}
											var chk_t = _chk("chk_type_"+i);
											if ( chk_t != "" && chk_t != "DONE" ) {
												if ( type_s != "" )
													type_s += ",";
												type_s += "'"+chk_t+"'";	
											}
											if ( chk_s == "DONE" && chk_t == "DONE" )
												break;	
										<?php } else { ?>
											var chk = _chk("chk_"+i);
											if ( chk == "DONE" )
												break;
											if ( chk == "" )
												continue;
											if ( s != "" )
												s += ",";
											s += chk;	
										<?php } ?>	
									}
									<?php if ( $is_summary ) { ?>
										if ( s == "" && type_s == "" ) {
											alert("Please select at least 1 group.");
											return false;
										}
										$("#email_rcpt").val(s);
										$("#email_type_rcpt").val(type_s);
									<?php } else { ?>	
										if ( s == "" ) {
											alert("Please select at least 1 recipient.");
											return false;
										}
										$("#email_rcpt").val(s);
									<?php } ?>	
									$("#email_form").attr("action","?id="+et+"&__send=1");
									return true;
								}
							</script>
							<form id="email_form" action="" method="post" onsubmit="return _onSend()"> 
							<input type="hidden" name="email_rcpt" id="email_rcpt" value="" />
							<input type="hidden" name="email_type_rcpt" id="email_type_rcpt" value="" />
							<input type="hidden" name="summary" id="summary" value="<?php echo($is_summary?"1":"") ?>" />
                            <table width="95%" style="color:black; margin: 30px 30px 0px 30px">
								<tr>
									<td style="padding-top: 0px; text-align: right;">
										<strong>E-mail Template</strong>
										<select id="email_template">
											<option value="">Select Template</option>
											<?php		
											$sql = "SELECT id, title
														FROM wp_structure 
														WHERE `type` = 'email_template' AND online = '1'
														ORDER BY title";
											 $rs = mysql_query($sql);			
											 while ($row = mysql_fetch_array($rs)) { 
											?>
												<option value="<?php echo($row["id"]) ?>"><?php echo($row["title"]) ?></option>
											<?php
											 }
											?>											
										</select>	
									</td>
                                    <td style="padding-top: 0px; padding-left: 5px;" width="14%"><input type="submit" name="send" value="Send" class="button" /></td>
								</tr>
							</table>
						    </form>				
							<?php
					}
					
					
	  function show_form()
	  {
	  $wz_status_ary = array
		(
			"approved",	"incomplete", "new", "pre-registered", "registered", "reject", "step1", "step2", "step3", "step4", "step5", "step6", 		"test", "updated"
		);
	  ob_start();		
	  $sql = "select artist.*, artist_type.type as artist_type_name,usr.email from artist 
            LEFT JOIN artist_type ON artist.profile_type=artist_type.artist_id
			LEFT JOIN user usr ON usr.id = 	artist.user_id             
            ";
	
	
	if(isset($_REQUEST['name']) && $_REQUEST['name'] != ''){
		$where[] = " (first_name LIKE  '%" . $_REQUEST['name'] . "%' OR last_name LIKE '%" . $_REQUEST['name'] . "%')";
	}
	if(isset($_REQUEST['email']) && $_REQUEST['email'] != ''){
		$where[] = " usr.email LIKE '%" . $_REQUEST['email'] . "%'";
	}
	if(isset($_REQUEST['phone']) && $_REQUEST['phone'] != ''){
		$where[] = "  phone_number LIKE '%" . $_REQUEST['phone'] . "%'";
	}
	if(isset($_REQUEST['join_status']) && $_REQUEST['join_status'] != ''){
		$where[] = "  (artist.status LIKE '%" . $_REQUEST['join_status']. "%') ";
	}
	if(isset($_REQUEST['type']) && $_REQUEST['type'] != ''){
		$where[] = " artist.profile_type = '" . $_REQUEST['type'] . "'";
	}
	$where and $sql.= ' where '.implode(' AND ',$where);	
	
 $sql .='  order by usr.created DESC ';
$artist_result = mysql_query($sql);

$sql = "select artist_id, type, COUNT(a.profile_type) AS artist_count, (SELECT COUNT(*) FROM artist) AS total_count FROM artist_type at LEFT JOIN artist a ON( a.profile_type = at.artist_id) GROUP BY at.`artist_id`, a.profile_type ORDER BY type";
$result = mysql_query($sql);
$result_artist_count = mysql_query($sql);

$sql = "select * from state";
$state_result = mysql_query($sql);

$sql = "select * from country";
$country_result = mysql_query($sql);
//die($_REQUEST['aid']);


						  ?>
					  
                        <form action=".?id=<?php echo $_REQUEST['id'] ?>" method="post" enctype="multipart/form-data" id="search" > 
                            <table width="95%" style="color:black; margin: 30px 30px 0px 30px">
							
                                <tr id="">
                                    <td width="18%">
                                        <strong>Name (Audio,Video)</strong><br />
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
                                        <select name="type" id="type">
                                            <option value="">Select Artist Type</option>
                                            <? while ($types = mysql_fetch_array($result)) { ?>
                                                <option value="<?= $types['artist_id'] ?>" <?= ($types['artist_id'] == $_POST['type']) ? "selected" : "" ?>><?= $types['type'] ?></option>
                                            <? } ?>
                                        </select>
                                    </td>
									<td width="18%">
									<strong>Status</strong><br/>
									<select name="join_status"><option value="" <?php if(''==$_REQUEST['join_status']) echo 'selected="selected"';  ?>>Select Status</option>
									<?php foreach ( $wz_status_ary as $wz_status ) { ?>
										<option value="<?php echo($wz_status) ?>" <?php if($wz_status==$_REQUEST['join_status']) echo 'selected="selected"';  ?>><?php echo(ucwords($wz_status)) ?></option>
									<?php } ?></select>
											
									</td>
                                    <td width="6%"><input type="submit" name="search" value="Search" class="button" /></td>
                                </tr>
                               </table>
							</form>
                            		<?php $this->showEmailTemplate(); ?>
							<table width="95%" style="color:black; margin: 30px 30px 0px 30px">
								<?php if($_SESSION['acx']==1 and $_REQUEST['join_status']=='test') {?>
									<tr>
									<td colspan="4"></td>
									<td colspan="2" align="right"><a href="javascript:void(0);" class="button" id="btn_test" style="padding: 3px;
										text-decoration: none;width: 100px;"/>Delete All Test Data</a>
										<br /><br />
										</td>
									</tr>
								<?php
								}
								?>
								<tr>
                                    <td colspan="6" style="padding: 10px 0px 10px 0px" align="left"><ul class="artist_type">
									<? $flg = 1; while($type = mysql_fetch_array($result_artist_count)) {  $flg and print "<li><a href='javascript:showArtist(\"\")'>All ({$type[total_count]})</a></li>"; $flg = 0;?>
										<li><a href="javascript:showArtist('<?=$type['artist_id']?>')"><? echo $type['type']," (",$type['artist_count'],")";?></li>
									<?php }?>
									</ul></td>                                        
                                </tr>
								<tr>
                                    <td colspan="6" style="padding: 10px 0px 10px 0px">&nbsp;</td>                                        
                                 </tr>
								<? 	
                                while ($artist = mysql_fetch_array($artist_result)) { 
								$sql_audio = "SELECT count(*) AS count FROM `artist_media` where artist_id = ".$artist['id']." and type='audio'";
								$result = mysql_fetch_row(mysql_query($sql_audio));
								$audio = $result[0];
								$sql_video = "SELECT count(*) AS count_video FROM `artist_media` where artist_id = ".$artist['id']." and type='video'";
								$video_result = mysql_fetch_row(mysql_query($sql_video));
								$video = $video_result[0];
								?>
                                    <tr id="<?php echo $artist['id'];?>">
                                     <td width="18%"  style="padding: 0px"><a href=".?id=<?php echo $_REQUEST['id'] ?>&aid=<?= $artist['id'] ?>"><?= $artist['first_name'] . " " . $artist['last_name'].' ('.$audio.','.$video.')' ?></a></td>
                                        <td width="18%"  style="padding: 0px"><?php if ($artist['email']!=''){?><a href='mailto:<?php echo $artist['email']; ?>'><?php echo  $artist['email'];  }?></td>
                                        <td width="18%"  style="padding: 0px"><?= $artist['phone_number'] ?></td>
                                        <td width="22%"  style="padding: 0px"><?= $artist['artist_type_name'] ?></td>
										<td  style="padding: 0px"><select name="status" id="join_status" onChange="javascript: update_artist_status(this.value,'<?php echo $artist['id']; ?>');" >
											<option value="" <?php if(''==$artist['status']) echo 'selected="selected"';  ?>>Select Status</option>
										<?php foreach ( $wz_status_ary as $wz_status ) { ?>
											<option value="<?php echo($wz_status) ?>" <?php if($wz_status == $artist['status']) echo 'selected="selected"';  ?>><?php echo(ucwords($wz_status)) ?></option>
										<?php } ?>			
										</select><div id="show_details" style="display:none;"></div></td> 
											<td>
										<input type="checkbox" value="<?php echo $artist['id'];?>" id="chk_<?php echo($wz_i++) ?>" />
										<?= strftime("%d-%m-%Y", strtotime($artist['created']))?>
										</td>
										
                                    </tr>
                                <? } ?>
                            </table>
                        </form>
                    <?php 
					 $html=ob_get_contents();
					 ob_end_clean();
					 return $html;
					 } 
					  function showSummary() {
						 ob_start();		
						 ?>
						<?php $this->showEmailTemplate(true); ?>
						<table width="95%" style="color:black; margin: 30px 30px 0px 30px">
							<tr id="">
								<td valign="top" width="95%">
									<div style="margin-left: 30px; font-size: 14px; font-weight: bold;">Artist Types</div>
									<table width="95%" style="color:black; margin: 10px 30px 0px 30px;" cellspacing="1">
									<?php		
									$sql = "SELECT t.`type`,t.artist_id,COUNT(*) n 
											FROM artist a 
												LEFT JOIN artist_type t ON a.profile_type = t.artist_id 
												LEFT JOIN `user` u ON u.id = a.user_id 
											WHERE u.email IS NOT NULL 
												AND t.`type` IS NOT NULL 
											GROUP BY t.`type`,t.artist_id
											ORDER BY t.`type`";
									 $rs = mysql_query($sql);
									 $wz_i = 0;
									 while ($row = mysql_fetch_array($rs)) {
									?>
										<tr>
											<td style="padding: 4px; margin: 2;" width="30%">
												<a href="?id=<?php echo($_REQUEST["id"]) ?>&type=<?php echo($row['artist_id']) ?>" style="font-size: 14px;"><?php echo(ucwords($row['type'])) ?></a>
											</td>
											<td style="padding: 4px; margin: 2;" width="50px">
												<a href="?id=<?php echo($_REQUEST["id"]) ?>&type=<?php echo($row['artist_id']) ?>" style="font-size: 14px;"><?php echo($row['n']) ?></a>
											</td>
											<td>
												<input type="checkbox" value="<?php echo $row["artist_id"];?>" id="chk_type_<?php echo($wz_i++) ?>" />										
											</td>
										</tr>
									<?php
									 }
									?>
									</table>
									<div style="margin-left: 30px; margin-top: 25px; font-size: 14px; font-weight: bold;">Status</div>
									<?php		
									$wz_status_ary = array
									(
										"approved" => 0,
										"incomplete" => 0,
										"new" => 0,
										"pre-registered" => 0,
										"registered" => 0,
										"reject" => 0,
										"step1" => 0,
										"step2" => 0,
										"step3" => 0,
										"step4" => 0,
										"step5" => 0,
										"step6" => 0,
										"test" => 0,
										"updated" => 0
									);
									
									$sql = "SELECT a.`status`,COUNT(*) n 
											FROM artist a 
												LEFT JOIN artist_type t ON a.profile_type = t.artist_id 
												LEFT JOIN `user` u ON u.id = a.user_id 
											WHERE IFNULL(a.`status`,'') != '' 
												AND u.email IS NOT NULL 
												AND t.`type` IS NOT NULL 
											GROUP BY a.`status`
											ORDER BY a.`status`";
									 $rs = mysql_query($sql);	
									 while ($row = mysql_fetch_array($rs)) { 
										$status = $row['status'];
										$wz_status_ary[$status] += (int)$row["n"];
									 }
									 ?>
									<table width="95%" style="color:black; margin: 10px 30px 0px 30px;" cellspacing="1">
									<?php
									$wz_i = 0;
									 foreach ( $wz_status_ary as $status => $status_n ) {
									?>
										<tr>
											<td style="padding: 4px; margin: 2;" width="30%">
												<a href="?id=<?php echo($_REQUEST["id"]) ?>&join_status=<?php echo($status) ?>" style="font-size: 14px;"><?php echo(ucwords($status)) ?></a>
											</td>
											<td style="padding: 4px; margin: 2;" width="50px">
												<a href="?id=<?php echo($_REQUEST["id"]) ?>&join_status=<?php echo($status) ?>" style="font-size: 14px;"><?php echo($status_n) ?></a>
											</td>
											<td>
												<input type="checkbox" value="<?php echo $status;?>" id="chk_status_<?php echo($wz_i++) ?>" />										
											</td>
										</tr>
									<?php
									 } 
									?>
									</table>
								</td>
							</tr>
						</table>	
						<?php 
						$html = ob_get_contents();
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
                <h2 class="bar green"><span>
					<?php if ( isset($_REQUEST["summary"]) && $_REQUEST["summary"] == "1" ) { 
						echo("Artist Summary");
					} else {
						echo($record['title']);
					} ?>	
				</span>
				</h2> 
				
				<?php if ( !(isset($_REQUEST["summary"]) && $_REQUEST["summary"] == "1") ) { ?>
					<div style="float: right; height: 10px; margin-right: 20px; margin-top: -20px;">
						<a href="?id=<?php echo($_REQUEST['id']) ?>&summary=1" style="color: #ffffff; font-weight: bold;">Artist Summary</a>
					</div>
				<?php } else { ?>
					<div style="float: right; height: 10px; margin-right: 20px; margin-top: -20px;">
						<a href="?id=<?php echo($_REQUEST['id']) ?>" style="color: #ffffff; font-weight: bold;">Artist Manager</a>
					</div>
				<?php } ?>	
                <div style="min-height:500px;">
                    <?  if (isset($_REQUEST['aid']) && $_REQUEST['aid'] != '') { ?>
						<?php $profile_name_url = str_replace(' ','_',$artist_data['profile_name']); ?>
                        <form action=".?id=<?php echo $_REQUEST['id'] ?>&aid=<?=$_REQUEST['aid']?>" onsubmit="return isValid(this);" method="post" enctype="multipart/form-data" > 
						<input type="hidden" id="parent_id" onchange="alert('passed');">
							<p class="buttons">
							<input type="hidden" name="id" value="<?=$id ?>" />
                            <input type="hidden" name="aid" value="<?=$_REQUEST['aid'] ?>" />
                            <input type="hidden" name="is_submit" value="1" />
							<input type="hidden" name="userid" value="<?= $artist_data['user_id'] ?>" />
							<input type="submit" name="update" value="Update" class="button" />
							<input type="button" name="personal" id="per-btn" style="border:1px solid #66CC00; width:100px;" value="Personal Info" class="button" onclick="jQuery('#artist_data').show();jQuery('#calendar').hide(); jQuery(this).css('border', '1px solid #66CC00');jQuery('#cal-btn').css('border', '1px solid #fff');" />
							<?php if(!empty($profile_name_url)){?>
							<input type="button" name="viewprofile" id="cal-btn" value="View Profile" 
							class="button" onclick="window.open('http://www.soundbooka.com.au/version2/user/directLogin/<?php echo $artist_data['id']; ?>?url=profile/view/<?php echo $profile_name_url; ?>','mywindowprofile','menubar=1,resizable=1,width=600,height=600,left=500,top=300,scrollbars=1');"/>
							<?php } ?>
							<input type="button" name="editprofile" id="cal-btn" value="Edit Profile" 
							class="button" onclick="window.open('http://www.soundbooka.com.au/version2/user/directLogin/<?php 
							echo $artist_data['id']; ?>','mywindowedit','menubar=1,resizable=1,width=850,height=600,left=300,top=300,scrollbars=1');"/>
                            
                            
							<input type="button" onclick="javascript:history.back();" value="Back" class="button">
							</p>
							<table id="artist_data"  style="color:black; margin: 30px 30px 0px 30px;" width="94%">
								<tr><th style="text-align:left; padding-top: 20px;  border-bottom: 2px dotted #CCCCCC;" >Personal Info:</th>
								</tr>

								<tr><td>
								<table width="100%">
									
									<tr>
										<td width="23%">First Name<br><input type="text" name="first_name" value="<?= $artist_data['first_name'] ?>" /></td>
										<td width="25%">Last Name<br><input type="text" name="last_name" value="<?= $artist_data['last_name'] ?>" /></td>
										<td width="26%">Gender<br><?php echo $obj->returnDropdown('gender','gender','Gender',$artist_data['gender']);?></td>
									</tr>
									
									<tr>
										<td width="23%">Choose your secret question<br>
										<?php
										$sqlBase = "select bascode1 from xbasetypes where 
										basgroup1 = 'Secret Questions'";
										$resbase = mysql_query($sqlBase);
										?>
										<select name="secretques">
										<?php while ($rowbase = mysql_fetch_array($resbase)) {
										$varSelected = "";
										if ($user_data['secret_question'] == $rowbase['bascode1'])
										{
											$varSelected = "selected";
										}
										?>
									<option value="<?php echo $rowbase['bascode1']; ?>" 
									<?php echo $varSelected; ?>><?php 
									echo $rowbase['bascode1']; ?></option>
										<?php } ?>		
										</select></td>
										<td width="25%">Your secret answer<br><input type="text" 
										name="secretans" value="<?php echo $user_data['secret_answer']; ?>" /></td>
										<td width="26%">DOB<br>
										<select name="dobday">
											<option value="">Day</option>
											<?php
											for($x=1;$x<=31;$x++) :
											$varSelected = "";
											if ($arrDob[2] == str_pad($x,2,'0',STR_PAD_LEFT)) { $varSelected = "selected"; }
											?>
											<option value="<?php echo str_pad($x,2,'0',STR_PAD_LEFT); ?>" <?php echo $varSelected; ?> /><?php echo str_pad($x,2,'0',STR_PAD_LEFT); ?></option>
										<?php	
										endfor;
										?>
										</select>
										&nbsp;
										<select name="dobmonth">
											<option value="">Month</option>
									<?php
										for($x=1;$x<=12;$x++) :
										$varSelected = "";
										if ($arrDob[1] == str_pad($x,2,'0',STR_PAD_LEFT)) { $varSelected = "selected"; }
									?>
									<option value="<?php echo str_pad($x,2,'0',STR_PAD_LEFT); ?>" <?php echo $varSelected; ?>>
									<?php echo date('F',strtotime("2011-".str_pad($x,2,'0',STR_PAD_LEFT)."-01")); ?></option>
									<?php
										endfor; 
									?>
										</select>
										&nbsp;
										<select name="dobyear">
											<option value="">Year</option>
											<? 					
								for($x=2011;$x>=1950;$x--) : 
								$varSelected = "";
								if ($arrDob[0] == $x) { $varSelected = "selected"; }
								?>
									<option value="<?php echo $x; ?>" <?php echo $varSelected; ?>><?php echo $x; ?></option>
								<?php	
								endfor; 
                                ?>
										</select>
										&nbsp;
										</td>
									</tr>
									
								<tr>
									<td width="23%">Email<br><input type="text" style="width:200px;"  maxlength="20" 
									name="usremail" readonly value="<?php echo $user_data['email']; ?>"></td>
									<td width="23%">Password<br><input type="password"  maxlength="20" name="password1"></td>
									<td width="25%">Confirm Password<br><input type="password"  maxlength="20" name="password2"></td>	
								</tr>
								
								</table>
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
						
						<h2><a style="text-decoration:underline;" onClick="window.open('tpl/edit_calendar.php?aid=<?php echo $aid; ?>','mywindow','menubar=1,resizable=1,width=450,height=450,left=500,top=300');"> ADD NEW EVENTS</a></h2>

						
						<table style="margin:5px 0px;"><tr>
							<th><?=date('F',mktime(0,0,0,$month,1,$year)).' '.$year;?></th>
							<td><?=$controls;?></td>
						<?php
						//echo '<h2 style="float:left; padding-right:30px;">'.date('F',mktime(0,0,0,$month,1,$year)).' '.$year.'</h2>';
						//echo '<div style="float:left; margin-bottom:10px;">'.$controls.'</div>';
						//echo '<div style="clear:both;"></div>';
						echo draw_calendar($month,$year,$events);
						?></div>
						</form>
                    <? }
					// 1.24.12; wiseobject <-
					else if ( $_REQUEST["summary"] == "1" ) { 
						echo($obj->showSummary());
					} else { 
					 echo $obj->show_form(); }
					?>
					</div>
					  </div>

            </div> 
            <?php require ("tpl/inc/footer.php"); ?> 
        </div> 
    </div> 
					
              

    <script type="text/javascript">
    	$(function() {	
	$('#btn_test').click(function() {
		if(confirm('Are you sure to delete all test data')){
		url = '<?php echo $cfg['website_url']; ?>/ajax/deletetest';
		$.get(url, function(data) {
		alert('Test Data Deleted !!');
		window.location.href = window.location.href;
		});
		}
	});
	});
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
			$('.st'+Id).remove(); 
			$('tr#'+Id).append('<td style="float:right;position:absolute;margin-left:-100px;" class="st'+Id+'">Loading...</td>');
			$('.st'+Id).show(); 
			//alert('<?php echo $cfg['website_url']; ?>artist/updateArtistStatus/');
			$.post("<?php echo $cfg['website_url']; ?>artist/updateArtistStatus/",{aAtatus :status, AId:Id},function(data){
				
				$('.st'+Id).text('updated').delay(5000).fadeOut();
			});
		
		}
		function isValid(obj){
			if(obj.password1.value != obj.password2.value){
				alert('The password and confirm password are not matching. Please try again.');
				return false;
			}
			var patten = /^[a-zA-Z0-9]+$/;
			if(!patten.test(obj.password1.value) && obj.password1.value != ''){
				alert('Invalid password. Please enter only alphanumeric characters.');
				return false;
			}
			return true;
		}
		function showArtist(id){
			jQuery('#type').val(id);
			jQuery('#search').submit();	
		}
    </script>
	<?php /*if (!empty($_REQUEST['year'])) { ?>						  
<script type="text/javascript">	
     $(function(){					  
	$('#calendar').show();
     $('#cal-btn').click();
	
	});
</script>	
<?php } */?>
	
</body>
</html>

