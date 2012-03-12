<?php

    require ("cfg.php");
    require ("fn.php");

    if (! @ mysql_connect ($cfg['db']['address'], $cfg['db']['username'], $cfg['db']['password'])) {
        $error = 'DB connect error';
    }
    if (! @ mysql_select_db ($cfg['db']['name'])) {
        $error = 'DB select error';
    }

    $state_id = $_POST['state_id'];
    $data = array();
    
    $all_options = '<option value=""></option>';
    
    $data['display_centres'] = dbq("SELECT structure.id, structure.title
                                FROM {$cfg['db']['prefix']}_structure structure
                                INNER JOIN {$cfg['db']['prefix']}_display_centre display_centre ON display_centre.link = structure.id
                                WHERE structure.type = 'display_centre'
                                AND structure.online = '1'
                                AND display_centre.state_id = '$state_id'
                                ORDER BY structure.position ASC");
    
    if(is_array($data['display_centres']) && count($data['display_centres']) > 0){
        foreach($data['display_centres'] as $display_centre) 
        {
            $all_options .= "<option value='".$display_centre['id']."'>".$display_centre['title']."</option>\n";
        }
    }
    else
        $all_options = 'no_data';
    
    $all_options .= "||";
    $all_options .= '<option value=""></option>';
    
    $data['homes'] = dbq("SELECT structure.id, structure.title
                            FROM {$cfg['db']['prefix']}_structure structure
                            INNER JOIN {$cfg['db']['prefix']}_homes_states homes_states ON homes_states.homes_id = structure.id
                            WHERE structure.type = 'homes'
                            AND structure.online = '1'
                            AND homes_states.state_id = '$state_id'");
    
    if(is_array($data['homes']) && count($data['homes']) > 0){
        foreach($data['homes'] as $home) 
        {
            $all_options .= "<option value='".$home['id']."'>".$home['title']."</option>\n";
        }
    }
    else
        $all_options .= 'no_data';
    
    echo $all_options;