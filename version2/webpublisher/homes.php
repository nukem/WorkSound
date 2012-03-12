<?php

if (! isset ($errorsChecked)) {
	if (! preg_match ('/.+/', $_POST['title']))
		$errors[] =  $lang[103];

	if ($_POST['bedrooms'] != '' && ! is_numeric($_POST['bedrooms']))
		$errors[] =  'Bedrooms must be a numeric value.';
	if ($_POST['bathrooms'] != '' && ! is_numeric($_POST['bathrooms']))
		$errors[] =  'Bathrooms must be a numeric value.';
	if ($_POST['carspaces'] != '' && ! is_numeric($_POST['carspaces']))
		$errors[] =  'Carspaces must be a numeric value.';
	if ($_POST['squares'] != '' && ! is_numeric($_POST['squares']))
		$errors[] =  'Squares must be a numeric value.';
	if ($_POST['overall_width'] != '' && ! is_numeric($_POST['overall_width']))
		$errors[] =  'Overall width must be a numeric value.';
	if ($_POST['overall_depth'] != '' && ! is_numeric($_POST['overall_depth']))
		$errors[] =  'Overall depth must be a numeric value.';
	if ($_POST['frontage'] != '' && ! is_numeric($_POST['frontage']))
		$errors[] =  'Frontage must be a numeric value.';
	if (!isset($_POST['states']))
		$errors[] =  'Location must be selected.';

	if (dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND title = '" . addslashes ($_POST['title']) . "' AND title <> ''"))
		$errors[] = $lang[104];
	$uri = strtolower (preg_replace ('/[^A-Za-z0-9]+/', '-', strip_accents ($_POST['title'])));
	if (! isset ($errors) && dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$record['parent']} AND id <> $id AND uri = '$uri' AND uri <> ''"))
		$errors[] = $lang[105];
	$errorsChecked = true;
} else {


	if ($record['position'] != $_POST['position'])
		dbq ("UPDATE {$cfg['db']['prefix']}_structure SET position = position + 1 WHERE position >= {$_POST['position']} ORDER BY position DESC");

	$price_range_from = ($_POST['price_range_from']=='') ? "NULL" : "'".addslashes($_POST['price_range_from'])."'";
	$price_range_to = ($_POST['price_range_to']=='') ? "NULL" : "'".addslashes($_POST['price_range_to'])."'";
	$custom_price = ($_POST['custom_price']=='') ? "NULL" : "'".addslashes($_POST['custom_price'])."'";

	dbq ("UPDATE
	{$cfg['db']['prefix']}_structure,
	{$cfg['db']['prefix']}_homes
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
		featured = '" . addslashes ($_POST['featured']) . "',
		description = '" . addslashes (preg_replace('/src="..\//', 'src="', $_POST['description'])) . "',
		storeys = '" . addslashes ($_POST['storeys']) . "',
		bedrooms = '" . addslashes ($_POST['bedrooms']) . "',
		bathrooms = '" . addslashes ($_POST['bathrooms']) . "',
		carspaces = '" . addslashes ($_POST['carspaces']) . "',
		squares = '" . addslashes ($_POST['squares']) . "',
		overall_width = '" . addslashes ($_POST['overall_width']) . "',
		overall_depth = '" . addslashes ($_POST['overall_depth']) . "',
		total_size = '" . addslashes ($_POST['total_size']) . "',
		lot_size = '" . addslashes ($_POST['lot_size']) . "',
		frontage = '" . addslashes ($_POST['frontage']) . "',
		price_range_from = $price_range_from,
		price_range_to = $price_range_to,
		custom_price = $custom_price,
		show_price = '" . addslashes ($_POST['show_price']) . "',
		display_range = '" . addslashes ($_POST['display_range']) . "',
		virtual_tour = '" . addslashes ($_POST['virtual_tour']) . "',
		new = '" . addslashes ($_POST['new']) . "',
		houseland = '" . addslashes ($_POST['houseland']) . "'
		WHERE
		link = id AND
		id = $id");

	$count = count($_POST['fpd_label']);
	for($i = 0; $i < $count; $i++) {
		if(trim($_POST['fpd_value'][$i]) != '' && trim($_POST['fpd_label'][$i]) != '') {
			if(isset($_POST['fpd_id'][$i]) && trim($_POST['fpd_id'][$i]) != '') {
				$sql = 'UPDATE floorplan_dimensions SET label = "' . $_POST['fpd_label'][$i] . '", value = "' . $_POST['fpd_value'][$i] . '", wp_id = "' . $id . '", position = "' . $i . '" WHERE id = "' . $_POST['fpd_id'][$i] . '"';
			} else {
				$sql = 'INSERT INTO floorplan_dimensions (wp_id, label, value, position) VALUES ("' . $id . '", "' . $_POST['fpd_label'][$i] . '", "' . $_POST['fpd_value'][$i] . '", "' . $i . '");';
			}
			dbq($sql);
		}

	}

}


dbq ("DELETE FROM {$cfg['db']['prefix']}_homes_states WHERE homes_id = $id");

if(isset($_POST['states']) && !empty($_POST['states'])):
	foreach($_POST['states'] as $state_id):
		dbq("INSERT INTO {$cfg['db']['prefix']}_homes_states (`homes_id`, `state_id`) VALUES ('{$id}', '{$state_id}')");
endforeach;
endif;

dbq ("DELETE FROM {$cfg['db']['prefix']}_homes_inclusions WHERE homes_id = $id");

if(isset($_POST['inclusions']) && !empty($_POST['inclusions'])):
	foreach($_POST['inclusions'] as $inclusion_id):
		dbq("INSERT INTO {$cfg['db']['prefix']}_homes_inclusions (`homes_id`, `inclusion_id`) VALUES ('{$id}', '{$inclusion_id}')");
endforeach;
endif;

?>
