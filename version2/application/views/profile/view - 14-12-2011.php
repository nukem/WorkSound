
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
<style>
#content {overflow:auto}

</style>
					<div class="features">
								<div class="block-bar">
										<div class="left">
												<h2><?=$profile_name?> (<?=$types[$profile_type]?>)</h2>
												<div class="social">
												<?php if(!empty($twitter)){?><a 
												onClick="window.open('<?php echo $twitter; ?>','mywindow','menubar=1,resizable=1,width=600,height=600,left=500,top=300,scrollbars=1');" style="cursor:pointer;"><?php } ?><img src="<?=base_url()?>images/buttons/twitter.png" alt="twitter" title="twitter" width="26" height="24" /><?php if(!empty($twitter)){?></a><?php } ?>
												<?php if(!empty($facebook)){?><a 
												onClick="window.open('<?php echo $facebook; ?>','mywindow','menubar=1,resizable=1,width=600,height=600,left=500,top=300,scrollbars=1');" style="cursor:pointer;"><?php } ?><img src="<?=base_url()?>images/buttons/fb.png" alt="facebook" title="facebook" width="26" height="24" /><?php if(!empty($facebook)){?></a><?php } ?>
												<a href="#"><img src="<?=base_url()?>images/buttons/calendar.png" alt="calendar" title="calendar" width="18" height="24" /></a></div>
										</div>
										<div class="right">
												<span class="btn"><a href="<?= base_url() ?>"><img src="<?=base_url()?>images/buttons/back-btn.png" alt="back to list" width="91" height="22" /></a></span>
										</div>
								</div>
								<div class="gallery">
										<div class="block-content">
												<div class="full">
                                                <div id="slideshow">
                                                <? foreach ($images as $i) : ?>
                                                <img src="<?= base_url() ?><?='wpdata/images/'. $i->id.'-medium.jpg' ?>" alt="artist" width="216" />
                                                <? endforeach; ?>
                                                </div>
                                                </div>
												<div class="thumbs">
														<ul>
																<li><a href="#"><img src="<?= base_url() ?><?= (isset($images[1])) ? 'wpdata/images/'. $images[1]->id.'-thumb.jpg' : 'images/default_person.gif' ?>" alt="thumbs" width="80" /></a></li>
																<li><a href="#"><img src="<?= base_url() ?><?= (isset($images[2])) ? 'wpdata/images/'. $images[2]->id.'-thumb.jpg' : 'images/default_person.gif' ?>" alt="thumbs" width="80" /></a></li>
																<li><a href="#"><img src="<?= base_url() ?><?= (isset($images[3])) ? 'wpdata/images/'. $images[3]->id.'-thumb.jpg' : 'images/default_person.gif' ?>" alt="thumbs" width="80" /></a></li>
																<li><a href="#"><img src="<?= base_url() ?><?= (isset($images[4])) ? 'wpdata/images/'. $images[4]->id.'-thumb.jpg' : 'images/default_person.gif' ?>" alt="thumbs" width="80" /></a></li>
														</ul>
												</div>
										</div>
								</div>
								<div class="details">
										<div class="block-content" style="overflow:auto">
												<div class="info">
														<div class="info-left">
																<div class="block-box">
																		<h5>Location:</h5>
																		<p><?=$suburb?>, <?=$states[$state]?> <?=$postcode?><br /><span class="highlight">(Can travel: <?=trim((($travel_city) ? 'Within home city, ' : '') . (($travel_state) ? 'Within home state, ' : '') . (($travel_interstate) ? 'Interstate, ' : '') . (($travel_international) ? 'International, ' : ''), ", ")?>)</span></p>
																</div>
																<div class="block-box">
																		<h5>Minimum Set Time</h5>
																		<p><?=$gig_hours?> hours </p>
																</div>
																<?php 
																$test = explode(',',$specialization);
																if($profile_type==10){ ?>
																<div class="block-box">
																		<h5>Specialisation:</h5>
																		<div id="genres" class="scroll-content">
																				<div class="scroll-pane">
																						<ul>
																						<?php
																							foreach($test as $key => $val){
																								echo '<li>'.$specializations[$val].'</li>';
																							}
																						?>								
																						</ul>
																				</div>
																		</div>
																</div>
																<?php } else{ ?>
																<div class="block-box">
																		<h5>Genres:</h5>
																		<div id="genres" class="scroll-content">
																				<div class="scroll-pane">
																						<ul>
																								<? if ($genre1) : ?><li><?=$genres[$genre1]?></li><? endif; ?>
																								<? if ($genre2) : ?><li><?=$genres[$genre2]?></li><? endif; ?>
                                                                                                <? if ($genre3) : ?><li><?=$genres[$genre3]?></li><? endif; ?>
                                                                                                <? if ($genre4) : ?><li><?=$genres[$genre4]?></li><? endif; ?>
                                                                                                <? if ($genre5) : ?><li><?=$genres[$genre5]?></li><? endif; ?>
																								
                                                                                                
																						</ul>
																				</div>
																		</div>
																</div>
																<?php } ?>
														</div>
														<div class="info-right">
																<div class="block-box">
																<h5>Preferred Gig:</h5>
																		<div id="gig" class="scroll-content">
																				
<div class="scroll-pane">
																						<ul>
																								<? foreach ($artist_gigs_array as $ag) : ?>
																								<li><?=$gigs[$ag]?></li>
																								<? endforeach; ?>
																						</ul>
																				</div>
																		</div>
																</div>
																<div class="block-box">
																		<h5>Availability:</h5>																								
																		<div id="gig" class="scroll-content">
																				<div class="scroll-pane">
																						<ul>
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
																						</ul>
																				</div>
																		</div>
																</div>
																<div class="block-box sub">
																		<h5>Insurance: </h5>
																		<p><?=($has_insurance) ? 'Yes' : 'No'?></p>
																</div>
																<div class="block-box sub">
																		<h5>Management: </h5>
																		<p><?=($has_manager) ? 'Yes' : 'No'?></p>
																</div>
																
																<div class="block-box" style="">
																<h5>Equipment:</h5>
																<?=(!$equipment) ? '':'<p>I don\'t require</p> '?>
																		<? if (!$equipment) : ?>
																		<div id="equipment_div" class="scroll-content">
																				<div class="scroll-pane">
																				<?php $arr= explode(",", $needed_equipment);?>
																						<ul>
																							<? foreach ($arr as $a) : ?>
																							<li><?=$a?></li>
																							<? endforeach; ?>
																						</ul>
																				</div>
																		</div>
																		<? endif; ?>
																</div>
																
														</div>
														<div class="clear"></div>
														<span><a href="<?= base_url() ?>book"><img src="<?=base_url()?>images/buttons/book-this-artist.png" alt="book this artist" width="328" height="35" /></a></span>
												</div>
												<h4>About <?=$profile_name?> </h4>
												<p>
                                                <?=nl2br(ascii_to_entities($info1))?>
                                                </p>
												<div class="clear"></div>
										</div>
								</div>
								<div class="clear"></div>
						</div>
						<div class="left-content">
								<div class="block-content">
										<div class="block-bar inline">
												<h3>VIDEOS</h3>
										</div>
										<div class="block-bar">
												<p id="video-title"><?=(count($artist_media->video)) ? $artist_media->video[0]->title : 'n/a'?></p>
										</div>
										<div class="clear"></div>
										<div class="video-content">
												<div class="video-box" id="video-player" style="min-height:263px">
                                                <!--<img src="<?=base_url()?>images/banners/video/video.jpg" alt="video" width="466" height="263" />-->
                                                <?=(count($artist_media->video)) ? video_player($artist_media->video[0]->url) : ''?>
                                                
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
                                                                        		<? for ($x=1;$x<=count($artist_media->video);$x++) : ?>
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
												<div class="scroll-content">
														<div class="scroll-pane">
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
																<p><?=nl2br(symbol_convertion($info2))?></p>
														</div>
												</div>
										</div>
										<div class="block-box">
												<div class="scroll-content">
														<div class="scroll-pane">
																<?php if($types[$profile_type] == 'Professional Audio Services'){
																$info_head3 = 'Highlights so far';
																}
																else{
																$info_head3 = 'Festivals';
																} ?>
																<h4><?php echo $info_head3; ?></h4>
																<p><?=nl2br(symbol_convertion($info3))?></p>
														</div>
												</div>
										</div>
										<div class="block-box last">
												<div class="scroll-content">
														<div class="scroll-pane">
																<?php if($types[$profile_type] == 'Professional Audio Services'){
																$info_head4 = 'Core Competencies';
																}
																else{
																$info_head4 = 'Highlights so far';
																} ?>
																<h4><?php echo $info_head4; ?></h4>
																<p><?=nl2br(symbol_convertion($info4))?></p>
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
                                                <object width="413" height="81">
												<param value="https://player.soundcloud.com/player.swf?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F30186287&show_comments=true&auto_play=false&color=ff7700" name="movie">
												<param value="always" name="allowscriptaccess">
												<embed width="413" height="81" type="application/x-shockwave-flash" src="https://player.soundcloud.com/player.swf?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F30186287&show_comments=true&auto_play=false&color=ff7700" allowscriptaccess="always">
												</object>
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
																				<span class="icon"><a href="#"><img src="<?=base_url()?>images/buttons/clouds.png" alt="clouds" width="20" height="10" /></a></span>
																		</div>
																		<div class="details">
																				<p>
                                                                                <?= $audio->title ?> 
                                                                                <br />
                                                                                <?= substr($audio->description,0,50) ?>...
                                                                                </p>
																				<span class="icon"><a href="javascript:void(0)" title="<?= $audio->title ?>" class='play_audio' rel='<?= $audio->url?>'>Play</a></span>
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
												if($profile_type==1) $str = "instruments (".$types[$profile_type].")";
												else  $str = "instruments";
												$str = strtoupper($str);
												echo $str;
												
												$sql = "select * from artist_Instruments where artist_id = '".$this->uri->segment(3)."'order by id";
												$result = mysql_query($sql);
												while($row=mysql_fetch_array($result)){
														$artist_instrumentsa[]=$row;
												}
												echo '<div style="display:none;">';print_r($artist_instrumentsa);echo '</div>';
												?></h3>
										</div>
										<div class="scroll-content">
														
														<div class="scroll-pane" >
																<?php if(!($profile_type == 1 and in_array($dj_combo,array(2,0)))) { ?>
																<ul>
                                                                		
																		<?php $i = 0;
																		foreach($artist_instrumentsa as $key){
																		?>
																		<li>
																				<div class="type">
																						
																						<p><?php print_r($key['instrument_name']);?></p>
																				</div>
																				<div class="details">
																						
																						<p><?php print_r($key['comment']);?></p>
																				</div>
																		</li>
                                                                        <?php } ?>
																</ul>
																<?php }
																else {
																if($profile_type == 1 and $dj_combo== 2) 
																	echo "<strong>".$no_of_members." Members in total.</strong>";
																else if ($profile_type == 1 and $dj_combo== 0) 
																	echo "<strong>N/A</strong>";
																
																}?>
																<div class="clear"></div>
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
	
		$('#audio_title').html($(this).attr('title'));
		$('.audio-box').html('<div style="margin-left:150px;"><img src="<?=base_url()?>images/ajax-loader.gif" /></div>');
		$('.audio-box').load('<?=base_url()?>ajax/getAudio', {url: encodeURIComponent($(this).attr('rel'))});
		
	});
	
	flowplayer("player", "<?=base_url()?>js/flowplayer-3.2.7.swf");
});
</script>