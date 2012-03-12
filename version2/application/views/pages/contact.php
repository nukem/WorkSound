			<div class="contact_content" style="height:410px;">
				<h1><?=$title?></h1>
				<?=$content?>
			</div><!--end of contact_content-->
			
			<div class="contact_sider">
				<form action="" method="post" class="uniform">
				<fieldset>
					<div class="form_title">Get in touch! <img src="<?=base_url()?>images/ico_touch.gif" alt="" /></div>
					<div class="form_row">
						<label>Your Name <span>*</span></label>
						<input name="name" type="text" class="input1" id="name" value="<?php echo set_value('name', @$name); ?>"/>
					</div>
					
					<div class="form_row">
						<label>Email Address <span>*</span></label>
						<input name="email" type="text" class="input1" id="email" value="<?php echo set_value('email', @$email); ?>"/>
					</div>
					
					<div class="form_row">
						<label>Contact Number</label>
						<input name="phone" type="text" class="input1" id="phone" value="<?php echo set_value('phone', @$phone); ?>"/>
					</div>
			
					<div class="form_row">
						<label>Message <span>*</span></label>
						<textarea name="message" class="textarea1" id="message"><?php echo set_value('message', @$message); ?></textarea>
					</div>
					
					<input type="submit" class="input_submit" value="Submit" />
					
				</fieldset>
				</form>
			</div><!--end of contact_sider-->
			
			<br class="cl" />
		