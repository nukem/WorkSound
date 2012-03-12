<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
/**
 * PayPal_Lib Controller Class (Paypal IPN Class)
 *
 * Paypal controller that provides functionality to the creation for PayPal forms, 
 * submissions, success and cancel requests, as well as IPN responses.
 *
 * The class requires the use of the PayPal_Lib library and config files.
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Commerce
 * @author      Ran Aroussi <ran@aroussi.com>
 * @copyright   Copyright (c) 2006, http://aroussi.com/ci/
 *
 */

class Paypal extends MY_Controller {

	function Paypal()
	{
		parent::MY_Controller();
		$this->load->library('Paypal_Lib');
		$this->load->model('mUser');
		//$this->load->model('mBooka');
		$this->load->model('mBooka');
		$this->load->model('mArticle');
		$this->load->model('mUtil');
	}
	
	function index()
	{
		$this->form();
	}
	
	function form()
	{
		
		$this->paypal_lib->add_field('business', 'PAYPAL@EMAIL.COM');
	    $this->paypal_lib->add_field('return', site_url('paypal/success'));
	    $this->paypal_lib->add_field('cancel_return', site_url('paypal/cancel'));
	    $this->paypal_lib->add_field('notify_url', site_url('paypal/ipn')); // <-- IPN url
	    $this->paypal_lib->add_field('custom', '1234567890'); // <-- Verify return

	    $this->paypal_lib->add_field('item_name', 'Paypal Test Transaction');
	    $this->paypal_lib->add_field('item_number', '6941');
	    $this->paypal_lib->add_field('amount', '197');

		// if you want an image button use this:
		$this->paypal_lib->image('button_03.gif');
		
		// otherwise, don't write anything or (if you want to 
		// change the default button text), write this:
		// $this->paypal_lib->button('Click to Pay!');
		
	    $data['paypal_form'] = $this->paypal_lib->paypal_form();
	
		$this->load->view('paypal/form', $data);
        
	}

	function auto_form()
	{
		$this->paypal_lib->add_field('business', 'PAYPAL@EMAIL.COM');
	    $this->paypal_lib->add_field('return', site_url('paypal/success'));
	    $this->paypal_lib->add_field('cancel_return', site_url('paypal/cancel'));
	    $this->paypal_lib->add_field('notify_url', site_url('paypal/ipn')); // <-- IPN url
	    $this->paypal_lib->add_field('custom', '1234567890'); // <-- Verify return

	    $this->paypal_lib->add_field('item_name', 'Paypal Test Transaction');
	    $this->paypal_lib->add_field('item_number', '6941');
	    $this->paypal_lib->add_field('amount', '197');

	    $this->paypal_lib->paypal_auto_form();
	}
	function cancel($type,$id)
	{
		$this->session->set_flashdata('error', 'The order was canceled...');
		redirect('/booka/'.$type.'/'.$id);
		//$this->load->view('paypal/cancel');
	}
	
	function success($type,$id,$gigmap_id)
	{
		// This is where you would probably want to thank the user for their order
		// or what have you.  The order information at this point is in POST 
		// variables.  However, you don't want to "process" the order until you
		// get validation from the IPN.  That's where you would have the code to
		// email an admin, update the database with payment status, activate a
		// membership, etc.
	
		// You could also simply re-direct them to another page, or your own 
		// order status page which presents the user with the status of their
		// order based on a database (which can be modified with the IPN code 
		// below).

		//$data['pp_info'] = $this->input->post();
		//$this->load->view('paypal/success', $data);
		$sql = "update artist_gig_map set respond_status='Deposit Paid', respond='1',payment_date='".date("Y-m-d")."' where id='".$gigmap_id."'";
		//echo $sql;
		$this->db->query($sql);
		
		$sql_evt = "select b.*,a.gig_name,a.event_name,a.start_date,a.end_date,a.start_time,a.end_time,a.suburb from manage_gigs a,artist_gig_map b where b.id=".$gigmap_id." and a.gig_id=b.gig_id";
		
		$result_set = $this->db->query($sql_evt);
		
		$result = $result_set->result_array();
		//print_r($result[0]);
		

		
		$form_data = array(
			'id' => $id,
			'event_title' => $result[0]['event_name'].' : '.$result[0]['gig_name'],
			'event_loc' => $result[0]['suburb'],
			'event_desc' => '',
			'start_date' => substr($result[0]['start_date'],8,2).'/'.substr($result[0]['start_date'],5,2).'/'.substr($result[0]['start_date'],0,4),
			'to_date' => substr($result[0]['end_date'],8,2).'/'.substr($result[0]['end_date'],5,2).'/'.substr($result[0]['end_date'],0,4),
			'start_time' => substr($result[0]['start_time'],0,5),
			'end_time' => substr($result[0]['end_time'],0,5)
		);

		//print_r($form_data);
		$aid = $this->mBooka->savevent($form_data);
		$this->session->set_flashdata('message', 'Your payment was received using Paypal.');
		redirect('/booka/'.$type.'/'.$id);
		
	}
	
	function ipn()
	{
		// Payment has been received and IPN is verified.  This is where you
		// update your database to activate or process the order, or setup
		// the database with the user's order details, email an administrator,
		// etc. You can access a slew of information via the ipn_data() array.
 
		// Check the paypal documentation for specifics on what information
		// is available in the IPN POST variables.  Basically, all the POST vars
		// which paypal sends, which we send back for validation, are now stored
		// in the ipn_data() array.
 
		// For this example, we'll just email ourselves ALL the data.
		$to    = 'chris@soundbooka.com';    //  your email

		if ($this->paypal_lib->validate_ipn()) {
			
			$sql = "update artist_gig_map set offer_status='Deposit Paid' where id='".$this->paypal_lib->ipn_data['gigmap_id']."'";
			$this->db->query($sql);
			
			//taking values from artist gig map and  placing notification
          	$sql_from = "select * from artist_gig_map where id = '".$this->paypal_lib->ipn_data['gigmap_id']."'";		
            $result_from = $this->db->query($sql_from);
            //insert notification
            $sql_insert = "INSERT INTO `notifications` (`artist_id` ,`booka_id` ,`gig_id` ,`status` ,`created` ,`modified`)
                            VALUES ('".$result_from[0]['artist_id']."', '".$result_from[0]['booka_id']."', '".$result_from[0]['gig_id']."', 'Deposit Paid',now(), now())";
            $result_from = $this->db->query($sql_insert);
            //taking artist and booka values
           $sql_gig_detail = "select *,b.firstname AS booka_firstname,b.lastname AS booka_lastname,b.user_id as booka_user,b.primary_phone as booka_phone from manage_gigs gig JOIN artist_gig_map agm ON gig.gig_id = agm.gig_id JOIN artist art ON art.id = agm.artist_id JOIN booka b ON b.id = agm.booka_id 
						where agm.booka_id = '{$result_from[0]['artist_id']}' and
                        agm.artist_id = '{$result_from[0]['artist_id']}' 
                        and gig.gig_id= '{$result_from[0]['gig_id']}' 
                        and agm.artist_id = '{$result_from[0]['artist_id']}' 
                        and agm.gig_id ='{$result_from[0]['gig_id']}'";
           $query_gig_detail = $this->db->query($sql_gig_detail);    
           
            $this->_sendMail($query_gig_detail);
			
			$body  = 'An instant payment notification was successfully received from ';
			$body .= $this->paypal_lib->ipn_data['payer_email'] . ' on '.date('m/d/Y') . ' at ' . date('g:i A') . "\n\n";
			$body .= " Details:\n";

			foreach ($this->paypal_lib->ipn_data as $key=>$value)
				$body .= "\n$key: $value";
	
			// load email lib and email results
			$this->load->library('email');
			$this->email->to($to);
			$this->email->from($this->paypal_lib->ipn_data['payer_email'], $this->paypal_lib->ipn_data['payer_name']);
			$this->email->subject('CI paypal_lib IPN (Received Payment)');
			$this->email->message($body);	
			//$this->email->send();
			send_email($to, 'CI paypal_lib IPN (Received Payment)', $body);
			$artist_phone = $query_gig_detail[0]['booka_phone'];
			/*  An sms is sent to the booka*/
			$article = $this->getEmailTemplate(194356);	
			
			$booka = $query_gig_detail[0]['booka_firstname'].' '.$query_gig_detail[0]['booka_lastname'];
		
			if($query_gig_detail[0]['fee_hour'] !=0 && $query_gig_detail[0]['gig_hours '] !=0)
			$gig_amount = $query_gig_detail[0]['fee_hour'] * $query_gig_detail[0]['gig_hours '];
			else
			$gig_amount = $query_gig_detail[0]['fee_gig'];
			
			if($query_gig_detail[0]['payment_method'] == '1')
			$paymentmethod = 'PayPal';
			else
			$paymentmethod = 'Cash';
			
			$artist = $query_gig_detail[0]['first_name'].' '.$query_gig_detail[0]['last_name'];
			
			$gigname = $query_gig_detail[0]['gig_name'];
			
			$article->sms_content = str_replace('%Booka%',$booka,$article->sms_content);
			$article->sms_content = str_replace('%Gig Amount%',$gig_amount,$article->sms_content);
			$article->sms_content = str_replace('%Gig Payment Method%',$paymentmethod,$article->sms_content);
			$article->sms_content = str_replace('%Artist%',$artist,$article->sms_content);
			$article->sms_content = str_replace('%Gig Details%',$gigname,$article->sms_content);
			
			$si = new SmsInterface (false, false);               
			$si->addMessage ($artist_phone,$html);
			$username= $this->config->item('username');
			$password=  $this->config->item('password');       
			if (!$si->connect ($username, $password, true, false)){                
			$message = 0;
			}elseif (!$si->sendMessages ()) {
				$message=0;
			}
			if ($si->getResponseMessage () !== NULL){
				$message =0;
			} else{
				$message =1;
			}
			
		}
		
	}
	function _sendMail($query_gig_detail) {
        $article = $this->getEmailTemplate(194356);	
        $this->load->library('email');
        $this->email->from($article->email_from);
		$user = $this->mUser->get($query_gig_detail[0]['booka_user']);
        $this->email->to($user->email);
        $this->email->cc($article->cc);
        $this->email->bcc($article->bcc);
        $this->email->subject($article->subject);
		
		
		$booka = $query_gig_detail[0]['booka_firstname'].' '.$query_gig_detail[0]['booka_lastname'];
		
		if($query_gig_detail[0]['fee_hour'] !=0 && $query_gig_detail[0]['gig_hours '] !=0)
		$gig_amount = $query_gig_detail[0]['fee_hour'] * $query_gig_detail[0]['gig_hours '];
		else
		$gig_amount = $query_gig_detail[0]['fee_gig'];
		
		if($query_gig_detail[0]['payment_method'] == '1')
		$paymentmethod = 'PayPal';
		else
		$paymentmethod = 'Cash';
		
		$artist = $query_gig_detail[0]['first_name'].' '.$query_gig_detail[0]['last_name'];
		
		$gigname = $query_gig_detail[0]['gig_name'];
		
		$article->content = str_replace('%Booka%',$booka,$article->content);
		$article->content = str_replace('%Gig Amount%',$gig_amount,$article->content);
		$article->content = str_replace('%Gig Payment Method%',$paymentmethod,$article->content);
		$article->content = str_replace('%Artist%',$artist,$article->content);
		$article->content = str_replace('%Gig Details%',$gigname,$article->content);
        $html = '<html>
        <head>
        </head>
        <body>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="top"><table width="639" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><img src="http://www.soundbooka.com/version1/images/email_head.jpg" width="639" height="143" /></td>
              </tr>
              <tr>
                <td style="padding-top:30px; padding-left:20px;padding-bottom:20px;padding-right:10px;color: #332B28; font-family:Lato,Arial,Helvetica,sans-serif; font-size: 14px;">' . str_replace('%Create my profile%',$profile_link,$article->content) . '</td>
              </tr>
              <tr>
                <td><img src="http://www.soundbooka.com/version1/images/email_footer.jpg" width="639" height="83" border="0" usemap="#Map" /></td>
              </tr>
            </table></td>
          </tr>
        </table>

        <map name="Map" id="Map">
          <area shape="rect" coords="9,4,28,24" href="http://www.facebook.com/soundbooka" target="_blank" />
          <area shape="rect" coords="30,4,51,25" href="http://www.twitter.com/soundbooka" target="_blank" />
          <area shape="rect" coords="4,30,636,78" href="http://www.soundbooka.com/version1/" />
        </map>
        </body>
        </html>';	
    $body = $html ;	
    $this->email->message($body);
    send_email($user->email, $article->subject, $body);

    }
  function getEmailTemplate($id) {
        $article = new stdClass();
        $this->db->select('wp_structure.id,wp_structure.title,wp_email_template.recId,wp_email_template.content,wp_email_template.subject,wp_email_template.email_from,wp_email_template.cc,wp_email_template.bcc,');
        $this->db->join('wp_email_template', 'wp_email_template.link = wp_structure.id');
        $this->db->where('wp_structure.id', $id);
        $q = $this->db->get('wp_structure');
        if ($q->num_rows() > 0):
          $email_template = $q->row();
          return $email_template;
        else :
          return $email_template;
        endif;
    }
}
?>