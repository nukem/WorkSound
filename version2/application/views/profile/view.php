<link href="<?= base_url() ?>css/style-inner.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?= base_url() ?>css/font/stylesheet.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?= base_url() ?>css/jquery.jscrollpane.css" rel="stylesheet" type="text/css" media="screen" />
<!--[if lte IE 6]>
	<script type="text/javascript" src="js/dd_belatedpng_0.0.8a-min.js"></script>
	<script type="text/javascript" src="js/iefix.js"></script>
<![endif]-->
<!--[if lte IE 7]>
	<link href="css/ie.css" rel="stylesheet" type="text/css" media="screen" />
<![endif]-->
<script src="<?= base_url() ?>js/main.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/curvycorners.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/jquery.jscrollpane.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/jquery.mousewheel.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/jquery.cycle.lite.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/flowplayer-3.2.6.min.js" type="text/javascript"></script>
<script type="text/javascript">
		$(function()
			{
				$('.scroll-pane').jScrollPane(
					{
						showArrows: true
					}
				);
			});
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/audio-player.js"></script>  
<script type="text/javascript">  
	AudioPlayer.setup("<?php echo base_url(); ?>swf/player.swf", {  
		width: 405,animation : 'no'
	});  
</script>  
<style>
#content {overflow:auto}
#book_box {
    background: none repeat scroll 0 0 #D1D1D1;
	padding:8px;
	color:#000;
	overflow:auto;
}
#book_box input {
	width:100px!important;
	float:none;
	text-indent:0px;
}
#book_box form{
    margin: 0 auto;
    width: 940px;
	text-align:right
}
#book_box input[type=submit] {
	width:72px!important;
	background:none;
	background-color:#515050;
	font-size: 12px;
}
#book_box input[type=submit]:hover {
	background-color:#3d3c3c;
}
.button_continue {
    background: url("../images/ico_arrow.gif") no-repeat scroll 94% 8px #ff5c32;
    border: 0 none;
    border-radius: 5px 5px 5px 5px;
    color: #FFFFFF;
    cursor: pointer;
    float: right;
    font-family: 'Lato',Arial,Helvetica,sans-serif;
    height: 26px;
    padding-bottom: 3px;
    text-indent: -10px;
    width: 140px;
	height: 20px;
    margin-right: 21px;
    margin-top: -2px;
    text-align: center;
	text-indent: 3px;
    width: 142px !important;
}
.newright a{
color: #FFFFFF !important;
cursor: pointer;
}
.newright a:hover{
color: #FFFFFF !important;
cursor: pointer;
}
</style>
<script>
$(function(){
	$('.book_artist').click(function(){
		$box=$('#book_box');
		if($box.css('display')=='block') {
			$box.slideUp().delay(800).html('');
		}
		else{
			$box.slideDown();
			$box.empty().html('<div style="width:100px;height:25px;overflow:hidden;"><img src="<?php echo base_url();?>images/ajax-loader.gif" style="margin-top:-36px;" /></div>');
			$.post('<?php echo base_url();?>ajax/gigs/<?=$id?>',{},function(data){
				$box.html(data);
			})
		}
	});
	$('#add_fav').click(function(){
		$.post('<?php echo base_url();?>ajax/add_favourite/',{'artist_id':'<?=$id?>', 'booka_id':$('#bookaid').val()},function(data){
			
		})
	});
      $('.booka_artist').click(function() {
        alert('Please login with your Booker Account to making bookings');
        return false;
     	});
});
</script>
					<div class="features">
								<div class="block-bar" style="margin:0;">
										<div class="left">
												<h2><?=$profile_name?>(<?=$types[$profile_type]?>)</h2>
												
										</div>
										
										<div class="right">
												<span class="btn"><a href="javascript:void(0);" onClick="parent.history.back();"><img src="<?=base_url()?>images/buttons/back-btn.png" alt="back to list" width="91" height="22" /></a></span>
										</div>
										<div class="right">
                                        <?php if($this->session->userdata('profile_type')=='booka') { ?>
										<a class="btn_back book_artist" id="book_artist" title="Book Artist" alt="Book Artist" href="javascript: void(0);" style="width: 55px !important; margin-top: 0px !important;">Book</a>
										<?php }else{ ?>
                                        <a class="btn_back"  onclick="$('#login_box').slideToggle();$('.show-compact').slideDown();$('#login').slideDown();$('#forgot').slideUp(); " id="book_artist" title="Book Artist" alt="Book Artist"  href="javascript: void(0);"  style="width: 55px !important;margin-top: 0px !important;">Book</a>
                                        <?php } ?>
										</div>
										<div class="right newright">
                                        
										<?php if($this->session->userdata('profile_type')=='booka') { ?>
                                        
										<input type="hidden" value="<?php echo $this->session->userdata('artist_id'); ?>" id="bookaid"/>
                                        
										<a class="fav button_continue"  id="add_fav" title="Add to Favourite" alt="Add to Favourite" href="javascript: void(0);" style="width: 155px !important; margin-top: 0px !important;padding:1px;">Add to Favourite</a>
                                        
										<?php }else{ ?>                                        
                                        	<a class="fav button_continue" onclick="$('#login_box').slideToggle();$('.show-compact').slideDown();$('#login').slideDown();$('#forgot').slideUp(); "  id="add_fav" title="Add to Favourite" alt="Add to Favourite" style="width: 155px !important; margin-top: 0px !important;padding:1px;">Add to Favourite</a>
                                        <?php } ?>
										</div>
										
										
								</div>
								<div id="book_box" style="display: none;">
										
								</div>
								<div style="margin:9px 0 0 0;width:100%;"></div>
								<div class="gallery">
										<div class="block-content">
												<div class="full">
                                                <div id="slideshow">
												<?php if(count($images) > 0){ ?>
                                                <? foreach ($images as $i) : ?>
                                                <img src="http://www.soundbooka.com/resize/?f=<?=urlencode($i->id.'-medium.jpg') ?>&w=216&h=154" alt="artist" />
                                                <? 
													//break;
												endforeach; ?>
												<?php } else {
													echo '<img src="http://www.soundbooka.com/images/dj-border.jpg" height= "154" alt="artist" width="216" />';
												}?>
                                                </div>
												</div>
												<!--<div class="thumbs">
														<ul>
																<li><a href="#"><img src="<?= base_url() ?><?= (isset($images[1])) ? 'wpdata/images/'. $images[1]->id.'-thumb.jpg' : 'images/default_person.gif' ?>" alt="thumbs" width="80" /></a></li>
																<li><a href="#"><img src="<?= base_url() ?><?= (isset($images[2])) ? 'wpdata/images/'. $images[2]->id.'-thumb.jpg' : 'images/default_person.gif' ?>" alt="thumbs" width="80" /></a></li>
																<li><a href="#"><img src="<?= base_url() ?><?= (isset($images[3])) ? 'wpdata/images/'. $images[3]->id.'-thumb.jpg' : 'images/default_person.gif' ?>" alt="thumbs" width="80" /></a></li>
																<li><a href="#"><img src="<?= base_url() ?><?= (isset($images[4])) ? 'wpdata/images/'. $images[4]->id.'-thumb.jpg' : 'images/default_person.gif' ?>" alt="thumbs" width="80" /></a></li>
														</ul>
												</div>-->
												
												  <div id="box" >
												  
													
													<?php if(!empty($facebook)){?>
													<a onClick="window.open('<?php echo $facebook; ?>','mywindow','menubar=1,resizable=1,width=600,height=600,left=500,top=300,scrollbars=1');" alt="Facebook" title="Facebook" style="cursor:pointer;"><div id="img1"></div></a>
													<?php }
													else { echo '<div id="img1" alt="Facebook" title="Facebook"></div>'; } 
													?>
													
													
													<?php if(!empty($twitter)){?>
													<a onClick="window.open('<?php echo $twitter; ?>','mywindow','menubar=1,resizable=1,width=600,height=600,left=500,top=300,scrollbars=1');" alt="Twitter" title="Twitter" style="cursor:pointer;"><div id="img2" alt="Twitter" title="Twitter"></div></a>
													<?php }
													else { echo '<div id="img2" alt="Twitter" title="Twitter"></div>'; } ?>
													
													<?php if(!empty($plot)){?>
													<?php //echo ../plot/$id; ?>
													<a onClick="window.open('<?php echo $plot; ?>','mywindow','menubar=1,resizable=1,width=600,height=600,left=500,top=300,scrollbars=1');" alt="Stage Plot/Tech Rider" title="Stage Plot/Tech Rider" style=" cursor:pointer;"><div id="img3"></div></a>
													<?php }
													else { echo '<div id="img3" alt="Stage Plot/Tech Rider" title="Stage Plot/Tech Rider"></div>'; }?>
													
													<div id="img4" alt="Calender" title="Calender"></div>
													
												  </div>
												
										</div>
								</div>
								<div class="details">
										<div class="block-content" style="overflow:auto">
												<div class="info">
														<div class="info-left">
																<div class="block-box" style="height:69px !important;">
																		<h5>Location:</h5>
																		<div id="location" class="scroll-content">
																		<div class="scroll-pane">
																		<p><?=$suburb?>, <?=$states[$state]?> <?=$postcode?><br /><span class="highlight">(Can travel: <?=trim((($travel_city) ? 'Within home city, ' : '') . (($travel_state) ? 'Within home state, ' : '') . (($travel_interstate) ? 'Interstate, ' : '') . (($travel_international) ? 'International, ' : ''), ", ")?>)</span></p>
																		</div>
																		</div>
																</div>
																<div class="block-box">
																<?php if($profile_type==10): 
																		echo "<h5>Minimum Performance Time</h5>"; 
																	  else: 
																		echo "<h5>Minimum Set Time</h5>"; 
																	  endif;
																?>
																		<p><?php if($gig_hours) echo $gig_hours.'hours'; else echo 'N/A'; ?> </p>
																</div>
																<?php 
																if(!empty($specialization)){
																$test = explode(',',$specialization);
																}
																if($profile_type==10){ ?>
																<div class="block-box">
																		<h5>Specialisation:</h5>
																		<div id="genres" class="scroll-content">
																				<div class="scroll-pane">
																						<ul>
																						<?php
																						if(!empty($test)){
																							foreach($test as $key => $val){
																								echo '<li>'.$specializations[$val].'</li>';
																							}
																						}
																						?>								
																						</ul>
																				</div>
																		</div>
																</div>
																<?php } else{ 
																?>
																<div class="block-box">
																		<h5>Genres:</h5>
																		<div id="genres" class="scroll-content">
																				<div class="scroll-pane">
																						<ul>
																						<?php
																						$generic_values = explode(',',$genre1);
																						
																						
																							foreach($generic_values as $ke => $va){
																								
																								if($va != '99999'){
																								echo '<li>'.$genres[$va].'</li>';
																								}else{
																								echo '<li>others</li>';
																								}
																							}
																						
																					
																						?>
																								
                                                                                                
																						</ul>
																				</div>
																		</div>
																</div>
																<?php } ?>
														</div>
														<div class="info-right">

																<div class="block-box">
																<?php 
																$medium_new = explode(',',$preferred_medium);
																if($profile_type == 10){
																echo '<h5>Preferred Medium:</h5>'; ?>
																<div id="gig" class="scroll-content">
																				
																				<div class="scroll-pane">
																						<ul>
																								<?php if(!empty($medium_new[0])){ ?>
																								<? foreach ($medium_new as $med) : ?>
																								
																								<li><?=$mediums[$med]?></li>
																								<? endforeach; ?>
																								<?php } 
																								else {?>
																								<div id="gig" class="scroll-content">
																										
																										<div class="scroll-pane"><ul><li>N/A</li></ul>
																										</div>
																								</div>
																								<?php }?>
																						</ul>
																				</div>
																		</div>
																<?php }
																else {
																echo '<h5>Preferred Gig:</h5>'; ?>
																<?php if($profile_type != 9){?>
																		<div id="gig" class="scroll-content">
																				
																				<div class="scroll-pane">
																					<ul>
																					<? foreach ($artist_gigs_array as $ag) : ?>
																					<li><?php 
																					if(!empty($gigs[$ag])) echo $gigs[$ag];
																					?></li>
																					<? endforeach; ?>
																					</ul>
																				</div>
																		</div>
																		<?php } else {?>
																		<div id="gig" class="scroll-content">
																				
																				<div class="scroll-pane"><ul><li>N/A</li></ul>
																				</div>
																		</div>
																		<?php } ?>
																<?php } ?>
																		
																</div>
																<div class="block-box">
																		<h5>Availability:</h5>
																		<div id="availability" class="scroll-content">
																				<div class="scroll-pane">
																						<ul>	
																								<?php if(count($artist_availability_array) > 0) { ?>
																								<? $arrDays = array('Monday'=>'mon','Tuesday'=>'tue','Wednesday'=>'wed','Thursday'=>'thu','Friday'=>'fri','Saturday'=>'sat','Sunday'=>'sun'); ?>
                                                                                                <? foreach ($arrDays as $key=>$ad) : ?>
																								<? if (in_array($ad.'_day', $artist_availability_array) && in_array($ad.'_night', $artist_availability_array)) : ?>
                                                                                                <li><?=ucwords($key)?> (am/pm)</li>
                                                                                                <? elseif (in_array($ad.'_day', $artist_availability_array)) : ?>
                                                                                                <li><?=ucwords($key)?> (am)</li>
                                                                                                <? elseif (in_array($ad.'_night', $artist_availability_array)) : ?>
                                                                                                <li><?=ucwords($key)?> (pm)</li>
																								<? endif; ?>
                                                                                                <? endforeach; ?>
																								<?php } else { echo 'N/A'; }?>
																						</ul>
																				</div>
																		</div>
																</div>
																<div class="block-box sub">
																		<div><div style="float:left;"><h5>Insurance: </h5></div><div style="float:right;margin-right:10px;">&nbsp;<?=($has_insurance) ? 'Yes' : 'No'?></div></div>
																		
																</div>
																<div class="block-box sub">
																		<div><div style="float:left;"><h5>Management: </h5></div><div style="float:right;margin-right:10px;"><?=($has_manager) ? 'Yes' : 'No'?></div></div>
																		
																</div>
																
																<div class="block-box" style="">
																<h5>Equipment:</h5>
																<?=(!$equipment) ? '':'<p style="height:25px">I don\'t require<br/></p> '?>
																		<? if (!$equipment) : ?>
																		<div id="equipment_div" class="scroll-content">
																				<div class="scroll-pane">
																				<?php $arr= explode(",", $needed_equipment);
																				if(!empty($arr[0])){ ?>
																						I require
																						<ul>
																							<? foreach ($arr as $a) : ?>
																							<li><?=$a?></li>
																							<? endforeach; ?>
																							<?php }else{ ?>
																							<li>N/A</li>
																							<?php } ?>
																						</ul>
																				</div>
																		</div>
																		<? endif; ?>
																</div>
																
														</div>
														<div class="clear"></div>
														<span>
															<?php 
                                                            if($this->session->userdata('profile_type')=='booka') {
                                                                echo '<a class="book_artist" id="book_artist" title="Book Artist" alt="Book Artist" href="javascript: void(0);">';
                                                                ?>
                                                                            <img src="<?=base_url()?>images/buttons/book-this-artist.png" alt="book this artist"  href="javascript: void(0);" width="328" height="35" />
                                                            <?php } else {
                                                                echo '<a href="'.base_url().'"book">';                                                        
                                                                ?>
                                                                            <img src="<?=base_url()?>images/buttons/book-this-artist.png"  onclick="$('#login_box').slideToggle();$('.show-compact').slideDown();$('#login').slideDown();$('#forgot').slideUp(); return false;" alt="book this artist"  href="javascript: void(0);" width="328" height="35" />
                                                            <?php } 
                                                        ?>
                                            
														</a>
														
														
														</span>
												</div>
												<h4>About <?=$profile_name?> </h4>
												<div id="about" class="scroll-content" style="margin-left:335px;">
												<div class="block-box">
												<div class="scroll-content">
														<div class="scroll-pane">
                                                <p><?=nl2br(ascii_to_entities($info1))?></p>
														</div>
												</div>
												</div>
                                                </div>
												<div class="clear"></div>
										</div>
								</div>
								<div class="clear"></div>
						</div>
						<div class="left-content">
								<div class="block-content">
										<div class="block-bar inline">
												<h3>VIDEO</h3>
										</div>
										<div class="block-bar">
												<p id="video-title"><?=(count($artist_media->video)) ? $artist_media->video[0]->title : 'n/a'?></p>
										</div>
										<div class="clear"></div>
										<div class="video-content">
												<div class="video-box" id="video-player" style="min-height:263px">
                                                <!--<img src="<?=base_url()?>images/banners/video/video.jpg" alt="video" width="466" height="263" />-->
                                                <?=(count($artist_media->video)) ? video_player($artist_media->video[0]->url) : '<img src="'.base_url().'images/video-player-border.jpg" alt="video" width="466" height="263" />'?>
                                                
                                                </div>
												<div class="scroll-content">
														<div class="scroll-pane">
																<div class="listing">
																		<ul>
																			<?php
																				$vidcount  = count($artist_media->video);
																				if($vidcount <2){
																					$vidcount =2;
																				}
																			?>
                                                                        		<? for ($x=1;$x<=$vidcount;$x++) : ?>
                                                                        		<? if (isset($artist_media->video[$x-1])) : 
																					$video = $artist_media->video[$x-1];
																				?>
																				<li>
																						<div class="date">
																								<h4><?=str_pad($x,2,"0",STR_PAD_LEFT)?></h4>
																								<p><?=date('d/m/Y', strtotime($video->date_recorded))?></p>
																						</div>
																						<div class="details">
																								<h5><a href="javascript:void(0)" rel="<?=$video->url?>" class="play-video" title="<?=$video->title?>"><?=$video->title?></a></h5>
																								<p><?= substr($video->description,0,50) ?>...</p>
																								<span class="icon"><a href="javascript:void(0)" rel="<?=$video->url?>" class="play-video" title="<?=$video->title?>">Play</a></span>
																						</div>
																				</li>
                                                                                <? else: ?>
                                                                                <li>
																						<div class="date">
																								<h4><?=str_pad($x,2,"0",STR_PAD_LEFT)?></h4>
																								<p>n/a</p>
																						</div>
																						<div class="details">
																								<h5><a href="javascript:void(0)">n/a</a></h5>
																								<p>n/a</p>
																								<span class="icon"><a href="javascript:void(0)" >Play</a></span>
																						</div>
																				</li>
                                                                                <? endif; ?>
                                                                                <? endfor; ?>
	
																		</ul>
																		<div class="clear"></div>
																</div>
														</div>
												</div>
										</div>
								</div>
								<div id="performance" class="block-content">
										<div class="block-bar">
												<h3>PERFORMANCE HISTORY</h3>
										</div>
										<?php /* ?><div class="block-box">
												<div class="scroll-content">
														<div class="scroll-pane">
																<h4>Experience</h4>
																<p><?=nl2br(symbol_convertion($info1))?></p>
														</div>
												</div>
										</div>
										<?php */ ?>
										<div class="block-box">
										<?php if($types[$profile_type] == 'DJ'){
										$info_head2 = 'Residencies';
										}
										else if($types[$profile_type] == 'Professional Audio Services'){
										$info_head2 = 'Awards';
										}
										else{
										$info_head2 = 'Releases';
										} ?>
										<h4><?php echo $info_head2; ?></h4>
												<div class="scroll-content">
														<div class="scroll-pane">
																<?php if(!empty($info2)){?>
																<p><?=nl2br(symbol_convertion($info2))?></p>
																<?php } else{ ?>
																<p>N/A</p>
																<?php } ?>
														</div>
												</div>
										</div>
										<div class="block-box">
										<?php if($types[$profile_type] == 'Professional Audio Services'){
										$info_head3 = 'Highlights so far';
										}
										else{
										$info_head3 = 'Festivals';
										} ?>
										<h4><?php echo $info_head3; ?></h4>
												<div class="scroll-content">
														<div class="scroll-pane">
																<?php if(!empty($info3)){?>
																<p><?=nl2br(symbol_convertion($info3))?></p>
																<?php } else{ ?>
																<p>N/A</p>
																<?php } ?>
														</div>
												</div>
										</div>
										<div class="block-box last">
										<?php if($types[$profile_type] == 'Professional Audio Services'){
										$info_head4 = 'Core Competencies';
										}
										else{
										$info_head4 = 'Highlights so far';
										} ?>
										<h4><?php echo $info_head4; ?></h4>
												<div class="scroll-content">
														<div class="scroll-pane">
																<?php if(!empty($info4)){?>
																<p><?=nl2br(symbol_convertion($info4))?></p>
																<?php } else{ ?>
																<p>N/A</p>
																<?php } ?>
														</div>
												</div>
										</div>
								</div>
						</div>
						<div class="right-content">
								<div class="block-content" style="overflow:hidden">
										<div class="block-bar inline">
												<h3>AUDIO&nbsp;</h3>
										</div>
										
										<div class="block-bar">
												<p id="audio_title"><?=(count($artist_media->audio)) ? $artist_media->audio[0]->title : 'n/a'?></p>
												
										</div>
										<div class="clear"></div>
										<div class="audio-content">
												<div class="audio-box" style="min-height:81px">
                                                  <?php 
												  if(count($artist_media->audio) > 0){
												  $url = $artist_media->audio[0]->url;
												  $test = explode('/',$url);
												  if($test['2'] == 'soundbooka.com'){
												  if(count($artist_media->video) == 0){
												  $c = ',autostart: "yes"';
												  }else {
												  $c = '';
												  }
												  echo '<p id="audioplayer_1">Alternative content</p>  
												  <script type="text/javascript">  
												  AudioPlayer.embed("audioplayer_1", {soundFile: "'.$url.'" '.$c.'}); 
												  </script>';  
												  }
												 
												  else{
												  if(count($artist_media->video) == 0){
												  $c = 1;
												  }else {
												  $c = 0;
												  }
												  echo audio_player($url,$c);
												  }
												  }
												  else {
												  echo '<img src="'.base_url().'images/music-player.jpg" alt="audio" height="81" />';
												  }
												  ?>
												  <script>
												  
													/*$('.audio-box').scPlayer({
													  autoPlay  :   false
													});*/
													</script>
												
                                                </div>
												<div class="listing">
														<ul>
                                                                <? for ($x=1; $x<=10; $x++) : ?>
                                                                <? if (isset($artist_media->audio[$x-1])) :
																	$audio = $artist_media->audio[$x-1];
																?>
																<li>
																		<div class="date">
																				<h4><?=str_pad($x,2,"0",STR_PAD_LEFT)?></h4>
																				<p><?=date('d/m/Y', strtotime($audio->date_recorded))?></p>
																				<span class="icon"><a href="#">
																					<?php if(strpos($audio->url,'soundbooka.com')) { ?>
																					<img src="<?=base_url()?>images/buttons/new_mp3.png" alt="clouds" />
																					<?php } 
																					else {?>
																					<img src="<?=base_url()?>images/buttons/clouds.png" alt="clouds" width="20" height="10" />
																					<?php }?>
																				</a></span>
																		</div>
																		<div class="details">
																				<p>
                                                                                <?= $audio->title ?> 
                                                                                <br />
                                                                                <?= substr($audio->description,0,150) 
																				?>
                                                                                </p>
																				<span class="icon"><a href="javascript:void(0)" title="<?= $audio->title ?>" class='play_audio' rel='<?= $audio->url?>'>Play</a></span>
																				<span class="current_audio">&nbsp;</span>
																		</div>
																</li>
                                                                <? else : ?>
                                                                <li>
																		<div class="date">
																				<h4><?=str_pad($x,2,"0",STR_PAD_LEFT)?></h4>
																				<p>n/a</p>
																				<span class="icon"><a href="#"><img src="<?=base_url()?>images/buttons/clouds.png" alt="clouds" width="20" height="10" /></a></span>
																		</div>
																		<div class="details">
																				<p>
                                                                                n/a 
                                                                                <br />
                                                                                
                                                                                </p>
																				<span class="icon"><a href="#">Play</a></span>
																		</div>
																</li>
                                                                <? endif; ?>
                                                                <? endfor; ?>
																
														</ul>
														<div class="clear"></div>
												</div>
										</div>
								</div>
								<div id="instruments" class="block-content" style="color:#333">
										<div class="block-bar">
												<h3><?php 
												if($profile_type==1 && $dj_combo != 0){ $str = "DJS (DJ Combo)";}
												else if($profile_type==1 && $dj_combo == 0){ $str = "instruments (DJ)";}
												else if($profile_type==7){ $str = "line-up"; }
												else { $str = "instruments";}
												
												$str = strtoupper($str);
												echo $str;
												
												$sql = "select * from artist_Instruments where artist_id = '".$id."'order by id";
												$result = mysql_query($sql);
												while($row=mysql_fetch_array($result)){
														$artist_instrumentsa[]=$row;
												}
												
												?></h3>
										</div>
										<div class="scroll-content">
														
														<div class="scroll-pane" >
																<?php if(!($profile_type == 1 &&  in_array($dj_combo,array(0))) && $profile_type != 10 ) { ?>
																<ul>
                                                                		
																		<?php $i = 0;
																		if(!empty($artist_instrumentsa) && count($artist_instrumentsa) > 0){
																		(sizeof($artist_instrumentsa)==1)? $sz=1:$sz=0;
																		
																		foreach($artist_instrumentsa as $key){
																		?>
																		<li>
																				<div class="type" <?php if($sz==1) echo 'style="width:141px;"'; ?>>
																						
																						<p><?php print_r($key['instrument_name']);?></p>
																				</div>
																				<div class="details">
																						
																						<p><?php print_r($key['comment']);?></p>
																				</div>
																		</li>
                                                                        <?php } } else{  echo "<strong>No Instruments found</strong>"; }?>
																</ul>
																<?php }
																else {
																/*if($profile_type == 1 and $dj_combo== 2) 
																	echo "<strong>".$no_of_members." Members in total.</strong>";*/
																if ($profile_type == 1 and $dj_combo== 0 ) 
																	echo "<strong>N/A</strong>";
																else if ($profile_type == 10)
																	echo "<strong>N/A</strong>";
																}
																
																?>
																<div class="clear"></div>
														</div>
										</div>
								</div>
						</div>
						</div>
						
<script>
$(function() {
	
	$('#slideshow').cycle();
	
	$('.play-video').click(function() {
	
		$('#video-player').html('');
		$('#video-title').html($(this).attr('title'));
		$('#video-player').load('<?=base_url()?>ajax/getVideo', {url: encodeURIComponent($(this).attr('rel'))}, function() {flowplayer("player", "<?=base_url()?>js/flowplayer-3.2.7.swf");});
		//$('#video-player').html('<iframe title="YouTube video player" class="youtube-player" type="text/html" width="466" height="263" src="" frameborder="0" allowFullScreen></iframe>');
		//$('#video-player').oembed($(this).attr('rel'));
	});
	
	$('.play_audio').click(function() {
		$('.current_audio').hide();$('.icon').show();
		$details=$(this).parents('.details');
		$details.find('.icon').hide();
		
		$('#audio_title').html($(this).attr('title'));
		$('.audio-box').html('<div style="margin-left:150px;"><img src="<?=base_url()?>images/ajax-loader.gif" height="81"/></div>');
		$('.audio-box').load('<?=base_url()?>ajax/getAudio', {url: encodeURIComponent($(this).attr('rel'))});
		$details.find('.current_audio').show();
	});
	
	flowplayer("player", "<?=base_url()?>js/flowplayer-3.2.7.swf");
   
});
</script>