<style>
.info_box {margin-bottom:50px;}
</style>
	
			<div style="background-image:none;height:364px !important;">

					<p><h1>Welcome!</h2></p>
			  <p>&nbsp;</p>
                    <p>Thank you for creating an account on Soundbooka.</p>
              <p>&nbsp;</p>
				  <p>
You will shortly receive a confirmation email at the address you entered when creating your account. <br />Please 
follow the link contained within to complete the registration process.
			  </p>
				
			  <p>&nbsp;</p>
                    <p>The Soundbooka Team</p>
                    <p>&nbsp;</p>
                    <p></p>
                    <p><a href="#" class="btn_join">Re-Send Email</a></p>
			</div>

			
			
			<br class="cl" />
<script>
$(function() {
	$('.btn_join').click(function() {
		url = '<?=base_url()?>artist/re_send/<?=$id?>';
		$.get(url, function(data) {
		  //if (data == 'OK') {
			  showMessage('Email sent!');
		  //} else {
			  //showErrorEx('Email sending failed! Please try again.');
		  //}		  
		});
	});
	
});
</script>