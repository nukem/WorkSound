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
		
		$message = $this->load->view('emails/contact', $data, TRUE);
		
		send_email('info@soundbooka.com', 'Soundbooka - Contact Us', $message);
		
		$message = $this->load->view('emails/contact-thank-you', $data, TRUE);
		
		send_email(set_value('email'), 'Soundbooka - Contact Us', $message);
	
        $this->session->set_flashdata('message', 'Your message was sent.');
        redirect('/contact');
    }
	
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
	
	$data = array(
        'main_content' => 'pages/general'
    );
	$data = array_merge($data, (array) $article);
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