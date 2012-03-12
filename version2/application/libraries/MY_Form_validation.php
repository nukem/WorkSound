<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/**
 * Soundbooka
 * 
 * @author     Chathura Payagala <chathupayagala@gmail.com>
 */
class MY_Form_validation extends CI_Form_validation {

  function __construct() {
    parent::__construct();
  }

  /**
   * Unique
   *
   * @access  public
   * @param  string
   * @param  field
   * @return  bool
   */
  function unique($str, $field) {
    $CI = & get_instance();
    list($table, $column, $id) = explode('.', $field, 3);

    $CI->form_validation->set_message('unique', '%s already exists.');

    $query = $CI->db->query("SELECT COUNT(*) AS dupe FROM $table WHERE $column = '$str' AND id <> $id");
    $row = $query->row();
    return ($row->dupe > 0) ? FALSE : TRUE;
  }

  function error_array() {
    if (count($this->_error_array) === 0) {
      return FALSE;
    } else {
      $err_list = '';
      foreach ($this->_error_array as $e) {
        $err_list .= "<li>$e</li>";
      }
      return $err_list;
    }
  }

  function set_error($id, $error='') {
    if (empty($error)) {
      return FALSE;
    } else {
      $CI = & get_instance();

      $CI->form_validation->_error_array[$id] = $error;

      return TRUE;
    }
  }

}

?>
