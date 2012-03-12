
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<header class="clearfix">
<div id="header">
		<div class="header_inside">
			<div class="logo"><a href="<?=base_url()?>"><img src="<?=base_url()?>images/logo.gif" alt="" /></a></div>	
			<ul class="nav">
				<li><a href="<?=base_url()?>">Home</a></li>
				<li><a href="<?=base_url()?>book" class="highlight">Book an Artist</a></li>
                <? //if ($this->session->userdata('is_loged')) : ?>  
				<!--<li><a href="<?=base_url()?>artist/step1/<?= $this->session->userdata('artist_id') ?>" class="highlight">Join as an Artist</a></li>-->
                <? //else : ?>
                <li><a href="<?=base_url()?>artist/register" class="highlight">Join as an Artist</a></li>
                <? //endif; ?>
				<li><a href="<?=base_url()?>about">About</a></li>
				<li><a href="<?=base_url()?>faq">FAQ</a></li>
				<li><a href="<?=base_url()?>contact">Contact</a></li>
			</ul>  
			<?php $test = $this->session->userdata('is_loged');
					$test_id = $this->session->userdata('artist_id');
					$ids = $this->session->userdata('artists');
					$uri_test = $this->uri->segment(3);
					
					if($test  == '1' && !empty($test)){
						if(($this->uri->segment(1)=='artist' || $this->uri->segment(1)=='profile')){
							 if(in_array($uri_test,$ids)){
								?><a href="javascript: void(0);"  onclick="$('#login_box').slideToggle()" class="btn_login">Logout</a><?php
							}
							else {
							$this->session->set_userdata('is_loged', false); 
							$this->session->set_userdata('artist', null);
							$test_id = '';
					?><a href="javascript: void(0);"  onclick="$('#login_box').slideToggle();$('#login').slideDown();$('#forgot').slideUp(); " class="btn_login">Login</a><?php }
						}
						else {?><a href="javascript: void(0);"  onclick="$('#login_box').slideToggle()" class="btn_login">Logout</a><?php }
					?>
			<?php } else {
				if($uri_test > 0){
				$this->session->set_userdata('is_loged', false); 
				$this->session->set_userdata('artist', null);
				$test_id = '';
				}
			?>
			<a href="javascript: void(0);"  onclick="$('#login_box').slideToggle();$('#login').slideDown();$('#forgot').slideUp(); " class="btn_login">Login</a>
			<?php } ?>
			<!--<?=base_url()?>webpublisher/<form action="#" class="search_form">
			<fieldset>
				<input type="text" class="input_txt" value="Search" onblur="if(this.value=='') this.value='Search';" onfocus="if(this.value=='Search') this.value='';" />
				<input type="submit" class="input_send" value="" />
			</fieldset>
			</form>-->
		</div>
		</div>
</header>
<style>
#login_box {
    background: none repeat scroll 0 0 #D1D1D1;
	padding:8px;
	color:#000;
	overflow:auto;
}
#login_box input {
	width:100px!important;
	float:none;
	text-indent:0px;
}
#login_box form{
    margin: 0 auto;
    width: 940px;
	text-align:right
}
#login_box input[type=submit] {
	width:72px!important;
	background:none;
	background-color:#515050;
	font-size: 12px;
}
#login_box input[type=submit]:hover {
	background-color:#3d3c3c;
}
</style>
<div id="login_box" <? if (!$this->session->userdata('is_loged')) echo 'style="display: none;"'; ?>>
<? if (!$this->session->userdata('is_loged')) : ?>
<form method="post" action="<?=base_url()?>user/login" id="login">
						<div class="form_item" style="float:none">
							<label><a href="javascript:void(0);" onclick="$('#login').slideUp();$('#forgot').slideDown();">Forgot Password</a>&nbsp;</label>
						</div>
						<div class="form_item" style="float:none">
							<label>Email&nbsp;</label>
							<input name="username" type="text" class="input1" id="username"/>
						</div>
						
						<div class="form_item" style="float:none">
							<label>Password&nbsp;</label>
							<input name="password" style="text-align:justify;" type="password" class="input1" id="password"/>
						</div>
                        <input type="submit" value="Login" class="input_continue" name="signin" />
				
			</form>	
			<form method="post" action="<?=base_url()?>user/forgot" style="display:none;" id="forgot">
						<div class="form_item" style="float:left;">
							<label><a href="javascript:void(0);" onclick="$('#login').slideDown();$('#forgot').slideUp();">Login</a>&nbsp;</label>
						</div>
						<div class="form_item" style="float:left;width:102px;">
							<label>Secret Question</label>
							</div>
						
						<?php 
						$questions = $this->mUtil->getCodes('Secret Questions');
						$i = 0;
						foreach ($questions as $key => $s) {
						$question[$s] = $s;  
						$i++;
						}
						?>
						<style>
						.form_item .selector span {
							
							float:left;
						}
						</style>
							<div class="form_item simu_select1">
                                <?=form_dropdown('secret_question', $question, set_value('secret_question',@$secret_question), 'id=secret_question')?>
							</div>
							<div class="form_item" style="float:left">
							<label>Answer&nbsp;</label>
							<input name="sec_ans" style="text-align:justify;" type="sec_ans" class="input1" id="password"/>
							</div>
							<div class="form_item" style="float:left">
							<label>Email&nbsp;</label>
							<input name="username" type="text" class="input1" id="username"/>
							</div>
                        <input type="submit" value="Send Password" class="input_continue" name="signin" style="width: 90px !important;">
			</form>	
<? else : ?>
<?php $i=0;
$arr1 = $this->session->userdata('profile_name');
if(!empty($other_profiles)) {
	$size=sizeof($other_profiles);
	foreach($other_profiles as $artist){  $i++;?>
	<form method="post" <?php if($i>1) echo 'style="display:none;"'; ?> id="<?php echo $i; ?>">
	<?php if($i!=$size) echo '<a href="javascript:void(0);" class="next">next</a>'; ?>&nbsp; &nbsp;
	<?php if($i!=1) echo '<a href="javascript:void(0);" class="prev">prev</a>'; ?>&nbsp; &nbsp;
	<input style="background-image:none" type="button" value="Edit Profile <?=$i?>" class="input_continue" name="edit_profile" onclick="window.location='<?=base_url()?>artist/step1/<?= $artist['id']?>'" /> &nbsp; &nbsp;
	<input style="background-image:none" type="button" value="Profile <?=$i?>" class="input_continue" name="signin" onclick="window.location='<?=base_url()?>profile/view/<?= $artist['id']?>'" /> &nbsp; &nbsp;
	<input style="background-image:none" type="button" value="Logout" class="input_continue" name="signin" onclick="window.location='<?=base_url()?>user/logout'"/>
	</form>
	<?php } ?>
<?php }
else if($this->session->userdata('artists')!='') {
 foreach($this->session->userdata('artists') as $artist){ $i++;?>
 <form method="post">
<input style="background-image:none" type="button" value="Edit Profile <?=$i?>" class="input_continue" name="edit_profile" onclick="window.location='<?=base_url()?>artist/step1/<?= $artist?>'" /> &nbsp; &nbsp;
<input style="background-image:none" type="button" value="Profile <?=$i?>" class="input_continue" name="signin" onclick="window.location='<?=base_url()?>profile/view/<?= $artist?>'" /> &nbsp; &nbsp;
<input style="background-image:none" type="button" value="Logout" class="input_continue" name="signin" onclick="window.location='<?=base_url()?>user/logout'"/></form>
<?php } 
}?>
<? endif; ?>
</div>
<script>
$(function(){
	$('.next').click(function(){
		$f=$(this).parents('form')
		$f.slideUp();
		$n=parseInt($f.attr('id'))+1;
		$('form#'+$n).slideDown();
	});
	$('.prev').click(function(){
		$f=$(this).parents('form')
		$f.slideUp();
		$n=parseInt($f.attr('id'))-1;
		$('form#'+$n).slideDown();
	});
});
</script>