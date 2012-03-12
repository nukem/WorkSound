<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/**
 * Soundbooka
 * 
 * @author     Chathura Payagala <chathupayagala@gmail.com>
 */
class Ajax extends MY_Controller {

  function Ajax() {
    parent::__construct();
    $this->load->model('mUser');
    $this->load->model('mArtist');
    $this->load->model('mUtil');
  }

  public function index() {
    die('-1');
  }

  public function getStateOptions($country_id) {
    $states = $this->mUtil->getStateList($country_id);
    $options = array('' => '<option value="">-- please select --</option>');
    foreach ($states as $k => $s) {
      $options[] = "<option value='{$k}'>{$s}</option>";
    }
    echo implode("\n", $options);
    die;
  }
  
  public function getInstrumentOptions($cat_id) {
    $states = $this->mUtil->getInstrumentList($cat_id);
    $options = array('' => '<option value="">-- please select --</option>');
    foreach ($states as $k => $s) {
      $options[] = "<option value='{$k}'>{$s}</option>";
    }
    echo implode("\n", $options);
    die;
  }
	
	
	public function saveInstrument() {
		$ret = $this->mArtist->saveInstrument($_POST);
		echo $ret;
		die;
	}
	
	public function removeInstrument() {
		$this->db->where('id',$_POST['ai_id']);
		$this->db->delete('artist_Instruments');
		die;
	}
	
	public function setProfilePic() {
		$this->db->where('parent',$_POST['artist_id']);
		$this->db->set('position',10);
		$this->db->update('wp_image_gallery');
		
		$this->db->where('id',$_POST['id']);
		$this->db->set('position',0);
		$this->db->update('wp_image_gallery');
		die;
	}
	
	public function removeProfilePic() {
		unlink(realpath('wpdata/images/'.$_POST['id'].'.jpg'));
		unlink(realpath('wpdata/images/'.$_POST['id'].'_*.jpg'));
		$this->db->where('id',$_POST['id']);
		$this->db->delete('wp_image_gallery');
		die;
	}
	
	public function saveMedia() {
		$d = explode("/",$_POST['date_recorded']);
		$_POST['date_recorded'] = $d[2] . "-" . $d[1] . "-" . $d[0];
		$ret = $this->mArtist->saveMedia($_POST);
		echo $ret;
		die;
	}
	
	
	public function removeMedia() {
		$this->db->where('id',$_POST['am_id']);
		$this->db->delete('artist_media');
		die;
	}
	
	public function removePlot() {
		$this->db->where('id',$_POST['plot_id']);
		$this->db->delete('plots');
		die;
	}
	
	public function getVideo() {
		$url = urldecode($_POST['url']);
		echo video_player($url);
		die;
	}
	/*public function getAudio() {
		$url = urldecode($_REQUEST['url']);
		echo audio_player($url);
		die;
	}*/
	public function getAudio() {
	  $url = urldecode($_POST['url']);
	  //echo $url;
	  $test = explode('/',$url);
	  if($test['2'] == 'soundbooka.com'){
	   echo '<div id="audioplayer_1" style="margin-left:150px;"><img src="<?=base_url()?>images/ajax-loader.gif" /></div>
	  <script type="text/javascript">  
	  AudioPlayer.embed("audioplayer_1", {soundFile: "'.$url.'",autostart: "yes"}); 
	  </script>';  
	  }
	  else{
	  echo audio_player($url,1);
	  }
	 }
	
	public function savePlot() {
		$artist_id=$_POST['artist_id'];
		$plot=$_POST['plot'];
		$this->db->insert('plots',array('artist_id'=>$artist_id, 'plot'=>$plot));
		die(1);
	 }
	
	function gigs($id=0){
		if($id==0) return;
		$data['artist_id']=$id;
		$q=$this->db->query("SELECT * FROM manage_gigs WHERE status!='deactive'");
		$data['gigs']=$q->result_array();
		$q=$this->db->query("SELECT * FROM artist_gig_map WHERE artist_id={$id}");
		$a=$q->result_array();
		$id=array();
		if(count($a)>0) { foreach($a as $v) $id[]=$v['gig_id']; }
		$data['artists']=$id;
		
		#echo '<pre style="display:none;">';print_r($data['artists']);echo '</pre>';
		
		
		$this->load->view('booka/offer_gig',$data);
	}
	function offer_update(){
		if(!isset($_POST)) return;
		if(!empty($_POST['gig_id'])) $gig_id=$_POST['gig_id'];
		if(!empty($_POST['artist_id'])) $artist_id=$_POST['artist_id'];
		$position=$_POST['order'];
		if(empty($artist_id) || empty($gig_id)) return;
		
		$q=$this->db->get_where('artist_gig_map',array('gig_id'=>$gig_id,'artist_id'=>$artist_id, 'position'=>$position));
		if($q->num_rows>0) return;
		
		$q=$this->db->get_where('manage_gigs',array('gig_id'=>$gig_id));
		if($q->num_rows>0){
			$r=$q->result_array();
			$gigs=$r[0];
			$update['gig_id']=$gig_id;
			$update['artist_id']=$artist_id;
			$update['offered_date']=date('Y-m-d');
			$update['booka_id']=$gigs['booka_id'];
			$this->db->insert('artist_gig_map', $update);
			echo 1;
		}
		
	}
	public function update_gig_position() {
		$order=explode(',',$_POST['order']);
		foreach($order as $k=>$v) {
			$this->db->update('artist_gig_map',array('position'=>$k),array('id'=>$v));
		}
		
	}
	
	public function update_gig_status() {
		if($_POST['offer_status']=='Activate') $offer_status = 'Draft';
		else $offer_status = $_POST['offer_status'];
		$this->db->update('artist_gig_map',array('offer_status'=>$offer_status),array('id'=>$_POST['id']));
		$sql = "SELECT * FROM artist_gig_map WHERE id = {$_POST['id']}";
		$q = $this->db->query($sql);
		$data['artist_details'] = $q->result_array();
		$histroy_data['artist_id'] = $data['artist_details'][0]['artist_id'];
		$histroy_data['booka_id'] = $data['artist_details'][0]['booka_id'];
		$gig_data['gig'] = $data['artist_details'][0]['gig_id'];
		$histroy_data['histroy_status'] = $offer_status;
		$histroy_data['histroy_created'] = date('Y-m-d H:i:s');
		$histroy_data['gig_id'] = $_POST['id'];
		
		if($offer_status=='Offer' || $offer_status=='Confirm'){
		
			$this->db->insert('notifications',array('status'=>$offer_status,'artist_id'=>$histroy_data['artist_id'],'booka_id'=>$histroy_data['booka_id'],'gig_id'=>$gig_data['gig'],'created'=>date('Y-m-d H:i:s')));
               //sending SMS to the artist        
              $si = new SmsInterface (false, false);               
                if($offer_status=='Offer'){
                    $si->addMessage ('0499 477 021','Hi,Congratulations, you have a gig offered to you.Please go to Soundbooka and login to view and accept your offer. You can use the chat function if you need to clarify or negotiate.');
                }elseif($offer_status=='Confirm') {
                    $si->addMessage ('0499 477 021','Hi,Congratulations, you have a gig confirmed to you.Please go to Soundbooka and login to view and accept your offer. You can use the chat function if you need to clarify or negotiate.');                
                }
                if (!$si->connect ('Test261', 'm8D8qqrx', true, false)){
                    $message = 0;
                }elseif (!$si->sendMessages ()) {
                    $message=0;
                }
                if ($si->getResponseMessage () !== NULL){
                    $message =0;
                    
                } else{
                    $message =1;
                }   
		
		}
		if($offer_status=='Offer'){
			$this->load->model('mArticle');
			$this->load->library('email');
			$email = $this->mArticle->getEmailTemplate(194324);
			
			$email_from_address=$email->email_from.'@soundbooka.com';
			$email_from_name='Soundbooka';
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'iso-8859-1';
			$config['mailtype'] = 'html';
			$config['wordwrap'] = TRUE;
			
			// $html = str_replace('%Create my profile%',$profile_link,$article->content);
			$html=$email->content;
			$this->email->initialize($config);
			$this->email->from($email_from_address, $email_from_name);
			/*$this->email->to('arunmani4u@gmail.com');
			$this->email->to("max.emb@gmail.com");
			$this->email->bcc($email->bcc);
			$this->email->bcc("sarunkumar@enoahisolution.com");*/
			$this->email->subject($email->subject);
			$this->email->message($html);
			$this->email->send();
			send_email('arunmani4u@gmail.com', $email->subject, $html);
		}
		
		
		$this->db->insert('gig_histroy', $histroy_data);
		//redirect('/booka/manage_gig/'.$histroy_data['booka_id']);
	}
	function update_artist_gig_status(){
		if($_POST['respond_status']=='Accept') $respond_status='Accepted';
		else if($_POST['respond_status']=='Reject') $respond_status='Rejected';
		else return;
		$upd['respond_status']=$respond_status;
		$upd['respond_date']=date('Y-m-d');
		$upd['respond']=1;
		$sql = "UPDATE artist_gig_map set respond_status = '".$respond_status."',respond_date = ".date('Y-m-d')." ,respond = 1 where id = ".$_POST['id']."";
		$this->db->query($sql);
		
		//$this->db->update('artist_gig_map',$upd,array('id'=>$_POST['id']));
         //sending SMS to the artist        
            $si = new SmsInterface (false, false);
           if($_POST['respond_status']=='Rejected'){
                   $si->addMessage ('0499 477 021','Hi,sorry, your are rejected by the gig offered.');
           }else if($_POST['respond_status']=='Accept'){
                   $si->addMessage ('0499 477 021','Hi,Congratulations, you have a gig accepted to you.Please go to Soundbooka and login to view and accept your offer. You can use the chat function if you need to clarify or negotiate.');
           }
           if (!$si->connect ('Test261', 'm8D8qqrx', true, false)){
                $message = 0;
            }elseif (!$si->sendMessages ()) {
               $message=0;
            }
            if ($si->getResponseMessage () !== NULL){
                $message =0;
                
            } else{
                $message =1;
            } 
		
		$sql = "SELECT * FROM artist_gig_map WHERE id = {$_POST['id']}";
		$q = $this->db->query($sql);
		
		$data['artist_details'] = $q->result_array();
		
		$histroy_data['artist_id'] = $data['artist_details'][0]['artist_id'];
		$histroy_data['booka_id'] = $data['artist_details'][0]['booka_id'];
		$gig_data['gig'] = $data['artist_details'][0]['gig_id'];
		$histroy_data['histroy_created'] = date('Y-m-d H:i:s');
		$histroy_data['gig_id'] = $_POST['id'];
		
		if($respond_status=='Accepted' || $respond_status=='Rejected'){
		
			$this->db->insert('notifications',array('status'=>$respond_status,'artist_id'=>$histroy_data['artist_id'],'booka_id'=>$histroy_data['booka_id'],'gig_id'=>$gig_data['gig'],'created'=>date('Y-m-d H:i:s')));
		
		}
		$sql_from = "select u.email,a.first_name,a.last_name from artist a JOIN user u ON a.user_id = u.id where a.id = ".$histroy_data['artist_id']." ";
		
		$result_from = $this->db->query($sql_from);
		
		$result_from = $result_from->result_array();
		
		$sql_to = "select u.email from booka b JOIN user u ON b.user_id = u.id where b.id = ".$result[0]['booka_id']." ";
		
		$result_to = $this->db->query($sql_to);
		
		$result_to = $result_to->result_array();
		
		if($respond_status=='Accepted' || $respond_status=='Rejected'){
			$this->load->model('mArticle');
			$this->load->library('email');
			if($respond_status=='Accepted') $email = $this->mArticle->getEmailTemplate(194325);
			else if($respond_status=='Rejected') $email = $this->mArticle->getEmailTemplate(194326);
			else $email = $this->mArticle->getEmailTemplate(194325);
			
			$email_from_address=$email->email_from.'@soundbooka.com';
			$email_from_name='Soundbooka';
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'iso-8859-1';
			$config['mailtype'] = 'html';
			$config['wordwrap'] = TRUE;
			
			$email_from_address = $result_from[0]['email'];
			$email_to_address = $result_to[0]['email'];
		
			$email_from_name = $result_from[0]['first_name'] .' '. $result_from[0]['last_name'];
			// $html = str_replace('%Create my profile%',$profile_link,$article->content);
			$html=$email->content;
			$this->email->initialize($config);
			$this->email->from($email_from_address, $email_from_name);
			/*$this->email->to($email_to_address);
			$this->email->to("max.emb@gmail.com");
			$this->email->bcc($email->bcc);
			$this->email->bcc("sarunkumar@enoahisolution.com");*/
			$this->email->subject($email->subject);
			$this->email->message($html);
			$this->email->send();
			send_email($email_to_address, $email->subject, $html);
		}
		
		
		echo $respond_status;
	
	}
	
	public function update_audio_position() {
		$order=explode(',',$_POST['order']);
		foreach($order as $k => $v) {
			$v = substr($v,3);
			$this->db->update('artist_media',array('position'=>$k),array('id'=>$v));
		}
	}
	function add_favourite(){
		if(!isset($_POST)) return exit(0);
		if(!empty($_POST['booka_id'])) $booka_id=$_POST['booka_id'];
		if(!empty($_POST['artist_id'])) $artist_id=$_POST['artist_id'];
		if(empty($booka_id) && empty($artist_id)) exit(0);
		$q=$this->db->get_where('manage_favourite',array('booka_id'=>$booka_id, 'artist_id'=>$artist_id));
		if($q->num_rows()==0){
			$this->db->insert('manage_favourite',array('booka_id'=>$booka_id, 'artist_id'=>$artist_id, 'status'=>'Active'));	
			echo 1;
		}
		else exit(2);
	}
	function chat(){
		list($booka_id,$artist_id,$artist_name,$gig_id,$gig_name,$sent_by)=explode('|',$_POST['rel']);
		
		$q=$this->db->query("SELECT * FROM chat_history WHERE booka_id='{$booka_id}' && gig_id='{$gig_id}' && artist_id='{$artist_id}' ORDER BY created_date");
		$r=$q->result_array();
		
		$data = array(
		  'title' => 'Gig Artist Chat History'
		);
		$data['chats']=$r;
		$data['booka_id']=$booka_id;
		$data['artist_name']=$artist_name;
		$data['artist_id']=$artist_id;
		$data['gig_id']=$gig_id;
		$data['sent_by']=$sent_by;
		$data['gig_name']=$gig_name;
		
		
		$this->load->view('booka/chat_history', $data);
	}
	function rate(){
		list($booka_id,$artist_id,$artist_name,$gig_id,$gig_name,$sent_by,$payment,$artist_fee) = explode('|',$_POST['rel']);
		
		$q=$this->db->query("SELECT * FROM chat_history WHERE booka_id='{$booka_id}' && gig_id='{$gig_id}' && artist_id='{$artist_id}' ORDER BY created_date");
		$r=$q->result_array();
		
		$data = array(
		  'title' => 'Complete the Performance Status'
		);
		$data['chats']=$r;
		$data['booka_id']=$booka_id;
		$data['artist_name']=$artist_name;
		$data['artist_id']=$artist_id;
		$data['gig_id']=$gig_id;
		$data['sent_by']=$sent_by;
		$data['gig_name']=$gig_name;
		$data['payment_method']=$payment;
		$data['artist_fee']=$artist_fee;
				
		$this->load->view('booka/rate', $data);
	}
	function saveRating(){
		$ins['star_rate']=$_POST['star_rate'];
		$ins['booka_id']=$_POST['booka_id'];
		$ins['artist_id']=$_POST['artist_id'];
		$ins['gig_id']=$_POST['gig_id'];
		//$ins['sent_by']=$_POST['sent_by'];
		$ins['created_date']=date('Y-m-d h:i:s');
		$this->db->insert('rating',$ins);
		
		$q=$this->db->query("update artist_gig_map set rated=1 WHERE id=".$_POST['sent_by']);
			
	}
	
	function update_chat(){
		$ins['booka_id']=$_POST['booka_id'];
		$ins['artist_id']=$_POST['artist_id'];
		$ins['gig_id']=$_POST['gig_id'];
		$ins['message']=$_POST['message'];
		$ins['sent_by']=$_POST['sent_by'];
		$ins['created_date']=date('Y-m-d h:i:s');
		if($ins['message']!='') $this->db->insert('chat_history',$ins);
		echo 1;
	}

}