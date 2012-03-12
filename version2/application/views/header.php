
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
var baseurl = '<?=base_url()?>';
</script>
<header class="clearfix">
<div id="header" style="margin:0px auto; text-align:center;">
		<div class="header_inside" style="text-align:left;">
			<div class="logo"><a href="<?=base_url()?>"><img src="<?=base_url()?>images/logo.gif" alt="" /></a></div>	
			<ul class="nav">
				<li><a href="<?=base_url()?>">Home</a></li>
				<li><a href="<?=base_url()?>book" class="highlight">Book an Artist</a></li>
                <? //if ($this->session->userdata('is_loged')) : ?>  
			 
                <? //else : ?>
                <li><a href="<?=base_url()?>artist/register" class="highlight">Join as an Artist</a></li>
				<li><a href="<?=base_url()?>booka/register" class="highlight">Join as a Booker</a></li>
                <? //endif; ?>
				<li><a href="<?=base_url()?>about">About</a></li>
				<li><a href="<?=base_url()?>faq">FAQ</a></li>
				<li><a href="<?=base_url()?>contact">Contact</a></li>
			</ul>  
			<?php 
			$test = $this->session->userdata('is_loged');
			// echo '<div style="display:none;">'; print_r($test); echo '</div>';
					$test_id = $this->session->userdata('artist_id');
					$ids = $this->session->userdata('artists');
					$uri_test = $this->uri->segment(3);
					$uri_test = str_replace('_',' ',$uri_test);
					$profile_names = $this->session->userdata('profile_name');
					if($test  == '1' && !empty($test)){
						?><a href="javascript: void(0);"  onclick="$('#login_box').slideToggle()" class="btn_login">Logout</a>
			<?php } else {
				if($uri_test > 0){
				$this->session->set_userdata('is_loged', false); 
				$this->session->set_userdata('artist', null);
				$test_id = '';
				}

			?>
			<a href="javascript: void(0);"  onclick="$('#login_box').slideToggle();$('#login').slideDown();$('#forgot').slideUp(); " class="btn_login">Login</a>
			<?php } ?>
			<!--webpublisher/<form action="#" class="search_form">
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
  
            <div class="show-compact" style="float:left;width:360px;display:none;">
                        <div class="form_item gi_but" style="border-radius: 5px 5px 5px 5px; padding:0px 0px 0px 90px;  float:left "> <a href="<?=base_url()?>booka/register" class="highlight">Join as a Booker</a></div>                       
                        <div class="form_item" style="float:right; padding:2px 0px 0px 5px;">
                            <img src='../../images/spacer.gif' height='5px;' width='1px;'>
                            <label>OR </label>
                            <img src='../../images/spacer.gif' height='5px;' width='5px;'>
                            <label> Login</label>
                        </div> 
                        </div>
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
<?php 
	$i=0;
	//count for notification
	if($this->session->userdata('profile_type') == 'artist'){
		$values = 'a';
	}else{
		$values = 'b';
	}
	$sql_count = "select count(*) n from notifications noti LEFT JOIN manage_gigs gig ON noti.gig_id = gig.gig_id JOIN artist_gig_map agm ON agm.gig_id = gig.gig_id where noti.".$this->session->userdata('profile_type')."_id = '{$this->session->userdata('artist_id')}' and noti.is_view".$values."= '0'";
	
	$query_count = $this->db->query($sql_count);      
	
	$nofitication = $query_count->result_array();      
	
	$this->session->set_userdata('count_notification',$nofitication[0]['n']);
	if($this->session->userdata('artists')!='') {
// foreach($this->session->userdata('artists') as $artist){ $i++;?>
 <form method="post">
<?php 

//if($this->session->userdata('profile_type') == 'artist'){  
if($this->session->userdata('count_notification')!=0){
 ?>
  <a style="text-decoration:none; padding:2pt 25px 5pt !important; width: 109px !important;float: none;text-indent: 0;color:#fff;background-image:none;text-align:center; margin-right:10px;" href="<?=base_url()?><?= $this->session->userdata('profile_type')?>/view_notification/<?= $this->session->userdata('artist_id')?>" class="input_continue button">Notifications (<span style="color:#ff5c32;"><?php echo $this->session->userdata('count_notification'); ?></span>)</a>    &nbsp;
 
<?php  }else{ ?>

   <a style="text-decoration:none; padding:2pt 25px 5pt !important; width: 109px !important;float: none;text-indent: 0;color:#fff;background-image:none;text-align:center; margin-right:10px;" href="<?=base_url()?><?= $this->session->userdata('profile_type')?>/notification/<?= $this->session->userdata('artist_id')?>" class="input_continue button">Notifications </a>    &nbsp;
 


<?php }

 //}
 ?>
<input style="background-image:none;width: 99px !important;" type="button" value="Personal Info" class="input_continue" name="signin" onclick="window.location='<?=base_url()?><?= $this->session->userdata('profile_type')?>/personal_info/<?= $this->session->userdata('artist_id')?>'" /> &nbsp; &nbsp;
<?php if($this->session->userdata('profile_type') == 'booka'){ ?>
<input style="background-image:none;width: 109px !important;" type="button" value="My Favourites" class="input_continue" name="favourite" onclick="window.location='<?=base_url()?><?= $this->session->userdata('profile_type')?>/manage_favourite/<?= $this->session->userdata('artist_id')?>'" /> &nbsp; &nbsp;
<?php } if($this->session->userdata('profile_type') == 'booka'){ ?>
<input style="background-image:none;width: 90px !important;" type="button" value="My Gigs" class="input_continue" name="gig" onclick="window.location='<?=base_url()?><?= $this->session->userdata('profile_type')?>/manage_gig/<?= $this->session->userdata('artist_id')?>'" /> &nbsp; &nbsp;
<?php } else if($this->session->userdata('profile_type') == 'artist'){?>
<input style="background-image:none;width: 90px !important;" type="button" value="My Gigs List" class="input_continue" name="gig" onclick="window.location='<?=base_url()?><?= $this->session->userdata('profile_type')?>/manage_gig_list/<?= $this->session->userdata('artist_id')?>'" /> &nbsp; &nbsp;
<?php } ?>
<input style="background-image:none;width: 90px !important;" type="button" value="Calendar" class="input_continue" name="gig" onclick="window.location='<?=base_url()?>booka/calender/<?= $this->session->userdata('artist_id')?>'" /> &nbsp; &nbsp;
<input style="background-image:none;width: 90px !important;" type="button" value="My Profiles" class="input_continue" name="signin" onclick="window.location='<?=base_url()?><?= $this->session->userdata('profile_type')?>/manage_profile/<?= $this->session->userdata('artist_id')?>'" /> &nbsp; &nbsp;
<input style="background-image:none;width: 90px !important;" type="button" value="Settings" class="input_continue" name="settings" onclick="window.location='<?=base_url()?><?= $this->session->userdata('profile_type')?>/settings/<?= $this->session->userdata('artist_id')?>'" /> &nbsp; &nbsp;
<input style="background-image:none" type="button" value="Logout" class="input_continue" name="signin" onclick="window.location='<?=base_url()?>user/logout'"/></form>
<?php //} 
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

