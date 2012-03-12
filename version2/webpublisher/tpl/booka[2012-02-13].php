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
if(isset($_POST['update'])){
	$bid = $_REQUEST['bid'];
	$dob=$_POST['dobyear'].'-'.$_POST['dobmonth'].'-'.$_POST['dobday'];
	 $sql ="UPDATE `booka` b, user u SET 
        b.`firstname` = '{$_POST['firstname']}',
        u.`secret_question` = '{$_POST['secret_question']}',
        u.`secret_answer` = '{$_POST['secret_answer']}',
        u.`dob` = '{$dob}',
		b.`lastname` = '{$_POST['lastname']}'";
		
	 if($_POST['password1']!=='' && $_POST['password1']==$_POST['password2']) $sql.=", u.password='{$_POST['password1']}'";
		
	$sql.="	WHERE b.user_id = u.id && u.`id` ={$bid}";
	dbq($sql);
}


if(!isset($_GET['bid'])){
	$query="SELECT * FROM booka b, user u where b.user_id=u.id && b.booka_type!=''";
	if(isset($_POST['search'])){
		if($_POST['name']!='') $query.=" && (b.firstname LIKE '%{$_POST['name']}%' || b.lastname LIKE '%{$_POST['name']}%' )";
		if($_POST['email']!='') $query.=" && u.email LIKE '%{$_POST['email']}%'";
		if($_POST['phone']!='') $query.=" && b.primary_phone LIKE '%{$_POST['phone']}%'";
		if($_POST['type']!='') $query.=" && b.booka_type = '{$_POST['type']}'";
		if($_POST['join_status']!='') $query.=" && b.status = '{$_POST['join_status']}'";
	}
	
	$bookas = dbq ($query);
	
	$query="SELECT booka_type, COUNT(booka_type) AS count, (SELECT COUNT(*) FROM booka) AS total_count FROM booka GROUP BY booka_type";
	$booka_type = dbq ($query);
	
?>
	<div id="right-col"> 
		<h2 class="bar green"><span><?php echo $record['title'] ?></span></h2> 
		<div style="min-height:500px;">
	<form action=".?id=<?php echo $_REQUEST['id'] ?>" method="post" enctype="multipart/form-data" > 
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
				<select name="type">
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
				<option value="reject" <?php if('reject'==$_POST['join_status']) echo 'selected="selected"';  ?>>Reject</option> </select>
					
			</td>
			<td width="6%"><input type="submit" name="search" value="Search" class="button" /></td>
		</tr>
		<tr>
			<td colspan="6" style="padding: 10px 0px 10px 0px"><ul class="artist_type">
									<? foreach($booka_type as $k=>$row) {  !$k and print "<li><a href='javascript:showArtist(\"\")'>All ({$row[total_count]})</a></li>";  if($row['booka_type'] == '') continue; ?>
										<li><a href="javascript:showArtist('<?=$row['booka_type']?>')"><? echo $row['booka_type']," (",$row['count'],")";?></li>
									<?php }?>
									</ul></td>                                        
		 </tr>
		<tr>
			<td colspan="6" style="padding: 10px 0px 10px 0px">&nbsp;</td>                                        
		 </tr>
		<?php
		foreach($bookas as $booka){
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
				</select></td>
			</tr>';
		}
		?>
	</table>
</form>
</div>
</div>
<?php }
else {
	$query="SELECT * FROM booka b, user u where b.user_id=u.id && u.id='{$_REQUEST['bid']}'";
	$booka_data=dbq($query);
	$booka_data=$booka_data[0];
	
?>
<div id="right-col"> 
                <h2 class="bar green"><span><?php echo $record['title'] ?></span></h2> 
                <div style="min-height:500px;">

                        <form action=".?id=<?php echo $_REQUEST['id'] ?>&bid=<?=$_REQUEST['bid']?>" onsubmit="return isValid(this);" method="post" enctype="multipart/form-data" > 
						<input type="hidden" id="parent_id" onchange="alert('passed');">
							<p class="buttons">
							<input type="submit" name="update" value="Update" class="button" />
							</p>
							<table id="artist_data"  style="color:black; margin: 30px 30px 0px 30px;" width="94%">
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
								
								</table>
								</td></tr>	
                            </table>
					
        </div> 
    </div> 


<?php }
?>
	<?php require ("tpl/inc/footer.php"); ?> 
</div> 
</div> 
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
</script>
<style>
    #artist_data tr td {padding: 10px;}
	#tbl_availability tr td{ padding: 5px;}
	.form_row label{ display:block;}
	.form_row div{ float:left; margin:0 10px 10px 0;}
</style>

</body>
</html>