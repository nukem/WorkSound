<?php 
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/**
 * Soundbooka
 * 
 * @author     Chathura Payagala <chathupayagala@gmail.com>
 */
class Resize extends MY_Controller {

	function _getResizePath( $file_path, $w, $h )
	{
		$ary = pathinfo($file_path);
		$ext = strtolower($ary["extension"]);
		$rz_file = basename($file_path);
		$cache_dir = dirname(__FILE__).'/../../wpdata/images/cache/';
		if ( !is_dir($cache_dir) )
			mkdir($cache_dir);
		$rz_file = $cache_dir.'/'.substr($rz_file,0,strlen($rz_file)-(strlen($ext)+1))."_".$w."x".$h.".jpg";
		return $rz_file;
	}
	
	function _getScaleRatio( $src_x, $src_y, $target_x, $target_y )
	{
		$n = max($src_x,$src_y);
		$n2 = min($target_x,$target_y);
		return 1-(($n-$n2)/$n);
	}

	function _resizeImage( $file_path, $max_w, $max_h )
	{
		list($w,$h) = getimagesize($file_path);
		if ( $w <= $max_w /*&& $h <= $max_h*/ )
			return $file_path;
		$r = $this->_getScaleRatio($w,$h,$max_w,$max_h);
		$ary = pathinfo($file_path);
		$ext = strtolower($ary['extension']);
		if ( $ext == "jpeg" || $ext == "jpg" )
			$src = imagecreatefromjpeg($file_path);
		else if ( $ext == "png" )	
			$src = imagecreatefrompng($file_path);
		else if ( $ext == "gif" )	
			$src = imagecreatefromgif($file_path);
		$rz_w = $w*$r;
		$rz_h = $h*$r;
		$dst = imagecreatetruecolor($max_w,$max_h);
		imagealphablending($dst, false);
		imagesavealpha($dst,true);
		$transparent = imagecolorallocatealpha($dst, 0, 0, 0, 0);
		imagefilledrectangle($dst, 0, 0, $w, $h, $transparent);
		imagecopyresampled($dst, $src, ($max_w-$rz_w)/2, ($max_h-$rz_h)/2, 0, 0, $rz_w, $rz_h, $w, $h);
		$rz_file = $this->_getResizePath($file_path,$max_w,$max_h);
		if ( is_file($rz_file) )
			unlink($rz_file);
		if ( $ext == "jpeg" || $ext == "jpg" ) {
			$quality = 100;
			imagejpeg($dst,$rz_file,$quality<=0?90:100);
		} else if ( $ext == "png" )
			imagepng($dst,$rz_file);
		else if ( $ext == "gif" )	
			imagegif($dst,$rz_file);
		imagedestroy($src);
		imagedestroy($dst);
		return $rz_file;
	}

	function _streamHeader( $file )
	{
		$ary = pathinfo($file);
		$ext = strtolower($ary['extension']);
		$disp = 'inline; filename="'.basename($file).'"';
		if ( $ext == "jpeg" || $ext == "jpg" ) {
			$mime = 'Content-Type: image/jpeg';
		} else if ( $ext == "gif" || $ext == "png" ) {
			$mime = 'Content-Type: image/'.$ext;
		} 
		header('Pragma: public');   // required
		header('Expires: 0');       // no cache
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private',false);
		header('Content-Type: '.$mime); 
		header('Content-Disposition: '.$disp);
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.filesize($file));	
	}

	function _streamFile( $file )
	{
		ob_end_clean();	
		$fp = fopen($file,"rb");
		if ( !$fp )
			return false;
		$this->_streamHeader($file);
		while ( !feof($fp) )
			print(fread($fp,8192));
		fclose($fp);
		exit;
		return true;
	}
	
	public function resize() {
		$file = dirname(__FILE__).'/../../wpdata/images/'.$_REQUEST["f"];	
		$max_w = (int)$_REQUEST["w"];
		$max_h = (int)$_REQUEST["h"];
		list($w,$h) = getimagesize($file);
		if ( $w > $max_w ) {
			$rz_file = $this->_getResizePath($file,$max_w,$max_h);
			if ( !is_file($rz_file) )
				$rz_file = $this->_resizeImage($file,$max_w,$max_h);
			$this->_streamFile($rz_file);
		} else {		
			$this->_streamFile($file);
		}	
	}		
}	
?>
