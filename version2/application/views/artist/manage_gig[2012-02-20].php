<?php
$test = $this->session->userdata('is_loged');
$test_id = $this->session->userdata('artist_id');
$ids = $this->session->userdata('artists');
$uri_test = $this->uri->segment(3);
if($test  == '1' && !empty($test)){?>
<h1>My Gigs</h1>
			
<?php } else{
$this->session->set_userdata('is_loged', false);
$this->session->set_userdata('artist', null);
$test_id = '';
?>
<h1>My Gigs</h1>
		
<?php } 

?>		
<script> 
$(function(){
	fn();
});
function fn(){
	$('.status>a').click(function(){
		$text=$(this).text();
		if($text != 'History' && $text != 'Chat'){
			$tr=$(this).parents('tr');
			$id=$(this).parents('tr').attr('id');
			$(this).parents('.status').text('');
			
			$.post('<?=base_url()?>ajax/update_artist_gig_status',{'id':$id, 'respond_status': $text},function(data){
				$tr.find('.st').text(data);
			});
		}
	});
}
</script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.lightbox.js"></script>				
<form action="" method="post" class="uniform">			
	<table>
		<tr>
		
	<td width="20%;"><h2>Gig profiles</h2></td>
	<td>
				<div style="padding-left:10px;float:left;"><label>Gigs&nbsp;</label>
				<div style="float:right;"  class="simu_select5">
				<?php
				extract($_POST);
				?>
				<input name="cur_date" type="hidden" value="<?php echo date("d/m/Y");?>" />
				<input name="past_date" type="hidden" value="<?php echo date("d/m/Y",strtotime("yesterday"));?>" />
				<select name="gig" style="opacity: 0;" onchange="if(this.value==1) {
																	this.form.start_date.value = this.form.cur_date.value; 
																	this.form.end_date.value = '';
																	}
																else if(this.value==2) {
																	this.form.end_date.value = this.form.past_date.value;
																	this.form.start_date.value ='';
																	}
																else {
																	this.form.start_date.value ='';
																	this.form.end_date.value ='';
																}">
				<option value="0">All Gig</option>
				<option value="1">Current Gig</option>
				<option value="2">Past Gig</option>
				</select>
				</div>
			</td>
			<td>
				<div style="padding-left:10px;float:left;"><label>Date From&nbsp;</label>
				<div style="float:right;" ><input name="start_date" type="text" class="input7 datepick" id="startDate" value="<?php echo set_value('start_date',@$start_date); ?>" /></div>
				
			</td>
			<td>
				<div style="padding-left:10px;float:left;"><label>Date To&nbsp;</label>
				<div style="float:right;" id="end" ><input name="end_date" type="text" class="input7 datepick" id="endDate" value="<?php echo set_value('end_date',@$end_date); ?>"/></div>
				<script>
				$( "#startDate" ).datepicker({dateFormat: 'dd/mm/yy'});
				$( "#endDate" ).datepicker({dateFormat: 'dd/mm/yy'});
					$( "#startDate" ).change(function(){
						test = $(this).datepicker('getDate');
						testm = new Date(test.getTime());
						testm.setDate(testm.getDate() + 1);
						$('#end').html('<input name="end_date" type="text" class="input7 datepick" id="endDate" />');
						$( "#endDate" ).datepicker({dateFormat: 'dd/mm/yy',minDate:testm});
					});
				</script>
			</td>
			<td>
				<div style="padding-left:10px;float:left;"><label>Status&nbsp;</label>
				<div style="float:right;" class="simu_select5">
				<?php
				$status_options = array(
                  ''  => 'All',
                  'Confirm'    => 'Confirm',
                  'Offer'   => 'Offer',
				  'Accept'   => 'Accept',
				  'Reject'   => 'Reject',
				  'Deposit Paid'   => 'Payment'
                );
				?>
				<?=form_dropdown('status',$status_options,set_value('status',@$status))?>
				</div>
			</td>
			<td>&nbsp;<input type="submit" name="go" class="input_continue" value="Go" style="background-image:none; width:40px;" ></td>
			</tr>
			</table>
			</form>
	<div class="form_title">
	<table class="instrument_table" id="tbl_audio" style="width:939px;">
	  <tr>
		<th style="important;border-left: 1px solid #999999 !important;width:281px !important;">Gig name</th>
		<th style="width:179px !important;">Start Date</th>
		<th style="width:179px !important;">End Date</th>
		<th style="width:112px !important;">Status</th>
		<th style="width:188px !important;">&nbsp;</th>
	  </tr>
	<?php
	echo '<div style="display:none;">'; print_r($gigs); echo '</div>';
	$count = count($gigs);
	if(count($gigs) > 0){
	foreach($gigs as $key=>$val){
		echo 
		'<tr id="'.$val['id'].'">
			<td style="border-left: 1px solid #999999 !important;">'.$val['gig_name'].'';
			echo '</td>
			<td>'.date('d/m/Y',strtotime($val['start_date'])).' - '.date('H:i',strtotime($val['start_time'])).'</td>
			<td>'.date('d/m/Y',strtotime($val['end_date'])).' - '.date('H:i',strtotime($val['end_time'])).'</td>';
			echo '<td>Active</td>';
			echo '<td><a href="'.base_url().'booka/view/'.$val['gig_id'].'" target="_blank">View Gig</a></td>
		</tr>';
		if(!empty($val['profile_name'])){
			echo '<tr><td colspan=5 style="padding:0px;">';
			echo '<table class="instrument_table sub" id="tbl_audio" style="margin-bottom:0px;border-left:0px;border-right:0px;border-bottom:0px;">
			  <tr>
				<th style="width:214pt !important;">Artist Name</th>
				<th style="width:180px !important;margin-left:1px;">Artist Type</th>
				<th style="width:181px !important;">Offered Date</th>
				<th style="width:113px !important;">Status</th>
				<th style="width:186px !important;">&nbsp;</th>
			  </tr>';
			  $profile_name = str_replace(' ','_',$val['profile_name']);
			  echo '<tr id="'.$val['map_id'].'">
					<td><a href="'.base_url().'profile/view/'.$profile_name.'" target="_blank">'.$val['profile_name'].'</a></td>
					<td>'.$types[$val['profile_type']].'</td>
					<td>'.date('d/m/Y',strtotime($val['offered_date'])).'</td>
					<td class="st">';
					if($val['respond']==1) echo $val['respond_status'];
					else echo $val['offer_status'];
			  echo  '</td>';
			  echo  '<td class="status">';
			
			if($val['offer_status']=='Confirm' && $val['respond']!=1) 
			echo '<a href="javascript:void(0);">Accept</a> | <a href="javascript:void(0);">Reject</a> | ';
			
			if($val['offer_status']=='Offer' && $val['respond']!=1) 
			echo '<a href="javascript:void(0);">Accept</a> | <a href="javascript:void(0);">Reject</a> | ';
			
			echo '<a href="javascript:void(0);" class="chat_view" rel="'.$val['booka_id'].'|'.$id.'|'.$profile_name.'|'.$val['gig_id'].'|'.$val['gig_name'].'|a'.'">Chat</a>';
			echo '</td></tr>';
			echo '</table></td></tr>';
			if($key != $count-1){
			echo '<table class="instrument_table" id="tbl_audio"><tr>
					<th style="important;border-left: 1px solid #999999 !important;width:281px !important;">Gig name</th>
					<th style="width:179px !important;">Start Date</th>
					<th style="width:179px !important;">End Date</th>
					<th style="width:112px !important;">Status</th>
					<th style="width:188px !important;">&nbsp;</th>
				  </tr>';
			
			}
			}
		}
	}
	else{
		echo '<tr>
			<td style="border-left: 1px solid #999999 !important;" colspan = 5 align="center">No records found</td></tr>';
	}
	?>
	</table>
	</div><br class="cl"/>
<style>
.sub th{background-color:#F8F8F8;}
</style>
	