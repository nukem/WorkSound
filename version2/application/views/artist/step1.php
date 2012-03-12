<?php
$test = $this->session->userdata('is_loged');
$test_id = $this->session->userdata('artist_id');
$ids = $this->session->userdata('artists');
$uri_test = $this->uri->segment(3);
if($test  == '1' && !empty($test)){?>
<h1>Edit your profile</h1>
			
<?php } else{
$this->session->set_userdata('is_loged', false);
$this->session->set_userdata('artist', null);
$test_id = '';
?>
<h1>Join as an Artist</h1>
		
<?php } ?>		
			<div class="<?php if($uri_test != $test_id ) echo 'step';else echo 'editstep';?> step1">step</div>
			<br />

			<form action="" method="post" class="uniform">
			<fieldset>

				<table width="100%"><tr width="100%">
					<td width="50%"><h2>ABOUT YOU</h2></td>
					<td width="50%" align="right"><div align=right class="form_title" ><span>*</span> This indicates a mandatory field</div></td>
				</tr></table>
				<h2>STEP 1 OF 6 </h2>
				<?php if($uri_test != $test_id ){?>
				<div class="form_title">Hi! Ready to join as an Artist on Soundbooka?</div>
				<?php } ?>
				<div class="form_block">
					<div class="form_intro">
						<p>We require a few details so your Soundbooka Profile Page can be created and you can start being booked for gigs. 
	</p><p>	Registration is <strong>FREE</strong> and easy to complete.
					<strong class="bubble_info" >
						<strong class="popup" style="width:247px"><b>arrow</b><em style="width:219px">Soundbooka is a quality-controlled site. Soundbooka reserves the right to deny registration to applicants who do not meet our minimum performance standard</em></strong>
	<img src="<?=base_url()?>images/question_mark_icon.png" style = "width:15px;height:15px;" alt="" class="img_ask" />
					</strong>
	</p>						
					</div>

					<div class="form_row">
						<div class="form_item">
							<label>First Name <span>*</span></label>
							<input name="first_name" type="text" class="input1" id="first_name" value="<?php echo set_value('first_name', @$first_name); ?>"/>
						</div>
						
						<div class="form_item">
							<label>Last Name <span>*</span></label>
							<input name="last_name" type="text" class="input1" id="last_name" value="<?php echo set_value('last_name', @$last_name); ?>"/>
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
					
					<div class="form_row">
						<div class="form_item">
							<label>Gender <span>*</span></label>
							<div class="simu_select1">
								<?=form_dropdown('gender', $genders, set_value('gender',@$gender), 'id=gender')?>
							</div>
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
					
					<div class="form_row">
						<div class="form_item">
							<label>Street Address <span>*</span></label>
							<input name="address" type="text" class="input1" id="address" value="<?php echo set_value('address', @$address); ?>"/>
						</div>
						
						<div class="form_item">
							<label>Town/Suburb <span>*</span></label>
							<input name="suburb" type="text" class="input1" id="suburb" value="<?php echo set_value('suburb', @$suburb); ?>"/>
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
					
					
					<div class="form_row">
                    	<div class="form_item">
							<label>Country / Region <span>*</span></label>
							<div class="simu_select1">
                                <?=form_dropdown('country', $countries, set_value('country',@$country), 'id=country')?>
							</div>
						</div>
                    
						<div class="form_item">
							<label>State/Territory <span>*</span></label>
							<div class="simu_select5">
                                <?=form_dropdown('state', $states, set_value('state',@$state), 'id=state')?>
							</div>
						</div>
						
						
						
						<div class="form_item">
							<label>Postcode <span>*</span></label>
							<input  name="postcode" type="text" class="input2" id="postcode" value="<?php echo set_value('postcode',@$postcode); ?>"/>
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
					
					<div class="form_row">
						
						<div class="form_item">
							<label>Primary Phone Number (Mobile) <span>*</span><strong class="bubble_info">
		<img src="<?=base_url()?>images/question_mark_icon.png" style = "width:15px;height:15px;"
								alt="" class="img_ask" />
						<strong class="popup"><b>arrow</b><em>We require your mobile telephone number so you can be informed of
your bookings via SMS.</em></strong>
					</strong></label>
							<input name="phone_code" type="hidden" class="input3" id="phone_code" value="<?php echo set_value('phone_code',@$phone_code); ?>"/>
							<input name="phone_number" type="text" class="input4" id="phone_number" value="<?php echo set_value('phone_number',@$phone_number); ?>"/>
						</div>
						
						<div class="form_item">
							<label>Alternative Phone Number</label>
							<input name="phone_alternate" type="text" class="input5" id="phone_alternate" value="<?php echo set_value('phone_alternate',@$phone_alternate); ?>"/>
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
				</div><!--end of form_block-->
				
				
								
				<input type="submit" value="Save &amp; Continue" class="input_continue" />
				
				<br class="cl" />

			</fieldset>
			</form>
			
			<br class="cl" />
<script>
$(function() {

	
	$('#country').change(function() {
		$.ajax({
		  type: "GET",
		  url: "<?=base_url()?>ajax/getStateOptions/"+$(this).val(),
		  async: false
		}).done(function( msg ) {
		  $('#state').html(msg);
		  $.uniform.update('#state');
		});
	});
});

</script>	