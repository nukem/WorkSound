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
<div style="min-height:345px;">
<h1>Join as a Booker</h1>
		
<?php } ?>		

			<!--<div class="<?php if($uri_test != $test_id ) echo 'step';else echo 'editstep';?> step6">step</div>-->
			<?php /* ?><div class="line_help"><a href="#">click here for help</a></div><?php */ ?>
			<br />
			<form action="#" method="post" class="uniform">
			<fieldset>
				<?php if($test  == '1' && !empty($test) && ($uri_test == $test_id)){?>
				<h2>PROFILE UPDATED <!--<img src="<?=base_url()?>images/ico_smile.gif" alt="" width="17" />--></h2>
				<?php } else { ?>
				<h2>REGISTRATION COMPLETE <!--<img src="<?=base_url()?>images/ico_smile.gif" alt="" width="17" />--></h2>
				<?php } ?>
				 
				<?php if($test  == '1' && !empty($test) && ($uri_test == $test_id)){?>
				<div class="form_title">Thank you for updating your Booker profile on SoundBooka!</div>
				<?php } else { ?>
				<div class="form_title">Thank you for registering as a Booker on Soundbooka!</div>
				<?php } ?>
				<?php if($test  == '1' && !empty($test) && ($uri_test == $test_id)){?>
				<div class="form_block">
					<div class="para2">
					<p>For more information please visit the Soundbooka FAQ page<a href="<?=base_url()?>faq"> here</a></p>
					</div>
				</div>
				<?php } else{?>
				<div class="form_block">
					<div class="para2">
						<p>You will shortly receive an email as to whether your account has been activated.</p>
						<p>
							For more information please visit the Soundbooka FAQ page <a href="<?=base_url()?>faq"> here</a>.
							<strong class="bubble_info">
								<img src="<?=base_url()?>images/question_mark_icon.png" style = "width:15px;height:15px;" alt="" class="img_ask" />
								<strong class="popup"><b>arrow</b><em>Soundbooka will activate your profile only if it meets with our minimum quality requirements. You will be notified whether your registration has been accepted.</em></strong>
							</strong
						></p>
					</div>
					<div class="btn_row">
						<!--<a href="<?=base_url()?>profile/view/<?=$id?>">Click here to view your profile</a>
						<a href="<?=base_url()?>artist/create_new/<?=$id?>">Click here to add a new profile</a>-->
						<!--<a href="#" id="resend">Resend verification email</a>-->
					</div>
				</div><!--end of form_block-->
				
				<?php } ?>
				
				<div class="shadow_line_nobg">line</div>
				
				
				
				<br class="cl" />

			</fieldset>
			</form>
			
			<br class="cl" />
</div>	
<script>
$(function() {
	$('#resend').click(function() {
		url = '<?=base_url()?>artist/re_send/<?=$id?>';
		$.get(url, function(data) {
		  if (data == 'OK') {
			  showMessage('Email sent!');
		  } else {
			  showErrorEx('Email sending failed! Please try again.');
		  }		  
		});
	});
	
});
</script>