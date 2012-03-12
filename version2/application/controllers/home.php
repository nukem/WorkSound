<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/**
 * Soundbooka
 * 
 * @author     Chathura Payagala <chathupayagala@gmail.com>
 */
class Home extends MY_Controller {
	
  function Home() {
    parent::__construct();
    $this->load->model('mArticle');
    $this->load->model('mArtist');
	$this->load->model('mUtil');
	$this->load->helper('text');
  }

  public function index() {
    $data = array(
        'title' => '',
        'main_content' => 'home'
    );
    $this->load->view('template', $data);
  }
  
  public function contact() {
	
	$this->form_validation->set_rules('name', 'Name', 'required|trim');
	$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
    $this->form_validation->set_rules('message', 'Message', 'required|trim');
    $this->form_validation->set_rules('phone', 'phone', '');
    $this->form_validation->set_rules('subject', 'subject', '');
    
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

    if ($this->form_validation->run() == FALSE) {
      $article = $this->mArticle->get(194195);
		
		$data = array(
			'main_content' => 'pages/contact'
		);
		$data = array_merge($data, (array) $article);
		
      $data['form_errors'] = $this->form_validation->error_array();
      $subjects = $this->mUtil->getCodes('Contact Us Subject');
	  
	  foreach ($subjects as $s) {
		$data['subjects'][$s] = $s;  
	  }
      $this->load->view('template', $data);
    } else {
		/*$body = "Name: " . set_value('name') . "<br>";
		$body .= "Email: " . set_value('email') . "<br>";
		$body .= "Phone: " . set_value('phone') . "<br>";
		$body .= "Subject: " . set_value('subject') . "<br>";
		$body .= "Message: <br><br>" . set_value('message') . "<br>";*/
		
		$article = $this->mArticle->getEmailTemplate(194255);
		// Admin email
		$match = array("/\{name\}/", "/\{email\}/", "/\{phone\}/", "/\{message\}/");
		$replace = array(set_value('name'), set_value('email'), set_value('phone'), set_value('message'));
		
		$data['message'] = preg_replace($match, $replace, $article->content);
		$message = $this->load->view('emails/contact', $data, TRUE);
		
		send_email('info@soundbooka.com', $article->subject, $message);
		
		// Thank you mail
		
		$article = $this->mArticle->getEmailTemplate(194256);
		
		$data['message'] = preg_replace($match, $replace, $article->content);
		$message = $this->load->view('emails/contact', $data, TRUE);
		
		send_email(set_value('email'), $article->subject, $message);
	
        $this->session->set_flashdata('message', 'Your message was sent.');
        redirect('/thankyou',$data);
    }
	
  }
  
   public function re_send() {
	$article = $this->mArticle->getEmailTemplate(194255);
		// Admin email
		$match = array("/\{name\}/", "/\{email\}/", "/\{phone\}/", "/\{message\}/");
		$replace = array(set_value('name'), set_value('email'), set_value('phone'), set_value('message'));
		
		$data['message'] = preg_replace($match, $replace, $article->content);
		$message = $this->load->view('emails/contact', $data, TRUE);
		
		send_email('info@soundbooka.com', $article->subject, $message);
		
		// Thank you mail
		
		$article = $this->mArticle->getEmailTemplate(194256);
		
		$data['message'] = preg_replace($match, $replace, $article->content);
		$message = $this->load->view('emails/contact', $data, TRUE);
		
		send_email(set_value('email'), $article->subject, $message);
	die('OK');  
  }

  
  public function thankyou() {
    $data = array(
        'title' => 'Thank You',
        'main_content' => 'pages/thankyou'
    );
    $this->load->view('template', $data);
  }
  
  public function about() {
	$article = $this->mArticle->get(194212);
	
	$data = array(
        'main_content' => 'pages/about'
    );
	$data = array_merge($data, (array) $article);
    $this->load->view('template', $data); 
  }
  
  public function book() {
	$article = $this->mArticle->get(194210);
	$this->load->library('session');
	$this->session->set_userdata('searching',array());
	$data = array(
        'main_content' => 'pages/book'
    );
	$data['res'] = '1';
	$types=array(0=>'Please select artist type');
	$q=$this->db->get_where('artist_type',array('active'=>1));
	$atype=$q->result_array();
	foreach($atype as $v) $types[$v['artist_id']]=$v['type'];
	$data['types']=$types;
	$allgenres=$this->mArtist->allgenres();
	foreach($allgenres as $v){
		$data['genres'][$v['artist_type']][]=array('id'=>$v['genre_id'],'genre'=>$v['genre']);
	}
	foreach($data['types'] as $ke => $va){
		if($ke != 0)
		$data['genres'][$ke][] = array('id'=>'99999','genre'=>'Other');
	}
	$data['time']=array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
    $data['min']=array('00','05','10','15','20','25','30','35','40','45','50','55');
	$res=array();
	foreach($allgenres as $v){
		$res[$v['genre_id']]=$v['genre'];
	}
	$data['allgenres']=$res;
	$data['specializations'] = $this->mUtil->getCodes('Specialization'); 
	$data['mediums'] = $this->mUtil->getCodes('Preferred Medium');
	$skip=implode("','",array('Any','Other'));
	$q=$this->db->query("SELECT * FROM xbasetypes WHERE active=1 && basgroup1='gigs' &&  bascode1 NOT IN ('{$skip}') ORDER BY bascode1");
	$ret=$q->result_array();
	//$data['pref_gigs']=array('Select Gigs');
	foreach($ret as $v){
		$data['pref_gigs'][$v['baseid']]=$v['bascode1'];
	}
	if (isset($_POST) && is_array($_POST) && count($_POST)) {
		$data['specialization'] = (array) @$_POST['specialization_arr'];
		$data['preferred_medium'] = (array) @$_POST['preferred_medium_arr'];
	} 
	if(!empty($_POST)){
		$searching = array($_POST);
		$this->session->set_userdata('searching',$searching);
		$this->form_validation->set_rules('profile_type', 'Profile Type', 'required|trim');
		//$this->form_validation->set_rules('genre', 'Genre', 'required');
		
		if(isset($_POST) && is_array($_POST) && count($_POST)){
			$myErrors = array();
			
		}
		foreach ($myErrors as $k => $me) {
			$this->form_validation->set_error('custom_' . $k, $me);
		}
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == FALSE  || count($myErrors)){
			$data['form_errors'] = $this->form_validation->error_array();
		}
		else {
		$data['results']=$this->mArtist->searchArtist($_POST);
		if($this->mArtist->searchArtist($_POST))$data['res'] = '1';
		else $data['res'] = '0';
		}
	}
    
	$data['countries'] = $this->mUtil->getCountryList();
	$data['states'] = $this->mUtil->getStateList(2);
	$data['states'][0] = 'select a state';
	  
	$this->load->view('template', $data); 
  }
  
  
 public function book_artist($artist=0) {
	$data = array();
	if($artist<1) redirect($this->config->item('base_url'));
	if($this->session->userdata('email')!='') {
			$data = array(
				'title' => 'Create Profile Step 1',
				'main_content' => 'pages/book_artist'
			);
			$q=$this->db->get_where('artist',array('id'=>$artist));
			$res=$q->result_array();
			$data['artist']=$res[0];
		
	}
	else redirect($this->config->item('base_url'));
    $this->load->view('template', $data); 
  }
  
  
  public function tips() {
	$article = $this->mArticle->get(194218);
	
	$data = array(
        'main_content' => 'pages/general'
    );
	$data = array_merge($data, (array) $article);
    $this->load->view('template', $data); 
  }
  
  public function advertise() {
	$article = $this->mArticle->get(194217);
	
	$data = array(
        'main_content' => 'pages/advertise'
    );
	$data = array_merge($data, (array) $article);
    $this->load->view('template', $data); 
  }
  
  public function privacy($ajax = false) {
	$article = $this->mArticle->get(194198);
	
	if ($ajax) {
		echo "<div>" . $article->content . "</div>";
		die;	
	}
	  
	$data = array(
        'main_content' => 'pages/general'
    );
	$data = array_merge($data, (array) $article);
    $this->load->view('template', $data);
  }
  
  public function user_agreement($ajax = false) {
	$article = $this->mArticle->get(194209);
	
	if ($ajax) {
		echo "<div>" . $article->content . "</div>";
		die;	
	}
	  
	$data = array(
        'main_content' => 'pages/general'
    );
	$data = array_merge($data, (array) $article);
    $this->load->view('template', $data);
  }
  
  public function faq() {
   $this->session->set_userdata('is_loged', true);
	$this->db->where('active', 1);
	$q = $this->db->get('faq');
	$faqs = $q->result();
	
	$data = array(
		'title' => 'FAQ',
        'main_content' => 'pages/faq',
		'faqs' => $faqs
    );
    $this->load->view('template', $data); 
  }

}