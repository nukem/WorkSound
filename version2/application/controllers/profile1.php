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
	$this->load->helper('text');
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
	//print_r($data);die;
	if (!empty ($data['trailer'])) {
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $data['trailer'][0]['Url'], $matches);
        if (count($matches)) {
          $data['trailer'][0]['thumb'] = "http://img.youtube.com/vi/{$matches[0]}/0.jpg";
        } else {
          $data['trailer'][0]['thumb'] = "";
        }
      }
	  // echo '<pre style="display:none;">';print_r($data);echo '</pre>'; 
    $this->load->view('template', $data);
  }

}