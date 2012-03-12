<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/**
 * Soundbooka
 * 
 * @author     Chathura Payagala <chathupayagala@gmail.com>
 */
class Errors extends CI_Controller {

  public function page_not_found() {
    $data = array(
        'title' => '404 - Page not found',
        'main_content' => '404'
    );
    $this->load->view('template', $data);
  }

}