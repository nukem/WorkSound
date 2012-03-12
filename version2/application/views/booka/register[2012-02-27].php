
			<div class="info_box">
			<div class="info_box_inside">
				<div class="box_title">Register as a Booker on Soundbooka</div>
				<div class="box_cont">
					<p>Hi! Create your Soundbooka Account so you can book your favourite Soundbooka artists!  <br />
						Please fill out the registration form below – it's FREE and simple to complete.  <br />
						Have you previously joined Soundbooka and wish to make changes to your Profile?
						<a href="javascript: void(0);"  onclick="$('#login_box').slideToggle();$('#login').slideDown();$('#forgot').slideUp(); " >Sign in here</a>
					</p>
				</div>
			</div>
			</div><!--end of info_box-->
			
			<form action="" method="post" class="uniform">
			<fieldset>
				<?php /*?><div class="form_title">Account Type</div>
				<div class="form_block">
					<div class="form_row">
						<div class="simu_select1">
                        <?=form_dropdown('type', $types, set_value('type',@$type), 'id=type')?>
						</div>
					</div>
				</div><?php */?><!--end of form_block-->
				
				<div class="form_title">Choose your User ID and Password. 
				<strong class="bubble_info">
						<strong class="popup"><b>arrow</b><em>Soundbooka does not sell your personal information to third parties. Please read our <a href="javascript:void(0)" onclick="showPrivacy()">Privacy Policy</a> for more information</em></strong>
	<img src="<?=base_url()?>images/question_mark_icon.png" style = "width:15px;height:15px;" alt="" class="img_ask" />
					</strong>
					</div>
				<div class="form_block">
					<p>This will allow you to Login as a registered User</p>
					<div class="form_row">
						<div class="form_item">
							<label>Email Address <span>*</span></label>
							<input name="email" type="text" class="input1" id="email" value="<?php echo set_value('email'); ?>" />
							<em>This will be your Soundbooka User ID</em>
						</div>
						
						<div class="form_item">
							<label>Re-enter your Email Address <span>*</span></label>
							<input name="email_confirm" type="text" class="input1" id="email_confirm" value="<?php echo set_value('email_confirm'); ?>" />
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
					
					<div class="form_row">
						<div class="form_item">
							<label>Create your Password <span>*</span> <strong class="bubble_info">
						<strong class="popup"><b>arrow</b><em>Your password is case sensitive and must be between 6 and 10 characters in length.</em></strong>
	<img src="<?=base_url()?>images/question_mark_icon.png" style = "width:15px;height:15px;" alt="" class="img_ask" />
					</strong>
					</label>
							<input name="password" type="password" class="input1" id="password" value="<?php echo set_value('password'); ?>" />
							
						</div>
						
						<div class="form_item">
							<label>Re-enter Password <span>*</span></label>
							<input name="password_confirm" type="password" class="input1" id="password_confirm" value="<?php echo set_value('password_confirm'); ?>" />
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
					
					<div class="form_row">
						<div class="form_item">
							<label>Choose your secret question <span>*</span></label>
                            <div class="simu_select1">
                                <?=form_dropdown('secret_question', $questions, set_value('secret_question',@$secret_question), 'id=secret_question')?>
							</div>
						  <em>This will allow Soundbooka to confirm your identity <br />should you forget your password.</em>
						</div>
						
						<div class="form_item">
							<label>Your secret answer <span>*</span></label>
							<input name="secret_answer" type="text" class="input1" id="secret_answer" value="<?php echo set_value('secret_answer'); ?>" />
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
					
					<div class="form_row">
						<div class="form_item">
							<label>Date of Birth <span>*</span></label>
							<div class="simu_select2">
                            	<? 
								$days = array(''=>'Day');
								for($x=1;$x<=31;$x++) :
									$days[str_pad($x,2,'0',STR_PAD_LEFT)] = str_pad($x,2,'0',STR_PAD_LEFT);
								endfor; 
                                ?>
                                <?=form_dropdown('dob_day', $days, set_value('dob_day'), 'id=dob_day')?>
							</div>
							
							<div class="simu_select3">
								<? 
								$months = array(''=>'Month');
								for($x=1;$x<=12;$x++) :
									$months[str_pad($x,2,'0',STR_PAD_LEFT)] = date('F',strtotime("2011-".str_pad($x,2,'0',STR_PAD_LEFT)."-01"));
								endfor; 
                                ?>
                                <?=form_dropdown('dob_month', $months, set_value('dob_month'), 'id=dob_month')?>
							</div>
							
							<div class="simu_select4">
								<? 
								$years = array(''=>'Year');
								for($x=2011;$x>=1950;$x--) :
									$years[$x] = $x;
								endfor; 
                                ?>
                                <?=form_dropdown('dob_year', $years, set_value('dob_year'), 'id=dob_year')?>
							</div>
							<em>You must be at least 18 years old to register <br/>as an Artist on Soundbooka.</em>
							
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
				</div><!--end of form_block-->
				
				<div class="shadow_line">line</div>
				
				<div class="form_title">Soundbooka <a href="javascript:void(0)" onclick="showAgreement()">User Agreement</a> and <a href="javascript:void(0)" onclick="showPrivacy()">Privacy Policy</a></div>
				
				<div class="form_block">
					
					<div class="form_row">
						<label>I agree that:</label>
						<div class="option">
							<label>
								<input name="agree" type="checkbox" id="agree" value="1" />
								<strong>I accept the User Agreement and Privacy Policy <span>*</span></strong>
							</label>
						</div>
						<div class="option">
							<label>
								<input name="age" type="checkbox" id="age" value="1" />
								<strong>I am at least 18 years old <span>*</span></strong>
							</label>
						</div>
						<div class="option">
							<label>
								<input name="newsletter" type="checkbox" id="newsletter" value="1" checked />
								<strong>I would like to receive the Soundbooka newsletter</strong>
							</label>
						</div>
					</div><!--end of form_row-->
				</div><!--end of form_block-->
				
				<div class="shadow_line">line</div>
				
				<input type="submit" value="Register Now" class="input_register" />
			</fieldset>
			</form>
			
			<br class="cl" />
<div id="agreement" title="User Agreement" style="display:none">
    <div class="scroll_box" style="height:365px" id="agreement_content">
        
    </div>
</div>

<div id="privacy" title="Privacy Policy" style="display:none">
    <div class="scroll_box" style="height:365px" id="privacy_content">
        
    </div>
</div>
                        
                        
<script>
$(function() {

	$( "#agreement" ).dialog({
		height: 500,
		width: 600,
		modal: true,
		autoOpen: false,
		buttons: {
			Close: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	$( "#privacy" ).dialog({
		height: 500,
		width: 600,
		modal: true,
		autoOpen: false,
		buttons: {
			Close: function() {
				$( this ).dialog( "close" );
			}
		}
	});
});

function showAgreement() {
	$('#agreement_content').load(BASE_URL + 'home/user_agreement/true', function() {
	  $('#agreement').dialog('open');
	});

}

function showPrivacy() {
	$('#privacy_content').load(BASE_URL + 'home/privacy/true', function() {
	  $('#privacy').dialog('open');
	});	
}

</script>