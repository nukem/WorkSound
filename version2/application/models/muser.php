<?php

/**
 * Soundbooka
 * 
 * @author     Chathura Payagala <chathupayagala@gmail.com>
 */
class mUser extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function save($form_data) {
    $newId = 0;

    if ($form_data['id'] == 0) {
      $form_data['created'] = date('Y-m-d H:i:s');
      $this->db->insert('user', $form_data);
      $newId = $this->db->insert_id();
    } else {
      $form_data['modified'] = date('Y-m-d H:i:s');
      $this->db->where('id', $form_data['id']);
      $this->db->update('user', $form_data);
      $newId = $form_data['id'];
    }

    return $newId;
  }

  function get($id) {
    $user = new stdClass();

    $this->db->where('id', $id);
    $q = $this->db->get('user');
    if ($q->num_rows() > 0):
      $user = $q->row();
      return $user;
    else :
      return $user;
    endif;
  }

}