<style>
.info_box {margin-bottom:50px;}
.info_box {margin-bottom:50px;}
.btn_resend {
    background: url("<?=base_url()?>images/btn_bg2.gif") repeat-x scroll 0 0 transparent;
    border-radius: 4px 4px 4px 4px;
    color: #FFFFFF;
    display: block;
    font-size: 19px;
    height: 38px;
    line-height: 38px;
    margin-left: 50px;
    text-align: center;
    text-decoration: none;
    width: 328px;
}
.btn_resend:hover {
    color: #EDEDED;
}

#email_box {
    background: none repeat scroll 0 0 #fff;
	padding:8px;
	color:#000;
	overflow:auto;
	width: 405px;
	float:right;
	margin-right:100px;
}
#email_box input {
	width:100px!important;
	float:none;
	text-indent:0px;
}
#email_box form{
    margin: 0 auto;
    width: 940px;
	text-align:right
}
#email_box input[type=submit] {
	width:72px!important;
	background:none;
	background-color:#515050;
	font-size: 12px;
}
#email_box input[type=submit]:hover {
	background-color:#3d3c3c;
}
.bubble{
padding-top: 10px;float:right;margin-right:150px;
}
</style>
	
			<div style="background-image:none;height:205px !important;">

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
                    <!--<p><a href="#" class="btn_join">Re-Send Email</a></p>-->
					<div>
					<div style="float:left;">
                    <p><a href="#" class="btn_join">Re-Send Email</a></p>
					</div>
					<div style="float:left;">
					<p><a href="#" class="btn_resend" onclick="$('#email_box').slideToggle()">Re-Send to Another Email</a></p>
					</div>
					<div class="bubble">
					<strong class="bubble_info">
						<strong class="popup"><b>arrow</b><em>Your email system may have mistakenly filtered out or deleted the Soundbooka email. Click here to send your registration to another email account so you can check your email and complete your registration. </em></strong>
					<img src="<?=base_url()?>images/question_mark_icon.png" style = "width:15px;height:15px;" alt="" class="img_ask" />
					</strong>
					</div>
					</div>
			</div>

			
			
			<br class="cl" />
<div id="email_box" style="display: none;">

<div style="float:right;">
<input type="submit" style="background-color:#029ac1;" value="Send" class="input_continue" name="signin" id="send"/>
</div>
<div class="form_item" style="float:right;">
	<label>Enter Another Email</label>
	<input name="email" style="text-align:justify;width:172px !important;" type="text" class="input1" id="email" />
</div>
</div>
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
	
	$('#send').click(function() {
		var email = $('#email');
		if (!validate(email)) {
			showErrorEx('Email fields is required!');
			return; 
		}
		if (!checkEmail(email.val())) {
			email.addClass('input-error');
			return;
		} else {
			email.removeClass('input-error');
			url = '<?=base_url()?>artist/change_email/<?=$id?>/';
			$.get(url,{'email' : email.val()}, function(data) {
				//alert(data);
				showMessage('Email sent!');
				$("#email").val('');
				$('#email_box').slideUp();
				
			});
		}
	});
	
});
function validate(elm) {
	if(elm.val() == elm.attr('title') || elm.val() == '') {
		elm.addClass('input-error');
		return false;
	}
	elm.removeClass('input-error');
	return true;
}

function checkEmail(value) {
	var x = value;
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
	{
		showErrorEx('Invalid Email address');
		return false;
	}
	else{
		return(true);
	}
}
</script>