<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class Cron extends MY_Controller {

	function Cron() {
		parent::__construct();
		$this->load->model('mUser');
		$this->load->model('mArtist');
		$this->load->model('mUtil');
	}

	public function index() {
		die('-1');
	}
	function booka_gig(){
		$sql="SELECT * FROM artist_gig_map agm, manage_gigs mg WHERE agm.gig_id=mg.gig_id ORDER BY mg.booka_id ASC";
		$q=$this->db->query($sql);
		$r=$q->result_array();
		echo '<pre>';
		print_r($r);
	}  
	
	// 1.23.12; wiseobject <- 
	function _freqOfEmail( $freq ) {
		$n = $freq;
		if ( $freq == "hourly" )
			$n = 1;
		else if ( $freq == "daily" )
			$n = 24;
		return $n;		
	}

	// 1.23.12; wiseobject <- 
	function _gigsOffered( $id ) {
		$sql = "SELECT a.gig_name,a.start_date,a.end_date,ar.id,ar.user_id
				FROM artist_gig_map agm
					INNER JOIN manage_gigs a ON a.gig_id = agm.gig_id
					INNER JOIN artist ar ON agm.artist_id = ar.id
				WHERE ar.id = {$id} AND agm.offer_status = 'Offer'
				AND DATE_FORMAT(a.start_date ,'%Y-%m-%d') >= CURDATE()
				ORDER BY a.start_date,a.gig_name";
		$rs = $this->db->query($sql);	
		$s = "";
		foreach ( $rs->result_array() as $row ) {
			if ( $s == "" )
				$s = "OFFERED GIGS\n-----------------\n";
			$s .= "Gig Name: ".$row['gig_name']."\n";
			$s .= "Start Date: ".date("m/d/Y",$row["start_date"])."\n";
			$s .= "End Date: ".date("m/d/Y",$row["end_date"])."\n";
		}
		return $s;
	}
	
	// 1.23.12; wiseobject <- 
	function _gigsResponded( $id, $response_status ) {
		$sql = "SELECT a.gig_name,a.start_date,a.end_date,ar.id,ar.user_id
				FROM artist_gig_map agm
					INNER JOIN manage_gigs a ON a.gig_id = agm.gig_id
					INNER JOIN artist ar ON agm.artist_id = ar.id
				WHERE ar.id = {$id} AND agm.offer_status != 'Delete' 
				AND agm.respond = 1 AND agm.respond_status IS NOT NULL AND agm.respond_status = '{$response_status}'
				AND DATE_FORMAT(a.start_date ,'%Y-%m-%d') >= CURDATE()
				ORDER BY a.start_date";
		$row_ary = $this->db->query($sql);	
		$rs = $this->db->query($sql);	
		$s = "";
		foreach ( $rs->result_array() as $row ) {
			if ( $s == "" )
				$s = strtoupper($response_status)." GIGS\n-----------------\n";
			$s .= "Gig Name: ".$row['gig_name']."\n";
			$s .= "Start Date: ".date("m/d/Y",$row["start_date"])."\n";
			$s .= "End Date: ".date("m/d/Y",$row["end_date"])."\n";
		}
		return $s;
	}	
	
	// 1.23.12; wiseobject <- 
	function _sendEmails( $freq ) {
		$k = 0;
		$n = $this->_freqOfEmail($freq);
		$sql = "SELECT first_name,email,a.id,a.user_id
				 FROM `artist` a
					INNER JOIN `user` u ON u.id = a.user_id
				 WHERE a.status in ('approved','test')
					AND a.freq_of_email IS NOT NULL
					AND a.freq_of_email = '{$freq}'
					AND (a.last_cron IS NULL OR HOUR(TIMEDIFF(NOW(),a.last_cron)) > {$n})";
		$rs = $this->db->query($sql);	
		foreach ( $rs->result_array() as $user ) {
			$id = $user["id"];
			$body = "";
			$s = $this->_gigsOffered($id);
			if ( $s != "" )
				$body .= $s."\r\n\r\n";
			$s = $this->_gigsResponded($id,'Accepted');	
			if ( $s != "" )
				$body .= $s."\r\n\r\n";
			$s = $this->_gigsResponded($id,'Rejected');	
			if ( $s != "" )
				$body .= $s."\r\n\r\n";
			if ( $s != "" )	{
				mail
				(
					$user["email"],
					"Your SoundBooka updates - ".date("F j, Y, g:i a"),
					$body,
					"From: noreply@soundbooka.com.au\r\n"
				);
				$k++;
			}
			// mark			
			$this->db->query("UPDATE `artist` SET last_cron = NOW() WHERE id = {$id}");
		}
		return $k;
	}
	
	// 1.23.12; wiseobject <- 
	function sendGigNotifications(){
		echo("SENT ARTIST MAILS");
		echo("<br />HOURLY => ".$this->_sendEmails('hourly'));
		echo("<br />EVERY 2 HOURS => ".$this->_sendEmails('2'));
		echo("<br />EVERY 4 HOURS => ".$this->_sendEmails('4'));
		echo("<br />EVERY 6 HOURS => ".$this->_sendEmails('6'));
		echo("<br />EVERY 12 HOURS => ".$this->_sendEmails('12'));
		echo("<br />DAILY => ".$this->_sendEmails('daily'));
		die("");
	}  
	
	// 1.27.12; wiseobject <- 
	function sendBookaGigNotifications() {
		echo("SENT BOOKA MAILS");
		echo("<br />HOURLY => ".$this->_sendEmails('hourly'));
		echo("<br />EVERY 2 HOURS => ".$this->_sendEmails('2'));
		echo("<br />EVERY 4 HOURS => ".$this->_sendEmails('4'));
		echo("<br />EVERY 6 HOURS => ".$this->_sendEmails('6'));
		echo("<br />EVERY 12 HOURS => ".$this->_sendEmails('12'));
		echo("<br />DAILY => ".$this->_sendEmails('daily'));
		die("");
	}  
}