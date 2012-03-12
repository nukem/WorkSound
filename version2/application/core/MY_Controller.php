<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/**
 * Soundbooka
 * 
 * @author     Chathura Payagala <chathupayagala@gmail.com>
 */
class MY_Controller extends CI_Controller {

  function MY_Controller() {
    parent::__construct();
    $this->load->model('mUtil');
	$this->load->helper('media_helper');
  }

}