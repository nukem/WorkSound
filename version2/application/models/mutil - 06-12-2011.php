<?php

/**
 * Soundbooka
 * 
 * @author     Chathura Payagala <chathupayagala@gmail.com>
 */
class mUtil extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function getCountryList() {
    $ret = array('' => '-- please select --');
    $this->db->where('active', 1);
    $q = $this->db->get('country');
    foreach ($q->result_array() as $r) {
      $ret[$r['country_id']] = $r['country_name'];
    }
    return $ret;
  }

  function getStateList($country_id=0) { 
    $ret = array();
    if (empty($country_id))
      return $ret = array('' => '-- select a country first --');
    $this->db->where('active', 1);
    $this->db->where('country_id', $country_id);
    $q = $this->db->get('state');
    foreach ($q->result_array() as $r) {
      $ret[$r['state_id']] = $r['state'];
    }
    return $ret;
  }
  
  function getStates() { 
    $ret = array();
    $this->db->where('active', 1);
    $q = $this->db->get('state');
    foreach ($q->result_array() as $r) {
      $ret[$r['state_id']] = $r['state'];
    }
    return $ret;
  }
  
  function getGenres() { 
    $ret = array();
    $q = $this->db->get('genre');
    foreach ($q->result_array() as $r) {
      $ret[$r['genre_id']] = $r['genre'];
    }
    return $ret;
  }

  function getCodes($type) {
	//echo $type;
    $this->db->where('basgroup1', $type);
    $this->db->where('active', 1);
	if ($type == 'Gigs') {
		$this->db->order_by('bascode1');
	} else {
    	$this->db->order_by('bascode1');
	}
    $q = $this->db->get('xbasetypes');
    foreach ($q->result_array() as $r) {
      $ret[$r['baseid']] = $r['bascode1'];
    }
    return $ret;
  }
  
  function getInstrumentCategoryList() {
    $ret = array('' => '-- please select a category --');
    $this->db->where('active', 1);
	$this->db->order_by('order,instrument_category ASC');
    $q = $this->db->get('instrument_category');
    foreach ($q->result_array() as $r) {
      $ret[$r['instrument_category_id']] = $r['instrument_category'];
    }
    return $ret;
  }

  function getInstrumentList($cat_id=0) { 
    $ret = array();
    if (empty($cat_id))
      return $ret = array('' => '-- select a category first --');
    //$this->db->where('active', 1);
	$this->db->order_by('instrument ASC');
    $this->db->where('instrument_category', $cat_id);
    $q = $this->db->get('instrument');
    foreach ($q->result_array() as $r) {
      $ret[$r['instrument_id']] = $r['instrument'];
    }
    return $ret;
  }
  
  function getProfileTypeList() {
    $ret = array('' => '-- please select a profile type --');
    $this->db->where('active', 1);
	$this->db->order_by('order ASC');
    $q = $this->db->get('artist_type');
    foreach ($q->result_array() as $r) {
      $ret[$r['artist_id']] = $r['type'];
    }
    return $ret;
  }

}
