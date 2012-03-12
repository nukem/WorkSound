<?php
$gig_values = $this->session->userdata('searching');
if(!empty($gig_values))
{
	$start_date = $gig_values[0]['start_date'];
	$end_date = $gig_values[0]['end_date'];
	$artist_type = $gig_values[0]['profile_type'];
	
	$start_time = $gig_values[0]['start_time'];
	$end_time = $gig_values[0]['end_time'];
	$country = $gig_values[0]['country'];
	$state = $gig_values[0]['state'];
	$postcode = $gig_values[0]['postcode'];
	$fee_hour = $gig_values[0]['fee_hour'];
	$gig_hours = $gig_values[0]['gig_hours'];
	$fee_gig = $gig_values[0]['fee_gig'];
}
$test = $this->session->userdata('is_loged');
$test_id = $this->session->userdata('artist_id');
$ids = $this->session->userdata('artists');
$uri_test = $this->uri->segment(3);
if($test  == '1' && !empty($test) && in_array($uri_test,$ids)){?>
<h1>Gig profile</h1>
			
<?php } else{
$this->session->set_userdata('is_loged', false);
$this->session->set_userdata('artist', null);
$test_id = '';
?>
<h1>Gig profile</h1>
		
<?php } ?>		
			<!--<div class="<?php if($uri_test != $test_id ) echo 'step';else echo 'editstep';?> step1">step</div>-->
			<br />

			<form action="" method="post" class="uniform">
			<fieldset>
				<table width="100%"><tr width="100%">
					<td width="50%"><h2>GIG</h2></td>
					<td width="50%" align="right"><div align=right class="form_title"><span>*</span> This indicates a mandatory field</div></td>
				</tr></table>
				<?php //if($uri_test != $test_id ){?>
				<div class="form_title">Hi! Create your gig so you can offer it to your favourite Soundbooka artists!</div>
				<?php //} ?>

				<?php if(set_value('booka_type', @$booka_type)==0) echo '
					<script>$(function(){$("#booka_type2").click();});</script>
				'; 
				
				?>
				
				<div class="form_block">
					<div class="form_row">
						<div class="form_item">
							<label>Gig Name <span>*</span></label>
							<input name="gig_name" type="text" class="input1" id="gig_name" value="<?php echo set_value('gig_name', @$gig_name); ?>"/>
						</div>
						<?php if(empty($gig_name)) { ?>
						<div class="form_item">
							<label>OR</label>
							<div class="simu_select1">
							<?=form_dropdown('existing_gigname', $existing_gigname)?>
							</div>
						</div>
						<?php } ?>
						<br class="cl" />
					</div><!--end of form_row-->
					<div class="form_row">
						<div class="form_item">
							<label>Event Name</label>
							<input name="event_name" type="text" class="input1" id="event_name" value="<?php echo set_value('event_name', @$event_name); ?>"/>
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
				
					<div class="form_row" id="commerical">
						<div class="form_item">
							<label>Start Date <span>*</span></label>
							<input name="start_date" type="text" class="input2" id="startDate" value="<?php echo set_value('start_date', @$start_date); ?>"/>
						</div>
						<div class="form_item">
							<label>Start Time <span>*</span></label>
							<div class="simu_select4">
							<?=form_dropdown('start_time', $time, set_value('start_time',@$start_time), 'id=start_time')?>
							</div>
						</div>
						<div class="form_item">
							<label>
								End Date <span>*</span>
							</label>
							<span id="end"><input name="end_date" type="text" class="input2" id="endDate" value="<?php echo set_value('end_date', @$end_date); ?>" /></span>
						</div>
						<div class="form_item">
							<label>
								End Time <span>*</span>
							</label>
							<div class="simu_select4">
							<?=form_dropdown('end_time', $time, set_value('end_time',@$end_time), 'id=end_time')?> 
							</div>
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
					
					
			<div class="form_row">
				<div class="form_item" style="margin-bottom:0px;">
						<label>Profile Type <span>*</span>
						<strong class="bubble_info">
							<img src="<?=base_url()?>images/question_mark_icon.png" style = "width:15px;height:15px;" alt="" class="img_ask" />
							<strong class="popup"><b>arrow</b><em>You can create multiple Soundbooka Profile Pages. Simply complete your first Profile Page, then login and select a new Profile Type.</em></strong>
						</strong>
					</label>
					<div class="simu_select1">
					<?=form_dropdown('artist_type', $types, set_value('artist_type',@$artist_type), 'id=profile_type')?>
					</div>
				</div>
				<br class="cl" />
			</div><!--end of form_row-->
			
		<div class="form_block div_genre">
			<div class="form_title div_genre">
			Genres <span>*</span>
			
			<strong class="bubble_info">
				<img src="<?=base_url()?>images/question_mark_icon.png" style = "width:15px;height:15px;" alt="" class="img_ask" />
				<strong class="popup"><b>arrow</b><em>We cater to every type of preforming artist on Soundbooka. By selecting the genres that best describe your sound we can provide you with the gigs that best match your skill set.</em></strong>
			</strong><br/>
			<p>Please select the genres that best describe your sound</p>
		</div>
			<div class="form_row">
				<?php 
					$result = mysql_query("select * from genre where active ='1' order by genre");
					$genres = array();
					while($row=mysql_fetch_array($result)){
						$genres[$row['artist_type']][] = array('id'=>$row['genre_id'],'genre'=>$row['genre']);
					}
					
					if(!empty($gig_values)){
					$test = $gig_values[0]['genre'];
					}else{
					$test=explode(',',set_value('genre',@$genre));
					}
					#echo '<div style="display:none;">test'; print_r($test); echo '</div>';
					foreach ($genres as $at=>$gs) {
						if(set_value('artist_type',@$artist_type)==$at) $show=1;else $show=0;
					?>
					<div class="option_col_x at_<?=$at?>" <?php if($show==0) echo 'style="display:none"'; ?>>
						<? if (!isset($genre)) $genre = array(); ?>
						<? $gs = array_chunk($gs,6,1); ?>
						<? foreach ($gs as $gsx) : ?>
						<div class="option_col">
						<? foreach ($gsx as $g) {?>
							
							<div class="option">
								<label>
									<input type="checkbox" class="id_<?=$g['id']?> genre" name="genre[]" id="genre" value="<?=$g['id']?>" <?=(in_array($g['id'],@$test) ? 'checked="checked"':'')?>/>
									<strong><?php echo $g['genre'];?></strong>
								</label>
							</div>
							
						<? } ?>
						<br class="cl" /></div>
						<? endforeach; ?>
					<br class="cl" />
					</div><!--end of option_col-->
					<?php } ?>
				
				
		</div><!--end of form_block-->
		</div>
					<div class="form_block">
					<div class="form_title">
					Performance Fee <span>*</span> 
					
					</div>
					<div class="form_row">
						<div class="form_item">
							<label>What is your Maximum fee per hour? <span>*</span></label>
                            <span class="label">$ </span><input type="text" class="input1" name="fee_hour" id="fee_hour" value="<?php echo set_value('fee_hour',@$fee_hour); ?>" style="width:50px;text-align:right" />
						</div>
                        
                       <div class="form_item">
							<label>What is the maximum amount of time you need the performer?<span>*</span></label>
							<span style="float:left;margin-right:5px" class="label">No. of hours </span>
								<input type="text" class="input1" name='gig_hours' value="<?=set_value('gig_hours',@$gig_hours)?>" id='id=gig_hours' style="width:50px;text-align:right" />
							
						</div>
						
						
						<br class="cl" />
					</div><!--end of form_row-->
					<div class="form_row">
						<div class="form_item">
							<label> - OR -</label>
                    	</div>
                    <br class="cl" /></div>
					<div class="form_row">
						<div class="form_item">
							<label>What is your Maximum fee per gig/session?<span>*</span></label>
							
                            <span class="label">$ </span><input type="text" class="input1" name="fee_gig" id="fee_gig" value="<?php echo set_value('fee_gig',@$fee_gig); ?>" style="width:50px;text-align:right"/>
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
					
			</div><!--end of form_block-->
					<div class="form_row">	
						<div class="form_item">
							<label>Address <span>*</span></label>
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
						<br class="cl" />
					</div><!--end of form_row-->				<?php if(!empty($profile_id)) { ?>
				<div class="form_row">	
						<div class="form_item">
							<label>Status</label>
							<div class="simu_select5">
							<?=form_dropdown('status', array('active'=>'active','deactive'=>'deactive'), set_value('status',@$status), 'id=status')?>
						</div>
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
				<?php } ?>
				</div><!--end of form_block-->
				<div class="form_row">	
				<label>Payment method <span>*</span></label>
						
						<div class="form_item">
							<div class="option_holder">
								<div class="option">
									<label>
										<input name="payment_method" type="radio" value="1" <?php echo set_radio('payment_method', '1',((1==@$payment_method) ? TRUE:FALSE)); ?> />
										<strong>PayPal</strong>
									</label>
								</div>
								<div class="option">
									<label>
										<input name="payment_method" type="radio" value="2" <?php echo set_radio('payment_method', '2',((2==@$payment_method) ? TRUE:FALSE)); ?>/>
										<strong>Cash</strong>
									</label>
								</div>
							</div>
						</div><!--end of form_item-->
				</div>
								
				<input type="submit" value="Save" class="input_continue" />
				
				<br class="cl" />

			</fieldset>
			</form>
<script>
$(function() {

	$('#fee_hour').keypress(function() {
		$('#fee_gig').val('0');
	});
	$('#fee_gig').keypress(function() {
		$('#fee_hour').val('0');
	});
	
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

	$( "#startDate" ).datepicker({dateFormat: 'dd/mm/yy'});
	$( "#startDate" ).change(function(){
		test = $(this).datepicker('getDate');
		testm = new Date(test.getTime());
		testm.setDate(testm.getDate());
		$('#end').html('<input name="end_date" type="text" class="input2 datepick" id="endDate" />');
		$( "#endDate" ).datepicker({dateFormat: 'dd/mm/yy',minDate:testm});
	});
	
	$('#profile_type').change(function() {
		if ($(this).val() == '') {
			$('#step2').slideUp('fast');
		} else {
			$('#step2').slideDown('fast');
		}
		$('.div_genre').hide();
		$('.option_col_x').hide();
		$('input.genre').attr('checked',false);
		$.uniform.update('input.genre');
		if($('.at_'+$('#profile_type').val()+ ' .option:last input').val()!='99999')
		{
			$('.genboxdivother').remove();
			$('<div class="option genboxdivother"><label><div class="checker" id="uniform-genre"><span><input type="checkbox" class="id_99999 genre other_gen_box" name="genre[]" id="genre" value="99999" style="opacity: 0;" onclick="return AddGenTextBox();"></span></div><strong>Other</strong></label><label><div id="gen_textbox" style="padding-top:20px; display:none" ><input type="text" name="other_gen" class="input1" id="other_gen" value="" style="width:50px;"/> </div></div>').insertAfter('.at_'+$('#profile_type').val()+ ' .option:last');			
		}
		$('.at_'+$(this).val()).show();
		//alert($('.at_'+$(this).val()).html());
		$('.div_genre').slideDown();
		updateUI();
	});
});

function updateUI() {
	opt = $('#profile_type').val();
	switch (opt) {
		case '1':
			$('#instrument_type').slideDown();
			$('#div_instruments').hide();
			$('#div_equipment').slideDown();
			$('#instrument_heading').hide();
			break;
		case '3':
			$('#div_djcombo').hide();
			$('#div_instruments').slideDown();
			$('#solo_combo_type_heading').slideDown();
			$('#DJ_combo_type_heading').hide();
			$('#DJ_combo_type_text').hide();
			$('#div_dj').hide();
			$('#instrument_heading').show();
			$('#band_type_text').hide();
			$('#solo_combo_type_text').show();
			$('#DJ_combo_type_text').hide();
			break;
		case '7':
			$('#div_djcombo').hide();
			$('#div_instruments').slideDown();
			$('#DJ_combo_type_heading').hide();
			$('#DJ_combo_type_text').hide();
			$('#div_dj').hide();
			$('#instrument_heading').html('Line-up').show();
			$('#band_type_text').show();
			$('#solo_combo_type_text').hide();
			$('#DJ_combo_type_text').hide();
			$('.instrument-description').html('Player Name');
			break;
		case '9':
			$('#div_djcombo').hide();
			$('#div_instruments').slideDown();
			$('#DJ_combo_type_heading').hide();
			$('#DJ_combo_type_text').hide();
			$('#div_dj').hide();
			$('#instrument_heading').show();
			$('#div_gig').hide();
			$('#band_type_text').hide();
			$('#solo_combo_type_text').show();
			$('#DJ_combo_type_text').hide();
			break;
		case '10':
			$('#div_djcombo').hide();
			$('#div_instruments').hide();
			$('.div_genre').hide();
			$('#div_gig').hide();
			$('#div_specialization').slideDown();
			$('#div_equipment').hide();
			if ($('#specialization_14').attr('checked')) {
				//$('.div_genre').slideDown();
			}
			$('#div_dj').hide();
			$('#instrument_heading').show();
			if($('#div_specialization .option_col:last .options:last input').val()!='99999'){
			$('.specializationDivOther').remove();
			$('<div class="options specializationDivOther"><label><div class="checker" id="uniform-specialization-n"><span><input type="checkbox" class="other_specialization_box" name="specialization_arr[]"  value="99999" style="opacity: 0;" onclick="return AddspecializationTextBox();"></span></div><strong>Other</strong></label><div id="specialization_textbox" style="padding-top:20px; display:none" ><input type="text" name="other_specialization" class="input1" id="other_specialization" value="" style="width:50px;"/> </div></div>').insertAfter('#div_specialization .option_col:last .options:last');
		}
			break;	
	}
	if($('.at_'+$('#profile_type').val()+ ' .option:last input').val()!='99999')
	{
		$('.genboxdivother').remove();
		$('<div class="option genboxdivother"><label><div class="checker" id="uniform-genre"><span><input type="checkbox" class="id_99999 genre other_gen_box" name="genre[]" id="genre" value="99999" style="opacity: 0;" onclick="return AddGenTextBox();"></span></div><strong>Other</strong></label><div id="gen_textbox" style="padding-top:20px; display:none" ><input type="text" name="other_gen" class="input1" id="other_gen" value="" style="width:50px;"/> </div></div>').insertAfter('.at_'+$('#profile_type').val()+ ' .option:last');			
	}
	//alert($('#div_gig .options:last').html());	
	if($('#div_gig .options:last input').val()!='99999'){
		$('.gigboxdivother').remove();
		$('<div class="options gigboxdivother"><label><div class="checker" id="uniform-undefined"><span><input type="checkbox" class="other_gig_box" name="gigs_arr[]"  value="99999" style="opacity: 0;" onclick="return AddGigTextBox();"></span></div><strong>Other</strong></label><div id="gig_textbox" style="padding-top:20px; display:none" ><input type="text" name="other_gig" class="input1" id="other_gig" value="" style="width:50px;"/> </div></div>').insertAfter('#div_gig .options:last');
	}

}

</script>
