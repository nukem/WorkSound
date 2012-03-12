<?php 

?>
<h2><?=$title?></h2>
<div id="about" class="scroll-content" style="margin:35px 35px ;">
<div class="block-box">
<div class="scroll-content">
<div class="scroll-pane">

<table class="instrument_table" id="chat">
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
<textarea class="text-input" rows="3" cols="45" name="message" id="message"></textarea>
<input type="hidden" value="<?=$gig_name?>" id="gig_name"/>
<input type="hidden" value="<?=$artist_name?>" id="artist_name"/>
<input type="hidden" value="<?=$artist_id?>" id="artist_id"/>
<input type="hidden" value="<?=$gig_id?>" id="gig_id"/>
<input type="hidden" value="<?=$booka_id?>" id="booka_id"/>
<input type="hidden" value="<?=$sent_by?>" id="sent_by"/>
<input type="submit" value="Send" class="input_continue" id="save" />
</form>
<script>
$(function(){
	$('#save').click(function(){
		if($('#sent_by').val()=='a') $a=$('#artist_name').val();
		else if($('#sent_by').val()=='b') $a=$('#gig_name').val();
		if($('#message').val()=='') return false;
		$.post('<?=base_url()?>ajax/update_chat',{'artist_id':$('#artist_id').val(), 'gig_id':$('#gig_id').val(), 'booka_id':$('#booka_id').val(), 'sent_by':$('#sent_by').val(), 'message':$('#message').val()},function(data){
			$('#chat tbody').append('<tr><td>'+$a+'</td><td>'+$('#message').val()+'</td></tr>');
			$('#message').val('');$('.empty').remove();
		});
	});
});
</script>

</div>
</div>
</div>
</div>