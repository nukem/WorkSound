<?php
$info = $personal[0];
?>
<div style="width:100%;"><div style="float:left; width:50%;" ><h1>Settings</h1></div>
<br class="cl" />
</div>
		
	<fieldset>
	<form action="" method="post" class="uniform">	
	
	<table width="100%"><tr></td>
		<div class="form_row">
						<div class="form_item">
							<label>Frequency Of Email <span></span></label>
							<div class="simu_select1">
							<select id="freq_of_email" name="freq_of_email">
								<option <?php if(is_null($info['freq_of_email']) || $info['freq_of_email'] == '') echo 'selected="selected"';?> value=""> Please Select</option>
								<option <?php if($info['freq_of_email'] == 'hourly') echo 'selected="selected"';?> value="hourly"> Hourly</option>
								<option <?php if($info['freq_of_email'] == '2') echo 'selected="selected"';?> value="2"> Every 2 Hours</option>
								<option <?php if($info['freq_of_email'] == '4') echo 'selected="selected"';?> value="4"> Every 4 Hours</option>
								<option <?php if($info['freq_of_email'] == '6') echo 'selected="selected"';?> value="6"> Every 6 Hours</option>
								<option <?php if($info['freq_of_email'] == '12') echo 'selected="selected"';?> value="12"> Every 12 Hours</option>
								<option <?php if($info['freq_of_email'] == 'daily') echo 'selected="selected"';?> value="daily"> Daily</option>
							</select>
							</div>
							<br />
							<label>Booking Notifications <span></span></label>
							<div class="simu_select1">
							<select id="booking_notify" name="booking_notify">
								<option <?php if(is_null($info['booking_notify']) || $info['booking_notify'] == '') echo 'selected="selected"';?> value=""> Please Select</option>
								<option <?php if($info['booking_notify'] == 'sms') echo 'selected="selected"';?> value="sms"> SMS</option>
								<option <?php if($info['booking_notify'] == 'e-mail') echo 'selected="selected"';?> value="e-mail"> E-mail</option>
							</select>
							</div>
						</div>
						<br class="cl" />
					</div><!--end of form_row-->

		<br class="cl" />
		<input class="input_continue" type="submit" name="save" value="save" style="background-image:none;width: 120px !important;float:left;">
		
		
	</td></tr>
	</table></form>
	</fieldset>
	