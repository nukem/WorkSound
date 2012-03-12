<?php
$test = $this->session->userdata('is_loged');
$test_id = $this->session->userdata('artist_id');
$ids = $this->session->userdata('artists');
$uri_test = $this->uri->segment(3);
if($test  == '1' && !empty($test) && in_array($uri_test,$ids)){?>
<h1>Edit your profile</h1>
			
<?php } else{
$this->session->set_userdata('is_loged', false);
$this->session->set_userdata('artist', null);
$test_id = '';
?>
<h1>Join as an Artist</h1>
		
<?php } ?>		
			
			<div class="<?php if($uri_test != $test_id ) echo 'step';else echo 'editstep';?> step4">step</div>
			<!--<div class="line_help"><a href="#">click here for help</a></div>-->
<br/>
			<form action="" method="post" class="uniform" onsubmit="return clearTips();">
			<fieldset>
				<table width="100%"><tr width="100%">
					<td width="50%"><h2>PERFORMANCE HISTORY<h2></td>
					<td width="50%" align="right"><div align=right class="form_title"><span>*</span> This indicates a mandatory field</div></td>
				</tr></table>
				<h2>STEP 4 of 6</h2>
				<!--<div class="form_title">&nbsp;</div>-->
				<div class="form_block">
					<?php if($profile_type==1){?>
						<p> Almost there! Here you can provide more information about yourself as a DJ including your experience, residencies, festival appearances, professional highlights as well as your social media links. This information will appear on your Soundbooka Profile Page.</p>
					<?php } ?>		
					<?php if($profile_type==3){?>
						<p> Almost there! Here you can provide more information about yourself as a solo artist including your experience, releases, festival appearances, professional highlights as well as your social media links. This information will appear on your Soundbooka Profile Page.</p>
					<?php } ?>		
					<?php if($profile_type==7){?>
						<p> Almost there! Here you can provide more information about band including your experience, releases, festival appearances, professional highlights as well as your social media links. This information will appear on your Soundbooka Profile Page.</p>
					<?php } ?>		
					<?php if($profile_type==9){?>
						<p> Almost there! Here you can provide more information about yourself as a session musician including your experience, releases, festival appearances, professional highlights as well as your social media links. This information will appear on your Soundbooka Profile Page.</p>
					<?php } ?>		
					<?php if($profile_type==10){?>
						<p> Almost there! Here you can provide more information about yourself as an audio professional including your experience, professional highlights, awards, core competencies and social media links. This information will appear on your Soundbooka Profile Page.</p>
					<?php } ?>		
					<div class="form_row">
                    <? if ($profile_type != 10) : ?>
						<div class="form_item">
							<label>Experience<span>*</span></label>
							<textarea class="textarea2 infotext" name="info1" id="info1" title="Add more information so that people know more about you. (Min. 50 words)"><?php echo symbol_convertion($info1); ?></textarea>
						</div>
						
						<div class="form_item2">
							<label><?=($profile_type==1) ? 'Residencies':'Releases'?></label>
							<?php if($profile_type==1){?>
								<textarea class="textarea2 infotext" name="info2" id="info2" title="Hold down any residencies? List them here. (Max. 50 words)"><?= set_value('info2',@symbol_convertion($info2)); ?></textarea>
							<?php } ?>
							<?php if($profile_type==3){?>
							<textarea class="textarea2 infotext" name="info2" id="info2" title="List your releases here (max 50 words)"><?= set_value('info2',@symbol_convertion($info2)); ?></textarea>
							<?php } ?>
							<?php if($profile_type==7){?>
							<textarea class="textarea2 infotext" name="info2" id="info2" title="List your releases here (max 50 words)"><?= set_value('info2',@symbol_convertion($info2)); ?></textarea>
							<?php } ?>
							<?php if($profile_type==9){?>
							<textarea class="textarea2 infotext" name="info2" id="info2" title="List the releases you have worked on here (max 50 words)"><?= set_value('info2',@symbol_convertion($info2)); ?></textarea>
							<?php } ?>
						</div>
					</div><!--end of form_row-->
					
					<div class="form_row">
						<div class="form_item">
							<label>Festivals</label>
							<textarea class="textarea2 infotext" name="info3" id="info3" title="List festivals appearances here. (Max. 50 words)"><?= set_value('info3',@symbol_convertion($info3)); ?></textarea>
						</div>
						
						<div class="form_item2">
							<label>Highlights so far</label>
							<textarea class="textarea2 infotext" name="info4" id="info4" title="Performed anywhere special or with someone amazing? (Max. 50 words)"><?= set_value('info4',@symbol_convertion($info4)); ?></textarea>
						</div>
					</div><!--end of form_row-->
                    
                    <? else: ?>
					
					<div class="form_row">
						<div class="form_item">
							<label>Experience</label>
							<textarea class="textarea2 infotext" name="info1" id="info1" title="Add more information so that people know more about you. (Max. 50 words)"><?= set_value('info1',@symbol_convertion($info1)); ?></textarea>
						</div>
						
						<div class="form_item2">
							<label>Awards</label>
							<textarea class="textarea2 infotext" name="info2" id="info2" title="Won any awards? Please list them here. (Max. 50 words)"><?= set_value('info2',@symbol_convertion($info2)); ?></textarea>
						</div>
					</div><!--end of form_row-->
					
					<div class="form_row">
                    
						<div class="form_item">
							<label>Highlights so far</label>
							<textarea class="textarea2 infotext" name="info3" id="info3" title="Worked on anything special or with someone amazing? (Max. 50 words)"><?= set_value('info3',@symbol_convertion($info3)); ?></textarea>
						</div>
					
						<div class="form_item2">
							<label>Core Competencies</label>
							<textarea class="textarea2 infotext" name="info4" id="info4" title="Please list the tools you are competent in - software, instruments, etc. (Max. 50 words)"><?= set_value('info4',@symbol_convertion($info4)); ?></textarea>
						</div>
                        <br class="cl" />
					</div><!--end of form_row-->
                    <? endif; ?>
						
              <div class="shadow_line_nobg">line</div>

				<div class="form_row">
					<div class="form_title">Social Media</div>
					<p>List your artist  Facebook and Twitter links here.</p>

						<div class="form_item">
							<label>Facebook</label>
							<input name="facebook" type="text" class="input1" id="facebook" value="<?php echo set_value('facebook', @$facebook); ?>" style="width:450px"/>
						</div>
					
						<div class="form_item2">
							<label>Twitter</label>
							<input name="twitter" type="text" class="input1" id="twitter" value="<?php echo set_value('twitter', @$twitter); ?>" style="width:450px"/>
						</div>
                        <br class="cl" />
					</div><!--end of form_row-->	

				</div><!--end of form_block-->
             
				
				<div class="shadow_line_nobg">line</div>
				
				<input type="submit" value="Save &amp; Continue" class="input_continue" name="save" />
				
				<a href="<?php echo base_url() ?>artist/step3/<?php echo $uri_test;?>" class="btn_back2" >Back</a>
				
				<br class="cl" />

			</fieldset>
			</form>
			
			<br class="cl" />
	
<script>
function clearTips() {
	$('.infotext').each(function() {
		  if($(this).val() == $(this).attr('title')) $(this).val('');
	});	
	return true;
}
$('.input_continue').live('click',function() {
		if ($('#info1').val()=='') {
		  $('#info1').addClass('input-error');
		  showErrorEx('Field is required!');
		  return false;
		}
		$('#info1').removeClass('input-error');
	});
</script>