<?php

    require ("cfg.php");
    require ("fn.php");

    if (! @ mysql_connect ($cfg['db']['address'], $cfg['db']['username'], $cfg['db']['password'])) {
        $error = 'DB connect error';
    }
    if (! @ mysql_select_db ($cfg['db']['name'])) {
        $error = 'DB select error';
    }

    $homes_id = $_POST['homes_id'];
    $data = array();
    $json = array();
    
    $all_options = '<option value=""></option>';
    
    $data['facade'] = dbq("SELECT id, title FROM {$cfg['db']['prefix']}_image_gallery WHERE parent = '" . mysql_real_escape_string($homes_id) . "' AND online = '1'");
    
    $home_data = dbq("SELECT * FROM {$cfg['db']['prefix']}_homes WHERE `link` = '" . mysql_real_escape_string($homes_id) . "'");
    
    if ( ! $home_data)
    {
        $json['home_data'] = FALSE;
    }
    else
    {
        $json['home_data'] = $home_data[0];
    }
    
    if(is_array($data['facade']) && count($data['facade']) > 0)
    {
        foreach($data['facade'] as $facade) 
        {
            $all_options .= "<option value='".$facade['id']."'>".$facade['title']."</option>\n";
        }
    }
    else
    {
        $all_options = 'no_data';
    }
    
    $json['options'] = $all_options;
    
    echo json_encode($json);
