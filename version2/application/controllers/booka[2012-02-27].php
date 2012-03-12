<?php
error_reporting("0");
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/**
 * Soundbooka
 * 
 * @author     Chathura Payagala <chathupayagala@gmail.com>
 */
class Booka extends MY_Controller {

  function Booka() {
    parent::__construct();
    $this->load->model('mUser');
    //$this->load->model('mBooka');
	$this->load->model('mBooka');
	$this->load->model('mArticle');
	$this->load->model('mUtil');
    
  }

  public function index() {
    $data = array(
        'title' => '',
        'main_content' => 'home'
    );
    $this->load->view('template', $data);
  }

  public function registered($id) {
    //send_email('chathupayagala@gmail.com', 'subject', 'message');
    $data = array(
        'title' => 'Registration Complete',
        'main_content' => 'booka/registered',
		'id' => $id
    );
    $this->load->view('template', $data);
  }
  
  public function re_send($id) {
	$this->_sendEmail($id);
	die('OK');  
  }

  public function updateBookaStatus() {
	$status = $_POST['bStatus'];
	$id = $_POST['bId'];
	$sql ="UPDATE `booka` b, user u SET status='{$status}' WHERE b.user_id = u.id && u.`id` ='{$id}'";
    $this->db->query($sql);
	if($status == 'approved')
	{
		$this->sendEmailApproved($id);

	}else if($status == 'reject')
	{
		$this->sendEmailRejected($id);
	}
	
	//die('OK');  
  }  
  // Date: 30 Nov ' 11 EM code starts here
  

  public function register() {
   
//
    //$this->form_validation->set_rules('type', 'Account Type', 'required|trim');
   	$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback_check_profile');
    $this->form_validation->set_rules('email_confirm', 'Email Confirm', 'required|trim|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'required|alpha_numeric|trim');
    $this->form_validation->set_rules('password_confirm', 'Password Confirm', 'required|alpha_numeric|trim');
    $this->form_validation->set_rules('secret_question', 'Secret Question', 'required');
    $this->form_validation->set_rules('secret_answer', 'Secret Answer', 'required');
    $this->form_validation->set_rules('dob_day', 'Birth Day', 'required');
    $this->form_validation->set_rules('dob_month', 'Birth Month', 'required');
    $this->form_validation->set_rules('dob_year', 'Birth Year', 'required');
    $this->form_validation->set_rules('age', 'Age verification', 'required|is_numeric');
    $this->form_validation->set_rules('agree', 'Agree Terms', 'required|is_numeric');

    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

    if ($this->form_validation->run() == FALSE) {
      $data = array(
          'title' => 'Register',
          'main_content' => 'booka/register'
      );
      $data['form_errors'] = $this->form_validation->error_array();
      $data['types'] = $this->mUtil->getCodes('Account Types');
	  $questions = $this->mUtil->getCodes('Secret Questions');
      foreach ($questions as $s) {
		$data['questions'][$s] = $s;  
	  }
      $this->load->view('template', $data);
    } else {
	  $profile_type = 'booka';
      $form_data = array(
          'id' => 0,
          'email' => set_value('email'),
          'password' => set_value('password'),
          'type' => set_value('type'),
          'secret_question' => set_value('secret_question'),
          'secret_answer' => set_value('secret_answer'),
          'newsletter' => set_value('newsletter'),
          'dob' => set_value('dob_year') . "-" . set_value('dob_month') . "-" . set_value('dob_day'),
		  'profile_type' => $profile_type,
		  'isbooka' => 1
		);
      if ($newID = $this->mUser->save($form_data)) {
       $aid = $this->mBooka->save(array('id' => 0, 'user_id' => $newID),$_POST);              
       $this->session->set_flashdata('message', 'You can now complete your profile.');  
        
       $this->_sendEmail($aid);
	   $captcha=$this->random_text();	  
        
        //echo base_url().'user/directLogin/'.$aid.'/1?clr='.$captcha;exit;
		redirect(base_url().'user/directLogin/'.$aid.'/1?clr='.$captcha);
      
	  } else {
        $this->session->set_flashdata('error', 'An error occurred saving your information. Please try again later');

        $data = array(
            'title' => 'Register',
            'main_content' => 'Booka/register'
        );
        $this->load->view('template', $data);
      }
    }
  }

  function _sendEmail($id) {
    $Booka = $this->mBooka->get($id);
    $user = $this->mUser->get($Booka->user_id);
	$article = $this->mArticle->getEmailTemplate(194220);
	
	  $this->load->library('email');

	  $this->email->from($article->email_from);
	  $this->email->to($user->email);
	  $this->email->cc($article->cc);
	  $this->email->bcc($article->bcc);
	  $this->email->subject($article->subject);
    
		//$profile_link = "<a href='" . base_url() . "Booka/step1/{$id}'>Create my profile</a>";
		$profile_link = "<a href='" . base_url() . "booka/step1/{$id}'>Create my profile</a>";
	
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
    //$this->email->send();

    send_email($user->email, $article->subject, $body);

    return;
  }
  
    function sendEmailApproved($id) 
	{
		$Booka = $this->mBooka->get($id);
		$user = $this->mUser->get($Booka->user_id);
		$article = $this->mArticle->getEmailTemplate(194220);
   
		$profile_link = "<a href='" . base_url() . "profile/view/{$id}'>here</a>";
		
	$html = "<html>
<head>
</head>
<body>
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td align=\"center\" valign=\"top\"><table width=\"639\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
      <tr>
        <td><img src=\"http://www.soundbooka.com/version1/images/email_head.jpg\" width=\"639\" 
		height=\"143\" /></td>
      </tr>
      <tr>
        <td style=\"padding-top:30px; padding-left:20px;padding-bottom:20px;padding-right:10px;color: #332B28; font-family:Lato,Arial,Helvetica,sans-serif; font-size: 14px;\">Hi!<br/><br/>Soundbooka are pleased to inform you that your Profile Page has been reviewed and activated. You will now be able to be booked for gigs through <a href=\"www.soundbooka.com\">www.soundbooka.com</a><br/><br/>View your activated Soundbooka Profile Page ".$profile_link."<br/><br/>For more information please contact us at <a href=\"mailto:info@soundbooka.com\">info@soundbooka.com</a><br/><br/>Thanks,<br/><br/>The Soundbooka Team <br/><br/><a href=\"www.soundbooka.com\">www.soundbooka.com</a>
</td>
      </tr>
      <tr>
        <td><img src=\"http://www.soundbooka.com/version1/images/email_footer.jpg\" width=\"639\" height=\"83\" border=\"0\" usemap=\"#Map\" /></td>
      </tr>
    </table></td>
  </tr>
</table>

<map name=\"Map\" id=\"Map\">
  <area shape=\"rect\" coords=\"9,4,28,24\" href=\"http://www.facebook.com/soundbooka\" target=\"_blank\" />
  <area shape=\"rect\" coords=\"30,4,51,25\" href=\"http://www.twitter.com/soundbooka\" target=\"_blank\" />
  <area shape=\"rect\" coords=\"4,30,636,78\" href=\"http://www.soundbooka.com/version1/\" />
</map>
</body>
</html>";

    send_email($user->email, "Welcome to Soundbooka!", $html);
	//die('OK');  
    return;
  }
  
  function sendEmailRejected($id) 
	{
		$Booka = $this->mBooka->get($id);
		$user = $this->mUser->get($Booka->user_id);
		$article = $this->mArticle->getEmailTemplate(194220);
		$this->load->library('email');
		$this->email->from($article->email_from);
		$this->email->to($user->email);
		$this->email->cc($article->cc);
		$this->email->bcc($article->bcc);
		$this->email->subject("Registration Pending");
    
		
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
        <td style="padding-top:30px; padding-left:20px;padding-bottom:20px;padding-right:10px;color: #332B28; font-family:Lato,Arial,Helvetica,sans-serif; font-size: 14px;">Hi!<br/><br/>Unfortunately your Soundbooka Profile Page will not be activated.<br/><br/>You will be able to register as an Booka on Soundbooka again in three months. For more information please visit the Soundbooka FAQ page <a href="http://www.soundbooka.com/version1/faq">here</a>.<br/><br/>Thanks,<br/><br/>The Soundbooka Team <br/><br/><a href="www.soundbooka.com">www.soundbooka.com</a>    </td>
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
    //$this->email->send();

    send_email($user->email, "Your Soundbooka Profile", $body);
//die('OK');  
    return;
  }

  public function step1($id=0) {
	
	if (!$id) {
      $this->session->set_flashdata('error', 'You have to resigter first.');
      redirect('/booak/register');
    }
	
	if(!empty($_POST)){
		$this->form_validation->set_rules('booka_type', 'Business Type', 'required|trim');
		$this->form_validation->set_rules('address', 'Business Address', 'required|trim');
		$this->form_validation->set_rules('suburb', 'Town/Suburb', 'required|trim');
		$this->form_validation->set_rules('country', 'Country', 'required|trim');
		$this->form_validation->set_rules('state', 'State', 'required|trim');
		$this->form_validation->set_rules('postcode', 'Postcode', 'required');
		$this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
		$this->form_validation->set_rules('phone_code', 'Phone Code', '');
		$this->form_validation->set_rules('primary_phone', 'Phone Number', 'required');
		$this->form_validation->set_rules('alternative_phone', 'Phone Number', '');

	if($_POST['booka_type'] == '1'){
		$booka = 'commerical';
		//$this->form_validation->set_rules('business_name', 'Business Name', 'required|trim');
		$this->form_validation->set_rules('abn', 'ABN', 'required|trim');
	}else $booka = 'private';
	
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	
	}
    if ($this->form_validation->run() == FALSE) {
      $data = array(
          'title' => 'Create Profile Step 1',
          'main_content' => 'booka/step1'
      );
      $data['form_errors'] = $this->form_validation->error_array();
      $data = array_merge($data, (array) $this->mBooka->get($id));
	  if (empty($data['id'])) {
		  $this->session->set_flashdata('error', 'Profile does not exist - please try again.');
		  redirect('/booka/register');
	  }

      $data['countries'] = $this->mUtil->getCountryList();
	  $data['states'] = $this->mUtil->getStateList(set_value('country', $data['country']));
	  $data['genders'] = $this->mUtil->getCodes('gender');
	
      //print_r($data);die;
      $this->load->view('template', $data);
    } else {
      $form_data = array(
          'id' => $id,
		  'booka_type' => $booka,
		  'business_name' => set_value('business_name'),
		  'abn' => set_value('abn'),
          'firstname' => set_value('firstname'),
          'lastname' => set_value('lastname'),
          'address' => $this->input->post('address'),
          'suburb' => set_value('suburb'),
          'state' => set_value('state'),
          'country' => set_value('country'),
          'postcode' => set_value('postcode'),
          // 'phone_code' => set_value('phone_code'),
          'primary_phone' => set_value('primary_phone'),
          'alternative_phone' => set_value('alternative_phone')
      );
	
      if ($newID = $this->mBooka->save($form_data)) {
        //$this->session->set_flashdata('message', 'You can now complete your profile.');
        redirect('/booka/step2/' . $newID);
      } else {
        $this->session->set_flashdata('error', 'An error occurred saving your information. Please try again later');

        $data = array(
            'title' => 'Create Profile Step 1',
            'main_content' => 'booka/step1'
        );
		
        $this->load->view('template', $data);
      }
    }
  }




  public function step2($id=0) {
   if (!$id) {
      $this->session->set_flashdata('error', 'You have to resigter first.');
      redirect('/Booka/register');
    }
   $this->form_validation->set_rules('payment_method', 'Payment Method', 'required');
   
   if ($this->input->post('payment_method') == 1) {
    $this->form_validation->set_rules('paypal_email', 'Paypal Email', 'required|valid_email');
   } else {
	   $this->form_validation->set_rules('paypal_email', 'Paypal Email', '');
   }
    
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

    if ($this->form_validation->run() == FALSE) {
      $data = array(
          'title' => 'Create Booka Profile Step 2',
          'main_content' => 'booka/step2'
      );
      $data['form_errors'] = $this->form_validation->error_array();
	  $data = array_merge($data, (array) $this->mBooka->get($id));
	  if (empty($data['id'])) {
		  $this->session->set_flashdata('error', 'Profile does not exist - please try again.');
		  redirect('/booka/register');
	  }
	
      $this->load->view('template', $data);
    } else {
      $form_data = array(
	  	  'id' => $id,
          'payment_method' => set_value('payment_method'),
          'paypal_email' => set_value('paypal_email'),
          
		);
      if ($newID = $this->mBooka->save($form_data)) {
		echo '<div style="display:none;">'; print_r($this->input->post('save')); echo '</div>';
		if ($this->input->post('save')) {
        	redirect('/booka/step3/' . $newID);
		} else {
			redirect('/booka/step2/' . $newID);
		}
      
	  } else {
        $this->session->set_flashdata('error', 'An error occurred saving your information. Please try again later');

        $data = array(
          'title' => 'Create Booka Profile Step 2',
          'main_content' => 'booka/step2'
        );
		
        $this->load->view('template', $data);
      }
    }
  }

  public function step3($id=0) {
	if (!$id) {
      $this->session->set_flashdata('error', 'You have to resigter first.');
      redirect('/booka/register');
    }
    $data = array(
        'title' => '',
        'main_content' => 'booka/step3',
		'id' => $id
    );
	
    $this->load->view('template', $data);
  }
  
  public function create_new($id) {
	  if (!$id) {
      $this->session->set_flashdata('error', 'You have to resigter first.');
      redirect('/Booka/register');
    }
	
	$Booka = $this->mBooka->get($id);
	  if (!isset($Booka->id) || !$Booka->id) {
		  $this->session->set_flashdata('error', 'You have to resigter first.');
		  redirect('/Booka/register');
	  }
	  
	$ins['id'] = 0;
	$ins['user_id'] = $Booka->user_id ;
	$ins['first_name'] = $Booka->first_name ;
	$ins['last_name'] = $Booka->last_name ;
	$ins['address'] = $Booka->address ;
	$ins['suburb'] = $Booka->suburb ;
	$ins['state'] = $Booka->state ;
	$ins['country'] = $Booka->country ;
	$ins['postcode'] = $Booka->postcode ;
	$ins['phone_code'] = $Booka->phone_code ;
	$ins['phone_number'] = $Booka->phone_number ;
	$ins['phone_alternate'] = $Booka->phone_alternate ;
	$ins['gender'] = $Booka->gender ;
	  
	$aid = $this->mBooka->save($ins);
	redirect('/Booka/step1/'.$aid);
  }
	function manage_profile($id){
	if (!$id) {
	  $this->session->set_flashdata('error', 'You have to resigter first.');
	  redirect('/booka/register');
	}
	 $data = array(
		  'title' => 'Manage Profiles',
		  'main_content' => 'booka/manage_profile'
	  );
	$r = $this->db->query("SELECT a.id as id, u.email from booka a, user u WHERE a.id='{$id}' AND a.user_id=u.id");
	$artist=($r->result_array());
	$email=$artist[0]['email'];

	$data['other_profiles']=$this->mBooka->other_profile($email);
	// echo '<pre style="display:none;">';print_r($data);echo '</pre>';
	$booka=($r->result_array());
	$this->load->view('template', $data);
	}
	
	
	  // 1.27.12; wiseobject <- settings
	  function settings($id){
		if (!$id) {
		  $this->session->set_flashdata('error', 'You have to resigter first.');
		  redirect('/booka/register');
		}
		$this->form_validation->set_rules('freq_of_email', 'Frquency of E-mail', 'trim');
		$this->form_validation->set_rules('booking_notify', 'Booking Notifications', 'trim');
		if ($this->form_validation->run() == FALSE) {
			$data = array
			(
				'title' => 'Settings',
				'main_content' => 'booka/settings'
			);
			$data['form_errors'] = $this->form_validation->error_array();
			$sql = "select freq_of_email,booking_notify from `booka` where id = '{$id}' ";
			$query = $this->db->query($sql);
			$data['personal'] = ($query->result_array());
			$this->load->view('template', $data);
		} else {
			$this->session->set_flashdata('message', 'You have updated successfully.');
			$sql = sprintf
			(
				"UPDATE `booka` SET freq_of_email = '%s', booking_notify = '%s' WHERE	`id` = '%s'",
				$_POST['freq_of_email'],
				$_POST['booking_notify'],
				$id
			);
			$this->db->query($sql);
			redirect('/booka/settings/'.$id);
		}
	  }
	
  function personal_info($id){
		if (!$id) {
		$this->session->set_flashdata('error', 'You have to resigter first.');
		redirect('/booka/register');
		}
		$this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
		$this->form_validation->set_rules('secret_answer', 'Secret Answer', 'required');
			
		if ($this->form_validation->run() == FALSE) {
		$data = array(
		'title' => 'Personal Information',
		'main_content' => 'booka/personal_info'
		);
		$data['form_errors'] = $this->form_validation->error_array();
		$questions = $this->mUtil->getCodes('Secret Questions');
		  foreach ($questions as $s) {
			$data['questions'][$s] = $s;  
		  }
		$sql = "select booka.*,usr.* from booka LEFT JOIN user usr ON usr.id = booka.user_id where booka.id = '{$id}' ";
		$query = $this->db->query($sql);
		$data['personal'] = ($query->result_array());
		#echo '<pre style="display:none;">';print_r($data);echo '</pre>';
		
		$this->load->view('template', $data);
		} else {
		#echo '<pre style="display:none;">';print_r($_POST);echo '</pre>';
		$this->session->set_flashdata('message', 'You have updated successfully.');
		$dob=$_POST['dob_year'].'-'.$_POST['dob_month'].'-'.$_POST['dob_day'];
		
		$updatesql ="UPDATE `booka` a, user u SET a.`firstname` = '{$_POST['first_name']}', a.`lastname` = '{$_POST['last_name']}', u.dob='{$dob}', u.secret_answer='{$_POST['secret_answer']}', u.secret_question='{$_POST['secret_question']}' ";
		if($_POST['password1']!='') $updatesql.=", u.password='{$_POST['password1']}'";
		$updatesql.=" WHERE a.`id` ='{$id}' && a.user_id=u.id";		
		
		$this->db->query($updatesql);
		redirect('/booka/personal_info/'.$id);
		}
	  }
	
	function manage_gig($id){
	if (!$id) {
	  $this->session->set_flashdata('error', 'You have to resigter first.');
	  redirect('/booka/register');
	}
	 $data = array(
		  'title' => 'Manage Gigs',
		  'main_content' => 'booka/manage_gig'
	  );
	
	$sql_gig = "SELECT * FROM manage_gigs WHERE booka_id='{$id}'";
	extract($_POST);
	if(isset($start_date) and trim($start_date)!='') {
		$sd = explode("/",$start_date);
		$sdate = "$sd[2]-$sd[1]-$sd[0]";
	}
	else {
		$sdate = '1970-01-01';
	}
	if(isset($end_date) and trim($end_date)!='') {
		$ed = explode("/",$end_date);
		$edate = "$ed[2]-$ed[1]-$ed[0]";
	}
	else {
		$edate = '3000-12-31';
	}
	
	$sql_gig .= "and   start_date >= '{$sdate}'  and end_date <='{$edate}'";
	
	//echo $sql_gig;
	$r = $this->db->query($sql_gig);
	
	
	
	$data['gigs']=$r->result_array();
	$bid=array(0);
	if(count($data['gigs'])>0) foreach($data['gigs'] as $v) $bid[]=$v['gig_id'];
	$bid=implode(',',$bid);
	//print_r($_POST); 
	$sql= "SELECT *, ag.id AS agid, a.id AS aid FROM artist_gig_map ag
							LEFT JOIN artist a ON ag.artist_id=a.id
							LEFT JOIN artist_type at ON at.artist_id=a.profile_type
							WHERE ag.gig_id IN ({$bid}) ";
	if(isset($status)) {
		if($status=='Draft') $sql .= "and (ag.respond_status = '' or ag.respond_status like  'Draft') ";
		else if($status=='Payments') $sql .= "and ag.respond_status like  'Deposit Paid' ";
		else $sql .= "and ag.respond_status like '%{$status}%' and ag.respond_status not like '%Payments%'";
	}
	
	
	
	/*if(isset($start_date) and ) {
		if($status=='Draft') $sql .= "and ag.respond_status = ''";
		else $sql .= "and ag.respond_status like '%{$status}%'";
	}
	*/
	
	
	$sql .= " ORDER BY position" ; 
	//echo $sql;
	$q = $this->db->query($sql);
	
	$map_artists=$q->result_array();
//print_r($map_artists);
	if(count($map_artists)>0) {
		foreach($map_artists as $val){
			$data['map_artists'][$val['gig_id']][$val['agid']]['profile_name']=$val['profile_name'];
			
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
				
				$data['map_artists'][$val['gig_id']][$val['agid']]['amount'] = $amount;
				$data['map_artists'][$val['gig_id']][$val['agid']]['performance_amount'] = $performance_amount;
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
				
				$data['map_artists'][$val['gig_id']][$val['agid']]['amount'] = $amount;
				$data['map_artists'][$val['gig_id']][$val['agid']]['performance_amount'] = $performance_amount;
			}
			$data['map_artists'][$val['gig_id']][$val['agid']]['profile_name']=$val['profile_name'];
			$data['map_artists'][$val['gig_id']][$val['agid']]['offered_date']=$val['offered_date'];
			$data['map_artists'][$val['gig_id']][$val['agid']]['payment_date']=$val['payment_date'];
			$data['map_artists'][$val['gig_id']][$val['agid']]['type']=$val['type'];
			$data['map_artists'][$val['gig_id']][$val['agid']]['artist_id']=$val['aid'];
			$data['map_artists'][$val['gig_id']][$val['agid']]['id']=$val['agid'];
			if($val['respond']!=1)	
			{
				$data['map_artists'][$val['gig_id']][$val['agid']]['status']=$val['offer_status'];
			}
			else 
			{ 
				$data['map_artists'][$val['gig_id']][$val['agid']]['status']=$val['respond_status'];			
			}
			//$data['map_artists'][$val['gig_id']][$val['agid']]['status']=$val['offer_status'];
			
			$data['map_artists'][$val['gig_id']][$val['agid']]['rated'] = $val['rated'];
			$rate_sql = "SELECT CEIL(AVG(`star_rate`)) AS star_rate,booka_id,gig_id,artist_id FROM rating where `artist_id`='".$val['aid']."'";
			$rate_result = $this->db->query($rate_sql);
			$data['map_artists'][$val['gig_id']][$val['agid']]['rate'] = $rate_result->result_array();
			
			
			if($val['offer_status']=='Confirm' || $val['respond_status']=='Accepted') 
			$data['gig_test'][$val['gig_id']]=1;
		}	
	}
	
	$data['id']=$id;
	$this->load->view('template', $data);
	} 
  function check_profile($email){
	if($email=='') { return false; }
	$other_profiles=$this->mBooka->other_profile($email);	  
	if(sizeof($other_profiles)>0) {
		$this->form_validation->set_message('check_profile', 'This email is already registered. Login to edit or add more profiles.');
		return false;
	}
	else return true;
  }
  
  function gig_profile($id=0,$profile_id=0) {

	if (!$id) {
      $this->session->set_flashdata('error', 'You have to resigter first.');
      redirect('/booak/register');
    }
 
	if($profile_id>0) $gig_profile=$this->mBooka->get_gig_profile($profile_id);
	
	// $data['allgenres']=$this->mArtist->allgenres();
		if(!empty($_POST)){
			if(!empty($_POST['existing_gigname'])) { $data['gig_name']=$_POST['gig_name']=$_POST['existing_gigname']; }
			$this->form_validation->set_rules('gig_name', 'Gig Name', 'required|trim');
			
			$this->form_validation->set_rules('fee_hour', 'fee_hour', '');
			$this->form_validation->set_rules('fee_gig', 'fee_gig', '');
			$this->form_validation->set_rules('gig_hours', 'Performance time ', 'numeric');
			
			$this->form_validation->set_rules('start_date', 'Start Date', 'required|trim');
			$this->form_validation->set_rules('start_time', 'Start Time', '');
			$this->form_validation->set_rules('end_date', 'End Date', 'required|trim');
			$this->form_validation->set_rules('end_time', 'End Time', '');
			$this->form_validation->set_rules('artist_type', 'Artist Type', 'required|trim');
			$this->form_validation->set_rules('genre', 'Genre', 'required');
			$this->form_validation->set_rules('address', 'Address', 'required|trim');
			$this->form_validation->set_rules('country', 'Country', 'required|trim');
			$this->form_validation->set_rules('state', 'State', 'required|trim');
			$this->form_validation->set_rules('suburb', 'Suburb', 'required|trim');
			$this->form_validation->set_rules('active', 'Active', '');
			$this->form_validation->set_rules('existing_gigname', 'existing_gigname', '');

			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			if ((!isset($_POST['gig_hours']) || !isset($_POST['fee_hour']) || empty($_POST['gig_hours']) || empty($_POST['fee_hour'])) && empty($_POST['fee_gig']) ) {
			$myErrors[] = 'Enter performance fee';
			}
			
			foreach ($myErrors as $k => $me) {
				$this->form_validation->set_error('custom_' . $k, $me);
			}
		}
		if ($this->form_validation->run() == FALSE || count($myErrors)) {
			$data = array(
				'title' => 'Create Gig Profile',
				'main_content' => 'booka/gig_profile'
			);
		if(!empty($_POST['existing_gigname'])) { $data['gig_name']=$_POST['gig_name']=$_POST['existing_gigname']; }
		$data['form_errors'] = $this->form_validation->error_array();
		$q=$this->db->get_where('artist_type',array('active'=>1));
		$atype=$q->result_array();
		foreach($atype as $v) $types[$v['artist_id']]=$v['type'];
		$data['types']=$types;
		if($profile_id>0) { 
			$data = array_merge($data, (array) $this->mBooka->get_gig_profile($profile_id));
			$data['profile_id']=$profile_id;
			$data['status']=set_value('status');
			$data['start_time']=substr($data['start_time'],0,2);
			$data['end_time']=substr($data['end_time'],0,2);
		}
		$e1 = $this->db->query("SELECT DISTINCT(gig_name) FROM manage_gigs");
		$e=$e1->result_array();
		$data['existing_gigname']=array('Select Gig Name');
		foreach($e as $v){
			$data['existing_gigname'][$v['gig_name']]=$v['gig_name'];
		}
		$data['countries'] = $this->mUtil->getCountryList();
		$data['states'] = $this->mUtil->getStateList(set_value('country', @$data['country']));
		$data['time']=array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24');
		
		$r = $this->db->query("SELECT payment_method from manage_gigs where gig_id='{$profile_id}'");
		$artist=($r->result_array());
		if(isset($artist[0]['payment_method']) and $artist[0]['payment_method'] > 0) { $data['payment_method']=$artist[0]['payment_method']; }
		else {
			$r = $this->db->query("SELECT payment_method from booka where id='{$id}'");
			$artist=($r->result_array());
			$data['payment_method']=$artist[0]['payment_method'];
			}
		
	  //print_r($data);die;
      $this->load->view('template', $data);
    } else {
		$this->session->set_userdata('searching',array());
		$s=explode('/',set_value('start_date'));
		$start_date=$s[2].'-'.$s[1].'-'.$s[0];
		$s=explode('/',set_value('end_date'));
		$end_date=$s[2].'-'.$s[1].'-'.$s[0];
		$start_time=set_value('start_time').':00:00';
		$end_time=set_value('end_time').':00:00';
      $form_data = array(
          'gig_name' => set_value('gig_name'),
		  'event_name' => $_POST['event_name'],
		  'fee_hour' => set_value('fee_hour'),
          'fee_gig' => set_value('fee_gig'),
          'gig_hours' => set_value('gig_hours'),
		  'booka_id' => $id,
		  'start_date' => $start_date,
		  'start_time' => $start_time,
		  'end_date' => $end_date,
		  'end_time' => $end_time,
		  'artist_type' => set_value('artist_type'),
		  'country' => set_value('country'),
		  'state' => set_value('state'),
		  'suburb' => set_value('suburb'),
          'genre' => implode(',',$_POST['genre']),
          'address' => $this->input->post('address'),
		  'payment_method' => $this->input->post('payment_method')
      );
	  if($profile_id>0) $gig_id=$form_data['gig_id']=$profile_id;
	  $user_id = $this->session->userdata('search_user');
      if ($newID = $this->mBooka->save_manage_gigs($form_data)) {
		if(isset($user_id) && !empty($user_id)){
		$gig_id=$newID;
		$artist_id = $user_id;
		$update['gig_id']=$gig_id;
		$update['artist_id']=$artist_id;
		$update['offered_date']=date('Y-m-d');
		$update['booka_id']=$this->session->userdata('artist_id');
		$this->db->insert('artist_gig_map', $update);
		$this->session->set_userdata('search_user',null);
		}
         
        redirect('/booka/manage_gig/' . $id);
      } else {
        $this->session->set_flashdata('error', 'An error occurred saving your information. Please try again later');

        $data = array(
            'title' => 'Create Gig Profile',
            'main_content' => 'booka/gig_profile'
        );
		
        $this->load->view('template', $data);
      }
    }
  }
  
    public function view($id=0) {
	
	if (!$id) {
      $this->session->set_flashdata('error', 'You have to resigter first.');
      redirect('/booak/register');
    }
   
      $data = array(
          'title' => 'View Gig Profile',
          'main_content' => 'booka/view'
      );
      
      $data = array_merge($data, (array) $this->mBooka->get($id));
	  echo '<div style="display:none;">';
	  print_r($data);
	  echo '</div>';
	  if (empty($data['id'])) {
		  $this->session->set_flashdata('error', 'Profile does not exist - please try again.');
		  redirect('/booka/register');
	  }

      $data['countries'] = $this->mUtil->getCountryList();
	  $data['states'] = $this->mUtil->getStateList(set_value('country', $data['country']));
	  $data['genders'] = $this->mUtil->getCodes('gender');
	
      //print_r($data);die;
      $this->load->view('template', $data);
     
    }
	function manage_favourite($id=0){
		$data = array(
		  'title' => 'Manage Favourites',
		  'main_content' => 'booka/manage_favourite'
		);
		$data['types'] = $this->mUtil->getProfileTypeList();
		$q=$this->db->query("SELECT *,mf.status AS fstatus FROM manage_favourite mf, artist a WHERE a.id=mf.artist_id");
		$data['favourites']=$q->result_array();
		$this->load->view('template', $data);
	}
	
	function histroy($id){
		$data = array(
		  'title' => 'Gig Artist History',
		  'id' => $id
		  //'main_content' => 'booka/manage_favourite'
		);
		
		$sql = "SELECT *, ag.id AS agid, ag.gig_id AS gig_map_id FROM artist_gig_map ag
							LEFT JOIN artist a ON ag.artist_id=a.id
							LEFT JOIN artist_type at ON at.artist_id=a.profile_type
							LEFT JOIN gig_histroy histroy ON histroy.gig_id = ag.id
							WHERE ag.id = {$id}  ORDER BY histroy_created DESC, position";
		
		$q = $this->db->query($sql);
	
		$data['artists_histroy'] = $q->result_array();
		$this->load->view('histroy', $data);
		
	}
	function calender(){
		
		
		if(isset($_POST) && !empty($_POST['del_events'])){
			$sql ="delete from `user_event` WHERE id in (".implode(",",$_POST['del_events']).")";
			$this->db->query($sql);
		}
		
		$data = array(
		  'title' => 'Calender',
		  'main_content' => 'booka/calender'
		);
		$this->load->view('template', $data);
	}
	function editcalender(){
	
	if(isset($_POST['delete'])){
		$id = $_REQUEST['id'];	
		$this->db->where('id', $id);
		$this->db->delete('user_event');		
		
		$this->db->where('parenteventid', $id);
		$this->db->delete('user_event_detail');
		$this->session->set_flashdata('message', 'You have successfully deleted event.');
		?>
		<script type="text/javascript" language="javascript">
		if (window.opener && !window.opener.closed) {
				window.opener.location.reload();
		} 
		window.close();
		</script>
		<?php
	}
	
	if(isset($_POST) && !empty($_POST) && !isset($_POST['delete'])){
	$this->form_validation->set_rules('event_title', 'Event Title', 'required');
    $this->form_validation->set_rules('event_loc', 'Event Location', 'required');
    $this->form_validation->set_rules('event_start_date', 'Start Date', 'required');
    $this->form_validation->set_rules('event_to_date', 'End Date', 'required');
   // $this->form_validation->set_rules('event_occ', 'Event Occurence', 'required|is_numeric');
    
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    if ($this->form_validation->run() == FALSE) {
      $data = array(
          'title' => 'Edit Events',
          'main_content' => 'artist/saveevent'
      );
     $data['form_errors'] = $this->form_validation->error_array();
     $this->load->view('template', $data);
      
    } 
	else {
		$id = $_REQUEST['id'];
		$form_data = array(
		'id' => $id,
		'event_title' => set_value('event_title'),
		'event_loc' => set_value('event_loc'),
		'event_desc' => set_value('event_desc'),
		'start_date' => set_value('event_start_date'),
		'to_date' => set_value('event_to_date'),
		'start_time' => $_POST['event_start_time'],
		'end_time' => $_POST['event_end_time'],
	);

		//print_r($_POST);
		$aid = $this->mBooka->savevent($form_data);
		$this->session->set_flashdata('message', 'You have successfully saved event.');
		?>
		<script type="text/javascript" language="javascript">
		if (window.opener && !window.opener.closed) {
				window.opener.location.reload();
		} 
		window.close();
		</script>
		<?php //redirect('/artist/registered/'.$aid);
    }
	}
		$data = array(
		  'title' => 'Edit Calender',
		  'main_content' => 'booka/edit_calendar'
		);
		$this->load->view('booka/edit_calendar', $data);
	}
     function random_text(){
	  $codelenght = 10;
	  $newcode_length=0;$newcode='';
		 while($newcode_length < $codelenght) {
		 $x=1;
		 $y=3;
		 $part = rand($x,$y);
		 if($part==1){$a=48;$b=57;}  // Numbers
		 if($part==2){$a=65;$b=90;}  // UpperCase
		 if($part==3){$a=97;$b=122;} // LowerCase
		 $code_part=chr(rand($a,$b));
		 $newcode_length = $newcode_length + 1;
		 $newcode = $newcode.$code_part;
		 }
		 return $newcode;
	}
	function notification($id){
		
		$data = array(
			'title' => 'Notification',
			'main_content' => 'booka/notification'
		);
		
		//$sql = "select * from notifications noti LEFT JOIN manage_gigs gig ON noti.gig_id = gig.gig_id JOIN artist_gig_map agm ON agm.gig_id = gig.gig_id where noti.artist_id = '{$id}'";
		
		$sql = "select *,noti.status as notify_status,noti.created as notify_created from notifications noti JOIN manage_gigs gig ON noti.gig_id = gig.gig_id JOIN
		artist art ON  noti.artist_id = art.id where noti.booka_id  = '{$id}' ";
				
		extract($_POST);
		if(isset($start_date) and trim($start_date)!='') {
			$sd = explode("/",$start_date);
			$sdate = "$sd[2]-$sd[1]-$sd[0]";
		}
		else {
			$sdate = '1970-01-01';
		}
		if(isset($end_date) and trim($end_date)!='') {
			$ed = explode("/",$end_date);
			$edate = "$ed[2]-$ed[1]-$ed[0]";
		}
		else {
			$edate = '3000-12-31';
		}
		
		$sql .= " and   noti.created >= '{$sdate}'  and noti.created <='{$edate}'";
		
		if(isset($gig) and $gig > 0) $sql .= " and   noti.gig_id = '{$gig}'";
		if(isset($status) and $status != '') $sql .= " and   noti.status like  '%{$status}%'";
		
		$sql .= "order by noti.created DESC";
		$data['sql'] =$sql;
		
		
		$query = $this->db->query($sql);
		$data['notification'] = $query->result_array();
		
		$sql_gig = $sql = "select gig.gig_id,gig.gig_name,gig.start_date from notifications noti JOIN manage_gigs gig ON noti.gig_id = gig.gig_id JOIN
		artist art ON  noti.artist_id = art.id where noti.booka_id  = '{$id}' order by gig.gig_name";
		
		$r = $this->db->query($sql_gig);
		$data['gigs']=$r->result_array();
		
		
		$this->load->view('template', $data);
	}
	function view_notification($id) {
		redirect('/booka/notification/'.$this->session->userdata('artist_id'));
	}
    
    function paypal_process($gig_id,$profile_id) {    
 
            //PayPal API Credentials
             $API_UserName = $this->config->item('APIUsername'); //TODO
            $API_Password = $this->config->item('APIPassword'); //TODO
            $API_Signature = $this->config->item('APISignature'); //TODO
                   
            //Default App ID for Sandbox	
            $API_AppID = $this->config->item('ApplicationID');
 
            $API_RequestFormat = "NV";
            $API_ResponseFormat = "NV";
            
            //seleting gig values            		
               $sql_gig = $sql = "select * from manage_gigs gig JOIN artist_gig_map artmap  ON artmap.gig_id = gig.gig_id  where gig.gig_id  = '{$gig_id}' and artmap.artist_id='{$profile_id}'";		                
                $r = $this->db->query($sql_gig);
                $data=$r->result_array();     

            //artist detail fetching
                    $sql_artist = $sql = "select * from artist art where art.id  = '{$profile_id}'";		                
                $artist = $this->db->query($sql_artist);
                $artistdetail=$artist->result_array(); 
                
            
                 	$amount = $data[0]['fee_gig'];
                $site_fee =0;
				if($amount >= 0 && $amount <= 500){
					$site_fee = 29;
				}
				elseif($amount >= 501 && $amount <= 1000){
					$site_fee = 49;
				}
				elseif($amount >= 1001 && $amount <= 1500){
					$site_fee = 69;
				}
				elseif($amount >= 1501 && $amount <= 2000){
					$site_fee = 89;
				}
				elseif($amount > 2000){
					$site_fee = (($amount * 5) / 100 );
				}
           //$site_fee =$site_fee+$amount;
            //Create request payload with minimum required parameters
            $bodyparams = array ("requestEnvelope.errorLanguage" => "en_US",
                        "actionType" => "PAY",
                        "currencyCode" => "USD",
                        "cancelUrl" => $this->config->item('base_url')."booka/gig_profile/".$gig_id,
                        "returnUrl" => $this->config->item('base_url')."booka/processPaypal/".$gig_id."/".$profile_id."/".$data[0]['booka_id'],
                        "receiverList.receiver(0).email" =>  $this->config->item('sitePaypalBusinessID'), //TODO
                        "receiverList.receiver(0).amount" => $amount, //TODO
                        "receiverList.receiver(0).primary" => "true", //TODO
                        "receiverList.receiver(1).email" => $artistdetail[0]['paypal_email'], //TODO
                        "receiverList.receiver(1).amount" => $site_fee, //TODO
                        "receiverList.receiver(1).primary" => "false" //TODO
                        );
 
            // convert payload array into url encoded query string
            $body_data = http_build_query($bodyparams, "", chr(38));           
            try
            {
                //create request and add headers
                $params = array("http" => array( 
                                "method" => "POST",
                                "content" => $body_data,
                                "header" =>  "X-PAYPAL-SECURITY-USERID: " . $API_UserName . "\r\n" .
                                "X-PAYPAL-SECURITY-SIGNATURE: " . $API_Signature . "\r\n" .
                                "X-PAYPAL-SECURITY-PASSWORD: " . $API_Password . "\r\n" .
                                "X-PAYPAL-APPLICATION-ID: " . $API_AppID . "\r\n" .
                                "X-PAYPAL-REQUEST-DATA-FORMAT: " . $API_RequestFormat . "\r\n" .
                                "X-PAYPAL-RESPONSE-DATA-FORMAT: " . $API_ResponseFormat . "\r\n" 
                ));
                //create stream context             
                 $ctx = stream_context_create($params);
                 
                //open the stream and send request
                $url = trim($this->config->item('SandboxURL'));
                $fp = fopen($url, "r", false, $ctx);
                //get response
                 $response = stream_get_contents($fp);                                   
                //check to see if stream is open
                 if ($response === false) {
                    throw new Exception("php error message = " . "$php_errormsg");
                 }                       
                //close the stream
                 fclose($fp);

                //parse the ap key from the response
                $keyArray = explode("&", $response);
                    
                foreach ($keyArray as $rVal){
                    list($qKey, $qVal) = explode ("=", $rVal);
                        $kArray[$qKey] = $qVal;
                }
                   
                //set url to approve the transaction
                $payPalURL = "https://www.sandbox.paypal.com/webscr?cmd=_ap-payment&paykey=" . $kArray["payKey"];
                
                //updating gig with the paykey and status
                $sql ="UPDATE `artist_gig_map` SET offer_status='confirm', respond_status ='Deposit Paid', paykey ='{$kArray["payKey"]}' WHERE gig_id ='{$gig_id}' and artist_id ='{$profile_id}'";
                $this->db->query($sql);                                             

                //print the url to screen for testing purposes
                If ( $kArray["responseEnvelope.ack"] == "Success") {
                    echo '<html><body><p>Click here to move to paypal: <a href="' . $payPalURL . '" target="_blank">' . $payPalURL . '</a></p></body></html>';
                 }
                else {
                    echo 'ERROR Code: ' .  $kArray["error(0).errorId"] . " <br/>";
                    echo 'ERROR Message: ' .  urldecode($kArray["error(0).message"]) . " <br/>";
                   $this->session->set_flashdata('error', 'Sorry there is some problem in the payment process.Please Try again later.');
                }   
                
        }

     catch(Exception $e) {
            echo "Message: ||" .$e->getMessage()."||";
    }
    }
    
    function processPaypal($gig_id,$artist_id,$booka_id){
            
            //updating gig with the paykey and status
            $sql ="UPDATE `artist_gig_map` SET offer_status='Fully Paid', respond_status ='Fully Paid' WHERE gig_id ='{$gig_id}' and artist_id ='{$artist_id}'";
            $this->db->query($sql);   
            $this->session->set_flashdata('message', 'Paypal Payment process succesfully completed.');  
            redirect('/booka/manage_gig/'. $booka_id);
    
    }
     

}