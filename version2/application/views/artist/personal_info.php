<?php
$test = $this->session->userdata('is_loged');
$test_id = $this->session->userdata('artist_id');
$ids = $this->session->userdata('artists');
$uri_test = $this->uri->segment(3);
#echo '<pre style="display:none;">';print_r($this->session->userdata);echo '</pre>';
if($test  == '1' && !empty($test)){?>
<div style="width:100%;"><div style="float:left; width:50%;"><h1>Personal Info</h1></div><div align=right class="form_title" style="float:right; margin-top:12px; margin-bottom:0px; width:50%;"><span>*</span> This indicates a mandatory field</div>
<br class="cl" />
</div>
	
<?php } else{
$this->session->set_userdata('is_loged', false);
$this->session->set_userdata('artist', null);
$test_id = '';
?>
<div style="width:100%;"><div style="float:left; width:50%;" ><h1>Personal Info</h1></div><div align=right class="form_title" style="float:right; margin-top:12px; margin-bottom:0px; width:50%;"><span>*</span> This indicates a mandatory field</div>
<br class="cl" />
</div>
		
<?php }
	
	foreach($personal as $val){
	//print_r($val);
	$sqlUser = "select * from user where id = '{$val['user_id']}'";
	$user_result = mysql_query($sqlUser);
	$user_data = mysql_fetch_array($user_result);

	$arrDob = explode ("-",$user_data['dob']);
?>		
	<fieldset>
	<form action="" method="post" class="uniform">	
	
	<table width="100%"><tr></td>
		<div class="form_row">
						<div class="form_item">
							<label>First Name <span>*</span></label>
							<input type="text" name="first_name" value="<?= $val['first_name'] ?>" /></div>
						
						<div class="form_item">
							<label>Last Name <span>*</span></label>
							<input type="text" name="last_name" value="<?= $val['last_name'] ?>" /></div>
						<div class="form_item">
							<label>Gender <span></span></label>
							<div class="simu_select3">
							<select id="gender" name="gender">
								
								<option <?php if($val['gender'] == '5') echo 'selected="selected"';?> value="5"> Male</option>
								<option <?php if($val['gender'] == '6') echo 'selected="selected"';?> value="6"> Female</option>
							</select>
							</div>
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
		<div class="form_row">
						<div class="form_item">
							<label>Date of Birth <span>*</span></label>
							<div class="simu_select2">
                            	<? 
								$days = array();
								for($x=1;$x<=31;$x++) :
									$days[str_pad($x,2,'0',STR_PAD_LEFT)] = str_pad($x,2,'0',STR_PAD_LEFT);
								endfor; 
                                ?>
                                <?=form_dropdown('dob_day', $days, $arrDob[2], 'id=dob_day')?>
							</div>
							
							<div class="simu_select3">
								<? 
								$months = array();
								for($x=1;$x<=12;$x++) :
									$months[str_pad($x,2,'0',STR_PAD_LEFT)] = date('F',strtotime("2011-".str_pad($x,2,'0',STR_PAD_LEFT)."-01"));
								endfor; 
                                ?>
                                <?=form_dropdown('dob_month', $months, $arrDob[1], 'id=dob_month')?>
							</div>
							
							<div class="simu_select4">
								<? 
								$years = array();
								for($x=2011;$x>=1950;$x--) :
									$years[$x] = $x;
								endfor; 
                                ?>
                                <?=form_dropdown('dob_year', $years, $arrDob[0], 'id=dob_year')?>
							</div>
						
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
		<?php
		$sqlBase = "select bascode1 from xbasetypes where 
		basgroup1 = 'Secret Questions'";
		$resbase = mysql_query($sqlBase);
		?>
		<div class="form_row">
		<div class="form_item">
			<label>Choose your secret question <span>*</span></label>
			<div class="simu_select1">
				<?=form_dropdown('secret_question', $questions, set_value('secret_question',@$user_data['secret_question']), 'id=secret_question')?>
			</div>
		</div>
		<div class="form_item">
			<label>Your secret answer <span>*</span></label>
			<input name="secret_answer" type="text" class="input1" id="secret_answer" value="<?php echo $user_data['secret_answer']; ?>" />
		</div>
		<br class="cl" />
		</div>

		<div class="form_row">
			<div class="form_item">
			<label>Email<span>*</span></label>
			<input type="text" style="width:200px;"  maxlength="20" name="usremail" readonly value="<?php echo $user_data['email']; ?>">
			</div>
		</div>
		
		<div class="form_row">
			<div class="form_item">
			<label>Password<span></span></label>
			<input type="password"  maxlength="20" name="password1">
			</div>
			<div class="form_item">
			<label>Confirm Password<span></span></label>
			<input type="password"  maxlength="20" name="password2">
			</div>
			<br class="cl" />
		</div><!--end of form_row-->
		<?php } ?>
		<br class="cl" />
		<input class="input_continue" type="submit" name="save" value="save" style="background-image:none;width: 120px !important;float:left;">
		
		
	</td></tr>
	</table></form>
	</fieldset>
	