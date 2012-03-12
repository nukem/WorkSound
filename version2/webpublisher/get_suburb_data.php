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
    
    $all_options = '<option value="0"></option>';
    
    $data['suburbs'] = dbq("SELECT structure.id, structure.title, suburb.postcode
                                FROM {$cfg['db']['prefix']}_structure structure
                                INNER JOIN {$cfg['db']['prefix']}_suburb suburb ON suburb.link = structure.id
                                WHERE structure.type = 'suburb'
                                AND structure.online = '1'
								AND suburb.state_id = '$state_id'
								ORDER BY structure.title");
    
    if(is_array($data['suburbs']) && count($data['suburbs']) > 0){
        foreach($data['suburbs'] as $suburb) 
        {
            $all_options .= "<option value='".$suburb['id']."' rel='".$suburb['postcode']."'>".$suburb['title']."</option>\n";
        }
    }
    else
        $all_options = 'no_data';
    
    $all_options .= "||";
    $all_options .= '<option value="0"></option>';
    
    $data['homes'] = dbq("SELECT structure.id, structure.title
                            FROM {$cfg['db']['prefix']}_structure structure
                            INNER JOIN {$cfg['db']['prefix']}_homes_states homes_states ON homes_states.homes_id = structure.id
                            WHERE structure.type = 'homes'
                            AND structure.online = '1'
                            AND homes_states.state_id = '$state_id'
							ORDER BY structure.title");
    
    if(is_array($data['homes']) && count($data['homes']) > 0){
        foreach($data['homes'] as $home) 
        {
            $all_options .= "<option value='".$home['id']."'>".$home['title']."</option>\n";
        }
    }
    else
        $all_options .= 'no_data';
    
    echo $all_options;
