<style>
.info_box {margin-bottom:50px;}
</style>
	
			<div style="background-image:none;height:364px !important;">

					<p><h1>Thanks for your message!</h2></p>
			  
              <p>&nbsp;</p>
				  <p>
						We'll be in touch shortly at the email address you provided.
			  </p>
				
			  <p>&nbsp;</p>
                    <p>The Soundbooka Team</p>
                    <p>&nbsp;</p>
                    <p></p>
                  
			</div>

			
			
			<br class="cl" />
<script>
$(function() {
	$('.btn_join').click(function() {
		url = '<?=base_url()?>re_send';
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