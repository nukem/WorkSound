<?php
error_reporting(0);

$test = $this->session->userdata('is_loged');
$test_id = $this->session->userdata('artist_id');

$gig_list[]='Select Gig Profile';
if(count($gigs) > 0){
foreach($gigs as $val){
	if(in_array($val['gig_id'],$artists)) continue;
	$gig_list[$val['gig_id']] = $val['gig_name'].' - '.date('d/m/Y',strtotime($val['start_date']));
}
}

$test = explode('/',$_SERVER['HTTP_REFERER']);
$profile_name = str_replace('_',' ',$test[6]);
$sql = "select * from artist where profile_name = '".$profile_name."'";
$query = $this->db->query($sql);
$result =$query->result_array();
$this->session->set_userdata('search_user', $result[0]['id']);


?>
<div style="float:right;">
<div class="form_item alert_gig"></div>
<input type="submit" value="Create Gig & Book" class="input_continue" onclick="window.location='<?=base_url()?>booka/gig_profile/<?=$test_id?>'" name="book" style="width: 120px !important;float:left;margin:-2px 10px 0 0;">
<div class="form_item"><img src='../../images/spacer.gif' height='5px;' width='1px;'><label>OR </label><img src='../../images/spacer.gif' height='5px;' width='5px;'><label> Choose existing gig</label></div>
<div class="form_item simu_select1" style="margin-left:-15px;">
	<?=form_dropdown('gig_id', $gig_list, '' , 'id=gig_list')?>
</div>
<?php $order = array(1,2,3);?>
<div class="form_item" style="margin-left:-15px;"><label>Artist Position</label></div>
<div class="form_item simu_select3" style="margin-left:-15px;">
	<?=form_dropdown('order', $order, '' , 'id=order')?>
</div>

<input type="submit" value="Book" class="input_continue booking" name="book" style="width: 90px !important;margin:-2px 5px 0 0;">
</div>
<script>
$(function(){
	$("select, input:checkbox, input:radio, input:file").uniform();
	$('.booking').click(function(){
		$('.alert_gig').empty().text('Loading...');
		$.post('<?=base_url()?>ajax/offer_update',{'order':$('#order').val(),'gig_id':$('#gig_list').val(),'artist_id':'<?=$artist_id?>'},function(data){
			$('.alert_gig').text('Booked');
			
		});
	});
});

</script>
