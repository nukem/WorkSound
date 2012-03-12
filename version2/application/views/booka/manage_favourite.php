<?php
$test = $this->session->userdata('is_loged');
$test_id = $this->session->userdata('artist_id');
$ids = $this->session->userdata('artists');
$uri_test = $this->uri->segment(3);
if($test  == '1' && !empty($test)){?>
<h1>My Favourites</h1>
			
<?php } else{
$this->session->set_userdata('is_loged', false);
$this->session->set_userdata('artist', null);
$test_id = '';
?>
<h1>My Favourites</h1>
		
<?php } 

// save global references here
$glob_profile_type = $this->session->userdata('profile_type');
$glob_artist_id = $this->session->userdata('artist_id');
$glob_booka_id = $this->session->userdata('booka_id');

?>		
<script> 
$(function(){
	//fn();
});
function fn(){
	$('.status>a').click(function(){
		$text=$(this).text();
		$id=$(this).parents('tr').attr('id');
		$.post('<?=base_url()?>ajax/update_gig_status',{'id':$id, 'offer_status': $text},function(data){
			window.location.href=window.location.href;
		});
	});
}
</script>			
	<h2>Artist profiles</h2>
	<div class="form_title">
	
	<?php
	if(count($favourites) > 0){
	echo '<table class="instrument_table" id="tbl_audio">
		<thead>
		  <tr>
			<th width="40%" style="important;border-left: 1px solid #999999 !important;">Artist Name</th>
			<th width="28%">Profile Type</th>
			<th width="20%">Phone Number</th>
			<th width="12%">&nbsp;</th>
		  </tr>
		  </thead>';
		echo '<tbody>';
		foreach($favourites as $val){
		$profile_name=str_replace(' ','_',$val['profile_name']);
		// echo "<br>The array key values are "; print_r(array_keys($val));
		echo 
		'<tr>
			<td style="border-left: 1px solid #999999 !important;">'.$val['profile_name'].'</td>
			<td>'.$types[$val['profile_type']].'</td>
			<td>'.$val['phone_number'].'</td>
			<td><a href="'.base_url().'profile/view/'.$profile_name.'">View profile</a></td>
		</tr>';
		}
		echo '</tbody></table>';
	}
	else{
		echo '<table class="instrument_table" id="tbl_audio"><tr>
			<td style="border-left: 1px solid #999999 !important;" colspan = 4 align="center">No records found</td></tr></table>';
	}
	?>
	</div><br class="cl"/>
<style>
.sub th{background-color:#F8F8F8;}
</style>
	