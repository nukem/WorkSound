<?php
$test = $this->session->userdata('is_loged');
$test_id = $this->session->userdata('artist_id');
$ids = $this->session->userdata('artists');
$uri_test = $this->uri->segment(3);
if($test  == '1' && !empty($test) && in_array($uri_test,$ids)){?>
<h1 style="width: 200px; float:left;">Edit your profile</h1>
			
<?php } else{
$this->session->set_userdata('is_loged', false);
$this->session->set_userdata('artist', null);
$test_id = '';
?>
<h1 style="width: 200px; float:left;">Join as a Booker</h1>
<?php } ?>
<div align=right class="form_title" style="width: 400px; float:right;"><span style="color:#FF5C32">*</span> This indicates a mandatory field</div>	
<div style="clear:both;"></div>		
			
			<!--<div class="<?php if($uri_test != $test_id ) echo 'step';else echo 'editstep';?> step5">step</div>-->
			<!--<div class="line_help"><a href="#">click here for help</a></div>-->
<br/>
			<form action="" method="post" class="uniform">
			<fieldset>
				<table width="100%"><tr width="100%">
					<td width="50%"><h2>PAYMENT DETAILS<h2></td>
					<!--<td width="50%" align="right"></td>-->
				</tr></table>
			 
				<div class="form_title">
					Making a Payment
					<strong class="bubble_info">
						<img src="<?=base_url()?>images/question_mark_icon.png" style = "width:15px;height:15px;" alt="" class="img_ask" />
						<strong class="popup"><b>arrow</b><em>Soundbooka allows you to pay by PayPal or in cash. In any instance the Soundbooka Fee must by paid using Paypal. Soundbooka will provide you with an invoice for any performance and booking fees paid. You can create a PayPal account <a target="_blank" href="http://paypal.com">here</a>.</em></strong>
					</strong>
				</div>
				<div class="form_block">
					<div class="note_box note_box2"><span>arrow</span>Soundbooka uses <a target="_blank" href="http://paypal.com">PayPal</a> to secure your transactions. PayPal is free for you to join and use. You will need to maintain/open a PayPal account to receive payments from Soundbooka. If you change your PayPal email address/login, you must notify Soundbooka otherwise payments may fail to you. Until you register with PayPal Soundbooka will not be able to make payments to you, although payments will be held for you.</div>
					<p>How would you like to pay? Allowance for credit cards?? OR just have paypal info??</p>
					<div class="form_row">
						<label>Payment method <span>*</span></label>
						
						<div class="form_item">
							<div class="option_holder">
								<div class="option">
									<label>
										<input name="payment_method" type="radio" value="1" <?php echo set_radio('payment_method', '1',((1==$payment_method) ? TRUE:FALSE)); ?> />
										<strong>PayPal</strong>
									</label>
								</div>
								<div class="option">
									<label>
										<input name="payment_method" type="radio" value="2" <?php echo set_radio('payment_method', '2',((2==$payment_method) ? TRUE:FALSE)); ?>/>
										<strong>Cash</strong>
									</label>
								</div>
								<div class="option">
									<label>
										<input name="payment_method" type="radio" value="3" <?php echo set_radio('payment_method', '3',((3==$payment_method) ? TRUE:FALSE)); ?>/>
										<strong>Either</strong>
									</label>
								</div>
							</div>
						</div><!--end of form_item-->
						
						<div class="form_item">
							<input name="paypal_email" type="text" class="input1 infotext" id="paypal_email" title="Paypal email address" value="<?= set_value('paypal_email', ((@$paypal_email) ? $paypal_email: 'Paypal email address'));?>" /> <img src="<?=base_url()?>images/img_paypal.gif" alt="" />
							<em><a target="_blank" href="http://paypal.com">Click here</a> to create a PayPal account</em>
					  </div><!--end of form_item-->
						
						<br class="cl" />
					</div><!--end of form_row-->
					
				</div><!--end of form_block-->
				
				
				
				<div class="shadow_line_nobg">line</div>
				
				<input type="submit" value="Save &amp; Continue" class="input_continue" name="save" />
				
				<a href="<?php echo base_url() ?>booka/step1/<?php echo $uri_test;?>" class="btn_back2" >Back</a>
				
				<br class="cl" />

			</fieldset>
			</form>
			
			<br class="cl" />
		
        
