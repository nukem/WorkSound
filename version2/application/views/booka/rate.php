
<h2><?=$title?></h2>
<div id="about" class="scroll-content" style="margin:35px 35px ;">
<div class="block-box">
<div class="scroll-content">
<div class="scroll-pane">

<table class="instrument_table" id="chat" style="display:none;">
<thead>
	<th width="25%">NAME</th>
	<th width="50%">MESSAGE</th>
	<th width="25%">MESSAGE</th>
</thead>
<tbody>

<?
if(count($chats)>0){
	foreach($chats as $chat){
		echo '<tr><td>';
		if($chat['sent_by']=='a') echo $artist_name;
		else if($chat['sent_by']=='b') echo $gig_name;
		
		echo '</td><td>'.$chat['message'];
		
		echo '</td><td>'.$chat['created_date'].'</td></tr>';		
	}	
}else{
echo '<tr class="empty"><td colspan="3">No Chat History Found</td></tr>';
}?>
</tbody>
</table>
<form action="javascript:void(0);" id="forma">
<p>Please rate the performance of the artist for this gig. This helps us give a fair rating for other members of Soundbooka.</p>
<br>
<div style="width:350px; margin-bottom: 20px;">
	<div style="padding-left:10px;float:left;"><label>File the rating&nbsp;</label>
		<div style="float:right; width:200px;" class="simu_select5">
		<select name="star_rate" id="star_rate">
			<option value="1">1 Star</option>
			<option value="2">2 Star</option>
			<option value="3">3 Star</option>
			<option value="4">4 Star</option>
			<option value="5">5 Star</option>
		</select>
		</div>
	</div>
</div>
<input type="hidden" value="<?=$gig_name?>" id="gig_name"/>
<input type="hidden" value="<?=$artist_name?>" id="artist_name"/>
<input type="hidden" value="<?=$artist_id?>" id="artist_id"/>
<input type="hidden" value="<?=$gig_id?>" id="gig_id"/>
<input type="hidden" value="<?=$booka_id?>" id="booka_id"/>
<input type="hidden" value="<?=$sent_by?>" id="sent_by"/>
<input style="clear:both: background-image:none;" type="submit" value="Save" class="input_continue" id="save" name="save"  />
</form>
<?php 
//artist fee echo '<div style="display:none;">';echo $artist_fee; echo '</div>';
if($payment_method==1){ ?>
<form style="width:100px;float:left;" method="post" action="https://www.paypal.com/cgi-bin/webscr">  
	 
					 <input type="hidden" name="cmd" value="_xclick">

					<input type="hidden" name="business" value="chris@soundbooka.com">
					
					<input type="hidden" name="amount" value="<?=$artist_fee?>">
					
					<input type="hidden" name="gigmap_id" value="<?=$sent_by?>">
					
					<input type="hidden" name="item_name" value="Gig Payment">

					<input type="hidden" name="no_shipping" value="1">
					
					<input type="hidden" name="return" value="http://www.soundbooka.com.au/version2/paypal/success/manage_gig/<?=$booka_id?>/<?=$sent_by?>">

					<input type="hidden" name="cancel_return" value="http://www.soundbooka.com.au/version2/paypal/cancel/manage_gig/<?=$booka_id?>">

					<input type="hidden" name="notify_url" value="http://www.soundbooka.com.au/version2/paypal/ipn">
					
					<input type="hidden" name="currency_code" value="AUD">

					<input type="hidden" name="tax" value="0">
					
					<input style="background-image:none; position:absolute;" type="submit" value="Final Payment" class="input_continue" name="final_pay" id="final_pay"  />
</form>
<?php } ?>
<script>
$(function(){
	$('#save').click(function(){
		if($('#sent_by').val()=='a') $a=$('#artist_name').val();
		else if($('#sent_by').val()=='b') $a=$('#gig_name').val();
		if($('#message').val()=='') return false;
		$.post('<?=base_url()?>ajax/saveRating',{'artist_id':$('#artist_id').val(), 'gig_id':$('#gig_id').val(), 'booka_id':$('#booka_id').val(), 'sent_by':$('#sent_by').val(), 'star_rate':$('#star_rate').val()},function(data){
			window.location = $('#booka_id').val();
		});
	});
});
</script>

</div>
</div>
</div>
</div>