<?php
$test = $this->session->userdata('is_loged');
$test_id = $this->session->userdata('artist_id');
$ids = $this->session->userdata('artists');
$uri_test = $this->uri->segment(3);
if(isset($_POST['genre'])){
$genres_val = $_POST['genre'];
}else{
$genres_val = array();
}
?>	
<style>
.tab h2{float:left;border:1px solid #CCC;padding:5px;margin-right:5px;cursor:pointer;}
.tab h2.current{background-color:#EEE;}

.artist-nav{
width:929px;
height:	24px;
background:url(images/back-nav.jpg) no-repeat;
margin-bottom:6px;
padding:6px;
font-family:Arial, Helvetica, sans-serif;
}

.artist-nav .left{
float:left;
}

.artist-nav .right{
	float:right;
}
.artist-nav .btn{
display:block;
	width:58px;
	
}

.artist-nav div{
float:left;
display:block;
	width:500px;
	font-weight:bold;
	margin-left:10px;
	line-height:24px;
	color:#029ac1;
}
.artists{
display:block;
float:left;	
	margin-right:8px;
	margin-bottom:10px;
}
.artists ul{
	display:block;
	float:left;
	width:168px;
	height:281px;
	background:url(images/back-artist.jpg) no-repeat;
	padding:7px;
	margin:0px;
	list-style:none;
	color:#fff;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	
}
.artists  .title{
	display:block;
	float:left;
width:150px;
height:27px;
background:url(images/back-title.png) no-repeat;
margin-top:7px;
padding:8px;
font-weight:bold;
font-size:13px;
}
.artists  .rating{
	display:block;
	float:left;
width:150px;
height:13px;
margin-top:3px;
}
.artists  .genre{
	display:block;
	float:left;
width:150px;
height:41px;
background:url(images/back-genre.png) no-repeat;
margin-top:7px;
padding:8px;
}
.artists  .location{
	display:block;
	float:left;
width:150px;
height:16px;
background:url(images/back-location.png) no-repeat;
margin-top:7px;
padding:4px;
padding-left:8px;
padding-right:8px;
}
br{padding:0px !important;margin:0px !important;}
.spacer{height:3px; width:100%; clear:both;}
.uniform .form_title
 {
 margin-bottom:7px !important;
 }
</style>
	<form action="" method="post" enctype="multipart/form-data" class="uniform">
	<fieldset>
		
		<?php 
		//extract($_POST);
		if(!empty($results) && count($results)>0 && 0)
			$style = 'style="display:none;"';
		else
			$style = 'style="display:block;"';
		?>
		<!--<div align=right class="form_title">This indicates a mandatory field</div>	-->
		<div class="tab">
		<h2 class="current" style="text-transform:none;" id="simple_search" onclick="$('#criteria').show()">Simple Search</h2>
		<h2 onclick="$('#criteria').show(); " style="text-transform:none;" id="adv_search">Advanced Search</h2>
		<?php 
		if(!empty($results) && count($results)>0)
			echo '';
		else
			echo '<div style="float:right;"><span style="color:red">*</span> This indicates a mandatory field</div>';
		
		?>
		</div>
		<br class="cl"  />
		<div id="criteria" <?=$style?> 
		<div class="form_block">
			<div class="form_row">
				<div class="form_item" style="margin-bottom:0px;">
						<label>What type of Artist do you want to book? <span>*</span>
					 
					</label>
					<div class="simu_select1">
					<?//=form_dropdown('profile_type', $types, set_value('profile_type',@$_POST['profile_type']), 'id=profile_type')?>
					<?php $types[11]='Any'; ?>
					<?=form_dropdown('profile_type', $types, '', 'id=profile_type')?>
					</div>
				</div>
				<br class="cl" />
			</div><!--end of form_row-->
			
			<div class="form_row">
				<?php if(!empty($_POST['profile_type']) || isset($_POST['profile_type'])){
				
			?>
			
			<div id="genere_result">
			<div class="form_title div_genre" style="display:none;"><br class="cl" />
				Genres <span>*</span>
				<strong class="bubble_info">
				<img src="<?=base_url()?>images/question_mark_icon.png" style = "width:15px;height:15px;" alt="" class="img_ask" />
				<strong class="popup"><b>arrow</b><em>We cater to every type of preforming artist on Soundbooka. By selecting the genres that best describe your sound we can provide you with the gigs that best match your skill set.</em></strong>
				</strong>
			</div>
			<div class="form_block div_genre" style="display:none;">
			<p>Please select the genres that best describe your sound</p>
			<div class="form_row">
				<div class="form_item" style="margin-bottom:0px;">
					<ul>
					<?php 
					$result = mysql_query("select * from genre where active ='1' and artist_type = '{$_POST['profile_type']}' order by genre");
					$gen = array();
					while($row=mysql_fetch_array($result)){
						$gen[$row['artist_type']][] = array('id'=>$row['genre_id'],'genre'=>$row['genre']);
					}
					foreach ($gen as $at=>$gs) { ?>
						<?php ?>
						<? $gs = array_chunk($gs,6,1); ?>
						<? foreach ($gs as $gsx) : ?>
						<div class="option_col">
						<? 
						foreach ($gsx as $g) {?>
							
							<div class="option">
								<label>
									<input type="checkbox" <?php if(isset($_POST['genre'])){ if(in_array($g['id'],$_POST['genre'])) echo 'checked="checked"'; } ?> class="id_<?=$g['id']?> genre" name="genre[]" id="genre" value="<?=$g['id']?>"/>
									<strong><?php echo $g['genre'];?></strong>
								</label>
							</div>
							
						<? } 
						
						?>
						<br class="cl" /></div>
						<? endforeach; ?>
					<?php } ?>
					
					</ul>
				</div>
				<br class="cl" />
			</div><!--end of form_row-->
			</div>
			</div>
			<?php } ?>
			 
			</div><!--end of form_row-->
		</div><!--end of form_block-->
<div id="artist_info_disp" style="display:none;">				
	
		<?php $_POST['genre'] = array(); ?>
       
		<div class="form_row"  id="instrument_type">
         <div class="spacer"></div>
		<div class="form_title">Instrument</div>
		<div class="form_item">
			<label><font>What type of instrument do you require the solo artist to play?</font> <span></span></label>
			<input name="instrument" type="text" class="input1" id="instrument" value="<?php echo set_value('instrument',@$_POST['instrument']); ?>" />
		</div>
             <div class="spacer"></div>
		</div>
		<div class="form_row"  id="session_musician_instrument_type">
         <div class="spacer"></div>
           
        <div class="form_row" >
		<div class="form_title">Instrument</div>
        <div class="form_item">
			<label><font>What type of instrument do you require the session musician to play?</font> <span></span></label>
			<input name="instrument" type="text" class="input1" id="instrument" value="<?php echo set_value('instrument',@$_POST['instrument']); ?>" />
		</div><br class="cl"/>
		</div>
		</div>

        <div class="form_row"  id="groupband_lineup" >
       <div class="spacer"></div>
            <div class="form_title">Line-up</div>
				<label><font>What type of band line-up do you require?</font></label>
                <div class="form_item" style="color:#5F5F5F; font-size:13px; font-weight:normal;">
                   <input type="checkbox" name="band_lineup" value="2_piece_band" />&nbsp;2 piece band
                   </div>
				<div class="form_item" style="color:#5F5F5F; font-size:13px; font-weight:normal;">   
				   <input type="checkbox" name="band_lineup" value="3_piece_band" />&nbsp;3 piece band
                   </div>
				<div class="form_item" style="color:#5F5F5F; font-size:13px; font-weight:normal;">
				   <input type="checkbox" name="band_lineup" value="4_piece_band" />&nbsp;4 piece band
                   </div>
				<div class="form_item" style="color:#5F5F5F; font-size:13px; font-weight:normal;">
				   <input type="checkbox" name="band_lineup" value="5_piece_band" />&nbsp;5 piece band
                   </div>
				<div class="form_item" style="color:#5F5F5F; font-size:13px; font-weight:normal;">
				   <input type="checkbox" name="band_lineup" value="Other" />&nbsp;Other
                </div>
				<br class="cl"/>
       </div>
      <div class="spacer"></div>
	   <div class="form_title">Date & Time</div>
        <div class="form_title" id="DJ_datetime">
					<div class="fntclass"> On what date and at what time do you require a DJ?</div>
					</div>
         <div class="form_title" id="solo_datetime">
				<div class="fntclass">	On what date and at what time do you require a solo artist?</div>
		 </div>
          <div class="form_title" id="session_musician_datetime">
				<div class="fntclass">	On what date and at what time do you require a session musician?</div>
		  </div>
          <div class="form_title" id="prof_audio_datetime">
					<div class="fntclass">On what date and at what time do you require an audio professional?</div>
					</div>
          <div class="form_title" id="groupband_datetime">
					<div class="fntclass">On what date and at what time do you require a band?</div>
		  </div>
		  <div class="form_title" id="groupany_datetime" style="display:none;">
					<div class="fntclass">On what date and at what time do you require an artist?</div>
		  </div>
           
		<div class="form_row">
			<div class="form_item">
				<label><font>Start Date</font> <span></span></label>
				<input name="start_date" type="text" class="input7 datepick" id="startDate" value="<?php echo set_value('start_date',@$_POST['start_date']); ?>" />
			</div>
			<div class="form_item">
				<label><font>Start Time</font> <span></span></label>
				<div>
				<div style="float:left;">
				<input name="start_time" type="text" class="input3 datepick" id="start_time" value="<?php echo set_value('start_time',@$_POST['start_time']); ?>" />
				</div><div style="float:right;">
				<div class="simu_select4">
				<select name="start_hour">
				<option value="0">AM</option>
				<option value="1">PM</option>
				</select>
				</div></div></div>
			</div>
            
			<div class="form_item">
				<label><font>End Date</font> <span></span></label>
					<span id="end"><input name="end_date" type="text" class="input7 datepick" id="endDate"  value="<?php echo set_value('end_date',@$_POST['end_date']); ?>"/></span>
			</div>
			<div class="form_item">
				<label><font>End Time</font> <span></span></label>
				<div>
				<div style="float:left;">
				<input name="end_time" type="text" class="input3 datepick" id="end_time" value="<?php echo set_value('end_time',@$_POST['end_time']); ?>" />
				</div><div style="float:right;">
				<div class="simu_select4">
				<select name="end_hour">
				<option value="0">AM</option>
				<option value="1">PM</option>
				</select>
				</div></div></div>
			</div>
			<br class="cl" />
		</div>
		<div class="form_row">
       		
		<div class="form_title">Location</div>
		<div class="form_title" id="DJ_location" >
				<div class="fntclass">		Where would you like the DJ to perform?</div>
					</div>
        <div class="form_title" id="solo_location" >
				<div class="fntclass">		Where would you like the solo artist to perform?</div>
					</div>
         <div class="form_title" id="session_musician_location" >
					<div class="fntclass">	Where would you like the session musician to perform?</div>
					</div>
        <div class="form_title" id="prof_audio_location" >
					<div class="fntclass">	Where would you like to book the audio professional?</div>
					</div>
        <div class="form_title" id="groupband_location" >
				<div class="fntclass">		Where would you like the band to perform?</div>
					</div>
        <div class="form_title" id="any_location" >
					<div class="fntclass">	Where would you like the artist to perform?</div>
					</div>
		<div class="form_row">
			
			<div class="form_item">
				<label><font>Town/Suburb</font> <span></span></label>
				<input name="suburb" type="text" class="input1" id="suburb" value="<?php echo set_value('suburb',@$_POST['suburb']); ?>"/>
			</div>
			<div class="form_item">
				<label><font>Country/Region</font> <span></span></label>
				<div class="simu_select5"><?=form_dropdown('country', $countries, set_value('country',@$_POST['country']), 'id=country')?></div>
			</div>
			<div class="form_item">
				<label><font>State/Territory</font> <span></span></label>
				<?php if(!isset($_POST['state'])) $_POST['state'] = 0;?> 
                 <div class="simu_select3"><?=form_dropdown('state', $states, set_value('state',@$_POST['state']), 'id=state')?></div>
			</div>
			<div class="form_item">	
				<label><font>Postcode</font> <span></span></label>
				<input name="postcode" type="text" class="input3" id="postcode" value="<?php echo set_value('postcode',@$_POST['postcode']); ?>"/>
			</div>
		<div class="spacer"></div>
		</div>
        
        <div class="form_block" id="prof_audio_check">
        <input type="checkbox" name="" value="1" /><label><font>&nbsp;I would like the audio professional to work from their own studio.</font> <span></span></label>
<div class="spacer"></div>
        </div>
		<div class="form_row" id="gig_type">
              <div class="form_title">Gig Type</div>
                 				 
			<div class="form_item">
				<label id="advance_DJ_gig"><font>What type of gig do you need the DJ for?</font> <span></span></label>
                <label id="advance_solo_artist_gig"><font>What type of gig do you need the solo artist for?</font> <span></span></label>
                <label id="advance_group_band_gig"><font>What type of gig do you need the band for?</font> <span></span></label>
				<!--<div class="simu_select1">-->
					<?//form_dropdown('pref_gigs', $pref_gigs, set_value('pref_gigs',@$_POST['$pref_gigs']), '')
					$gs = array_chunk($pref_gigs, 3, true);
					if(!empty($_POST['$pref_gigs'])){
						$test = (in_array($ke,@$_POST['pref_gigs']) ? 'checked="checked"':'');
					}
					else{
						$test = '';
					}
					foreach ($gs as $new_gs) {
						echo '<div class="option_col">';
						foreach($new_gs as $ke => $va){
						?>
							<div class="option">
							<label>
							<input type="checkbox" name="pref_gigs[]" id="pref_gigs" value="<?=$ke?>" /><strong><?php echo $va;?></strong>
							</label>
							</div>
					<?php
						}
						echo '</div>';
					}
				?>
				<div class="option_col">
				<div class="option">
					<label>
					<!--Other Gig
					<br class="cl">
					<input type="text" name="other_gigs" id="other_gigs" value="<?php echo @$_POST['other_gigs'];?>" />-->
						<input value="99999" type="checkbox" name="pref_gigs[]" id="pref_gigs"><strong>Other</strong>
					</label>
				</div>
				</div>
			</div>
			<br class="cl">	
		</div>
		<div class="form_title">Budget</div>
		<div class="form_block">
					<div class="form_title" id="DJ_fee" >
					<div class="fntclass">What is your budget for the booking a DJ?</div>
					</div>
                    <div class="form_title" id="solo_fee">
					<div class="fntclass">What is your budget for the booking a solo artist?</div>
					</div>
                     <div class="form_title" id="session_musician_fee">
					<div class="fntclass">What is your budget for the booking a session musician?</div>
					</div>
                    <div class="form_title" id="prof_audio_fee" >
					<div class="fntclass">What is your budget for the booking an audio professional?</div>
					</div>
                    <div class="form_title" id="groupband_fee" >
					<div class="fntclass">What is your budget for the booking a band?</div>
					</div>
					<div class="form_title" id="any_fee" style="display:none;">
					<div class="fntclass">What is your budget for the booking an artist?</div>
					</div>
                    
 
					<div class="form_row">
						<div class="form_item">
							<!--<label>What is your Maximum fee per gig/session?</label>-->
							$ <input type="text" class="input1" name="fee_gig" id="fee_gig" value="<?php echo set_value('fee_gig',@$fee_gig); ?>" style="width:50px;text-align:right"/>
							
						</div>
						<br class="cl" />
					</div><!--end of form_row-->
</div>				
			</div><!--end of form_block-->
            <div id="advance_search_display">

	<div class="adv_search" style="display:none;">  <div class="spacer"></div>
			<div class="form_row" id="advance_DJ">
                <div class="form_title">Artist Name</div>
                <div class="form_item">
                    <label><font>Type the name of the DJ you wish to book?</font> <span></span></label>
                    <input name="artist_name" type="text" class="input1" value="<?php echo set_value('artist_name',@$_POST['artist_name'])?>"/>
                </div>
            	<br class="cl" />
			</div>
         	<div class="form_row" id="advance_solo_artist"> 
         		<div class="form_title">
					Artist Name
                 </div>
                 <div class="form_item">
                    <label><font>Type the name of the solo artist you wish to book?</font> <span></span></label>
                    <input name="artist_name" type="text" class="input1" value="<?php echo set_value('artist_name',@$_POST['artist_name'])?>"/>
                </div>
            	<br class="cl" />
			</div>
          <div class="form_row" id="advance_group_band"> 
         		<div class="form_title">
					Artist Name
                 </div>
                 <div class="form_item">
                    <label><font>Type the name of the band you wish to book?</font> <span></span></label>
                    <input name="artist_name" type="text" class="input1" value="<?php echo set_value('artist_name',@$_POST['artist_name'])?>"/>
                </div>
            	<br class="cl" />
			</div>
           <div class="form_row" id="advance_prof_service"> 
         		<div class="form_title">
				   Name of audio professional:
                 </div>
                 <div class="form_item">
                    <label><font>Type the name of the audio professional you wish to book</font> <span></span></label>
                    <input name="artist_name" type="text" class="input1" value="<?php echo set_value('artist_name',@$_POST['artist_name'])?>"/>
                </div>
            	<br class="cl" />
			</div>
          <div id="step2" style="display:none;">				
		<div class="form_title div_genre">
			Genres
		</div>
		<div class="form_block div_genre">
			<p id="DJ_genre" style="padding:0px 0px 0px 0px !important; margin:0px !important;">Please select the type of genre/s you would like your DJ play?</p>
            <p id="Solo_artist_genre" style="padding:0px 0px 0px 0px !important; margin:0px !important;">Please select the type of genre/s you would like your solo artist to play?</p>
            <p id="group_band_genre" style="padding:0px 0px 0px 0px !important; margin:0px !important;">Please select the type of genre/s you would like the band to play?</p>
          
			<div class="form_row">
				<?php 
					foreach ($genres as $at=>$gs) {
					?>
					<div class="option_col_x at_<?=$at?>" style="display:none">
						<?php $_POST['genre'] = array(); ?>
						<? $gs = array_chunk($gs,6,1); ?>
						<? foreach ($gs as $gsx) : ?>
						<div class="option_col">
						<? foreach ($gsx as $g) {?>
							
							<div class="option">
								<label>
									<input type="checkbox" <?php if(isset($_POST['genre'])){ if(in_array($g['id'],$_POST['genre'])) echo 'checked="checked"'; } ?> class="id_<?=$g['id']?> genre" name="genre[]" id="genre" value="<?=$g['id']?>"/>
									<strong><?php echo $g['genre'];?></strong>
								</label>
							</div>
							
						<? } 
						
						?>
						<div class="spacer"></div>
						</div>
						<? endforeach; 
						
						?>
					
					
					</div><!--end of option_col-->
					<?php } ?>
				
				
		</div>
	</div>   <!--end of form_block-->
</div>   
        
       
		<div id="div_specialization" style="display:none">                
			<div class="form_title">Specialisation <span>*</span></div>
				<div class="form_block">
					<div class="form_row">
					<div class="form_item">
						<label>I require an audio professional who specialises in?</label>
						
						<? $specializations_grp = array_chunk($specializations,3,true); ?>
						
						<?//(in_array($k,@$specialization) ? 'checked="checked"':'')?>
						<? foreach ($specializations_grp as $sgrp) : ?>
						<div class="option_col">
						<? foreach ($sgrp as $k=>$s) : ?>
						<div class="options">
								<label style="margin-bottom:5px">
									<input class="specialization" name="specialization_arr[]" type="checkbox" id="specialization_<?=$k?>" value="<?=$k?>" />
									<strong><?=$s?></strong>
							</label>
						  </div>  
						<? endforeach; ?>
						</div>
						<? endforeach; ?>
						</div>							 			
						</div>
				</div><!--end of form_block-->
				
				<div class="shadow_line_nobg">line</div>
				
				<div class="form_title">Preferred Medium</div>
				<div class="form_block">
				<div class="form_row">
					<div class="form_item">
						<label>I require an audio professional who works in the following medium?</label>
						
						<div class="options">
						<?//(in_array($k,@$preferred_medium) ? 'checked="checked"':'')?>
						<? foreach ($mediums as $k=>$s) : ?>
								<label style="margin-bottom:5px">
									<input class="preferred_medium" name="preferred_medium_arr[]" type="checkbox" id="preferred_medium_<?=$k?>" value="<?=$k?>" />
									<strong><?=$s?></strong>
							</label>
						<? endforeach; ?>
						</div>
						</div>
					 <div class="spacer"></div>
					</div>
				</div><!--end of form_block-->
				<div class="shadow_line_nobg">line</div>
				
				
		</div>
         <div class="form_row" id="advance_DJ_equipment"> 
				  <div class="spacer"></div>
         		<div class="form_title">Equipment</div>
                <div class="form_item"><label>  Do you require the DJ to bring their own equipment?</label></div>
                 <br class="cl" />
                
                 <div class="form_item" style="width:275px;">
                   <input type="checkbox" name="band_lineup" value="2_piece_band" /><label><font>&nbsp;I require the DJ to bring their own equipment</font> </label>
				 </div>
				 <div class="form_item" style="width:150px;">
                   <input type="checkbox" name="band_lineup" value="3_piece_band" /><label><font>&nbsp;I will supply equipment</font> </label>
                </div>
                <div class="form_item" id="list_equipment" >
                  <label style='float:left;'><font>Please list equipment you will provide?</font> <span>&nbsp;</span></label>
                  <input type="text"  name="equipment_list" style='width:100px;float:left;'/>
                  </div>
            	
		</div>
         <div class="form_row" id="advance_group_band_equipment"> 
		 <br class="cl" />
         		<div class="form_title">Equipment</div>
                <div class="form_item"><label> Do you require the band to bring his or her own equipment?</div>
                <br class="cl" />
                
                 <div class="form_item" style="width:285px;">
                   <input type="checkbox" name="band_lineup" value="2_piece_band" /><label><font>&nbsp;I require the band to bring their own equipment</font> </label>
				   </div>
				   <div class="form_item" style="width:150px;">
                   <input type="checkbox" name="band_lineup" value="3_piece_band" /><label><font>&nbsp;I will supply equipment</font> </label>
                </div>
                  <div class="form_item">
                  <label style='float:left;'><font>Please list equipment you will provide?</font> <span>&nbsp;</span></label>
                  <input type="text"  name="equipment_list" style='width:100px;float:left;'/>
                  </div>
             
		</div>
        <div class="form_row" id="advance_solo_artist_equipment"> 
         		<br class="cl" />
				<div class="form_title">Equipment</div>
                <div class="form_item"><label> Do you require the band to bring their own equipment?</div>
                <br class="cl" />
                 
                 <div class="form_item" style="width:285px;">
                   <input type="checkbox" name="band_lineup" value="2_piece_band" /><label><font>&nbsp;I require the solo artist to bring their own equipment</font> </label>
				   </div>
				   <div class="form_item" style="width:150px;">
                    <input type="checkbox" name="band_lineup" value="3_piece_band" /><label><font>&nbsp;I will supply equipment</font> </label>
                    </div>
                  <div class="form_item">
                    <label style='float:left;'><font>Please list equipment you will provide?</font> <span>&nbsp;</span></label>
                    <input type="text"  name="equipment_list" style='width:100px;float:left;'/>
                  </div>
            	 
		</div> <div class="spacer"></div>
        <div class="form_row" id="gig_type">
              
        
		<div class="spacer"></div>
		
		</div>
        
		<div class="form_item" id="another_artist"><div class="spacer"></div>
			<div class="form_title">DJ Combo/Group</div>
			<label>
				Do  you require another artist to perform with the DJ (DJ Combo)or require a DJ group?
			</label>
			<br class="cl" />
			<div class="options">
					<label>
							<input name="require_other_artist" type="checkbox" id="travel_city" value="1"  <?php if(!empty($_POST['require_other_artist'])){ echo 'checked=checked'; } ?> />
							<strong>Yes I require another musician to play with the DJ</strong>
					</label>
					<br class="cl" />	
						<label>
							<input name="require_other_group" type="checkbox" id="travel_state" value="1" <?php if(!empty($_POST['require_other_group'])){ echo 'checked=checked'; } ?>  />
							<strong>Yes I require a DJ group</strong>
					</label>
					<br class="cl" />	
						<label>
							<input name="require_no_other" type="checkbox" id="travel_interstate" value="1" <?php if(!empty($_POST['require_no_other'])){ echo 'checked=checked'; } ?> />
							<strong>No I do not require a DJ group or Combo</strong>
					</label>				
					</div>
				 
		</div>
	 
		<div class="form_row" id="availability">
						<div class="form_item">
							<label>Availability<span></span></label>
							<div class="options">
							<ul>
								<li class="options-span"><h6>Monday</h6>
									<input <?php if(isset($_POST['availability'])) { if(in_array('mon_day',$_POST['availability'])) echo 'checked="checked"'; }?> style="margin-left:5px" name="availability[]" type="checkbox" id="mon_day" value="mon_day"/><strong style="margin-right:5px"> Day</strong>
									<input <?php if(isset($_POST['availability'])) { if(in_array('mon_night',$_POST['availability'])) echo 'checked="checked"'; }?> name="availability[]" type="checkbox" id="mon_night" value="mon_night"/><strong> Night</strong>
						    </li>
								
								<li class="options-span"> 
									<h6>Tuesday</h6>
									<input <?php if(isset($_POST['availability'])) { if(in_array('tue_day',$_POST['availability'])) echo 'checked="checked"'; }?> style="margin-left:5px" name="availability[]" type="checkbox" id="tue_day" value="tue_day"/><strong style="margin-right:5px"> Day</strong>
									<input <?php if(isset($_POST['availability'])) { if(in_array('tue_night',$_POST['availability'])) echo 'checked="checked"'; }?> name="availability[]" type="checkbox" id="tue_night" value="tue_night" /><strong> Night</strong>
						    </li>
								
								<li class="options-span"> 
									<h6>Wednesday</h6>
									<input <?php if(isset($_POST['availability'])) { if(in_array('thu_day',$_POST['availability'])) echo 'checked="checked"'; }?> style="margin-left:5px" name="availability[]" type="checkbox" id="wed_day" value="wed_day"/><strong style="margin-right:5px"> Day</strong>
									<input <?php if(isset($_POST['availability'])) { if(in_array('thu_day',$_POST['availability'])) echo 'checked="checked"'; }?> name="availability[]" type="checkbox" id="wed_night" value="wed_night"/><strong> Night</strong>
						    </li>
								
								<li class="options-span"> 
									<h6>Thursday</h6>
									<input <?php if(isset($_POST['availability'])) { if(in_array('thu_day',$_POST['availability'])) echo 'checked="checked"'; }?> style="margin-left:5px" name="availability[]" type="checkbox" id="thu_day" value="thu_day"/><strong style="margin-right:5px"> Day</strong>
									<input <?php if(isset($_POST['availability'])) { if(in_array('thu_night',$_POST['availability'])) echo 'checked="checked"'; }?> name="availability[]" type="checkbox" id="thu_night" value="thu_night"/><strong> Night</strong>
						    </li>
								
								<li class="options-span"> 
									<h6>Friday</h6>
									<input <?php if(isset($_POST['availability'])) { if(in_array('fri_day',$_POST['availability'])) echo 'checked="checked"'; }?> style="margin-left:5px" name="availability[]" type="checkbox" id="fri_day" value="fri_day"/><strong style="margin-right:5px"> Day</strong>
									<input <?php if(isset($_POST['availability'])) { if(in_array('fri_night',$_POST['availability'])) echo 'checked="checked"'; }?> name="availability[]" type="checkbox" id="fri_night" value="fri_night"/><strong> Night</strong>
						    </li>
								
								<li class="options-span"> 
									<h6>Saturday</h6>
									<input <?php if(isset($_POST['availability'])) { if(in_array('sat_day',$_POST['availability'])) echo 'checked="checked"'; }?> style="margin-left:5px" name="availability[]" type="checkbox" id="sat_day" value="sat_day"/><strong style="margin-right:5px"> Day</strong>
									<input <?php if(isset($_POST['availability'])) { if(in_array('sat_night',$_POST['availability'])) echo 'checked="checked"'; }?> name="availability[]" type="checkbox" id="sat_night" value="sat_night"/><strong> Night</strong>
						    </li>
								
								<li class="options-span"> 
									<h6>Sunday</h6>
									<input <?php if(isset($_POST['availability'])) { if(in_array('sun_day',$_POST['availability'])) echo 'checked="checked"'; }?> style="margin-left:5px" name="availability[]" type="checkbox" id="sun_day" value="sun_day"/><strong style="margin-right:5px"> Day</strong>
									<input <?php if(isset($_POST['availability'])) { if(in_array('sun_night',$_POST['availability'])) echo 'checked="checked"'; }?> name="availability[]" type="checkbox" id="sun_night" value="sun_night"/><strong> Night</strong>
								</li>
							</ul>	
							</div>
						</div><!--end of form_item-->
						<br class="cl" />
						
					</div><!--end of form_row-->
                    
			<div class="form_row">
		 <div class="spacer"></div>
				<div class="form_title">Payment Method</div>
				<h6 id="advance_DJ_payment">How would you like to pay the DJ?</h6>
                <h6 id="advance_solo_artist_payment"> How would you like to pay the solo artist?</h6>
                <h6 id="advance_group_band_payment"> How would you like to pay the band?</h6>
               <br class="cl" />
				<div class="form_item" style="width: 65px;">
					
					<input name="payment_method" type="radio" value="1" <?php if(@$_POST['payment_method'] == 1) echo 'checked="checked"';?> />
					<label>&nbsp;PayPal</label>
				</div>
				<div class="form_item" style="width: 65px;">
					
					<input name="payment_method" type="radio" value="2"<?php if(@$_POST['payment_method'] == 2) echo 'checked="checked"';?> />
					<label>&nbsp;Cash</label>
				</div>
				<div class="form_item" style="width: 65px;">
					
					<input name="payment_method" type="radio" value="3" <?php if(@$_POST['payment_method'] == 3) echo 'checked="checked"';?>/>
					<label>&nbsp;Either</label>
				</div>
				<br class="cl" />
			</div><!--end of form_item-->

		</div>	
	</div>	
			<div class="shadow_line_nobg">line</div>
				
				<input type="submit" value="Search" class="input_continue" name="save" style="margin-right:20px;" />	
		</div>
		<br class="cl" />
	<?php

if(!empty($results) && count($results)>0){
?>
	<script>
	$(function() {
		$('#criteria').hide();
		
	});
	</script>
	<div class="form_item" style="float:left;width:100%;">    	
    <div style="float:left;width:100%;">
        <div class="total_results" style="width: 45%;text-align:left;font-weight:bold; float:left; padding-top:10px; padding-bottom:10px;">
           
        </div>
        <div id="page_navigation" style="width: 53%;float:left; text-align:right; padding-top:10px; padding-bottom:10px;">                  
        </div>
    </div>
	<br class="cl"/>
	<?php
	$i=0;
	?>
	<div style="display:none;"><?php 	
	switch($results[0]['profile_type']){
		case 1: $profile_type_name = 'DJ'; break;
		case 3: $profile_type_name = 'Solo Artist'; break;
		case 7: $profile_type_name = 'Group/Band'; break;
		case 9: $profile_type_name = 'Session Musician'; break;
		case 10: $profile_type_name = 'Professional Audio Services'; break;
	}
	echo $profile_type_name;
	?></div>
	<div class="artist-nav" >
		<?php /* ?><span class="btn left"><img src="<?=base_url()?>images/prev-btn.jpg" width="58" height="22" alt=" "/></span><?php */ ?>
		<div><?php echo $profile_type_name;?></div>
		<?php /* ?><span class="btn right"><img src="<?=base_url()?>images/next-btn.jpg" width="58" height="22" alt=" "/></span><?php */ ?>
	</div>
    <div id="paginationcontent">
	<?php
	foreach($results as $r) {
		$i++;
		$images = $this->mArtist->getArtistImages($r['id']);
		$rating = $this->mArtist->getRating($r['id']);	
		
		$atype=$r['profile_type'];
		$genre=explode(',',$r['genre1']);
		$gen=array();
		if(!empty($genres_val)){
			foreach($genres_val as $g){
				if(!in_array($g,$genre)) continue;
				$gen[]= $allgenres[$g];
			}
		}
		$l_gen = array();
		$x=0;
		foreach($gen as $a){ $x++;
			if($x<5) $l_gen[]=$a;
		}
		
		$profile_name=str_replace(' ','_',$r['profile_name']);
		
	?>
	
	<div class="artists" >
	  <ul>
		<li class="img"><a href="<?php echo base_url().'profile/view/'.$profile_name; ?>">
			<?php 
			if(isset($images[0]->id) && !empty($images[0]->id)){
			echo '<img src="'.base_url().'wpdata/images/'. $images[0]->id .'-medium.jpg" width="166" height="120" />';
			}
			else {	?>
			<img src="images/no_image.jpg" width="166" height="120" alt=" " />
			<?php }?>
			</a></li>
		<li class="title"><a href="<?php echo base_url().'profile/view/'.$profile_name; ?>"><?php echo $r['profile_name'];?></a></li>
		<li class="rating">
			<?php 
			for($x=0;$x<5;$x++){
				if(isset($rating[0]['star_rate']) and $x < $rating[0]['star_rate']){
					?><img  style="vertical-align:text-top;" width="14" height="13" alt=" " src="<?=base_url()?>images/star-blue.png"><?php
				}
				else{
					?><img style="vertical-align:text-top;" width="14" height="13" alt=" " src="<?=base_url()?>images/star-grey.png"><?php
				}
				
			}?>
		</li>
		<li class="genre"><?php echo implode(', ',$l_gen); if(count($gen) >4) echo ' and more..';?></li>
		<li class="location"><?php echo $r['suburb']; ?></li>
	  </ul>
	</div>
	<?php 
	//if($i%5==0) echo '<br class="cl"/><br>';
	} ?>
    </div>
    <input type="hidden" name="current_page" id="current_page">
    <input type="hidden" name="show_per_page" id="show_per_page">
    				<br class="cl" />

    
	</div>
<?php
}
if($res == '0'){ 
echo '<div class="total_results" style="text-align:center;font-weight:bold;">No Results Found</div>'; 
}

unset($_POST);
?>

	</fieldset>
	</form>
</div>

	<br class="cl" />
<script>
$(function() {
	
	$('#fee_hour').keypress(function() {
		$('#fee_gig').val('0');
	});
	$('#fee_gig').keypress(function() {
		$('#fee_hour').val('0');
	});
	
	$( "#startDate" ).datepicker({dateFormat: 'dd/mm/yy'});
	$( "#startDate" ).change(function(){
		test = $(this).datepicker('getDate');
		testm = new Date(test.getTime());
		testm.setDate(testm.getDate());
		$('#end').html('<input name="end_date" type="text" class="input7 datepick" id="endDate" />');
		$( "#endDate" ).datepicker({dateFormat: 'dd/mm/yy',minDate:testm});
	});
    
	
	$('#profile_type').change(function() {
	$('#step2').show();
    $('.sample').remove();
	//$('<div class="option genboxdivother sample"><label><div class="checker" id="uniform-genre"><span><input type="checkbox" class="id_99999 genre other_gen_box" name="genre[]" id="genre" value="99999" style="opacity: 0;" onclick="return AddGenTextBox();"></span></div><strong>Other</strong></label><label><div id="gen_textbox" style="padding-top:20px; display:none" ><input type="text" name="other_gen" class="input1" id="other_gen" value="" style="width:50px;"/> </div></div>').insertAfter('.at_'+$('#profile_type').val()+ ' .option:last');	
    //$.uniform.update('input.other_gen_box');  
	$('#genere_result').hide();
		if ($(this).val() == '') {
			$('#step2').slideUp('fast');
		} else {
			$('#step2').slideDown('fast');
		}
	switch(document.getElementById('profile_type').value){
			case '0': 
				$('#artist_info_disp').hide();
				$('#advance_search_display').hide();
				$('#advance_prof_service').hide();
				$('#div_specialization').hide();
				$('#another_artist').hide();	
				break;
			case '1': 
				$('#artist_info_disp').show();
				$('#DJ_datetime').show();
				$('#DJ_location').show();
				$('#DJ_fee').show();
				$('#step2').show();
				$('#DJ_genre').show();
				$('#advance_DJ').show();
				$('#gig_type').show();
				$('#advance_DJ_gig').show();
				$('#advance_DJ_equipment').show();
				$('#advance_DJ_payment').show();
				$('#advance_solo_artist').hide();
				$('#instrument_type').hide();
				$('#Solo_artist_genre').hide();
				$('#solo_datetime').hide();
				$('#solo_location').hide();
				$('#solo_fee').hide();
				$('#prof_audio_datetime').hide();
				$('#prof_audio_location').hide();
				$('#prof_audio_fee').hide();
				$('#prof_audio_check').hide();
				$('#session_musician_datetime').hide();
				$('#session_musician_location').hide();
				$('#session_musician_fee').hide();
				$('#groupband_lineup').hide();
				$('#groupband_datetime').hide();
				$('#groupband_location').hide();
				$('#groupband_fee').hide();
				$('#session_musician_instrument_type').hide();
				$('#availability').hide();
				$('#advance_solo_artist_equipment').hide();
				$('#advance_solo_artist_gig').hide();
				$('#advance_solo_artist_payment').hide();
				$('#advance_group_band').hide();
				$('#group_band_genre').hide();
				$('#advance_group_band_equipment').hide();
				$('#advance_group_band_gig').hide();
				$('#advance_group_band_payment').hide();
				$('#advance_prof_service').hide();
				$('#advance_search_display').show();
				$('#any_location').hide();
				$('#advance_prof_service').hide();
				$('#div_specialization').hide();
				$('#any_fee').hide();
				$('#another_artist').show();
				$('#groupany_datetime').hide();
				break;
			case '3':
				$('#artist_info_disp').show();
				$('#solo_datetime').show();
				$('solo_location').show();
				$('#solo_fee').show();
				$('#gig_type').show();
				$('#instrument_type').show();
				$('#advance_solo_artist').show();
				$('#step2').show();
				$('#Solo_artist_genre').show();
				$('#advance_solo_artist_equipment').show();
				$('#advance_solo_artist_gig').show();
				$('#advance_solo_artist_payment').show();
				$('#advance_DJ').hide();
				$('#advance_DJ_gig').hide();
				$('#DJ_datetime').hide();
				$('#DJ_location').hide();
				$('#DJ_fee').hide();
				$('#advance_DJ_equipment').hide();
				$('#DJ_genre').hide();
				$('#group_band_genre').hide();
				$('#prof_audio_datetime').hide();
				$('#prof_audio_location').hide();
				$('#prof_audio_fee').hide();
				$('#prof_audio_check').hide();
				$('#session_musician_datetime').hide();
				$('#session_musician_location').hide();
				$('#session_musician_fee').hide();
				$('#groupband_lineup').hide();
				$('#groupband_datetime').hide();
				$('#groupband_location').hide();
				$('#groupband_fee').hide();
				$('#session_musician_instrument_type').hide();
				$('#advance_DJ_payment').hide();
				$('#availability').hide();
				$('#any_location').hide();
				$('#advance_group_band').hide();
				$('#advance_group_band_equipment').hide();
				$('#advance_group_band_gig').hide();
				$('#advance_group_band_payment').hide();
				$('#advance_prof_service').hide();
				$('#advance_search_display').show();
				$('#advance_prof_service').hide();
				$('#div_specialization').hide();
				$('#any_fee').hide();
				$('#another_artist').hide();
				$('#groupany_datetime').hide();
				break;
			case '10':
				$('#artist_info_disp').show();
				$('#solo_datetime').hide();
				$('#solo_location').hide();
				$('#solo_fee').hide();
				$('#instrument_type').hide();
				$('#DJ_datetime').hide();
				$('#advance_group_band_equipment').hide();
				$('#DJ_location').hide();
				$('#DJ_fee').hide();
				$('#DJ_genre').hide();
				$('#gig_type').hide();
				$('#group_band_genre').hide();
				$('#advance_group_band_gig').hide();
				$('#Solo_artist_genre').hide();
				$('#advance_solo_artist').hide();
				$('#advance_DJ').hide();
				$('#session_musician_datetime').hide();
				$('#session_musician_location').hide();
				$('#session_musician_fee').hide();
				$('#groupband_lineup').hide();
				$('#advance_DJ_payment').hide();
				$('#groupband_datetime').hide();
				$('#groupband_location').hide();
				$('#groupband_fee').hide();
				$('#advance_DJ_gig').hide();
				$('#advance_DJ_equipment').hide();
				$('#session_musician_instrument_type').hide();
				$('#advance_solo_artist_equipment').hide();
				$('#advance_solo_artist_payment').hide();
				$('#advance_solo_artist_gig').hide();
				$('#advance_group_band').hide();
				$('#availability').hide();
				$('#any_location').hide();
				$('#advance_group_band_payment').show();
				$('#prof_audio_datetime').show();
				$('#step2').hide();
				$('#advance_search_display').show();
				$('#prof_audio_location').show();
				$('#prof_audio_fee').show();
				$('#prof_audio_check').show();
				$('#advance_prof_service').show();
				$('#div_specialization').show();
				$('#any_fee').hide();
				$('#another_artist').hide();
				$('#groupany_datetime').hide();
				break;
			case '9':
				$('#artist_info_disp').show();
				$('#solo_datetime').hide();
				$('#gig_type').hide();
				$('#instrument_type').hide();
				$('#solo_location').hide();
				$('#solo_fee').hide();
				$('#advance_group_band_equipment').hide();
				$('#DJ_datetime').hide();
				$('#DJ_location').hide();
				$('#advance_group_band_gig').hide();
				$('#DJ_fee').hide();
				$('#Solo_artist_genre').hide();
				$('#advance_solo_artist').hide();
				$('#advance_DJ').hide();
				$('#availability').hide();
				$('#DJ_genre').hide();
				$('#prof_audio_datetime').hide();
				$('#prof_audio_location').hide();
				$('#prof_audio_fee').hide();
				$('#groupband_lineup').hide();
				$('#groupband_datetime').hide();
				$('#groupband_location').hide();
				$('#group_band_genre').hide();
				$('#groupband_fee').hide();
				$('#advance_group_band_payment').hide();
				$('#prof_audio_check').hide();
				$('#advance_DJ_equipment').hide();
				$('#advance_solo_artist_gig').hide();
				$('#advance_DJ_gig').hide();
				$('#advance_solo_artist_payment').hide();
				$('#advance_DJ_payment').hide();
				$('#advance_prof_service').hide();
				$('#advance_group_band').hide();
				$('#advance_solo_artist_equipment').hide();
				$('#advance_search_display').hide();
				$('#any_location').hide();
				$('#step2').hide();
				$('#session_musician_datetime').show();
				$('#session_musician_location').show();
				$('#session_musician_fee').show();
				$('#session_musician_instrument_type').show();
				$('#advance_prof_service').hide();
				$('#div_specialization').hide();
				$('#any_fee').hide();
				$('#another_artist').hide();
				$('#groupany_datetime').hide();
				break;
			case '7':
				$('#artist_info_disp').show();
				$('#solo_datetime').hide();
				$('#any_location').hide();
				$('#Solo_artist_genre').hide();
				$('#instrument_type').hide();
				$('#solo_location').hide();
				$('#solo_fee').hide();
				$('#gig_type').show();
				$('#DJ_datetime').hide();
				$('#DJ_location').hide();
				$('#DJ_fee').hide();
				$('#DJ_genre').hide();
				$('#prof_audio_datetime').hide();
				$('#advance_solo_artist').hide();
				$('#prof_audio_location').hide();
				$('#prof_audio_fee').hide();
				$('#prof_audio_check').hide();
				$('#advance_DJ_payment').hide();
				$('#advance_solo_artist_payment').hide();
				$('#session_musician_datetime').hide();
				$('#session_musician_location').hide();
				$('#advance_DJ_equipment').hide();
				$('#session_musician_fee').hide();
				$('#session_musician_instrument_type').hide();
				$('#advance_DJ_gig').hide();
				$('#advance_solo_artist_equipment').hide();
				$('#advance_solo_artist_gig').hide();
				$('#availability').hide();
				$('#advance_prof_service').hide();
				$('#step2').show();
				$('#groupband_lineup').show();
				$('#groupband_datetime').show();
				$('#groupband_location').show();
				$('#advance_group_band_gig').show();
				$('#group_band_genre').show();
				$('#groupband_fee').show();
				$('#advance_group_band_equipment').show();
				$('#advance_group_band').show();
				$('#advance_group_band_payment').show();
				$('#advance_search_display').show();
				$('#advance_prof_service').hide();
				$('#div_specialization').hide();
				$('#any_fee').hide();
				$('#another_artist').hide();
				$('#groupany_datetime').hide();
				break;
			case '11':
				$('#artist_info_disp').show();
				$('#solo_datetime').hide();
				$('#any_location').show();
				$('#solo_fee').hide();
				$('#any_fee').show();
				$('#groupany_datetime').show();
				$('#solo_location').hide();
				$('#instrument_type').hide();
				$('#advance_solo_artist').hide();
				$('#step2').hide();
				$('#Solo_artist_genre').hide();
				$('#advance_solo_artist_equipment').hide();
				$('#advance_solo_artist_gig').hide();
				$('#advance_solo_artist_payment').hide();
				$('#advance_DJ').hide();
				$('#advance_DJ_gig').hide();
				$('#DJ_datetime').hide();
				$('#DJ_location').hide();
				$('#DJ_fee').hide();
				$('#advance_DJ_equipment').hide();
				$('#DJ_genre').hide();
				$('#group_band_genre').hide();
				$('#prof_audio_datetime').hide();
				$('#prof_audio_location').hide();
				$('#prof_audio_fee').hide();
				$('#prof_audio_check').hide();
				$('#session_musician_datetime').hide();
				$('#session_musician_location').hide();
				$('#session_musician_fee').hide();
				$('#groupband_lineup').hide();
				$('#groupband_datetime').hide();
				$('#groupband_location').hide();
				$('#groupband_fee').hide();
				$('#session_musician_instrument_type').hide();
				$('#advance_DJ_payment').hide();
				$('#availability').hide();
				$('#advance_group_band').hide();
				$('#advance_group_band_equipment').hide();
				$('#advance_group_band_gig').hide();
				$('#advance_group_band_payment').hide();
				$('#advance_prof_service').hide();
				$('#advance_search_display').hide();
				$('#advance_prof_service').hide();
				$('#div_specialization').hide();
				$('#another_artist').hide();
				break;
		}
		$('.div_genre').hide();
		$('.option_col_x').hide();
		$('input.genre').attr('checked',false);
		$.uniform.update('input.genre');
		
		$('.at_'+$(this).val()).show();
		$('.div_genre').slideDown();
		
/*		if($(this).val()==1) $('#instrument_type').show();
		else $('#instrument_type').hide();
*/	});
	
	//$('#profile_type').val('<?php echo @$_POST['profile_type'];?>');
	
	$('.tab h2').click(function(){
		$('.tab h2').removeClass('current');
		$(this).addClass('current');
		$v=$(this).attr('id');
		if($v=='adv_search') $('.adv_search').show();
		else {
			$('.adv_search').hide();
			$('.adv_search').find('input:checkbox').attr('checked',false);
			$('.adv_search').find('input:checkbox').removeAttr('checked');
			$('.adv_search').find('input:text').val('');
			$('.adv_search').find('select').val(0).click();
			$.uniform.update('select');
			$.uniform.update('input:checkbox');
			
			$('#profile_type').change();
		}
	});
    
	
	
});
    function AddGenTextBox()
        {
        
        if($(":checked").val()==1){        
        $('.at_'+$('#profile_type').val()+ ' .option:last span').toggleClass("checked");     
        //    $('#gen_textbox').toggle();        
        }else{
        $('.at_'+$('#profile_type').val()+ ' .option:last span').toggleClass("");
        //$('#gen_textbox').toggle();

        }
    }
    
    $(document).ready(function(){

    //how much items per page to show
    var show_per_page = 10;
    //getting the amount of elements inside content div
    var number_of_items = $('#paginationcontent').children().size();
    //calculate the number of pages we are going to have
    var number_of_pages = Math.ceil(number_of_items/show_per_page);

    //set the value of our hidden input fields
    $('#current_page').val(0);
    $('#show_per_page').val(show_per_page);

    //now when we got all we need for the navigation let's make it '

    /*
    what are we going to have in the navigation?
        - link to previous page
        - links to specific pages
        - link to next page
    */
    var navigation_html = '<a class="previous_link btn_pagination" href="javascript:previous();">Prev</a>';
    var current_link = 0;
     while(number_of_pages > current_link){
        navigation_html += '<a class="page_link" href="javascript:go_to_page(' + current_link +')" longdesc="' + current_link +'">'+ (current_link + 1) +'</a>';
        current_link++;
    }

    navigation_html += '<a class="next_link btn_pagination" href="javascript:next();">Next</a>';

    $('#page_navigation').html(navigation_html);

    //add active_page class to the first page link
    $('#page_navigation .page_link:first').addClass('active_page');

    //hide all the elements inside content div
    $('#paginationcontent').children().css('display', 'none');

    //and show the first n (show_per_page) elements
    $('#paginationcontent').children().slice(0, show_per_page).css('display', 'block');

});

function previous(){

    new_page = parseInt($('#current_page').val()) - 1;
    //if there is an item before the current active link run the function
    if($('.active_page').prev('.page_link').length==true){
        go_to_page(new_page);
    }

}

function next(){
    new_page = parseInt($('#current_page').val()) + 1;
    //if there is an item after the current active link run the function
    if($('.active_page').next('.page_link').length==true){
        go_to_page(new_page);
    }

}
function go_to_page(page_num){
    //get the number of items shown per page
    var show_per_page = parseInt($('#show_per_page').val());

    //get the element number where to start the slice from
    start_from = page_num * show_per_page;   

    //get the element number where to end the slice
    end_on = start_from + show_per_page;
    
    //hide all children elements of content div, get specific items and show them
    $('#paginationcontent').children().css('display', 'none').slice(start_from, end_on).css('display', 'block');

    /*get the page link that has longdesc attribute of the current page and add active_page class to it
    and remove that class from previously active page link*/
    $('.page_link[longdesc=' + page_num +']').addClass('active_page').siblings('.active_page').removeClass('active_page');

    //update the current page input field
    $('#current_page').val(page_num);
}
</script>
