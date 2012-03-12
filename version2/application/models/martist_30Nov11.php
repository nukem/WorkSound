<?php

/**
 * Soundbooka
 * 
 * @author     Chathura Payagala <chathupayagala@gmail.com>
 */
class mArtist extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function save($form_data) {
    $newId = 0;
    if ($form_data['id'] == 0) {
      $form_data['created'] = date('Y-m-d H:i:s');
      $this->db->insert('artist', $form_data);
      $newId = $this->db->insert_id();
    } 
	else {
      $form_data['modified'] = date('Y-m-d H:i:s');
      $this->db->where('id', $form_data['id']);
      $this->db->update('artist', $form_data);
      $newId = $form_data['id'];
    }

    return $newId;
  }

  function get($id) {
    $user = new stdClass();

    $this->db->where('id', $id);
    $q = $this->db->get('artist');
    if ($q->num_rows() > 0):
      $user = $q->row();
	  $user->artist_instruments = $this->getArtistInstruments($user->id);
	  $user->images = $this->getArtistImages($user->id);
	  $user->artist_media->audio = $this->getArtistMedia($user->id,'audio');
	  $user->artist_media->video = $this->getArtistMedia($user->id,'video');
	  $user->artist_availability = $this->getAvailability($user->id);
	  $user->artist_gigs = $this->getGigs($user->id);
	  $user->artist_availability_array = $this->getAvailabilityArray($user->artist_availability);
	  $user->artist_gigs_array = $this->getGigsArray($user->artist_gigs);
      return $user;
    else :
      return $user;
    endif;
  }
  
  function getArtistInstruments($id) {
	  $this->db->select('artist_Instruments.*, instrument.instrument as title,instrument.instrument_category as category_id');
	  $this->db->join('instrument', 'instrument.instrument_id = artist_Instruments.instrument_id');
	  $this->db->where('artist_id', $id);
	  $res = $this->db->get('artist_Instruments');
	  return $res->result();
  }
  
  function getArtistImages($id) {
	  $this->db->where('parent', $id);
	  $this->db->order_by('position');
	  $res = $this->db->get('wp_image_gallery');
	  return $res->result();
  }
  
  function getArtistMedia($id, $type = null) {
	  $this->db->where('artist_id', $id);
	  if ($type) {
		$this->db->where('type', $type);  
	  }
	  $res = $this->db->get('artist_media');
	  return $res->result();
  }
  
  function saveMedia($data) {
	  	$newId = $data['am_id'];
	    $ins['artist_id'] = $data['artist_id'];
		$ins['url'] = $data['url'];
		$ins['type'] = $data['type'];
		$ins['title'] = $data['title'];
		$ins['date_recorded'] = $data['date_recorded'];
		$ins['description'] = $data['description'];
		if ($data['am_id']) {
			$this->db->where('id', $data['am_id']);
			$this->db->update('artist_media', $ins);
		} else {
			$this->db->insert('artist_media', $ins);
			$newId = $this->db->insert_id();
		}
		return $newId;
  }
  
  function saveInstrument($data) {
	  	$newId = $data['ai_id'];
	    $ins['artist_id'] = $data['artist_id'];
		$ins['instrument_id'] = $data['instrument_id'];
		$ins['comment'] = $data['comment'];
		if ($data['ai_id']) {
			$this->db->where('id', $data['ai_id']);
			$this->db->update('artist_Instruments', $ins);
		} else {
			$this->db->insert('artist_Instruments', $ins);
			$newId = $this->db->insert_id();
		}
		return $newId;
  }
  
  function getAvailability($id) {
	  $this->db->where('artist_id', $id);
	  $q = $this->db->get('artist_availability');
	  return $q->result();
  }
  
  function getGigs($id) {
	  $this->db->where('artist_id', $id);
	  $q = $this->db->get('artist_gig');
	  return $q->result();
  }
  
  function saveGigs($id,$data) {
	$this->db->where('artist_id', $id);
	$this->db->delete('artist_gig');
	$data = (array) $data;
	foreach ($data as $d) {
		$ins = array();
		$ins['artist_id'] = $id;
		$ins['gig_id'] = $d;
		$this->db->insert('artist_gig', $ins);		
	}
  }
  
  function saveAvailability($id,$data) {
	$this->db->where('artist_id', $id);
	$this->db->delete('artist_availability');
	$data = (array) $data;
	foreach ($data as $d) {
		$d = explode('_', $d);
		$ins = array();
		$ins['artist_id'] = $id;
		$ins['day'] = $d[0];
		$ins['time'] = $d[1];
		$this->db->insert('artist_availability', $ins);		
	}
  }
  
  function getAvailabilityArray($data) {
	  $ret = array();
	  foreach ($data as $d) {
		  $ret[] = $d->day . '_' . $d->time;
	  }
	  return $ret;
  }
  
  function getGigsArray($data) {
	  $ret = array();
	  foreach ($data as $d) {
		  $ret[] = $d->gig_id;
	  }
	  return $ret;
  }

}