<?php

/**
 * Soundbooka
 * 
 * @author     Chathura Payagala <chathupayagala@gmail.com>
 */
class mArticle extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get($id) {
    $article = new stdClass();

	$this->db->select('wp_structure.id,wp_structure.title,wp_article.recId,wp_article.content');
	$this->db->join('wp_article', 'wp_article.link = wp_structure.id');
    $this->db->where('wp_structure.id', $id);
    $q = $this->db->get('wp_structure');
    if ($q->num_rows() > 0):
      $article = $q->row();
      return $article;
    else :
      return $article;
    endif;
  }
  
  function getEmailTemplate($id) {
    $article = new stdClass();

	$this->db->select('wp_structure.id,wp_structure.title,wp_email_template.recId,wp_email_template.content,wp_email_template.subject,wp_email_template.email_from,wp_email_template.cc,wp_email_template.bcc,');
	$this->db->join('wp_email_template', 'wp_email_template.link = wp_structure.id');
    $this->db->where('wp_structure.id', $id);
    $q = $this->db->get('wp_structure');
    if ($q->num_rows() > 0):
      $email_template = $q->row();
      return $email_template;
    else :
      return $email_template;
    endif;
  }

}