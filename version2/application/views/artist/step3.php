<?php
$test = $this->session->userdata('is_loged');
$test_id = $this->session->userdata('artist_id');
$ids = $this->session->userdata('artists');
$uri_test = $this->uri->segment(3);
if($test  == '1' && !empty($test)){?>
<h1>Edit your profile</h1>
			
<?php } else{
$this->session->set_userdata('is_loged', false);
$this->session->set_userdata('artist', null);
$test_id = '';
?>
<h1>Join as an Artist</h1>
		
<?php } ?>		
			
			<div class="<?php if($uri_test != $test_id ) echo 'step';else echo 'editstep';?> step3">step</div>
			<!--<div class="line_help"><a href="#">click here for help</a></div>-->
<br/>
<script>baseurl="<?=$this->config->item('base_url')?>"</script>
<script src="<?=$this->config->item('base_url')?>js/jquery.lightbox.js"></script>
<script src="<?= base_url() ?>js/flowplayer-3.2.6.min.js" type="text/javascript"></script>
			<form action="" method="post" class="uniform">
			<fieldset>
				<table width="100%"><tr width="100%">
					<td width="50%"><h2>MEDIA UPLOAD</h2></td>
					<td width="50%" align="right"><div align=right class="form_title"><span>*</span> This indicates a mandatory field</div></td>
				</tr></table>
				<h2>STEP 3 of 6</h2>
				<!--<div class="form_title"> Please add some links of your performances.</div>-->
                
                <div class="form_title">
					Your Pictures <span>*</span>
					<strong class="bubble_info">
						<img src="<?=base_url()?>images/question_mark_icon.png" style = "width:15px;height:15px;" alt="" class="img_ask" />
						<strong class="popup"><b>arrow</b><!--<em>Soundbooka allows you to upload a maximum of five (5) images to your Soundbooka Profile Page. From these images you're able to select one as your Profile Picture. This will be displayed in the search results. By uploading a file you certify that you have the right to distribute the picture and that it does not violate the Soundbooka <a href="<?=base_url()?>user_agreement">User Agreement</a>.</em>-->
						<em>Soundbooka allows you to upload a maximum of five (5) images to your Soundbooka  Profile Page. These will be displayed in the search results. By uploading a file you certify that you have the right to distribute the picture and that it does not violate the Soundbooka
						<a href="javascript:void(0)" onclick="showAgreement();">User Agreement</a>.</em></strong>
					</strong>
				</div>
				<p>Please select the images you want to upload to your Soundbooka Profile Page.</p>
				
				<div class="form_row">
					<ul class="user_pic_list">
                    	<? $x = 0 ?>
                    	<? foreach ($images as $img) : ?>
						<li>
							<img src="<?= base_url() ?>wpdata/images/<?=$img->id?>-thumb.jpg" alt="" />
							<!--<span><? if ($img->position == 0) : ?><a href="javascript:void(0)" rel="<?=$img->id?>" class="make-default" style="color:#5f5f5f">Profile Pic</a><? else : ?><a href="javascript:void(0)" rel="<?=$img->id?>" class="make-default">Set as profile</a><? endif; ?></span>-->
							<span><a href="javascript:void(0)" rel="<?=$img->id?>" class="pic-remove">Remove</a></span>
						</li>
                        <? $x++;endforeach; ?>
						<? for ($x; $x<5; $x++) : ?>
                        <li class="blank-pic">
							<img src="<?=base_url()?>images/default_person.gif" alt="" />
							<!--<span><a>Set as profile</a></span>-->
							<span><a>Remove</a></span>
						</li>
                        <? endfor; ?>
					</ul>
					
					<div class="form_item" style="width: 260px;margin-left:-40px;">
						<label>Upload your pictures <span>*</span></label>
						<div id="profile_pic">
						<input name="jq-images" type="file" id="jq-images" onChange="return ajaxFileUploadImg('jq-images', 'file-parent');" size="75"/>
						</div>
						<em>Select an image file on your computer (max 4 MB)</em>
					</div>
					<br class="cl" />
				</div><!--end of form_row-->
                
                <div class="shadow_line_nobg">line</div>
				
				<div class="form_title">
					<img src="<?=base_url()?>images/img_audio.gif" alt="" /> Audio <span>*</span>
					<strong class="bubble_info">
						<img src="<?=base_url()?>images/question_mark_icon.png" style = "width:15px;height:15px;" alt="" class="img_ask" />
						<strong class="popup"><b>arrow</b><em>Soundbooka requires you to provide audio that showcases your performance capabilities. This can be a track you have already posted on 
						<a href="javascript: void(0);" 
							onclick="window.open('http://www.soundcloud.com','Soundcloud','menubar=1,resizable=1,width=600,height=600,left=500,top=300,scrollbars=1');">Soundcloud
						</a> or you can simply upload an mp3 file up to 5mb. You can upload a maximum of 10 tracks. These audio tracks will be displayed on your Soundbooka Profile Page.</em></strong>
					</strong>
				</div>
				<div class="form_block">
					<div class="note_box"><span>arrow</span>Soundbooka is a quality artist site and will review any audio or video submission before your profile will be approved.</div>
					<p>Let's hear what you're made of!<br />
						You must have at least some audio tracks to be approved by Soundbooka.
					</p>	
					<div class="form_row">
					  <div class="form_item">
						<label>Soundcloud</label>
						  <input name="url" type="text" class="input1 infotext" id="url" title="Copy and Paste Soundcloud URL" value=""/>
						  <em><a href="http://soundcloud.com" target="_blank">Click here</a> to learn how</em>
						</div>
						<div class="form_or">or</div>
					  <div class="form_item">
						<label>Upload Mp3 file</label>
						  <div id="audio_file">
						  <input name="jq-files1" type="file" id="jq-files1" onChange="return ajaxFileUpload('jq-files1', 'audio');" size="75"/>
						  </div>
						  <!--<span class="file_em">(Max. 5MB)</span>-->
						  <label>(Max. 30MB)</label>
						  <input type="hidden" name="audio_url_hidden" id ="audio_url_hidden" value="" />
						<label> <span id="audio_url"><span></label>
						 				
						</div>
						<div class="form_item">
						  <label>&nbsp;</label>
						  <div id="audioloading" style="display:none;width:100px;height:25px;overflow:hidden;position:absolute;"><img src="<?php echo base_url();?>images/ajax-loader.gif" style="margin-top:-36px;" /></div>
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
					
					<div class="form_row">
					  <div class="form_item">
						<label>Track Name <span>*</span></label>
						  <input name="title" type="text" class="input1 infotext" id="title" title="Track name" value=""/>
						</div>

					  <div class="form_item">
						<label>Date recorded <span>*</span></label>
						  <input name="date_recorded" type="text" class="input7 infotext datepicker" id="date_recorded" title="dd/mm/yy" />
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
					
					<div class="form_row">
						<div class="form_item">
						  <label>Track description </label>
							<textarea class="textarea1 infotext" name="description" id="description" title="Describe the track you are uploading... (Max. 25 words)"></textarea>
						</div>
						<input type="hidden" id="am_id" value="0" />
						<div class="form_item2">
							<p><a href="javascript:void(0)" class="btn_add" id="add_audio">Add</a></p>
							<p>
								You warrant that you shall not upload any content that infringes any<br />copyright, trademark or other intellectual property rights.
								<strong class="bubble_info">
									<img src="<?=base_url()?>images/question_mark_icon.png" style = "width:15px;height:15px;" alt="" class="img_ask" />
									<strong class="popup"><b>arrow</b><em>You warrant that you shall not upload any content that infringes any copyright, trademark or other intellectual property rights of any other entity and indemnify Soundbooka for any loss, damage or claim resulting from such. By posting on the Site, you grant us a world-wide, non-exclusive, unlimited and irrevocable right to use, publish, market, advertise or otherwise promote the content you post.</em></strong>
								</strong>
							</p>
						</div>
						<br class="cl" />
					</div><!--end of form_row-->

				</div><!--end of form_block-->
				
				
				<div class="shadow_line_nobg">line</div>
				
				
				<div class="form_title">Tracks you have uploaded <em>(Max. 10 tracks)</em></div>
				<div class="form_block">
					<table class="instrument_table" id="tbl_audio">
					  <tr>
					    <th width="22%">Track Name</th>
					    <th width="26%">Description</th>
					    <th width="11%">Date</th>
					    <th width="30%">File/Link</th>
					    <th width="11%">&nbsp;</th>
					  </tr>
                      <? foreach ($artist_media->audio as $ix=>$ma) : ?>
					  <tr class="<?=($ix%2) ? 'tr_even' : ''?>" id="tr_<?=$ma->id?>">
					    <td><?=$ma->title?></td>
					    <td><?=$ma->description?></td>
					    <td><?=date('d/m/Y', strtotime($ma->date_recorded))?></td>
					    <td><a href="<?=$ma->url?>" class="<?php if (strpos($ma->url, 'soundbooka.com') !== false) echo 'lightbox_link ';?>link" rel="audio" target="_blank"><?=character_limiter($ma->url,40)?></a></td>
						<td class="td_link"><a href="javascript:remove(<?=$ma->id?>)" rel="<?=$ma->id?>">remove</a> | <a href="javascript:edit(<?=$ma->id?>,'audio')"  rel="<?=$ma->id?>">edit</a></td>
					  </tr>
					  <? endforeach; ?>
					</table>
				</div><!--end of form_block-->
				
				
				<div class="form_title">
					<img src="<?=base_url()?>images/img_video.gif" alt="" /> Video
					<strong class="bubble_info">
						<img src="<?=base_url()?>images/question_mark_icon.png" style = "width:15px;height:15px;" alt="" class="img_ask" />
						<strong class="popup"><b>arrow</b><em>Soundbooka allows you to showcase your skills through video. These will be displayed on your Profile Page. This is not a mandatory requirement but will enhance your Soundbooka Profile greatly. You can use existing video that you have hosted on 
						<a href="javascript: void(0);" 
							onclick="window.open('http://vimeo.com','Vimeo','menubar=1,resizable=1,width=600,height=600,left=500,top=300,scrollbars=1');">Vimeo
						</a>
						or 
						<a href="javascript: void(0);" 
							onclick="window.open('http://youtube.com','Youtube','menubar=1,resizable=1,width=600,height=600,left=500,top=300,scrollbars=1');">Youtube
						</a>
						, or, you can upload a .mov, .mp4, .mpeg, or .3gp file up to 50mb. You can upload a maximum of two (2) video clips.</em></strong>
					</strong>
				</div>
				<div class="form_block">
					<p>Let's see you in action!</p>
					<div class="form_row">
					  <div class="form_item">
						<label>Vimeo / YouTube</label>
						  <input name="vurl" type="text" class="input1 infotext" id="vurl" title="Copy and Paste Vimeo/YouTube URL" />
						  <em>Click <a href="javascript: void(0);" 
							onclick="window.open('http://www.vimeo.com','Vimeo','menubar=1,resizable=1,width=600,height=600,left=500,top=300,scrollbars=1');">here</a> for Vimeo upload and click <a href="javascript: void(0);" 
							onclick="window.open('http://www.youtube.com','Youtube','menubar=1,resizable=1,width=600,height=600,left=500,top=300,scrollbars=1');">here</a> for <br>Youtube upload.</em>
						</div>
						<div class="form_or">or</div>
					  <div class="form_item">
						<label>Upload Video file</label>
						  <div id="video_file">
						  <input name="jq-files2" type="file" id="jq-files2" onChange="return ajaxFileUpload('jq-files2', 'video');" size="75"/>
						  </div>
						  <label>(Max. 30MB)</label>
						</div>
						<div class="form_item">
						  <label>&nbsp;</label>
						  <div id="videoloading" style="display:none;width:100px;height:25px;overflow:hidden;position:absolute;"><img src="<?php echo base_url();?>images/ajax-loader.gif" style="margin-top:-36px;" /></div>
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
					
					<div class="form_row">
					  <div class="form_item">
						<label>Title <span>*</span></label>
						  <input name="vtitle" type="text" class="input1 infotext" id="vtitle" title="Title" />
						</div>

					  <div class="form_item">
						<label>Date recorded <span>*</span></label>
						  <input name="vdate_recorded" type="text" class="input7 infotext datepicker" id="vdate_recorded" title="dd/mm/yy" />
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
					
					<div class="form_row">
						<div class="form_item">
						  <label>Video description </label>
							<textarea name="vdescription" class="textarea1 infotext" id="vdescription" title="Describe the video you are uploading... (Max. 25 words)"></textarea>
						</div>
						<input type="hidden" id="vam_id" value="0" />
						<div class="form_item2">
							<p><a href="javascript:void(0)" class="btn_add" id="add_video">Add</a></p>
							<p>
								You warrant that you shall not upload any content that infringes any<br />copyright, trademark or other intellectual property rights.
								<strong class="bubble_info">
									<img src="<?=base_url()?>images/question_mark_icon.png" style = "width:15px;height:15px;" alt="" class="img_ask" />
									<strong class="popup"><b>arrow</b><em>You warrant that you shall not upload any content that infringes any copyright, trademark or other intellectual property rights of any other entity and indemnify Soundbooka for any loss, damage or claim resulting from such. By posting on the Site, you grant us a world-wide, non-exclusive, unlimited and irrevocable right to use, publish, market, advertise or otherwise promote the content you post.</em></strong>
								</strong>
							</p>
						</div>
						<br class="cl" />
					</div><!--end of form_row-->

				</div><!--end of form_block-->
				
				
				<div class="shadow_line_nobg">line</div>
				
				<div class="form_title">Videos you have uploaded <em>(Max. 10 videos)</em></div>
				<div class="form_block">
					<table class="instrument_table"  id="tbl_video">
					  <tr>
					    <th width="22%">Title</th>
					    <th width="26%">Description</th>
					    <th width="11%">Date</th>
					    <th width="30%">File/Link</th>
					    <th width="11%">&nbsp;</th>
					  </tr>
					  <? foreach ($artist_media->video as $ix=>$mv) : ?>
					  <tr class="<?=($ix%2) ? 'tr_even' : ''?>" id="tr_<?=$mv->id?>">
					    <td><?=$mv->title?></td>
					    <td><?=$mv->description?></td>
					    <td><?=date('d/m/Y', strtotime($mv->date_recorded))?></td>
					    <td><a href="<?=$mv->url?>" class="<?php if (strpos($mv->url, 'soundbooka.com') !== false) echo 'lightbox_link ';?>link" rel="video" target="_blank"><?=character_limiter($mv->url,50)?></a></td>
						<td class="td_link"><a href="javascript:remove(<?=$mv->id?>)" rel="<?=$mv->id?>">remove</a> | <a href="javascript:edit(<?=$mv->id?>,'video')"  rel="<?=$mv->id?>">edit</a></td>
					  </tr>
					  <? endforeach; ?>
	
				</table>
				</div><!--end of form_block-->
                
                <div class="shadow_line_nobg">line</div>
                
                <div class="form_title">
					 Stage Plot
					
				</div>
                
                <div class="form_block">
					<p>Do you have a specific stage plot or tech rider that you require when you perform?</p>
					<div class="form_row">
					  <div class="form_item">
						<label>Please upload a PDF of your stage plot /tech rider</label>
						  <input name="plot[]" type="text" class="input1 infotext" id="plot" title="" value="" />
						  <?php 
						  foreach($plots as $plot) { ?>
							<input name="plot[]" id="PLOT_<?=$plot->id?>" type="hidden" class="input1 infotext" id="plot" title="" value="<?php echo $plot->plot;?>" />
						  <?php } ?>
						 <!--<em><a href="javascript:void(0)" class="btn_add" id="add_plot">Add</a></em>-->
						 
						</div>
						<div class="form_item">
						<label>&nbsp;</label>
						  <div id="plot_file">
						  <input name="jq-files3" type="file" id="jq-files3" onChange="return ajaxFileUpload('jq-files3', 'file');" size="75"/>
						  </div>
						  <em class="file_em" style="float:left !important;">(Max. 5MB)</em>
						</div>
						  <div class="form_item">
						  <label>&nbsp;</label>
						  <div id="fileloading" style="display:none;width:100px;height:25px;overflow:hidden;position:absolute;"><img src="<?php echo base_url();?>images/ajax-loader.gif" style="margin-top:-36px;" /></div>
						</div>
						
						  <br class="cl" />
						
						
					</div><!--end of form_row-->
					<div class="form_row">
					<div class="form_item" style="margin-left:306px;">
						<a href="javascript:void(0)" class="btn_add" id="add_plot">Add</a>
					  </div>

					
                    </div>
                </div>
				
			  <div class="shadow_line_nobg">line</div>
						<p> Files you have uploaded.</p>
				<div class="form_block">
					<table class="instrument_table"  id="tbl_plot">   
					  <tr>
					    <th width="70%">File/Link</th>
						<th width="30%">&nbsp;</th>
					  </tr> 
					  <?php // print_r($plots); 
					   foreach($plots as $plot) { ?> 
					  <tr id="plot_tr_<?=$plot->id?>"  >
					    <td><a href="<?=$plot->plot?>" target"_blak"><?=$plot->plot?></a></td>
						<td class="td_link"><a href="javascript:removePlot(<?=$plot->id?>)" rel="<?=$plot->id?>">remove</a></a></td>
					 </tr>
					  <?php } ?>
					</table>
				</div><!--end of form_block-->
            	
				<input name="save" type="submit" class="input_continue" id="save" value="Save &amp; Continue" onclick="return _onSaveContinue();" />
				<script type="text/javascript">
					function _onSaveContinue() {
						if ( $("#tbl_audio tr").length <= 1 &&
								$("#tbl_video tr").length <= 1 )
						{
							return confirm('Soundbooka recommends including audio tracks in your profile.\n\nIf you want to upload your tracks later click "OK", if you wish to do it now click "Cancel".');
						}						
						return true;
					}
				</script>

				<input type="button" value="Back" class="btn_back2" name="back" onclick="location.href = '<?php echo base_url() ?>artist/step2/<?php echo($id);?>'" />
				
				<!--<a href="<?php echo base_url() ?>artist/step2/<?php echo $uri_test;?>" class="btn_back2" >Back</a>-->
				
				<br class="cl" />
			<input type="hidden" name="isPost" value="1" />
			</fieldset>
			</form>
			
			<br class="cl" />
			<div id="agreement" title="User Agreement" style="display:none">
				<div class="scroll_box" style="height:365px" id="agreement_content">
					
				</div>
			</div>
<script>


var artist_id = '<?=$id?>';

function removePlot(id) {
	elm = $('#plot_tr_'+id);
	$('#PLOT_'+id).val('').remove();
	$.post("<?=base_url()?>ajax/removePlot", { plot_id: id},
	   function(data) {
		 elm.fadeOut().delay(2000).remove();
	   });
	   
}


$(function() {
	$( ".datepicker" ).datepicker({dateFormat: 'dd/mm/yy'});
	$('#pdf-png').click(function(){$('#jq-files3').click();});
	
	
	$('.make-default').live('click',function() {
		$('.make-default').html('Set as profile').css('color', '#FF5C32');
		$(this).html('Profile pic');
		$(this).css('color', '#5f5f5f');
		$.post("<?=base_url()?>ajax/setProfilePic", {id: $(this).attr('rel'), artist_id: '<?=$id?>'},
		   function(data) {
			 
		});
	});
	
	$('.pic-remove').live('click',function() {
		elm = $(this);
		$.post("<?=base_url()?>ajax/removeProfilePic", {id: $(this).attr('rel')},
		   function(data) {
			 elm.closest('li').addClass('blank-pic');
			 elm.closest('li').html('<img src="<?=base_url()?>images/default_person.gif" alt="" /> <span><a>Remove</a></span>');
			 
		});
	});

	
	$('#add_audio').click(function() 
	{
		if($('#audio_url_hidden').val()=="" || $('#audio_url_hidden').val()==0){
			murl = $('#url');
		}else{
			murl = $('#audio_url_hidden');
		}
		mtitle = $('#title');
		mdescription = $('#description');
		mdate = $('#date_recorded');
		mid = $('#am_id').val();
		
		validate(murl);validate(mtitle);validate(mdate)
		
		if(mdescription.val() == mdescription.attr('title')){
			mdescription.val('');
		}
		
		if (!validate(murl) || !validate(mtitle) || !validate(mdate)) {
			showErrorEx('All fields are required!');
			return; 
		}
		
		if (!checkURL(murl.val())) {
			murl.addClass('input-error');
			return;
		} else {
			murl.removeClass('input-error');
		}
		
		rowCount = $('#tbl_audio tr').length;
		cssclass = '';
		if (rowCount%2 == 0) cssclass=' class="tr_even"';
		
		$.post("<?=base_url()?>ajax/saveMedia", { am_id: mid, artist_id: artist_id, url: murl.val(), title: mtitle.val(), description: mdescription.val(), date_recorded: mdate.val(), type: 'audio' },
		   function(data) {
			  if (mid) {
				$('#tr_'+mid).remove();
				$('.btn_add').html('Add');
			  }
			 $('#tbl_audio > tbody:last').append('<tr'+cssclass+' id="tr_'+data+'"><td>'+mtitle.val()+'</td><td>'+mdescription.val()+'</td><td>'+mdate.val()+'</td><td><a href="javascript:void(0);" onclick="window.open (\''+murl.val()+'\',\''+mtitle.val()+'\',\'resizable=1,width=450,height=350\');" class="link">'+murl.val()+'</a></td><td class="td_link"><a href="javascript:remove('+data+')" rel="'+data+'" class="remove">remove</a> | <a href="javascript:edit('+data+',\'audio\')" rel="'+data+'" class="edit">edit</a></td></tr>');
			 murl.val(murl.attr('title'));
			 mtitle.val(mtitle.attr('title'));
			 mdescription.val(mdescription.attr('title'));
			 mdate.val(mdate.attr('title'));
			 $('#am_id').val(0);
			 $('#audio_url_hidden').val(0)
			 $('#url').val('')
			 $('.filename').text('No file selected')
		   });
		
	});
	
	$('#add_video').click(function() {
		murl = $('#vurl');
		mtitle = $('#vtitle');
		mdescription = $('#vdescription');
		mdate = $('#vdate_recorded');
		mid = $('#vam_id').val();
		
		validate(murl);validate(mtitle);validate(mdate)
		
		if(mdescription.val() == mdescription.attr('title')){
			mdescription.val('');
		}
		
		if (!validate(murl) || !validate(mtitle) || !validate(mdate)) {
			showErrorEx('All fields are required!');
			return; 
		}
		
		if (!checkURL(murl.val())) {
			murl.addClass('input-error');
			return;
		} else {
			murl.removeClass('input-error');
		}
		
		rowCount = $('#tbl_video tr').length;
		cssclass = '';
		if (rowCount%2 == 0) cssclass=' class="tr_even"';
		
		$.post("<?=base_url()?>ajax/saveMedia", { am_id: mid, artist_id: artist_id, url: murl.val(), title: mtitle.val(), description: mdescription.val(), date_recorded: mdate.val(), type: 'video' },
		   function(data) {
			  if (mid) {
				$('#tr_'+mid).remove();
				$('.btn_add').html('Add');
			  }
			 $('#tbl_video > tbody:last').append('<tr'+cssclass+' id="tr_'+data+'"><td>'+mtitle.val()+'</td><td>'+mdescription.val()+'</td><td>'+mdate.val()+'</td><td><a href="'+murl.val()+'" target="_blank" class="link">'+murl.val()+'</a></td><td class="td_link"><a href="javascript:remove('+data+')" rel="'+data+'" class="remove">remove</a> | <a href="javascript:edit('+data+',\'video\')" rel="'+data+'" class="edit">edit</a></td></tr>');
			 murl.val(murl.attr('title'));
			 mtitle.val(mtitle.attr('title'));
			 mdescription.val(mdescription.attr('title'));
			 mdate.val(mdate.attr('title'));
			 $('#vam_id').val(0);
			 $('.filename').text('No file selected');
		   });
		
	});

		$('#add_plot').click(function() 
		 {
		  murl = $('#plot');
			
		  validate(murl);
		  
		  if (!validate(murl)) {
		   showErrorEx('All fields are required!');
		   return; 
		  }
		  
		  if (!checkURL(murl.val())) {
		   murl.addClass('input-error');
		   return;
		  } else {
		   murl.removeClass('input-error');
		  }
		  
		  rowCount = $('#tbl_plot tr').length;
		  cssclass = '';
		  if (rowCount%2 == 0) cssclass=' class="tr_even"';
		  
		  $.post("<?=base_url()?>ajax/savePlot", { 'plot': murl.val(),'artist_id':artist_id},
			 function(data) {
			$('#tbl_plot > tbody:last').append('<tr'+cssclass+' id="tr_'+data+'"><td><a href="javascript:void(0);" class="link">'+murl.val()+'</a></td><td class="td_link"><a href="javascript:remove('+data+')" rel="'+data+'" class="remove">remove</a></td></tr>');
			$('#plot').val('')
			$('.filename').text('No file selected')
			 });
		  
		 });	
	
});

 function remove(id) {
	elm = $('#tr_'+id);
	
	$.post("<?=base_url()?>ajax/removeMedia", { am_id: id},
	   function(data) {
		 elm.fadeOut().delay(2000).remove();
	   });	
}

function edit(id,type) {
	if (type == 'audio') {
		type = '';
	} else {
		type = 'v';
	}
	elm = $('#tr_'+id);
	
	$('#'+type+'title').val(elm.find('td:nth-child(1)').text());
	$('#'+type+'description').val(elm.find('td:nth-child(2)').text());
	$('#'+type+'date_recorded').val(elm.find('td:nth-child(3)').text());
	$('#'+type+'url').val(elm.find('td:nth-child(4)').text());

	$('#'+type+'am_id').val(id);
	if (type == 'v') {
		$('#add_video').html('Update');
	} else {
		$('#add_audio').html('Update');
	}
}

function validate(elm) {
	if(elm.val() == elm.attr('title') || elm.val() == '') {
		elm.addClass('input-error');
		return false;
	}
	elm.removeClass('input-error');
	return true;
}

function checkURL(value) {
  var urlregex = new RegExp(
        "^(http:\/\/|https:\/\/|ftp:\/\/){1}([0-9A-Za-z]+\.)");
  if(urlregex.test(value))
  {
    return(true);
  }
  showErrorEx('Invalid URL format');
  return(false);
}

function ajaxFileUpload(elemID, type) {
	ext = $('#'+elemID).val().substr($('#'+elemID).val().lastIndexOf('.') + 1);
	
	parentID = 'file-parent';
	tbl = $('#tbl_audio');
	url = $('#url');
	if (type == 'video') {
		tbl = $('#tbl_video');
		url = $('#vurl');
		if (ext != 'wmv' && ext != 'avi' && ext != 'mpg' && ext != 'mpeg' && ext != 'mov' && ext != 'flv' && ext != 'divx') {
			showErrorEx('Please select a valid video file.');
			return;
		}
	} else if (type == 'audio') {
		tbl = $('#tbl_audio');
		url = $('#audio_url');
		if (ext != 'mp3' && ext != 'MP3') {
			showErrorEx('Please select a valid mp3 file.');
			return;
		}
	} else {
		tbl = null;
		url = $('#plot');
		if (ext != 'pdf' && ext != 'PDF') {
			showErrorEx('Please select a valid pdf file.');
			return;
		}
	}
	
	if (tbl != null) {
		if ($('#'+tbl.attr('id')+' tr').size() >= 11) {
			showErrorEx('You have already uploaded 10 files.');
			return false;
		}
	}
	
	var tempID = new Date().getTime();
	
	$('#'+type+'loading').show();
	url.focus();
	$('#'+elemID).parents('.form_item').find('.filename').text('');
	$.ajaxFileUpload
	(
		{
			url:'<?=base_url()?>webpublisher/doajaxfileupload.php?element='+elemID+'&parent=<?= $id ?>',
			secureuri:false,
			fileElementId:elemID,
			iframeParent:parentID,
			dataType: 'json',
			success: function (data, status)
			{
				$file_text = data.image_title;
				$text_new = $file_text.substring(0,8);
				$file_text = $text_new + '....' +data.file_ext;
				
				
				if(typeof(data.error) != 'undefined')
				{
					if(data.msg == 'SUCCESS') {
					  html = '<? echo str_replace('www.','',base_url()); ?>wpdata/files/'+data.insert_id+'.'+data.file_ext;
					  $('#'+type+'loading').hide();
					  if (type == 'audio'){
					  
						$("#url").val(html);
						$("#audio_url_hidden").val(html);
						// url.html(html);
						$('#'+elemID).parents('.form_item').find('.filename').text($file_text);
						$('#audio_file').html('<div class="uploader" id="uniform-jq-files1"><input type="file" size="75" onchange="return ajaxFileUpload(\'jq-files1\', \'audio\');" id="jq-files1" name="jq-files1" style="opacity: 0;"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action" style="-moz-user-select: none;">Choose File</span></div>');
					  
					  }
					  else if (type == 'video'){
					  
						$("#vurl").val(html);
						// url.html(html);
						//$('#'+elemID).parents('.form_item').find('.filename').text($file_text)
						$('#video_file').html('<div class="uploader" id="uniform-jq-files2"><input type="file" size="75" onchange="return ajaxFileUpload(\'jq-files2\', \'video\');" id="jq-files2" name="jq-files2" style="opacity: 0;"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action" style="-moz-user-select: none;">Choose File</span></div>');
					  
					  } 
					  else
					  {
						url.val(html);
						$('#plot_file').html('<div class="uploader" id="uniform-jq-files3"><input type="file" size="75" onchange="return ajaxFileUpload(\'jq-files3\', \'file\');" id="jq-files3" name="jq-files3" style="opacity: 0;"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action" style="-moz-user-select: none;">Choose File</span></div>');
					  }
					} else {
					  showErrorEx(data.error);
					}
					
				} else {
				  showErrorEx(typeof(data));
				}
			},
			error: function (data, status, e)
			{
				if (window.console){
				  console.log(data);
				  console.log(e);
				}
			}
		}
	);
	$('#'+elemID).val('');
	$.uniform.update('#jq-files1');
	return false;
}

function ajaxFileUploadImg(elemID, parentID)
	{
		//alert($('.blank-pic:first').length);
		if ($('.blank-pic:first').length == 0) {
			showErrorEx('You have already uploaded 5 images.');
			return;
		}
		
		var tempID = new Date().getTime();
		//$('#'+parentID+' ul').append('<li id="'+tempID+'" class="sort-li"><img src="js/loading.gif"> Upload in progress</li>');
		$('.blank-pic:first').html('<img src="<?=base_url()?>images/spinner.gif" alt="" />');
		

		$.ajaxFileUpload
		(
			{
				url:'<?=base_url()?>webpublisher/doajaxfileupload.php?element='+elemID+'&parent=<?= $id ?>',
				secureuri:false,
				fileElementId:elemID,
				iframeParent:parentID,
				dataType: 'json',
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.msg == 'SUCCESS') {
						  //alert(data.insert_id);
						  html = '<img src="<?=base_url()?>wpdata/images/'+data.insert_id+'-thumb.jpg" alt="" />';
						  // html += '<span><a href="javascript:void(0)" rel="'+data.insert_id+'" class="make-default">Set as profile</a></span>';
						  html += '<span><a href="javascript:void(0)" rel="'+data.insert_id+'" class="pic-remove">Remove</a></span>';
						  $('.blank-pic:first').html(html);
						  $('.blank-pic:first').removeClass('blank-pic');
						  $('#profile_pic').html('<div class="uploader" id="uniform-jq-images"><input type="file" size="75" onchange="return ajaxFileUploadImg(\'jq-images\', \'file-parent\');" id="jq-images" name="jq-images" style="opacity: 0;"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action" style="-moz-user-select: none;">Choose File</span></div>');						  
							
							
							
						} else {
                          showErrorEx(data.error);
                        }
						
					} else {
                      showErrorEx(typeof(data));
                    }
				},
				error: function (data, status, e)
				{
					if (window.console){
					  console.log(data);
					  console.log(e);
					}
				}
			}
		);
		$('#jq-images').val('');
		$.uniform.update('#jq-images');
		return false;
	}
	$(function() {

	$( "#agreement" ).dialog({
		height: 500,
		width: 600,
		modal: true,
		autoOpen: false,
		buttons: {
			Close: function() {
				$( this ).dialog( "close" );
			}
		}
	});

});

function showAgreement() {
	$('#agreement_content').load(BASE_URL + 'home/user_agreement/true', function() {
	  $('#agreement').dialog('open');
	});

}



</script>