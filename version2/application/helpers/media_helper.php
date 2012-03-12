<?
function video_player($url) {
	$html = '';
	if (strpos($url, 'youtube.com') !== false) {
		$matches = array();	
		preg_match('/v=(.{11})/', $url, $matches);
		$video_id = $matches[1];
		$html = '<iframe title="YouTube video player" class="youtube-player" type="text/html" width="466" height="263" src="http://www.youtube.com/embed/'.$video_id.'?autoplay=1" frameborder="0" allowFullScreen></iframe>';

	} elseif (strpos($url, 'vimeo.com') !== false) {
		$matches = array();	
		preg_match('/vimeo\.com\/([0-9]{1,10})/', $url, $matches);
		$video_id = $matches[1];
		$html = '<iframe src="http://player.vimeo.com/video/'.$video_id.'?title=0&amp;byline=0&amp;portrait=0" width="466" height="263" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
	} else {
		
		
		$html = '<a href="' . $url . '" style="display:block;width:466px;height:263px" id="player"></a> 
                 <script> //flowplayer("player", "<?=base_url()?>js/flowplayer-3.2.7.swf");</script>';
	}
	
	return $html;
}


function audio_player($url,$auto = 0) {
	
	$html = '';
	if($auto == 0){
	$auto_play = 'auto_play=false';
	}
	else{
	$auto_play = 'auto_play=true';
	}
	if (strpos($url, 'soundcloud.com') !== false) {
		$track = resolve_sc_track($url);
		$html = '<object height="81" width="413"> <param name="movie" value="https://player.soundcloud.com/player.swf?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F'.$track['id'].'&amp;show_comments=true&amp;auto_play=false&amp;color=ff7700"></param> <param name="allowscriptaccess" value="always"></param> <embed allowscriptaccess="always" height="81" src="https://player.soundcloud.com/player.swf?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F'.$track['id'].'&amp;show_comments=true&amp;'.$auto_play.'&amp;color=ff7700" type="application/x-shockwave-flash" width="413"></embed> </object>';
	} else {
		
	}
	
	return $html;
}

ini_set("user_agent", "SCPHP"); 
function resolve_sc_track($url){ 
	return json_decode(file_get_contents("http://api.soundcloud.com/resolve?client_id=332e9866d1ac9351309f0d21248c415f&format=json&url=".$url), true); 
} 