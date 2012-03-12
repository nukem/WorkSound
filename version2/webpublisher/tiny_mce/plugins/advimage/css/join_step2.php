<?php 
session_start();
$cfg['db']['address'] = "localhost:3306";
$cfg['db']['username'] = "soundbooka_user";
$cfg['db']['password'] = "password123";
$cfg['db']['name'] = "soundbooka";

if (preg_match('/^(sound.lk)/', $_SERVER['HTTP_HOST'])) {
$cfg['db']['address'] = "localhost";
$cfg['db']['username'] = "root";
$cfg['db']['password'] = "root";
$cfg['db']['name'] = "sound";	
}

$link = mysql_connect($cfg['db']['address'],$cfg['db']['username'],$cfg['db']['password']);
$db = mysql_select_db($cfg['db']['name']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>SoundBooka</title>
		
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="MSSmartTagsPreventParsing" content="true" />
		<meta http-equiv="imagetoolbar" content="no" />
		<meta name="robots" content="index, follow" />
			
		<link rel="stylesheet" type="text/css" href="css/screen.css" />
		<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css' />
		
		<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
		<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
		<script type="text/javascript" src="js/jquery.ui.core.js"></script>
		<script type="text/javascript" src="js/jquery.ui.widget.js"></script>
		<script type="text/javascript" src="js/jquery.ui.mouse.js"></script>
		<script type="text/javascript" src="js/jquery.ui.slider.js"></script>
		

		<script type="text/javascript">
			$(document).ready( function(){
				$("select, input:checkbox, input:radio, input:file").uniform();
				
				$( "#slider1" ).slider({
					range: "min",
					value: 400,
					min: 50,
					max: 2000,
					slide: function( event, ui ) {
						$( "#slider1 a span" ).html( '$'+ui.value );
					}
				});
				
				
				$( "#slider2" ).slider({
					range: "min",
					value: 400,
					min: 50,
					max: 2000,
					slide: function( event, ui ) {
						$( "#slider2 a span" ).html( '$'+ui.value );
					}
				});
				
				
				//tooltip
				$('.bubble_info').each(function () {
					// options
					var distance = 12;
					var time = 100;
					var hideDelay = 100;
					var hideDelayTimer = null;
				
					// tracker
					var beingShown = false;
					var shown = false;
					
					var trigger = $('.img_ask', this);
					var popup = $('.popup', this).css('opacity', 0);
				
					// set the mouseover and mouseout on both element
					$([trigger.get(0), popup.get(0)]).mouseover(function () {
					  // stops the hide event if we move from the trigger to the popup element
					  if (hideDelayTimer) clearTimeout(hideDelayTimer);
				
					  // don't trigger the animation again if we're being shown, or already visible
					  if (beingShown || shown) {
						return;
					  } else {
						beingShown = true;
				
						// reset position of popup box
						popup.css({
						  //bottom: 50,
						  //left: -65,
						  display: 'block' // brings the popup back in to view
						})
				
						// (we're using chaining on the popup) now animate it's opacity and position
						.animate({
						  //bottom: '-=' + distance + 'px',
						  opacity: 1
						}, time, 'swing', function() {
						  // once the animation is complete, set the tracker variables
						  beingShown = false;
						  shown = true;
						});
					  }
					}).mouseout(function () {
					  // reset the timer if we get fired again - avoids double animations
					  if (hideDelayTimer) clearTimeout(hideDelayTimer);
					  
					  // store the timer so that it can be cleared in the mouseover if required
					  hideDelayTimer = setTimeout(function () {
						hideDelayTimer = null;
						popup.animate({
						  //bottom: '-=' + distance + 'px',
						  opacity: 0
						}, time, 'swing', function () {
						  // once the animate is complete, set the tracker variables
						  shown = false;
						  // hide the popup entirely after the effect (opacity alone doesn't do the job)
						  popup.css('display', 'none');
						});
					  }, hideDelay);
					});
				  });
				
				$('.profile_type').click(function() {
					//alert($(this).val());
					$('.option_col').hide();
					$('.at_'+$(this).val()).fadeIn();
				})
				
			});
		</script>
		
	</head> 

	<body>
		<div id="header">
		<div class="header_inside">
			<div class="logo"><a href="#"><img src="images/logo.gif" alt="" /></a></div>
			
			<ul class="nav">
				<li><a href="#">Home</a></li>
				<li><a href="#" class="highlight">Book An Artist</a></li>
				<li><a href="#" class="highlight">Join As An Artist</a></li>
				<li><a href="#">Home</a></li>
				<li><a href="#">About</a></li>
				<li><a href="#">Faq</a></li>
				<li class="last"><a href="#">Contact</a></li>
			</ul>  
			
			<a href="#" class="btn_login">Login</a>
			
			<form action="#" class="search_form">
			<fieldset>
				<input type="text" class="input_txt" value="Search" onblur="if(this.value=='') this.value='Search';" onfocus="if(this.value=='Search') this.value='';" />
				<input type="submit" class="input_send" value="" />
			</fieldset>
			</form>
		</div>
		</div><!--end of header-->
		
		
		<div id="content">
			<h1>Join as an Artist</h1>
			
			<div class="step step2">step</div>
			<div class="line_help"><a href="#">click here for help</a></div>

			<form action="join_step3.php" class="uniform">
			<fieldset>
				<h2>STEP 2/6 - ARTIST SETUP</h2>
				<div class="form_title">Now, let’s hear more about you!</div>
				<div class="form_block">

					<p>
						The information you enter here will allow you to play the gigs you want to play. It will form the information that will be displayed on your Soundbooka Profile Page.
						<strong class="bubble_info">
							<img src="images/ico_ask.gif" alt="" class="img_ask" />
							<strong class="popup"><b>arrow</b><em>Your Profile Page will be visible to visitors to soundbooka.com. Your Soundbooka Profile Page displays performance information and acts as your performance resume.</em></strong>
						</strong>
					</p>


					<div class="form_row">
						<div class="form_item">
							<label>
								Profile Name <span>*</span>
								<strong class="bubble_info">
									<img src="images/ico_ask.gif" alt="" class="img_ask" />
									<strong class="popup"><b>arrow</b><em>Your Profile Name is the name you perform under. This name will be displayed on your Profile Page and appear in search results.</em></strong>
								</strong>
							</label>
							<input type="text" class="input1" value="Stage Name" />
						</div>
						
						<div class="form_item">
							<label>Profile Type <span>*</span></label>
							<div class="options">
								<?php 
								$result = mysql_query("select * from artist_type where active=1");
								while($row=mysql_fetch_array($result)){
								?>
								<label>
									<input type="radio" name="profile_type" class="profile_type"value="<?php echo $row['artist_id'];?>"/>
									<strong><?php echo $row['type'];?></strong>
								</label>
								<?php } ?>
							</div>
						</div>
						<br class="cl" />
					</div><!--end of form_row-->

				</div><!--end of form_block-->
				
				
				<div class="form_title">
					Your Pictures <span>*</span>
					<strong class="bubble_info">
						<img src="images/ico_ask.gif" alt="" class="img_ask" />
						<strong class="popup"><b>arrow</b><em>Soundbooka allows you to upload a maximum of five (5) images to your Soundbooka Profile Page. From these images you’re able to select one as your Profile Picture. This will be displayed in the search results. By uploading a file you certify that you have the right to distribute the picture and that it does not violate the Soundbooka <a href="#">User Agreement</a>.</em></strong>
					</strong>
				</div>
				<p>Please select the images you want to upload to your Soundbooka Profile Page.</p>
				
				<div class="form_row">
					<ul class="user_pic_list">
						<li>
							<img src="images/default_person.gif" alt="" />
							<span>Profile Pic</span>
							<span><a href="#">Remove</a></span>
						</li>
						<li>
							<img src="images/default_person.gif" alt="" />
							<span><a href="#">Set as profile</a></span>
							<span><a href="#">Remove</a></span>
						</li>
						<li>
							<img src="images/default_person.gif" alt="" />
							<span><a href="#">Set as profile</a></span>
							<span><a href="#">Remove</a></span>
						</li>
						<li>
							<img src="images/default_person.gif" alt="" />
							<span><a href="#">Set as profile</a></span>
							<span><a href="#">Remove</a></span>
						</li>
						<li>
							<img src="images/default_person.gif" alt="" />
							<span><a href="#">Set as profile</a></span>
							<span><a href="#">Remove</a></span>
						</li>
					</ul>
					
					<div class="form_item">
						<label>Upload your pictures <span>*</span></label>
						<input type="file" />
						<em>Select an image file on your computer (max 4 MB)</em>
					</div>
					<br class="cl" />
				</div><!--end of form_row-->
				
				
				
				<div class="shadow_line">line</div>
				
				<div class="form_title">
					Genres <span>*</span>
					<strong class="bubble_info">
						<img src="images/ico_ask.gif" alt="" class="img_ask" />
						<strong class="popup"><b>arrow</b><em>We cater to every type of preforming artist on Soundbooka. By selecting the genres that best describe your sound we can provide you with the gigs that best match your skill set.</em></strong>
					</strong>
				</div>
				<div class="form_block">
					<p>Please select the genres that best describe your sound (max 5)</p>
					<div class="form_row">
						
							<?php 
								$result = mysql_query("select * from genre");
								$genres = array();
								while($row=mysql_fetch_array($result)){
									$genres[$row['artist_type']][] = array('id'=>$row['genre_id'],'genre'=>$row['genre']);
								}
								//print_r($genres);die;
								foreach ($genres as $at=>$gs) {
									
								?>
								<div class="option_col at_<?=$at?>" style="display:none">
									<? foreach ($gs as $g) {?>
										<div class="option">
											<label>
												<input type="checkbox" class="id_<?=$g['id']?>" />
												<strong><?php echo $g['genre'];?>-<?=$g['id']?></strong>
											</label>
										</div>
                                    <? } ?>
								<br class="cl" />
								</div><!--end of option_col-->
                                
								<?php } ?>
						
						
				</div><!--end of form_block-->
				
				<div class="shadow_line">line</div>
				
				<div class="form_title">Instruments</div>
				<div class="form_block">
					<p>What type of instrument do you play?</p>
					<div class="form_row">
						<div class="form_item">
							<label>Please select your instrument <span>*</span></label>
							<div class="simu_select1">
								<select>
									<option>Start by typing your instrument...</option>
									<option>option1</option>
									<option>option2</option>
									<option>option3</option>
								</select>
							</div>
						</div>
						
						<div class="form_item">
							<label>
								Description
								<strong class="bubble_info">
									<img src="images/ico_ask.gif" alt="" class="img_ask" />
									<strong class="popup"><b>arrow</b><em>Here you can describe your sound. You might be a guitarist who has a bluesy edge or be a singer with a soulful groove. Include this information in 25 words or less.</em></strong>
								</strong>
							</label>
							<input type="text" class="input1" />
						</div>
						
						<a href="#" class="btn_add">Add</a>
						<br class="cl" />
					</div><!--end of form_row-->
					
					<table class="instrument_table">
					  <tr>
					    <th width="32%">Instruments I play</th>
					    <th width="57%">Comments</th>
					    <th width="11%">&nbsp;</th>
					  </tr>
					  <tr>
					    <td>Guitar (acoustic)</td>
					    <td>With a spanish flair</td>
					    <td class="td_link"><a href="#">remove</a> | <a href="#">edit</a></td>
					  </tr>
					  <tr class="tr_even">
					    <td>Guitar (electric)</td>
					    <td>A bit more blusey</td>
					    <td class="td_link"><a href="#">remove</a> | <a href="#">edit</a></td>
					  </tr>
					  <tr>
					    <td>Tenor Saxophone</td>
					    <td>Blues solos and brass hits</td>
					    <td class="td_link"><a href="#">remove</a> | <a href="#">edit</a></td>
					  </tr>
					</table>
				</div><!--end of form_block-->
				
				
				<div class="form_title">Equipment</div>
				<div class="form_block">
					<p>Do you supply your own equipment when you perform or do you require it to be supplied?</p>
					<div class="options">
						<label>
							<input type="checkbox" checked="checked" />
							<strong>I perform on my own equipment</strong>
						</label>
						
						<label>
							<input type="checkbox" />
							<strong>I require equipment to perform</strong>
						</label>
					</div>
				</div><!--end of form_block-->
				
				<div class="shadow_line">line</div>
				
				<div class="form_title">Preferred Gig</div>
				<div class="form_block">
					<p>Where do you most like to perform?</p>
					<div class="form_row">
						<label>Please select</label>
						<div class="simu_select1">
							<select>
								<option>-- Any --</option>
								<option>option1</option>
								<option>option2</option>
							</select>
						</div>
						<br class="cl" />
					</div>
				</div><!--end of form_block-->
				
				
				<div class="form_title">
					Performance Fee
					<strong class="bubble_info">
						<img src="images/ico_ask.gif" alt="" class="img_ask" />
						<strong class="popup"><b>arrow</b><em>This is how much you charge to perform. Soundbooka will deduct their Fee from this amount. You can select how much you charge per hour or per gig/session. All amounts are in $AUD.</em></strong>
					</strong>
				</div>
				<div class="form_block">
					<div class="note_box"><span>arrow</span>At no time will your Performance Fee be displayed to the public or bookers.</div>
					<p>Where do you most like to perform?</p>
					<div class="form_row">
						<div class="form_item">
							<label>What is your minimum fee per hour?</label>
							<div class="slider" id="slider1"></div>
						</div>
						
						<div class="form_item">
							<label>What is your minimum fee per gig/session?</label>
							<div class="slider" id="slider2"></div>
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
					
					<div class="form_row">
						<div class="form_item">
							<label>Minimum hours per Gig</label>
							<div class="simu_select5">
								<select>
									<option>option1</option>
									<option>option2</option>
									<option>option3</option>
								</select>
							</div>
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
					
				</div><!--end of form_block-->
				
				<div class="shadow_line">line</div>
				
				<div class="form_title">Availability</div>
				<div class="form_block">
					<div class="form_row">
						<div class="form_item">
							<label>When are you available to perform? <span>*</span></label>
							<div class="options">
								<label>
									<input type="checkbox" checked="checked" />
									<strong>mon</strong>
								</label>
								
								<label>
									<input type="checkbox" checked="checked" />
									<strong>tue</strong>
								</label>
								
								<label>
									<input type="checkbox" checked="checked" />
									<strong>wed</strong>
								</label>
								
								<label>
									<input type="checkbox" checked="checked" />
									<strong>thu</strong>
								</label>
								
								<label>
									<input type="checkbox" checked="checked" />
									<strong>fri</strong>
								</label>
								
								<label>
									<input type="checkbox" checked="checked" />
									<strong>sat</strong>
								</label>
								
								<label>
									<input type="checkbox" checked="checked" />
									<strong>sun</strong>
								</label>
								
							</div>
						</div><!--end of form_item-->
						<br class="cl" />
					</div><!--end of form_row-->
				</div><!--end of form_block-->
				
				
				<div class="form_title">
					Management
					<strong class="bubble_info">
						<img src="images/ico_ask.gif" alt="" class="img_ask" />
						<strong class="popup"><b>arrow</b><em>If you are a performer that has a manager or is represented by a management agency please fill out the required fields. Soundbooka will include your management on all communications.</em></strong>
					</strong>
				</div>
				<div class="form_block">
					<p>Do you have a manager?</p>
					<div class="form_row">
						<div class="form_item">
							<label>Please Select <span>*</span></label>
							<div class="options">
								<label>
									<input type="radio" name="have_manager" checked="checked" />
									<strong>yes</strong>
								</label>
								
								<label>
									<input type="radio" name="have_manager" />
									<strong>no</strong>
								</label>
							</div>
						</div><!--end of form_item-->
						
						<div class="form_item">
							<label>Manager Name <span>*</span></label>
							<input type="text" class="input6" />
						</div><!--end of form_item-->
						
						<div class="form_item">
							<label>Manager Email <span>*</span></label>
							<input type="text" class="input6" />
						</div><!--end of form_item-->
						
						<div class="form_item">
							<label>Manager contact number <span>*</span></label>
							<input type="text" class="input6" />
						</div><!--end of form_item-->
						
						<br class="cl" />
					</div><!--end of form_row-->
				</div><!--end of form_block-->
				
				
				<div class="form_title">
					Do you have insurance?
					<strong class="bubble_info">
						<img src="images/ico_ask.gif" alt="" class="img_ask" />
						<strong class="popup"><b>arrow</b><em>Unless waived by the Booker, you will be required to have your own current public liability insurance for each Gig. If you do not have public liability insurance, you will not be able to perform at venues that require you to have public liability insurance. Soudbooka requires Artists to provide details of public liability insurance to be able to accept Gigs requiring public liability insurance.</em></strong>
					</strong>
				</div>
				<div class="form_block">
					<div class="form_row">
						<div class="form_item">
							<label>Please Select <span>*</span></label>
							<div class="options">
								<label>
									<input type="radio" name="have_insurance" checked="checked" />
									<strong>yes</strong>
								</label>
								
								<label>
									<input type="radio" name="have_insurance" />
									<strong>no</strong>
								</label>
							</div>
						</div><!--end of form_item-->
						
						<br class="cl" />
					</div><!--end of form_row-->
				</div><!--end of form_block-->
				
				<div class="shadow_line">line</div>
				
				<input type="submit" value="Save &amp; Continue" class="input_continue" />
				
				<a href="join_step1.php" class="btn_back2">Back</a>
				
				<br class="cl" />

			</fieldset>
			</form>
			
			<br class="cl" />
		</div><!--end of content-->
		
		
		<div id="footer">
		<div class="footer_inside">
			<div class="foot_links">
				<div class="links_row">
					<span>Quick Links:</span>
					<a href="#">HOME</a> |
					<a href="#">JOIN AS AN ARTIST</a> |
					<a href="#">BOOK AN ARTIST</a> |
					<a href="#">ABOUT</a> |
					<a href="#">FAQ</a> |
					<a href="#">CONTACT</a>
				</div>
				
				<div class="links_row">
					<span>Legal:</span>
					<a href="#">PRIVACY POLICY</a> |
					<a href="#">TERMS &amp; CONDITIONS</a> |
					<a href="#">ARBITRATION</a> |
					<a href="#">LEGAL INFO</a>
				</div>
			</div><!--end of foot_links-->
			
			<div class="foot_copyright">
				<p><img src="images/foot_logo.gif" alt="" /></p>
				<p>©  2011 Soundbooka Pty Ltd - All rights Reserved</p>
			</div>
		</div>
		</div><!--end of footer-->
		
	
		<!--[if lt IE 7]>
			<script type="text/javascript" src="js/dd_belatedpng.js"></script>
			<script type="text/javascript">
				DD_belatedPNG.fix('img, .png_bg');
			</script>
		<![endif]-->
	
	
	</body>

</html>