<?php
$test = $this->session->userdata('is_loged');
$test_id = $this->session->userdata('artist_id');
$ids = $this->session->userdata('artists');
$uri_test = $this->uri->segment(3);
?>	
<form action="">
<div class="form_row"><h2>Book Artist</h2></div>
<div class="form_row">
<label>Profile Name : <?php echo $artist['profile_name']; ?></label>
</div>

</form>	

