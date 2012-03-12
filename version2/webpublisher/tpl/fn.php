<?php
function consise_text($text, $limit = 20, $spaces = false){
	if(!$spaces){
		$text = preg_replace('/\s+/', ' ', $text);
	}
	$pieces = explode(' ', $text);
	$cnt = count($pieces);
	if($cnt > $limit){
		$newtext = '';
		for($i=0; $i<$limit; $i++){
			$newtext .= $pieces[$i] . ' ';
		}
	}else{
		$newtext = $text . ' ';
	}
	return preg_replace('/\.[^\.]*$/', '', $newtext);
}

function in_array_deep($needle, $haystack, $key = false) {
	// thanks vandor at ahimsa dot hu (php.net) for the idea
	foreach($haystack as $k => $v) {
		if( is_array($v) ){
			if(in_array_deep($needle, $v, $key) === true) return true;
		}elseif($needle == $v){
			if(!$key){
				return true;
			}elseif($key == $k){
				return true;
			}
		}
	}
	return false;
}

/* the original set of functons by  J-LOWE */
function dbq ($query) {
	global $message;
	if (ereg ('^SELECT', $query)) {
		$result = mysql_query ($query) or die(mysql_error());	
		while ($row = mysql_fetch_array ($result, MYSQL_ASSOC))
			$return[] = $row;
		if (isset ($return))
			return ($return);
		else
			return (false);
	} elseif (ereg ('^INSERT', $query)) {
		mysql_query ($query) or die(mysql_error());
		return (mysql_insert_id ());
	} else {
		mysql_query ($query) or die(mysql_error());
		return (mysql_affected_rows ());
	}
}

function resize_img ($oldFile, $newFile, $newWidth, $newHeight, $method, $stretch, $jpgQuality, $fillR, $fillG, $fillB) {
	$imageInfo = getimagesize ($oldFile);
	switch ($imageInfo[2]) {
	case 1:
		$oldImage = imagecreatefromgif ($oldFile);
		break;
	case 2:
		$oldImage = imagecreatefromjpeg ($oldFile);
		break;
	case 3:
		$oldImage = imagecreatefrompng ($oldFile);
		break;
	}
	if ($method == 'shrink') {
		if (! $stretch && $imageInfo[0] < $newWidth && $imageInfo[1] < $newHeight) {
			$newImage = imagecreatetruecolor ($imageInfo[0], $imageInfo[1]);
			imagecopyresampled ($newImage, $oldImage, 0, 0, 0, 0, $imageInfo[0], $imageInfo[1], $imageInfo[0], $imageInfo[1]);
		} else {
			if ($imageInfo[0] / $imageInfo[1] >= $newWidth / $newHeight) {
				$newImage = imagecreatetruecolor ($newWidth, ($newWidth * $imageInfo[1]) / $imageInfo[0]);
				imagecopyresampled ($newImage, $oldImage, 0, 0, 0, 0, $newWidth, ($newWidth * $imageInfo[1]) / $imageInfo[0], $imageInfo[0], $imageInfo[1]);
			} else {
				$newImage = imagecreatetruecolor (($imageInfo[0] * $newHeight) / $imageInfo[1] , $newHeight);
				imagecopyresampled ($newImage, $oldImage, 0, 0, 0, 0, ($imageInfo[0] * $newHeight) / $imageInfo[1], $newHeight, $imageInfo[0], $imageInfo[1]);
			}
		}
		imagejpeg ($newImage, $newFile, $jpgQuality);
	} elseif ($method == 'crop') {
		$newImage = imagecreatetruecolor ($newWidth, $newHeight);
		if (! $stretch && ($imageInfo[0] < $newWidth || $imageInfo[1] < $newHeight)) {
			$color = imagecolorallocate ($newImage, $fillR, $fillG, $fillB);
			imagefill ($newImage, 0, 0, $color);
			if ($imageInfo[0] > $newWidth)
				imagecopyresampled ($newImage, $oldImage, 0, 0, 0, 0, $newWidth, ($newWidth * $imageInfo[1]) / $imageInfo[0], $imageInfo[0], $imageInfo[1]);
			elseif ($imageInfo[1] > $newHeight)
				imagecopyresampled ($newImage, $oldImage, 0, 0, 0, 0, ($imageInfo[0] * $newHeight) / $imageInfo[1], $newHeight, $imageInfo[0], $imageInfo[1]);
			else 
				imagecopyresampled ($newImage, $oldImage, 0, 0, 0, 0, $imageInfo[0], $imageInfo[1], $imageInfo[0], $imageInfo[1]);
		} else {
			if ($imageInfo[0] / $imageInfo[1] >= $newWidth / $newHeight)
				imagecopyresampled ($newImage, $oldImage, 0, 0, 0, 0, ($imageInfo[0] * $newHeight) / $imageInfo[1], $newHeight, $imageInfo[0], $imageInfo[1]);
			else
				imagecopyresampled ($newImage, $oldImage, 0, 0, 0, 0, $newWidth, ($newWidth * $imageInfo[1]) / $imageInfo[0], $imageInfo[0], $imageInfo[1]);
		}
		imagejpeg ($newImage, $newFile, $jpgQuality);
	} elseif ($method == 'fit') {
		$newImage = imagecreatetruecolor ($newWidth, $newHeight);
		$color = imagecolorallocate ($newImage, $fillR, $fillG, $fillB);
		imagefill ($newImage, 0, 0, $color);
		if (! $stretch && ($imageInfo[0] < $newWidth && $imageInfo[1] < $newHeight)) {
			imagecopyresampled ($newImage, $oldImage, floor (($newWidth - $imageInfo[0]) / 2), floor (($newHeight - $imageInfo[1]) / 2), 0, 0, $imageInfo[0], $imageInfo[1], $imageInfo[0], $imageInfo[1]);
		} else {
			if ($imageInfo[0] / $imageInfo[1] >= $newWidth / $newHeight)
				imagecopyresampled ($newImage, $oldImage, 0, floor (($newHeight - ($newWidth * $imageInfo[1]) / $imageInfo[0]) / 2), 0, 0, $newWidth, ($newWidth * $imageInfo[1]) / $imageInfo[0], $imageInfo[0], $imageInfo[1]);
			else
				imagecopyresampled ($newImage, $oldImage, floor (($newWidth - ($imageInfo[0] * $newHeight) / $imageInfo[1]) / 2), 0, 0, 0, ($imageInfo[0] * $newHeight) / $imageInfo[1], $newHeight, $imageInfo[0], $imageInfo[1]);
		}
		imagejpeg ($newImage, $newFile, $jpgQuality);
	}
}

function get_js_size ($image, $frame) {
	$imagesize = getimagesize ($image);
	return ("width=" . ($imagesize[0] + $frame) . ",height=" . ($imagesize[1] + $frame));
}

function get_html_size ($image) {
	$imagesize = getimagesize ($image);
	return ('width="' . $imagesize[0] . '" height="' . $imagesize[1] . '"');
}

function strip_slashes_deep ($var) {
	$var = is_array ($var) ? array_map ('strip_slashes_deep', $var) : stripslashes ($var);
	return $var;
}

function strip_accents ($str) {
	$translation = array ('Á' => 'A', 'Ä' => 'A', 'Č' => 'C', 'Ď' => 'D', 'É' => 'E', 'Ě' => 'E', 'Ë' => 'E', 'Í' => 'I', 'Ň' => 'N', 'Ó' => 'O', 'Ö' => 'O', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ú' => 'U', 'Ů' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Ž' => 'Z', 'á' => 'a', 'ä' => 'a', 'č' => 'c', 'ď' => 'd', 'é' => 'e', 'ě' => 'e', 'ë' => 'e', 'í' => 'i', 'ň' => 'n', 'ó' => 'o', 'ö' => 'o', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ú' => 'u', 'ů' => 'u', 'ü' => 'u', 'ý' => 'y', 'ž' => 'z');
	return strtr ($str, $translation);
}



?>
