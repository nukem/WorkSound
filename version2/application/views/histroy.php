<html>
<body>
<?php 
/*echo '<pre>';
print_r($artists_histroy);
echo '</pre>';*/
?>
<h2><?=$title?></h2>
<div id="about" class="scroll-content" style="margin:35px 35px ;">
<div class="block-box">
<div class="scroll-content">
<div class="scroll-pane">

<table class="instrument_table">
<?php 

if(!empty($artists_histroy) && count($artists_histroy) > 0){
$this->db->where('gig_id', $artists_histroy[0]['gig_map_id']);
$res = $this->db->get('manage_gigs');
$result = $res->result();

$sql = "select *,noti.status as notify_status,noti.created as notify_created from notifications noti JOIN manage_gigs gig ON noti.gig_id = gig.gig_id JOIN	artist art ON  noti.artist_id = art.id where noti.booka_id  = '{$artists_histroy[0]['booka_id']}' and  noti.artist_id  = '{$artists_histroy[0]['artist_id']}' and noti.gig_id  = '{$artists_histroy[0]['gig_map_id']}'";
$sql .= " order by noti.created DESC";
$query = $this->db->query($sql);
$notification = $query->result_array();
?>
<thead>
	<th width="50%">Event Name / Gig Name</th>
	<th width="25%">Start Date</th>
	<th width="25%">End Date</th>
</thead>
<tbody>
<tr>
<td><?php
if(!empty($result[0]->event_name)) echo $result[0]->event_name . ' / '; 
echo @$result[0]->gig_name;?></td>
<td><?=date('d/m/Y',strtotime(@$result[0]->start_date)).' - '.date('H:i',strtotime(@$result[0]->start_time))?></td>
<td><?=date('d/m/Y',strtotime(@$result[0]->end_date)).' - '.date('H:i',strtotime(@$result[0]->end_time))?></td>
<table class="instrument_table">

<thead>
	<th width="25%">Gig Name</th>
	<th width="25%">Artists Name</th>
	<th width="25%">Gig History Date</th>
	<th width="25%">Status</th>
</thead>
<tbody>
	
	<?php 
	if(!empty($notification) && count($notification) > 0 ){
	foreach($notification as $v) {
	if(!empty($v['notify_status'])) $status = $v['notify_status'];
	else $status = 'Draft';
	?>
	<tr> 
	<td><?=$result[0]->gig_name?></td>
	<td><?=$v['profile_name']?></td>
	
	<td><?=date('d/m/Y H:i',strtotime($v['notify_created']))?></td>
	<td><?=$status?></td>
	</tr>
	<?php }}else{
	echo '<tr><td colspan="4">No Records Found</td></tr>';
		}?>
	
</tbody>
</table>
</tbody>

<?}else{
echo '<tr><td colspan="3">No Records Found</td></tr>';
}?>
</table>
</div>
</div>
</div>
</div>
</body>
</html>