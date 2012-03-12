<?
function image_thumb($image_path, $height, $width)
{
    $CI =& get_instance();
	
	//$path_parts = pathinfo(realpath($image_path));
	$filename = str_replace(dirname($image_path)."/","",$image_path);
	$filename = explode(".",$filename);

    // Path to image thumbnail
    $image_thumb = dirname($image_path) . '/' . $filename[0] . '_' . $height . 'x' . $width . '.jpg';
	
	//die($image_thumb);

    if( ! file_exists($image_thumb))
    {
        // LOAD LIBRARY
        $CI->load->library('image_lib');

        // CONFIGURE IMAGE LIBRARY
        $config['image_library']    = 'gd2';
        $config['source_image']     = $image_path;
        $config['new_image']        = $image_thumb;
        $config['maintain_ratio']   = TRUE;
        $config['height']           = $height;
        $config['width']            = $width;
        $CI->image_lib->initialize($config);
        $CI->image_lib->resize();
        $CI->image_lib->clear();
    }

    return base_url() . $image_thumb;
}