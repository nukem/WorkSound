<?php
$test = $this->session->userdata('is_loged');
$test_id = $this->session->userdata('artist_id');
$ids = $this->session->userdata('artists');
$uri_test = $this->uri->segment(3);
if($test  == '1' && !empty($test) && in_array($uri_test,$ids)){?>
<h1  style="width: 200px; float:left;">Edit your profile</h1>
			
<?php } else{
$this->session->set_userdata('is_loged', false);
$this->session->set_userdata('artist', null);
$test_id = '';
?>
<h1 style="width: 200px; float:left;">Join as a Booker</h1>
<?php } ?>
<div align=right class="form_title" style="width: 400px; float:right;"><span style="color:#FF5C32">*</span> This indicates a mandatory field</div>	
	<div style="clear:both;"></div>
			<!--<div class="<?php if($uri_test != $test_id ) echo 'step';else echo 'editstep';?> step1">step</div>-->
			<br />

			<form action="" method="post" class="uniform">
			<fieldset>
				<table width="100%"><tr width="100%">
					<td width="50%"><h2>ABOUT YOU</h2></td>
					<!--<td width="50%" align="right"></td>-->
				</tr></table>				 
				 
				<div class="form_title">Hi! Ready to join as a Booker on Soundbooka?<br /> 
				Please select whether you are a commercial booker with an ABN or a private booker.
				</div>
				 
 
				<div class="options">
					<label>
						<input name="booka_type" id="booka_type1" type="radio" value="1"  checked="checked" onClick="$('#commerical').show();$('#commerical2').show();"/>
						<strong>Commercial</strong>
				  </label>
					
					<label>
						<input name="booka_type" id="booka_type2" type="radio" value="0" <?php if(set_value('booka_type', @$booka_type)==0) echo 'checked="checked"'; ?> onClick="$('#commerical').hide();$('#commerical2').hide();"/>
						<strong>Private</strong>
					</label>
				</div>
				<?php if(set_value('booka_type', @$booka_type)==0) echo '
					<script>$(function(){$("#booka_type2").click();});</script>
				'; ?>
				
				<div class="form_block">
					<div class="form_row">
						<div class="form_item">
							<label>First Name <span>*</span></label>
							<input name="firstname" type="text" class="input1" id="firstname" value="<?php echo set_value('firstname', @$firstname); ?>"/>
						</div>
						
						<div class="form_item">
							<label>Last Name <span>*</span></label>
							<input name="lastname" type="text" class="input1" id="lastname" value="<?php echo set_value('lastname', @$lastname); ?>"/>
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
					
					<div class="form_row" id="commerical">
						<?php /*?><div class="form_item">
							<label>Business Name <span>*</span></label>
							<input name="business_name" type="text" class="input1" id="business_name" value="<?php echo set_value('business_name', @$business_name); ?>"/>
						</div>
						<?php */?>
						<div class="form_item">
							<label>
								ABN <span>*</span>
							</label>
							<input name="abn" type="text" class="input1" id="abn" value="<?php echo set_value('abn', @$abn); ?>" />
						</div>
							<div class="form_item">
							<label>
								Business Name<span>*</span>
							</label>
							<input name="business_name" type="text" class="input1" id="business_name" value="<?php echo set_value('business_name', @$abn); ?>" />
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
					
					<div class="form_row">
						<div class="form_item">
							<label>Address <span>*</span><span id="commerical2">
										<strong class="bubble_info">
								<img src="<?=base_url()?>images/question_mark_icon.png" style = "width:15px;height:15px;"
											alt="" class="img_ask" />
									<strong class="popup" style="width:198px !important;">
									<b>arrow</b>
									<em style="width:170px !important;">Please enter your business<br>address into the following fields.</em>
									</strong>
								</strong></label></span>
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
							<input  name="postcode" type="text" class="input2" id="postcode" value="<?php echo set_value('postcode', @$postcode); ?>"/>
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
							<input name="phone_code" type="hidden" class="input3" id="phone_code" value="<?php echo set_value('phone_code', @$phone_code); ?>"/>
							<input name="primary_phone" type="text" class="input4" id="primary_phone" value="<?php echo set_value('primary_phone', @$primary_phone); ?>"/>
						</div>						
						<div class="form_item" style="margin-left: 65px;">
							<label>Alternative Phone Number</label>
							<input name="alternative_phone" type="text" class="input5" id="alternative_phone" value="<?php echo set_value('alternative_phone', @$alternative_phone); ?>"/>
						</div>
						<br class="cl" />
                        <fieldset>
  				 <!--end of form_item-->
						
						<br class="cl" />
                        <input type="submit" value="Save &amp; Continue" class="input_continue" />
					</div><!--end of form_row-->
					
				</div> 
                
                <!--end of form_block-->
 
				
			 
				
				<br class="cl" />

			</fieldset>
					</div><!--end of form_row-->
				</div><!--end of form_block-->
				
								
				
				
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