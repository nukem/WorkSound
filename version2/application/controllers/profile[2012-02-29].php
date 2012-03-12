<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/**
 * Soundbooka
 * 
 * @author     Chathura Payagala <chathupayagala@gmail.com>
 */
class Profile extends MY_Controller {

  function Profile() {
    parent::__construct();
    $this->load->model('mUser');
    $this->load->model('mArtist');
	$this->load->model('mArticle');
	
  }

  public function view($id) {
	$this->chk_login();
	$this->load->helper('text');
	$id=str_replace('_',' ',$id);
	$this->db->where('profile_name', $id);
    $q = $this->db->get('artist');
	$user = $q->row();
	
	if($q->num_rows() > 0){
	$id = $user->id;
	}
	else{
	$id = '0';
	}
	
	if (!$id) {
		redirect('/');
	}
    $data = array(
        'title' => 'Profile',
        'main_content' => 'profile/view'
    );
	$data = array_merge($data, (array) $this->mArtist->get($id));
	if (empty($data['id'])) {
	  $this->session->set_flashdata('error', 'Profile does not exist - please try again.');
	  redirect('/');
	}
	$data['types'] = $this->mUtil->getProfileTypeList();
	$data['states'] = $this->mUtil->getStates();
    $data['genders'] = $this->mUtil->getCodes('gender');
	$data['genres'] = $this->mUtil->getGenres();
	$data['gigs'] = $this->mUtil->getCodes('gigs');
	$data['specializations'] = $this->mUtil->getCodes('Specialization'); 
	$data['mediums'] = $this->mUtil->getCodes('Preferred Medium');
	//print_r($data);die;
	if (!empty ($data['trailer'])) {
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=savetubevideo.com/?v=)[^&\n]+#", $data['trailer'][0]['Url'], $matches);
        if (count($matches)) {
          $data['trailer'][0]['thumb'] = "http://img.youtube.com/vi/{$matches[0]}/0.jpg";
        } else {
          $data['trailer'][0]['thumb'] = "";
        }
      }
	 $this->db->query("UPDATE artist SET views=views+1 WHERE id='{$id}'");
	  // echo '<pre style="display:none;">';print_r($data);echo '</pre>'; 
    $this->load->view('template', $data);
  }
  public function view1($profile_name) {
	$this->load->helper('text');
	$profile_name =  str_replace('%20','',$profile_name);
	if (!$profile_name) {
		redirect('/');
	}
	
	
    $data = array(
        'title' => 'Profile',
        'main_content' => 'profile/view'
    );
	$data = array_merge($data, (array) $this->mArtist->getByName($profile_name));
	if (empty($data['id'])) {
	  $this->session->set_flashdata('error', 'Profile does not exist - please try again.');
	  redirect('/');
	}
	$id = $data['id'];
	$data['types'] = $this->mUtil->getProfileTypeList();
	$data['states'] = $this->mUtil->getStates();
    $data['genders'] = $this->mUtil->getCodes('gender');
	$data['genres'] = $this->mUtil->getGenres();
	$data['gigs'] = $this->mUtil->getCodes('gigs');
	$data['specializations'] = $this->mUtil->getCodes('Specialization'); 
	$data['mediums'] = $this->mUtil->getCodes('Preferred Medium');
	//print_r($data);die;
	if (!empty ($data['trailer'])) {
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=savetubevideo.com/?v=)[^&\n]+#", $data['trailer'][0]['Url'], $matches);
        if (count($matches)) {
          $data['trailer'][0]['thumb'] = "http://img.youtube.com/vi/{$matches[0]}/0.jpg";
        } else {
          $data['trailer'][0]['thumb'] = "";
        }
      }
	 
	  // echo '<pre style="display:none;">';print_r($data);echo '</pre>'; 
    $this->load->view('template', $data);
  }
  public function plot($id){
		$this->load->helper('text');
	if (!$id) {
		redirect('/');
	}
    $data = array(
        'title' => 'Profile',
        'main_content' => 'profile/plots'
    );
	$data = array_merge($data, (array) $this->mArtist->get($id));
	$this->load->view('template', $data);
  }
  
  public function chk_login(){
	if($this->session->userdata('is_loged')==1) {
		return;
	}
	else {
		$this->session->set_flashdata('error', 'Please Login.');
		redirect($this->config->item('base_url').'artist');
	}	  
  }
}