<?php

if (! isset ($errorsChecked)) {
 if (! preg_match ('/.+/', $_POST['title']))
  $errors[] =  $lang[103];
  
 if ( ! isset($_POST['state_id']) || $_POST['state_id'] == '')
	 $errors[] =  'State must be selected.';
 if ( ! isset($_POST['display_centre_id']) || $_POST['display_centre_id'] == '')
	 $errors[] =  'Display Centre must be selected.';
 if ( ! isset($_POST['home_id']) || trim($_POST['home_id']) == '')
	 $errors[] =  'Home must be selected.';
 if ( ! isset($_POST['facade_id']) || trim($_POST['facade_id']) == '')
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
	
	$date = 'null';
	if($_POST['sold_date']  != '' || $_POST['sold_date'] != 0) {
		$date = '\'' . date ('Y-m-d', strtotime($_POST['sold_date'])) . '\'';
	}

	$under_contract = 0;
	if(isset($_POST['under_contract']) && $_POST['under_contract'] == 1) {
		$under_contract = 1;
	}

	if(isset($_POST['portal_id']) && !empty($_POST['portal_id'])) {
		$portal_id = $_POST['portal_id'];
	} else {
		$portal_id = $id + 106601363;
	}

	dbq ("UPDATE
	{$cfg['db']['prefix']}_structure,
	{$cfg['db']['prefix']}_display_sale
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
		state_id = '" . addslashes ($_POST['state_id']) . "',
		display_centre_id = '" . addslashes ($_POST['display_centre_id']) . "',
		home_id = '" . addslashes ($_POST['home_id']) . "',
		facade_id = '" . addslashes ($_POST['facade_id']) . "',
	{$custom_home}
	{$custom_facade}
	address = '" . addslashes ($_POST['address']) . "',
		squares = '" . addslashes ($_POST['squares']) . "',
		package_bed = '" . addslashes ($_POST['package_bed']) . "',
		package_bath = '" . addslashes ($_POST['package_bath']) . "',
		package_cars = '" . addslashes ($_POST['package_cars']) . "',
		estate = '" . addslashes ($_POST['estate']) . "',
		price = $price,
		display_price = '" . addslashes ($_POST['display_price']) . "',
		cond = '" . addslashes ($_POST['cond']) . "',
		display_address = '{$display_address}', 
		street_number = '" . addslashes ($_POST['street_number']) . "',
		street_name = '" . addslashes ($_POST['street_name']) . "',
		suburb = '" . addslashes ($_POST['suburb']) . "',
		postcode = '" . addslashes ($_POST['postcode']) . "',
		package_bed = '" . addslashes ($_POST['package_bed']) . "',
		package_bath = '" . addslashes ($_POST['package_bath']) . "',
		package_cars = '" . addslashes ($_POST['package_cars']) . "',
		package_garages = '" . addslashes ($_POST['package_garages']) . "',
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
		portal_rea = '" .$portal_rea . "',
		portal_rea_upload = '" .$portal_rea_upload . "',
		portal_domain = '" .$portal_domain . "',
		portal_domain_upload = '" .$portal_domain_upload . "',
		portal_id = '" . addslashes ($portal_id) . "',
		portal_title = '" . addslashes ($_POST['portal_title']) . "',
		measurement_unit = '" . addslashes ($_POST['measurement_unit']) . "',
		portal_upload = '" .$portal_upload . "'
		
		WHERE
		link = id AND
		id = $id");
}

?>
