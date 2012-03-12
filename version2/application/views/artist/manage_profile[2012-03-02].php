<?php
$test = $this->session->userdata('is_loged');
$test_id = $this->session->userdata('artist_id');
$ids = $this->session->userdata('artists');
$uri_test = $this->uri->segment(3);
if($test  == '1' && !empty($test)){?>
<h1>My Profiles</h1>
			
<?php } else{
$this->session->set_userdata('is_loged', false);
$this->session->set_userdata('artist', null);
$test_id = '';
?>
<h1>My Profiles</h1>
		
<?php } ?>		
			
	<h2>Other profiles</h2>
	<div class="form_title">
	<table class="instrument_table" id="tbl_audio">
	  <tr>
		<th width="30%" style="important;border-left: 1px solid #999999 !important;">Profile Name</th>
		<th width="28%">Artist Type</th>
		<th width="12%" style="text-align:center;">Profile Views</th>
		<th width="15%">&nbsp;</th>
		<th width="15%">&nbsp;</th>
	  </tr>
	<?php
	foreach($artist_type as $key => $val){
		$artist_value[$val['artist_id']] =  $val['type'];
	}
	//print_r($artist_value);
	
	foreach($other_profiles as $val){
		//print_r($val['profile_type']);
		$profile_name=str_replace(' ','_',$val['profile_name']);
		if($profile_name=='') continue;
		//echo $id = $val['profile_type'];
		echo 
		'<tr>
			<td style="border-left: 1px solid #999999 !important;">'.$val['profile_name'].'</td>
			<td>'.$artist_value[$val['profile_type']].'</td>
			<td style="text-align:right;">'.$val['views'].'</td>
			
			<td><a href="'.base_url().'profile/view/'.$profile_name.'">View profile</a></td>
			<td><a href="'.base_url().'artist/step1/'.$val['id'].'">Edit profile</a></td>
		</tr>';
	
	}
	?>
	</table>
	<!--<div class="btn_row" style="float: right ! important; width: 18% ! important; margin-right: -20px;">
	<a href="<?=base_url()?>artist/create_new/<?=$test_id?>">Click here to add a new profile</a>
	</div>-->
	<input style="background-image:none;width: 145px !important;" type="button" value="Add a new profile" class="input_continue" name="signin" onclick="window.location='<?=base_url()?>artist/create_new/<?=$test_id?>'" />
	</div>

	