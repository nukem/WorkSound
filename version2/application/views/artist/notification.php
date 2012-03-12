<?php
$test = $this->session->userdata('is_loged');
$test_id = $this->session->userdata('artist_id');
$ids = $this->session->userdata('artists');
$uri_test = $this->uri->segment(3);
if($test  == '1' && !empty($test)){?>
<h1>Notification</h1>
			
<?php } else{
$this->session->set_userdata('is_loged', false);
$this->session->set_userdata('artist', null);
$test_id = '';
?>
<h1>Notification</h1>
		
<?php } ?>		

	<form action="" method="post" class="uniform">
	<table>
		<tr>
			<td width="20%;">&nbsp;</td>
			<td>
				<div style="padding-left:10px;float:left;"><label>Gigs&nbsp;</label>
				<div style="float:right;"  class="simu_select5">
				<?php
				extract($_POST);
				?>
				<input name="cur_date" type="hidden" value="<?php echo date("d/m/Y");?>" />
				<input name="past_date" type="hidden" value="<?php echo date("d/m/Y",strtotime("yesterday"));?>" />
				
				<?php
				$gig_options = array();
				$gig_options[0] = 'Any GIG';
                foreach($gigs as $gig) {
					$gig_options[$gig['gig_id']] = $gig['gig_name'].'-'.date("d/m/y",strtotime($gig['start_date']));
				}
				?>
				<?=form_dropdown('gig',$gig_options,set_value('gig',@$_POST['gig']))?>
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
                  'Draft'    => 'Draft',
                  'Offer'   => 'Offer',
				  'Accept'   => 'Accept',
				  'Reject'   => 'Reject',
				  'Confirm'   => 'Confirm',
				  'Deposit Paid'   => 'Deposit Paid'
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
	<table class="instrument_table" id="tbl_audio">
	  <tr>
		<th width="60%" style="important;border-left: 1px solid #999999 !important;">Gig Date / Name</th>
		<th width="28%">Status Date</th>
		<th width="12%" style="text-align:center;">Status</th>
	  </tr>
	<?php
	if(isset($notification) && !empty($notification)){
	foreach($notification as $val){
	if($val['start_date'] == $val['end_date']){
		$date = date('d/m/Y',strtotime($val['start_date'])).' - '.date('H:i',strtotime($val['start_time'])) .' to '.date('H:i',strtotime($val['end_time']));
	}
	else{
		$date = date('d/m/Y',strtotime($val['start_date'])).' - '.date('H:i',strtotime($val['start_time'])).' to '.date('d/m/Y',strtotime($val['end_date'])).' - '.date('H:i',strtotime($val['end_time']));
	}
	if($this->session->userdata('profile_type') == 'artist'){
		$values = 'a';
	}else{
		$values = 'b';
	}
	if($val['is_view'.$values] == 0){
		$style = "color:#ff5c32;";
	}else{
		$style = "";
	}
	echo 
		'<tr style="border-bottom:1px solid #999999 !important;'.$style.'">
			<td style="border-left: 1px solid #999999 !important;">'.$date.' / '.$val['gig_name'].'</td>
			<td>'.date('d/m/Y h:i',strtotime($val['notify_created'])).'</td>
			<td style="text-align:right;">'.$val['notify_status'].'</td>
		</tr>';
	
	}
	$sql = "update notifications set is_view".$values." = 1 where ".$this->session->userdata('profile_type')."_id  = ".$uri_test." ";
	$query_count = $this->db->query($sql);    
	$this->session->set_userdata('count_notification',0);
	}
	else{
		echo '<tr><td align="center" colspan="3">No Records Found</td></tr>';
	}
	?>
	</table>
	
	<?php
	
	
	?>
	</div>

	