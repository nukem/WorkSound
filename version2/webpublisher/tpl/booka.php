<?php require ("tpl/inc/head.php"); ?>
<body> 
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

<?php
$bid = $_REQUEST['bid'];
$obj=new submit();
if(isset($_POST['update'])){
	$bid = $_REQUEST['bid'];
	$dob=$_POST['dobyear'].'-'.$_POST['dobmonth'].'-'.$_POST['dobday'];
	$que = mysql_real_escape_string($_POST['secret_question']);
	 $sql ="UPDATE `booka` b, user u SET 
        b.`firstname` = '{$_POST['firstname']}',
        u.`secret_question` = '{$que}',
        u.`secret_answer` = '{$_POST['secret_answer']}',
        u.`dob` = '{$dob}',
        u.`is_admin` = '{$_POST['is_admin']}',
		b.`lastname` = '{$_POST['lastname']}'";
		
	 if($_POST['password1']!=='' && $_POST['password1']==$_POST['password2']) $sql.=", u.password='{$_POST['password1']}'";
		
	$sql.="	WHERE b.user_id = u.id && u.`id` ={$bid}";
	dbq($sql);
}


if(!isset($_GET['bid'])){
 //print_r($_REQUEST);
	     $query="SELECT * FROM booka b, user u where b.user_id=u.id ";	
		if($_REQUEST['name']!='') $query.=" && (b.firstname LIKE '%{$_REQUEST['name']}%' || b.lastname LIKE '%{$_REQUEST['name']}%' )";
		if($_REQUEST['email']!='') $query.=" && u.email LIKE '%{$_REQUEST['email']}%'";
		if($_REQUEST['phone']!='') $query.=" && b.primary_phone LIKE '%{$_REQUEST['phone']}%'";
		if(isset($_REQUEST['type']) && $_REQUEST['type']){  $query.=" && b.booka_type = '{$_REQUEST['type']}'";}			
        if($_REQUEST['join_status']){  $query.=" && b.status = '{$_REQUEST['join_status']}'"; }
           // echo $query;
            $bookas = dbq ($query);	
	     $query="SELECT booka_type, COUNT(booka_type) AS count, (SELECT COUNT(*) FROM booka) AS total_count FROM booka GROUP BY booka_type";
	    $booka_type = dbq ($query);
    }
	 
?>
	<div id="right-col"> 
         <h2 class="bar green"><span>
					<?php if ( isset($_REQUEST["summary"]) && $_REQUEST["summary"] == "1" ) { 
						echo("Booka Summary");
					} else {
						echo($record['title']);
					} ?>	
				</span>
				</h2> 
                	<?php if ( !(isset($_REQUEST["summary"]) && $_REQUEST["summary"] == "1") ) { ?>
					<div style="float: right; height: 10px; margin-right: 20px; margin-top: -20px;">
						<a href="?id=<?php echo($_REQUEST['id']) ?>&summary=1" style="color: #ffffff; font-weight: bold;">Booka Summary</a>
					</div>
				<?php } else { ?>
					<div style="float: right; height: 10px; margin-right: 20px; margin-top: -20px;">
						<a href="?id=<?php echo($_REQUEST['id']) ?>" style="color: #ffffff; font-weight: bold;">Booka Manager</a>
					</div>
				<?php } ?>
    <?php    
    if(!isset($_GET['bid']) && !isset($_REQUEST['summary'])) { 
    ?>
		    
		<div style="min-height:500px;">
	<form action=".?id=<?php echo $_REQUEST['id'] ?>" method="post" enctype="multipart/form-data" id="search">        
	<table width="95%" style="color:black; margin: 30px 30px 0px 30px">
	
		<tr id="">
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
				<strong>Booka Type</strong><br />
				<select name="type" id='type'>
					<option value="">Booka Type</option>
					<option value="commerical" <?php if($_POST['type']=='commerical') echo 'selected="selected"'; ?>>Commercial</option>
					<option value="private" <?php if($_POST['type']=='private') echo 'selected="selected"'; ?>>Private</option>
				</select>
			</td>
			<td width="18%">
			<strong>Status</strong><br/>
			<select name="join_status">
				<option value="" <?php if(''==$_POST['join_status']) echo 'selected="selected"';  ?>>Select Status</option>
				<option value="new" <?php if('new'==$_POST['join_status']) echo 'selected="selected"';  ?>>New</option>
				<option value="approved" <?php if('approved'==$_POST['join_status']) echo 'selected="selected"';  ?>>Approved</option>
				<option value="reject" <?php if('reject'==$_POST['join_status']) echo 'selected="selected"';  ?>>Reject</option> 
            </select>					
			</td>
			<td width="6%"><input type="submit" name="search" value="Search" class="button" /></td>
		</tr>
        </form>
            <tr >
                <td width="18%" colspan="6" style='margin:right;'>
                <?php 
                    $emailSubmit  = new submit();
                    $emailSubmit->showEmailTemplate(); ?>
                </td>
                </tr>
            <tr>
                                <td colspan="6" style="padding: 10px 0px 10px 0px">
                                    <ul class="artist_type">                                    
                                            <?php                                            
                                              $commercial = 0;
                                              $private = 0;
                                            foreach($booka_type as $k=>$row) {  
                                            !$k and print "<li><a href='javascript:showArtist(\"\")'>All ({$row[total_count]})</a></li>";  if($row['booka_type'] == '') continue; 
                                            ?>
                                            <li><a href="javascript:showArtist('<?=$row['booka_type']?>')"><? echo $row['booka_type']," (",$row['count'],")";?></li>                 
                                            <?php  if("commerical"==$row['booka_type']) {
                                                        $commercial = 1;
                                                    }                                                     
                                                   if("private"==$row['booka_type']) { 
                                                   
                                                        $private =1;
                                                   }
                                                   } ?>
                                              <?php                                            
                                                if($commercial==0){ ?>
                                       <li>  <a href="javascript:showArtist('commerical')">commerical(0)</a> </li>         
                                             <?php   }
                                                if($private==0){ ?>
                                                <li>    <a href="javascript:showArtist('private')">private(0)</a> </li>
                                                <?php } ?>
                                       
                                        
                                            
                                           
									</ul>
                                    </td>                                        
		 </tr>
		<tr>
			<td colspan="6" style="padding: 10px 0px 10px 0px">&nbsp;</td>                                        
		 </tr>
		<?php
		foreach($bookas as $booka){
                $val = strftime("%d-%m-%Y", strtotime($booka['created'])) ;
			$new=$app=$rej='';
			if($booka['status']=='new') $new='selected="selected"';
			if($booka['status']=='approved') $app='selected="selected"';
			if($booka['status']=='reject') $rej='selected="selected"';
			echo '<tr height=20 id="'.$booka['id'].'"><td><a href=".?id='.$_REQUEST['id'].'&bid='.$booka['id'].'">'.$booka['firstname'].' '.$booka['lastname'].'</a></td>
				<td><a href="mailto:'.$booka['email'].'">'.$booka['email'].'</a></td>
				<td>'.$booka['primary_phone'].'</td>
				<td>'.$booka['booka_type'].'</td>
				<td><select class="update" rel="'.$booka['id'].'">
					<option value="">Change status</option>
					<option value="new" '.$new.'>New</option>
					<option value="approved" '.$app.'>Approved</option>
					<option value="reject" '.$rej.'>Reject</option>
				</select></td>';
                echo '<td width="22%" style="float:left;">
                    <input type="checkbox" value="'.$booka['id'].'" id="chk_{($wz_i++)}" />
                '.$val.' 
                </td>   ';
			echo '</tr>';
		}
		?>
	</table>
</form>
</div>
<?php }else if($_REQUEST["summary"] == "1" ) { 
						echo($obj->showSummary());
}else {
	//$query="SELECT * FROM booka b, user u where b.user_id=u.id && u.id='{$_REQUEST['bid']}'";
	$query="SELECT u.*,b.* FROM booka b, user u where b.user_id=u.id && u.id='{$_REQUEST['bid']}'";
	$booka_data=dbq($query);
	$booka_data=$booka_data[0];
	
?></div>
<div id="right-col"> 
                
                <div style="min-height:500px;">
                    <?php $business_name_url = str_replace(' ','_',$booka_data['business_name']); ?>
                        <form action=".?id=<?php echo $_REQUEST['id'] ?>&bid=<?=$_REQUEST['bid']?>" onsubmit="return isValid(this);" method="post" enctype="multipart/form-data" > 
						<input type="hidden" id="parent_id" onchange="alert('passed');">
							<p class="buttons">
                            <input type="hidden" name="id" value="<?=$id ?>" />
                            <input type="hidden" name="bid" value="<?=$_REQUEST['bid'] ?>" />
                            <input type="hidden" name="is_submit" value="1" />
							<input type="hidden" name="userid" value="<?= $booka_data['user_id'] ?>" />
                            
							<input type="submit" name="update" value="Update" class="button" />
                            
                            	<input type="button" name="personal" id="per-btn" style="border:1px solid #66CC00; width:100px;" value="Personal Info" class="button" onclick="jQuery('#booka_data').show();jQuery('#calendar').hide(); jQuery(this).css('border', '1px solid #66CC00');jQuery('#cal-btn').css('border', '1px solid #fff');" />
                                
							<input type="button" name="calender" id="cal-btn" value="Calendar" class="button" onclick="jQuery('#booka_data').hide();jQuery('#calendar').show(); jQuery(this).css('border', '1px solid #66CC00');jQuery('#per-btn').css('border', '1px solid #fff');"/>
                            
							<input type="button" name="viewprofile" id="cal-btn" value="View Profile" 
							class="button" onclick="window.open('http://www.soundbooka.com.au/version2/user/directLogin/<?php echo $_REQUEST['bid']; ?>/1?url=booka/manage_gig/<?php echo $booka_data['id']; ?>','mywindow','menubar=1,resizable=1,width=600,height=600,left=500,top=300,scrollbars=1');"/> 
								
							<input type="button" name="editprofile" id="cal-btn" value="Edit Profile" 
							class="button" onclick="window.open('http://www.soundbooka.com.au/version2/user/directLogin/<?php echo $_REQUEST['bid']; ?>/1','mywindowedit','menubar=1,resizable=1,width=850,height=600,left=300,top=300,scrollbars=1');"/>
	 
                            
							<input type="button" onclick="javascript:history.back();" value="Back" class="button">
                            
							</p>
							<table id="booka_data"  style="color:black; margin: 30px 30px 0px 30px;" width="94%">
								<tr><th style="text-align:left; padding-top: 20px;  border-bottom: 2px dotted #CCCCCC;" >Personal Info:</th>
								</tr>

								<tr><td>
								<table width="100%">
									
									<tr>
										<td width="23%">First Name<br><input type="text" name="firstname" value="<?= $booka_data['firstname'] ?>" /></td>
										<td width="25%">Last Name<br><input type="text" name="lastname" value="<?= $booka_data['lastname'] ?>" /></td>
									</tr>
									
									<tr>
										<td width="23%">Choose your secret question<br>
										<?php
										$arrDob=explode('-',$booka_data['dob']);
										$sqlBase = "select bascode1 from xbasetypes where 
										basgroup1 = 'Secret Questions'";
										$resbase = mysql_query($sqlBase);
										?>
										<select name="secret_question">
										<?php while ($rowbase = mysql_fetch_array($resbase)) {
										$varSelected = "";
										if ($booka_data['secret_question'] == $rowbase['bascode1'])
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
										name="secret_answer" value="<?php echo $booka_data['secret_answer']; ?>" /></td>
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
									name="usremail" readonly value="<?php echo $booka_data['email']; ?>"></td>
									<td width="23%">Password<br><input type="password"  maxlength="20" name="password1"></td>
									<td width="25%">Confirm Password<br><input type="password"  maxlength="20" name="password2"></td>	
								</tr>
								<!-- beecart francis 3/12/2012 -->
								<tr>
									<td><br />
										<input type="hidden" name="is_admin" value="0" />
										<input type="checkbox" name="is_admin" id="is_admin" value="1" <?php echo (empty($booka_data['is_admin']))?'':'checked="checked"';?>/>
										<label for="is_admin" style="font-weight:normal;color:#000;font-size:100%;">Set Administrator Flag</label>
									</td>
								</tr>
								<!--  beecar francis 3/12/2012 -->
								</table>
								</td></tr>	
                            </table>
					
        </div> 
    </div> 


<?php }


//submit class
class submit {
					
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
                    
                    				
	     function showSummary() {
						 ob_start();		
						 ?>
						<?php $this->showEmailTemplate(true); ?>
						<table width="95%" style="color:black; margin: 30px 30px 0px 30px">
							<tr id="">
								<td valign="top" width="95%">
									<div style="margin-left: 30px; font-size: 14px; font-weight: bold;">Booka Types</div>
									<table width="95%" style="color:black; margin: 10px 30px 0px 30px;" cellspacing="1">
									<?php		
									  $sql = "SELECT  (t.`booka_type`),COUNT(*) n 
											FROM booka t												
											WHERE   t.`booka_type` !='' ";
											 
									 $rs = mysql_query($sql);
									 $wz_i = 0;
									 while ($row = mysql_fetch_array($rs)) {
                                    
									?>
										<tr>
											<td style="padding: 4px; margin: 2;" width="30%">
												<a href="?id=<?php echo($_REQUEST["id"]) ?>&type=<?php echo(ucwords($row['booka_type'])) ?>" style="font-size: 14px;"><?php echo(ucwords($row['booka_type'])) ?></a>
											</td>
											<td style="padding: 4px; margin: 2;" width="50px">
												<a href="?id=<?php echo($_REQUEST["id"]) ?>&type=<?php echo(ucwords($row['booka_type'])) ?>" style="font-size: 14px;"><?php echo($row['n']) ?></a>
											</td>
											<td>
												<input type="checkbox" value="<?php echo $row["id"];?>" id="chk_type_<?php echo($wz_i++) ?>" />										
											</td>
										</tr>
									<?php
                                   // print_r($row);
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
									
								  	$sql = "SELECT t.`status`,COUNT(*) n 
											FROM booka t												
											WHERE t.`status` != '' 	
											GROUP BY t.`status`
											ORDER BY t.`status`";
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
                    }
?>

</div> 
</div> 
	<?php require ("tpl/inc/footer.php"); ?> 
<script>
$(function(){
	$('.update').change(function(){
		$val=$(this).val();
		$rel=$(this).attr('rel');
		$tr=$(this).parents('tr').attr('id');
		$('#'+$tr).append('<td style="float:right;position:absolute;margin-left:-45px;" class="ch">Loading...</td>');
		$.post("<?php echo $cfg['website_url']; ?>/booka/updateBookaStatus/",{'bStatus':$val, 'bId':$rel},function(data){
			$('#'+$tr).find('.ch').text('updated').delay(5000).fadeOut();;
		});
		
	});
});
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
<style>
    #artist_data tr td {padding: 10px;}
	#tbl_availability tr td{ padding: 5px;}
	.form_row label{ display:block;}
	.form_row div{ float:left; margin:0 10px 10px 0;}
</style>

</body>
</html>