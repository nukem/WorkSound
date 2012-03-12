<header class="clearfix">
<div id="header">
		<div class="header_inside">
			<div class="logo"><a href="<?=base_url()?>"><img src="<?=base_url()?>images/logo.gif" alt="" /></a></div>
			
			<ul class="nav">
				<li><a href="<?=base_url()?>">Home</a></li>
				<li><a href="<?=base_url()?>book" class="highlight">Book an Artist</a></li>
				<li><a href="<?=base_url()?>artist/register" class="highlight">Join as an Artist</a></li>
				<li><a href="<?=base_url()?>about">About</a></li>
				<li><a href="<?=base_url()?>faq">FAQ</a></li>
				<li class="last"><a href="<?=base_url()?>contact">Contact</a></li>
			</ul>  
			
			<a href="javascript: void(0);"  onclick="$('#login_box').slideToggle()" class="btn_login">Login</a>
			
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
    background: none repeat scroll 0 0 #FF5C32;
	padding:5px;
	color:#fff;
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
<div id="login_box" style="display: none;">
<form method="post" action="<?=base_url()?>webpublisher/">
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

</div>
