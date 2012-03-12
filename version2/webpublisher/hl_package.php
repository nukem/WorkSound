<?php
error_reporting(0);
if (! isset ($errorsChecked)) {
	if (! preg_match ('/.+/', $_POST['title']))
		$errors[] =  $lang[103];

	if (!isset($_POST['state_id']) || $_POST['state_id'] == '')
		$errors[] =  'State must be selected.';
	if (!isset($_POST['suburb_id']) || $_POST['suburb_id'] == '')
		$errors[] =  'Suburb must be selected.';
	if (!isset($_POST['home_id']) || $_POST['home_id'] == '')
		$errors[] =  'Home must be selected.';
	if (!isset($_POST['facade_id']) || $_POST['facade_id'] == '')
		$errors[] =  'Facade must be selected.';
	if ($_POST['squares'] != '' && ! is_numeric($_POST['squares']))
		$errors[] =  'Squares must be a numeric value.';

	if($_POST['portal'] && $_POST['portal'] == 1) {

		// The following are required:
		if(!test_field($_POST['portal_title'])) {
			$errors[] = 'Property Title is required.';
		}

		if(!test_field($_POST['category'])) {
			$errors[] = 'Property Category is required.';
		}

		if(!test_field($_POST['status'])) {
			$errors[] = 'Property Status is required.';
		}

		if($_POST['status'] == 'sold' && !test_field($_POST['sold_date'])) {
			$errors[] = 'Sold date is required if Status is "Sold".';
		}

		if(!test_field($_POST['street_number'])) {
			$errors[] = 'Street Number is required.';
		}

		if(!test_field($_POST['street_name'])) {
			$errors[] = 'Street Name is required.';
		}

		if(!test_field($_POST['suburb'])) {
			$errors[] = 'Suburb is required.';
		}

		if(!test_field($_POST['postcode'])) {
			$errors[] = 'Postcode is required.';
		}

		if(!test_field($_POST['package_bed'])) {
			$errors[] = 'Package Beds is required.';
		}

		if(!test_field($_POST['package_bath'])) {
			$errors[] = 'Package Baths is required.';
		}

		if(!test_field($_POST['package_cars'])) {
			$errors[] = 'Package Garages is required.';
		}

		if(!test_field($_POST['price'])) {
			$errors[] = 'Actual Price is required.';
		}

		if(!test_field($_POST['inclusions'])) {
			$errors[] = 'Inclusions are required.';
		}

		if(!test_field($_POST['display_price'])) {
			$errors[] = 'Display Price is required.';
		}

		if($_POST['agent'] && $_POST['agent'] == 1) {


			if(!test_field($_POST['agent_name'])) {
				$errors[] = 'Agent\'s Name is required.';
			}

			if(!test_field($_POST['agent_mobile']) && !test_field($_POST['agent_phone'])) {
				$errors[] = 'Agent\'s Phone or Mobile is required.';
			}
			
			if(!test_field($_POST['agent_email'])) {
				$errors[] = 'Agent\'s Email is required.';
			}
			
		}
		
		/*
		if(!test_field($_POST['portal_rea']) && !test_field($_POST['portal_domain'])) {
			$errors[] = 'Please select at least one portal to upload the property data to.';
		}
		*/

	}

	if (dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND title = '" . addslashes ($_POST['title']) . "' AND title <> ''"))
		$errors[] = $lang[104];
	$uri = strtolower (preg_replace ('/[^A-Za-z0-9]+/', '-', strip_accents ($_POST['title'])));
	if (! isset ($errors) && dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND uri = '$uri' AND uri <> ''"))
		$errors[] = $lang[105];
	$errorsChecked = true;
} else {


	if ($record['position'] != $_POST['position'])
		dbq ("UPDATE {$cfg['db']['prefix']}_structure SET position = position + 1 WHERE position >= {$_POST['position']} ORDER BY position DESC");

	$price = ($_POST['price']=='') ? "NULL" : "'".addslashes($_POST['price'])."'";

	if (trim($_POST['custom_home']) != '')
	{
		$custom_home = "`custom_home` = '" . mysql_real_escape_string($_POST['custom_home']) . "',\n";
	}
	else
	{
		$custom_home = "`custom_home` = '',\n";
	}
	if (trim($_POST['custom_facade']) != '')
	{
		$custom_facade = "`custom_facade` = '" . mysql_real_escape_string($_POST['custom_facade']) . "',\n";
	}
	else
	{
		$custom_facade = "`custom_facade` = '',\n";
	}
	
	// basic check of the suburb field.
	// if the string contains " - " inform the user that they might 
	// not be using the correct suburb name.
	if(strpos($_POST['suburb'], ' - ') !== false) {
		$messages[] = 'Please check the suburb field. This contains information that may be rejected by real estate portals.';
	}

/*
	// Update the facade
	// Load file where facade = selected.

	// Change dir to wpdata, so that we can manipulate the files.
	chdir('../wpdata/');

	if(trim($_POST['facade_id']) != '') {
		$select_facade = 'SELECT * FROM wp_file_gallery WHERE id = ' . $_POST['facade_id'];
		$facade_details = dbq($select_facade);
		foreach($facade_details as $fd) {
			$save_facade = 'INSERT INTO wp_image_gallery (parent, title, extension, online) VALUES ("' . $id .'", "' . $fd['title'] . '", "' . $fd['extension'] . '", 1)';
			$wp_image_id = dbq($save_facade);
		}

		if($handle = opendir(getcwd())) {
			$file_list = array();
			while(false !== ($file = readdir($handle))) {
				if(strstr($file, $_POST['facade_id'])) {
					copy($file, str_replace($_POST['facade_id'], $wp_image_id, $file));
				}
			}
		}
	}
	*/

	$inclusions = '';
	if(isset($_POST['inclusion'])) {
		$inclusions = implode(',', $_POST['inclusion']);
	}

	$display_address = 0;
	if(isset($_POST['display_address']) && $_POST['display_address'] == 1) {
		$display_address = 1;
	}

	$fixed_site_cost = 0;
	if(isset($_POST['fixed_site_cost']) && $_POST['fixed_site_cost'] == 1) {
		$fixed_site_cost = 1;
	}

	$portal = 0;
	$portal_upload = 0;
	if(isset($_POST['portal']) && $_POST['portal'] == 1) {
		$portal = 1;
		$portal_upload = 1;
	}
	
	$portal_rea = 0;
	$portal_rea_upload = 0;
	if(isset($_POST['portal_rea']) && $_POST['portal_rea'] == 1) {
		$portal_rea = 1;
		$portal_rea_upload = 1;
	}
	
	$portal_domain = 0;
	$portal_domain_upload = 0;
	if(isset($_POST['portal_domain']) && $_POST['portal_domain'] == 1) {
		$portal_domain = 1;
		$portal_domain_upload = 1;
	}

	$agent = 0;
	if(isset($_POST['agent']) && $_POST['agent'] == 1) {
		$agent = 1;
	}

	$under_contract = 0;
	if(isset($_POST['under_contract']) && $_POST['under_contract'] == 1) {
		$under_contract = 1;
	}
	
	$date = 'null';
	if(($_POST['sold_date']  != '' || $_POST['sold_date'] != 0) && strtotime($_POST['sold_date'])) {
		#echo $_POST['sold_date'];
		$date = '\'' . date ('Y-m-d', strtotime($_POST['sold_date'])) . '\'';
	}

	if(isset($_POST['portal_id']) && !empty($_POST['portal_id'])) {
		$portal_id = $_POST['portal_id'];
	} else {
		$portal_id = $id + 106601363;
	}
	

	dbq ("UPDATE
	{$cfg['db']['prefix']}_structure,
	{$cfg['db']['prefix']}_hl_package
	SET
	title = '" . addslashes ($_POST['title']) . "',
		uri = '$uri',
		online = $online,
		sort = '{$_POST['sort']}',
		position = {$_POST['position']},
		modified = '$time',
		viewRights = '$viewRights',
		createRights = '$createRights',
		editRights = '$editRights',
		deleteRights = '$deleteRights',
		inclusions = '" . addslashes (preg_replace('/src="..\//', 'src="', $_POST['inclusions'])) . "',
		fine_print = '" . addslashes (preg_replace('/src="..\//', 'src="', $_POST['fine_print'])) . "',
		inclusion_id = '" . addslashes ($inclusions) . "',
		fine_print_id = '" . addslashes ($_POST['fine_print_id']) . "',
		state_id = '" . addslashes ($_POST['state_id']) . "',
		suburb_id = '" . addslashes ($_POST['suburb_id']) . "',
		home_id = '" . addslashes ($_POST['home_id']) . "',
		facade_id = '" . addslashes ($_POST['facade_id']) . "',
		{$custom_home}
		{$custom_facade}
		address = '" . addslashes ($_POST['address']) . "',
		squares = '" . addslashes ($_POST['squares']) . "',
		display_address = '{$display_address}', 
		street_number = '" . addslashes ($_POST['street_number']) . "',
		street_name = '" . addslashes ($_POST['street_name']) . "',
		suburb = '" . addslashes ($_POST['suburb']) . "',
		postcode = '" . addslashes ($_POST['postcode']) . "',
		package_bed = '" . addslashes ($_POST['package_bed']) . "',
		package_bath = '" . addslashes ($_POST['package_bath']) . "',
		package_cars = '" . addslashes ($_POST['package_cars']) . "',
		package_garages = '" . addslashes ($_POST['package_garages']) . "',
		estate = '" . addslashes ($_POST['estate']) . "',
		category = '" . addslashes ($_POST['category']) . "',
		status = '" . addslashes ($_POST['status']) . "',
		under_contract = '{$under_contract}',
		sold_date = " . $date . ",
		price = $price,
		display_price = '" . addslashes ($_POST['display_price']) . "',
		lot_size = '" . addslashes ($_POST['lot_size']) . "',
		house_size = '" . addslashes ($_POST['house_size']) . "',
		builder_id = '" . addslashes ($_POST['builder_id']) . "',
		cond = '" . addslashes ($_POST['cond']) . "',
		fixed_site_cost = '" . addslashes ($fixed_site_cost) . "',
		portal = '" . addslashes ($portal) . "',
		portal_id = '" . addslashes ($portal_id) . "',
		portal_title = '" . addslashes ($_POST['portal_title']) . "',
		measurement_unit = '" . addslashes ($_POST['measurement_unit']) . "',
		portal_upload = '" .$portal_upload . "',
		portal_rea_upload = '" .$portal_rea_upload . "',
		portal_domain_upload = '" .$portal_domain_upload . "',
		agent = '" . addslashes ($_POST['agent']) . "',
		agent_name = '" . addslashes ($_POST['agent_name']) . "',
		agent_phone = '" . addslashes ($_POST['agent_phone']) . "',
		agent_mobile = '" . addslashes ($_POST['agent_mobile']) . "',
		agent_email = '" . addslashes ($_POST['agent_email']) . "',
		portal_rea = '" . addslashes($_POST['portal_rea']) . "',
		portal_domain = '" . addslashes($_POST['portal_domain']) . "'
		WHERE
		link = id AND
		id = $id");

}

?>
