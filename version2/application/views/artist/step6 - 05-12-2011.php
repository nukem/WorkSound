
			<h1>Join as an Artist</h1>
			
			<div class="step step6">step</div>
			<?php /* ?><div class="line_help"><a href="#">click here for help</a></div><?php */ ?>
			<br />
			<form action="#" method="post" class="uniform">
			<fieldset>
				<h2>REGISTRATION COMPLETE <img src="<?=base_url()?>images/ico_smile.gif" alt="" width="17" /></h2>
				<h2>STEP 6 of 6<img src="<?=base_url()?>images/ico_smile.gif" alt="" width="17" /></h2>
				<div class="form_title">Thanks for registering with Soundbooka!</div>
				<div class="form_block">
					<div class="para2">
						<p>An email has been sent to your email address. </p>
						<p>
							Please click on the verification link to submit your account for reviewing.
							<strong class="bubble_info">
								<img src="<?=base_url()?>images/question_mark_icon.png" style = "width:15px;height:15px;" alt="" class="img_ask" />
								<strong class="popup"><b>arrow</b><em>Soundbooka will activate your profile only if it meets with our minimum quality requirements. You will be notified whether your registration has been accepted.</em></strong>
							</strong
						></p>
					</div>
					<div class="btn_row">
						<a href="<?=base_url()?>profile/view/<?=$id?>">Click here to view your profile</a>
						<a href="<?=base_url()?>artist/create_new/<?=$id?>">Click here to add a new profile</a>
						<a href="#" id="resend">Resend verification email</a>
					</div>
				</div><!--end of form_block-->
				
				
				
				<div class="shadow_line">line</div>
				
				
				
				<br class="cl" />

			</fieldset>
			</form>
			
			<br class="cl" />
	
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