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
<style>
.simu_select5 select {
    width: 178px;
}
</style>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.lightbox.js"></script>	
<script> 
$(function(){
	fn();
});
function fn(){
	$('.status>a').click(function(){
		$text = $(this).text();
		if($text != 'Rate' && $text != 'History' && $text != 'Chat' && $text != 'Pay'){
			$id = $(this).parents('tr').attr('id');
			$.post('<?=base_url()?>ajax/update_gig_status',{'id':$id, 'offer_status': $text},function(data){
			window.location.href = window.location.href;
		});
		}
		
	});
}
</script>	
	<form action="" method="post" class="uniform">
	<table style="margin-bottom:10px;">
		<tr>
			<td width="20%;"><h2>Gig profiles</h2></td> 
			<td valign="bottom">
				<div style="padding-left:10px;float:left;">Gigs&nbsp;
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
                  'Draft'    => 'Draft',
                  'Offer'   => 'Offer',
				  'Accept'   => 'Accept',
				  'Reject'   => 'Reject',
				  'Payments'   => 'Payments'
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
	
	<?php
	if(count($gigs) > 0){


	$total_booka_amount = 0;
	foreach($gigs as $key=>$val){
		if(!empty($val['fee_hour']) && $val['fee_hour'] != 0){
			$amount = $val['fee_hour'] * $val['gig_hours'];
			$performance_amount = $val['fee_hour'] * $val['gig_hours'];
			
			if($amount >= 0 && $amount <= 500){
				$amount = 29;
			}
			elseif($amount >= 501 && $amount <= 1000){
				$amount = 49;
			}
			elseif($amount >= 1001 && $amount <= 1500){
				$amount = 69;
			}
			elseif($amount >= 1501 && $amount <= 2000){
				$amount = 89;
			}
			elseif($amount > 2000){
				$amount = (($amount * 5) / 100 );
			}
			
			
		}
		else{
			$amount = $val['fee_gig'];
			$performance_amount = $val['fee_gig'];
			if($amount >= 0 && $amount <= 500){
				$amount = 29;
			}
			elseif($amount >= 501 && $amount <= 1000){
				$amount = 49;
			}
			elseif($amount >= 1001 && $amount <= 1500){
				$amount = 69;
			}
			elseif($amount >= 1501 && $amount <= 2000){
				$amount = 89;
			}
			elseif($amount > 2000){
				$amount = (($amount * 5) / 100 );
			}
			
			
		}
		if(count($map_artists[$val['gig_id']]) > 0){ 
			echo '<table class="instrument_table" id="tbl_audio">
			  <tr>
				<th width="30%" style="important;border-left: 1px solid #999999 !important;">Event Name / Gig name</th>
				<th width="16%">Start Date</th>
				<th width="16%">End Date</th>
				
				<th width="10%">Status</th>
				<th width="27%">&nbsp</th>
			  </tr>';
			echo 
			'<tr>
				<td style="border-left: 1px solid #999999 !important;">';
				if(!empty($val['event_name'])) echo strtoupper($val['event_name']). ' / '; echo $val['gig_name'].'';
				echo '</td>
				<td>'.date('d/m/Y',strtotime($val['start_date'])).' - '.date('H:i',strtotime($val['start_time'])).'</td>
				<td>'.date('d/m/Y',strtotime($val['end_date'])).' - '.date('H:i',strtotime($val['end_time'])).'</td>
				
				<td>'.(($val['status']=='deactive' ) ? 'Inactive':'Active').'</td>
				<td><a href="'.base_url().'booka/gig_profile/'.$id.'/'.$val['gig_id'].'">Edit Gig</a></td>
				
			</tr>';
			if(!empty($map_artists[$val['gig_id']]) && count($map_artists[$val['gig_id']])>0){
				echo '<tr><td colspan=5 style="padding:0px;">';
				echo '<table class="instrument_table sub" id="sub'.$key.'" style="margin-bottom:0px;border-left:0px;border-right:0px;border-bottom:0px;">
				  <thead>
				  <tr>
					<th width="30%">Artist Name</th>';
					
					if(@$_POST['status']=='Payments') { ?><th width="16%">Amount Paid</th><?php }
					else { ?><th width="16%">Artist Type</th><?php }
					
					if(@$_POST['status']=='Payments') { ?><th width="16%">Payment Date</th><?php }
					else { ?><th width="16%">Offered Date</th><?php }
					
					
					
					echo '<th width="10%">Status</th>
					<th width="27%">&nbsp;</th>
				  </tr>
				  </thead>';
				  //echo '<div style="display:none;">';print_r($map_artists[$val['gig_id']]); echo '</div>';
				  echo '<tbody>';
				  
				  $total_gig_amount = 0;
				  foreach($map_artists[$val['gig_id']] as $key => $v){
					$activate=0;
					if($v['status']=='') $status='Draft';
					else if($v['status']=='Confirm') $status='Accepted';
					else if($v['status']=='Delete') { $status='Inactive'; $activate=1;}
					else $status=$v['status'];
					$a_style='';
					if($status == 'Offer') $style = 'style="background-color:#029ac1;color:#ffffff;"';
					elseif($status == 'Confirm' || $status == 'Accepted' || $status =='Deposit Paid') {
						$style = 'style="background-color:#fd5b32;color:#ffffff;"';
						$a_style="style='color:#FFF;'";
						}
					else $style = '';
					echo '<tr id="'.$key.'">
						<td '.$style.'><a '.$a_style.' href="../../profile/view/'.str_replace(' ','_',$v['profile_name']).'">'.$v['profile_name'].'</a></td>';
						
					if(@$_POST['status']=='Payments' and $status =='Deposit Paid') { 
						$total_gig_amount += $v['amount'];
						$total_booka_amount += $v['amount'];
						?><td align="right"><?php echo '$'.number_format($v['amount'], 2, '.', '');?></td>
					<?php }
					else { ?><td><?php echo $v['type'];?></td><?php }
					
					if(@$_POST['status']=='Payments') { ?><td><?php echo date('d/m/Y',strtotime($v['payment_date'])); ?></td><?php }
					else { ?><td><?php echo date('d/m/Y',strtotime($v['offered_date'])); ?></td><?php }
						
					
					
					
					?><td><?php echo $status ?></td><?php
					
					if($status=='Accepted') {
					
					//if($this->uri->segment(3) == 2) $v['amount'] = 0.01;
					echo '<td class="status">';
					
					echo '				
					
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="width:100px;float:left;">  
	 
					 <input type="hidden" value="_xclick" name="cmd"/>

					<input type="hidden" value="chris@soundbooka.com" name="business"/>
					
					<input type="hidden" value="'.$amount.'" name="amount"/>
					
					<input type="hidden" value="'.$v['id'].'" name="gigmap_id"/>
					
					<input type="hidden" value="Gig Payment" name="item_name"/>

					<input type="hidden" value="1" name="no_shipping"/>
					
					<input type="hidden" value="'.base_url().'paypal/success/manage_gig/'.$this->uri->segment(3).'/'.$v['id'].'" name="return"/>

					<input type="hidden" value="'.base_url().'paypal/cancel/manage_gig/'.$this->uri->segment(3).'" name="cancel_return"/>

					<input type="hidden" value="'.base_url().'paypal/ipn" name="notify_url"/>
					
					<input type="hidden" value="AUD" name="currency_code"/>

					<input type="hidden" value="0" name="tax"/>
					
					 <input type="image" name="submit" border="0" border="0"  height="30"src="'.base_url().'images/pppaymentbutton.gif"  alt="PayPal - The safer, easier way to pay online">  
					</form> 
					| <a href="javascript:void(0);" class="history_view">History</a> | <a href="javascript:void(0);" class="chat_view" rel="'.$id.'|'.$v['artist_id'].'|'.$v['profile_name'].'|'.$val['gig_id'].'|'.$val['gig_name'].'|b'.'">Chat</a></td>';
					}
					else {
					if($activate==0  && $status!='Accepted' && $status !='Deposit Paid') { 
						echo '<td class="status">';
						if(empty($gig_test[$val['gig_id']])) 
						echo '<a href="javascript:void(0);">Offer</a> | <a href="javascript:void(0);">Confirm</a> | ';
						/*if($status == 'Rejected')
						echo '<a href="javascript:void(0);">Offer</a> | <a href="javascript:void(0);">Confirm</a> | <a href="javascript:void(0);">Delete</a> | <a href="javascript:void(0);" class="history_view">History</a> ';
						else*/
						echo '<a href="javascript:void(0);">Delete</a> | <a href="javascript:void(0);" class="history_view">History</a> ';
						if($status=='Offer') 
						echo '| <a href="javascript:void(0);" class="chat_view" rel="'.$id.'|'.$v['artist_id'].'|'.$v['profile_name'].'|'.$val['gig_id'].'|'.$val['gig_name'].'|b'.'">Chat</a>';
						echo '</td>';
					}
					else if($status=='Deposit Paid') {
						echo '<td class="status"><a href="javascript:void(0);" class="history_view">History</a> | <a href="javascript:void(0);" class="chat_view" rel="'.$id.'|'.$v['artist_id'].'|'.$v['profile_name'].'|'.$val['gig_id'].'|'.$val['gig_name'].'|b'.'">Chat</a>';?>
						<?php if($v['rated']==0){ ?>
						| <a href="javascript: void(0)" class="rate_view" rel="<?php echo $id.'|'.$v['artist_id'].'|'.$v['profile_name'].'|'.$val['gig_id'].'|'.$val['gig_name'].'|'.$v['id'].'|'.$val['payment_method'].'|'.$performance_amount;?>">Rate</a>
						<?php } ?>
						
						<span style="display:none;" id="rating" >
						<?php 
						for($x=0;$x<5;$x++){
							if(isset($v['rate'][0]['star_rate']) and $x < $v['rate'][0]['star_rate']){
								?><img  style="vertical-align:text-top;" width="14" height="13" alt=" " src="http://www.soundbooka.com.au/version2/images/star-blue.png"><?php
							}
							else{
								?><img style="vertical-align:text-top;" width="14" height="13" alt=" " src="http://www.soundbooka.com.au/version2/images/star-grey.png"><?php
							}
							
						}
						?>
						</span>
						</td><?php
					} else 
						echo '<td class="status"><a href="javascript:void(0);">Activate</a></td>';
					}
					echo '</tr>';
				  }
				   if(@$_POST['status']=='Payments' and $status =='Deposit ddd Paid') { 
				   ?>
				   <tr id="<?php echo $key+1;?>" style="border-top: 1px solid #999;">
						<th>Total GIG Amount</th>
						<td align="right"><?php echo '$'.number_format($total_gig_amount, 2, '.', '');?></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						
					</tr>
				   <?php 
				   }
				  
				  echo '</tbody>';
				  echo '</table>';
			}
			echo '</td></tr></table>';
		}
	}
	}
	else{
		echo '<table class="instrument_table" id="tbl_audio"><tr>
			<td style="border-left: 1px solid #999999 !important;" colspan = "5" align="center">No records found</td></tr></table>';
	}
	
	if(@$_POST['status']=='Payments' and $status =='Deposit Paid') { 
	   ?>
	   <table id="tbl_audio" class="instrument_table">
			 <tr>
			<th width="30%">Total Amount Paid</th>
			<td width="16%" align="right"><?php echo '$'.number_format($total_booka_amount, 2, '.', '');?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		</table>
	   <?php 
	   }
	?>
	
	
	
	
	<input style="background-image:none;width: 145px !important;" type="button" value="Add a new gig" class="input_continue" name="gig" onclick="window.location='<?=base_url()?>booka/gig_profile/<?=$test_id?>'" />
	</div><br class="cl"/>
<style>
.sub th{background-color:#F8F8F8;}
</style>
<script>
$(function(){
	$('.sub').each(function(){
		var id=$(this).attr('id');
		$('#'+id).find('tbody').sortable({
			update: function(e, ui){
				var order = $(this).sortable('toArray').toString();
				$.post('<?=base_url()?>ajax/update_gig_position',{'order':order},function(data){
					$('pre').html(data);
				});
			}
		});
	});
	
});
</script>
<style>
.status {
	border-right:0px important;
}
</style>	