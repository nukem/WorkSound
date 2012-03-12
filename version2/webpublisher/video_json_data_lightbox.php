<?php

$videourl = $_GET['videourl'];


	$video_url = $videourl;

	if(isset($video_url)) {
		$html_file = trim($video_url);

		$html = file_get_contents($video_url);

		/*
		 * The following is for PropVid videos
		$re = "@<div style=\"[a-z:;]+?\">[^<]*<table>[^<]*<tr><th[^>]*>([^<]|<[^/]|</[^t]|</t[^a])+</tr>[^<]*</table>[^<]*</div>@is";
		$pr = preg_match_all($re, $html, $matches);

		$json['agents'] = '<div id="bottom_right_box">';
		$json['agents'] .= $matches[0][0] . $matches[0][1];
		$json['agents'] .= '</div>';


		$json['agents'] = str_ireplace('<td class="agent_row_desc">&nbsp;</td>', '', $json['agents']);
		$json['agents'] = str_ireplace('<td class="agent_row_desc"> </td>', '', $json['agents']);




		$img_re = "@src='(../files/headshots/[a-z_0-9-]+?.jpg)'@";
		$pr = preg_match($img_re, $html, $img);
		$json['agent_photo'] = 'http://tsr2.propvid.tv/tsr3/pv/' . $img[1];
		# Scrape the page for agent details.
		//$json['agents'] = $dom->saveXML($dom->getElementById('bottom_right_box'));

		preg_match('/sc=([a-z0-9]+)/', $video_url, $matches);
		
		if(is_array($matches) && count($matches) > 0) {
			$json['scode'] = $matches[1];
		}
		 */
		

		 /*
		  * Lightbox Property Videos
		  * This method is more effective, as it doesn't rely on Regex to scrape the page.
		  * It relies on PHP_Tidy.
		  */

		$re = '/s1\.addVariable\("file",\s?"([^"]+)"\);/';
		$pr = preg_match($re, $html, $matches);

		foreach($matches as $s) {
			$json['swfobject'] = $s;
		}

		#$www = 'http://lightboxfilms.com.au/website/RayWhiteDrummoyne/index.php?am9iaWQ9OTE2';
		#$html = file_get_contents($www);

		/*
		 * This would have been nice, but we don't have access to PHP_Tidy
		$tidy = tidy_parse_string($html);
		$tidy->cleanRepair();

		$pattern = '/id="[a-zA-Z]+?"/';

		$tidy = preg_replace($pattern, '', $tidy);

		$dom = new DOMDocument();
		$dom->loadHTML($tidy);

		$scripts = $dom->getElementsByTagName('script');

		$count  = $scripts->length;

		for ($i = 0; $i < $count; $i++) {
			if(stripos($scripts->item($i)->nodeValue, 'swfobject') !== false) {
				$json['swfobject ']= implode("\n", array_map('trim', explode("\n", $scripts->item($i)->nodeValue)));
				//$swfobject = trim($scripts->item($i)->nodeValue);
				$json['swfobject'] = str_replace('../', 'http://lightboxfilms.com.au/website/', $json['swfobject']);
			}
		}
		 */

		echo json_encode($json);
	}

?>
