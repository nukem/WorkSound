<?php
  $states = dbq ("SELECT id, state FROM {$cfg['db']['prefix']}_states WHERE enabled = '1'");

function show_value($key) {
	global $record;
	if(isset($_POST[$key]) && trim($_POST[$key]) != '') {
		return $_POST[$key];
	} else if(isset($record[$key]) && trim($record[$key]) != '') {
		return $record[$key];
	} else {
		return '';
	}
}

?>

<? require ("tpl/inc/head.php"); ?>
<body> 
<div id="page"> 
  <? require ("tpl/inc/header.php"); ?> 
  <? require ("tpl/inc/path.php"); ?> 
  <div id="content"> 
    <div id="left-col"> 
      <div id="left-col-border"> 
        <? if (isset ($errors)) require ("tpl/inc/error.php"); ?> 
        <? if (isset ($messages)) require ("tpl/inc/message.php"); ?> 
        <? if (isset ($_SESSION['epClipboard'])) require ("tpl/inc/clipboard.php"); ?> 
        <? require ("tpl/inc/structure.php"); ?> 
      </div> 
    </div> 
    <div id="right-col"> 
      <h2 class="bar green"><span>Display for Sale</span></h2> 
      <form action=".?id=<?= $id ?>" method="post" enctype="multipart/form-data" > 
        <? require ("tpl/inc/buttons.php"); ?> 
        <div class="right-col-padding1"> 
          <div class="width-99pct"> 
            <table class="rec-table">
	      
	      <tr>
                <td colspan="4">
		  <label>Home Details</label>
		</td>
	      </tr>
	      
              <? require ("tpl/inc/record.php"); ?> 
	      
	      <tr>
                <td>
		  <label>State &bull;</label><br />
		  <select id="state_id" name="state_id" class="textfield width-100pct">
		    <option value=""></option>
		    <?php if(!empty($states)): ?>
		      <?php foreach($states as $state): ?>
			<option value="<?php echo $state['id']; ?>" <?php if((isset($_POST['state_id']) && $_POST['state_id'] == $state['id']) || $record['state_id'] == $state['id']) echo 'selected="selected"'; ?>><?php echo $state['state']; ?></option>
		      <?php endforeach; ?>
		    <?php endif; ?>
		  </select>
		</td>
                <td>
		  <label>Display Centre &bull;</label><br />
		  <select id="display_centre_id" name="display_centre_id" class="textfield width-100pct">
		    <option value=""></option>
		  </select>
		</td>
		<td>
		  <label>Home &bull;</label><br />
		  <select id="home_id" name="home_id" class="textfield width-100pct">
		    <option value=""></option>
		  </select>
		</td>
		<td>
		  <label>Facade &bull;</label><br />
		  <select id="facade_id" name="facade_id" class="textfield width-100pct">
		    <option value=""></option>
		  </select>
		</td>
	      </tr>
	      
		<tr>
		  <td colspan="2">&nbsp;</td>
		  <td><label>Custom home name</label><br />
			<input type="text" name="custom_home" id="custom_home" class="textfield width-100pct" value="<? if (isset ($_POST['custom_home'])) echo htmlspecialchars ($_POST['custom_home']); else echo htmlspecialchars ($record['custom_home']); ?>" />
		  </td>
		  <td><label>Custom facade name</label><br />
			<input type="text" name="custom_facade" id="custom_facade" class="textfield width-100pct" value="<? if (isset ($_POST['custom_facade'])) echo htmlspecialchars ($_POST['custom_facade']); else echo htmlspecialchars ($record['custom_facade']); ?>" />
		  </td>
		</tr>
		<tr>
			  <td colspan="4">
				  <fieldset>
					  <legend>Property Details</legend>
					  <table class="rec-table">
						  <tr>
							<td>
								<label>Street Number (</label><label><input type="checkbox" name="display_address" value="1" <?php if (show_value('display_address') == 1) { echo 'checked="checked"'; } ?> />Display Property Address)</label><br />
								<input type="text" name="street_number" class="textfield width-100pct" value="<?php echo show_value('street_number'); ?>" />
							</td>
							<td>
								<label>Street Name</label><br />
								<input type="text" name="street_name" class="textfield width-100pct" value="<?php echo show_value('street_name'); ?>" />
							</td>
							  <td colspan="2" rowspan="4">
<?php

// Find which folder we need to search
if(strstr($record['viewRights'], '523') !== false) {
	$inclusion_parent = 1481;
} else if(strstr($record['viewRights'], '524') !== false) {
	$inclusion_parent = 1483;
} else if(strstr($record['viewRights'], '525') !== false) {
	$inclusion_parent = 1485;
}

$inclusions_sql = 'SELECT id, title, type FROM wp_structure WHERE online = 1 AND type = "property_inclusion" AND parent = ';
$folder_sql = 'SELECT id, title, type FROM wp_structure WHERE online = 1 AND type = "folder" AND parent = ' . $inclusion_parent;

// Root level articles
$inclusions = dbq($inclusions_sql . $inclusion_parent);
$folders = dbq($folder_sql);
$count = count($folders);
if(is_array($folders) && $count > 0) {
for($i = 0; $i < $count; $i++) {
	$folders[$i]['children'] = dbq($inclusions_sql . $folders[$i]['id']);
}
}
if(is_array($inclusions) && is_array($folders)) {
	$inclusions = array_merge($inclusions, $folders);
}
?>
		<label>Inclusions</label><br />
<?php
$explode = explode(',', $record['inclusion_id']);
if(is_array($inclusions) && count($inclusions) > 0) {
	foreach($inclusions as $i) {
		if($i['type'] == 'property_inclusion') {
			if((in_array($i['id'], $explode))) {
				$selected = ' checked="checked" ';
			} else {
				$selected = '';
			}
			echo '<label class="inclusion-label"><input type="checkbox" name="inclusion[]" value="' . $i['id'] .'"' . $selected . '/>' . $i['title'] .' </label><br />';
		} else if ($i['type'] == 'folder') {
			echo '<label class="category">' . $i['title'] . '</label>';
			foreach($i['children'] as $c) {
				if(in_array($c['id'], $explode)) {
					$selected = ' checked="checked" ';
				} else {
					$selected = '';
				}
				echo '<label class="inclusion-label><input type="checkbox" name="inclusion[]" value="' . $c['id'] . '"' . $selected . '>' . $c['title'] . '</label><br />';
			}
		}
	}
}
?>

							  </td>
							  
						  </tr>


							<tr>

								<td><label>Suburb</label><br />
									<input type="text" name="suburb" id="suburb" class="textfield width-100pct"  value="<? if (isset ($_POST['suburb'])) echo htmlspecialchars ($_POST['suburb']); else echo htmlspecialchars ($record['suburb']); ?>" />
								</td>
								<td><label>Postcode</label><br />
									<input type="text" name="postcode" id="postcode" class="textfield width-100pct"  value="<? if (isset ($_POST['postcode'])) echo htmlspecialchars ($_POST['postcode']); else echo htmlspecialchars ($record['postcode']); ?>" />
								</td>


							</tr>
							<tr>
								<td>
									<label>Beds</label><br />
									<input type="text" name="package_bed" id="package_bed" class="textfield width-100pct" value="<? if (isset ($_POST['package_bed'])) echo htmlspecialchars ($_POST['package_bed']); else echo htmlspecialchars ($record['package_bed']); ?>" />
								</td>
								<td>
									<label>Baths</label><br />
									<input type="text" name="package_bath" id="package_bath" class="textfield width-100pct" value="<? if (isset ($_POST['package_bath'])) echo htmlspecialchars ($_POST['package_bath']); else echo htmlspecialchars ($record['package_bath']); ?>" />
								</td>
							</tr>							  
						  <tr>
							  <?php /* ?>
							  <td>
								  <label>Carports</label><br />
								  <input type="text" name="package_cars" id="package_cars" class="textfield width-100pct" value="<? if (isset ($_POST['package_cars'])) echo htmlspecialchars ($_POST['package_cars']); else echo htmlspecialchars (); ?>" />
							  </td>
							  <?php //*/ ?>
							  <td>
								  <label>Garages</label><br />
								  <input type="text" name="package_garages" id="package_garages" class="textfield width-100pct" value="<? echo $record['package_garages'] + $record['package_cars']; ?>" />
								  <input type="hidden" name="package_cars" id="package_cars" class="textfield width-100pct" value="0" />
							  </td>
							  <td></td>
						  </tr>

						  <tr>
							<td>
								<label>House Size (sqm)</label><br />
								<input type="text" name="house_size" class="textfield width-100pct" value="<?php echo show_value('house_size'); ?>" />
							</td>
							<td>
								<label>Lot Size (sqm)</label><br />
								<input type="text" name="lot_size" class="textfield width-100pct" value="<?php echo show_value('lot_size'); ?>" />
							</td>
							</tr>
							<tr>
								<td>
									<label>Unit of Measurement</label><br />
									<select name="measurement_unit" class="textfield width-100pct">
										<option></option>
<?php
$measurement_units = array(
	'squareMetre' => 'Square Metres',
	'square' => 'Squares',
	'acre' => 'Acres',
	'hectare' => 'Hectares'
);
foreach($measurement_units as $mu => $label) {
	$selected = '';
	if($mu == show_value('measurement_unit')) {
		$selected = ' selected="selected" ';
	}
	?>
										<option<?php echo $selected; ?> value="<?php echo $mu; ?>"><?php echo $label; ?></option>
<?php
}
?>
									</select>
								</td>

		  

					  </table>
				  </fieldset>
			  </td>
		</tr>
		  <tr>
			<td colspan="4">
				  <fieldset>
					  <legend>Automatically Generated Brochures</legend>
					  <table class="rec-table">
						  <tr>
							  <td colspan="4">
								  <p>
									  <a href="../infokit/property_brochure/<?php echo $id; ?>/vic/display_sale">
										  Download Property Brochure (VIC Template)</a>
									  |
									  <a href="../infokit/property_brochure/<?php echo $id; ?>/nsw/display_sale">
										  Download Property Brochure (QLD / NSW Template)</a> 
									  |
									  <a href="../infokit/property_brochure/<?php echo $id; ?>/two_page/display_sale">
										  Download Property Brochure (Two Page Template)</a> 

									  <small>Please note these are still in testing phase, and there may be more changes required</small>
								  </p>
							  </td>
						  </tr>
						  <tr>
							  <td>
								  <label>Estate</label><br />
								  <input type="text" name="estate" class="textfield width-100pct" value="<?php echo show_value('estate'); ?>" />
							  </td>
							  <td colspan="3">
							  </td>
						  </tr>
					  </table>
				  </fieldset>
			  </td>
			  
		  </tr>
	      
		  <tr>
			  <td colspan="4">
				  <fieldset>
					  <legend>Information for Real Estate Portals and Domain Portals</legend>
					  <table class="rec-table">
						  <tr>
							  <td colspan="4">
								  <label><input type="checkbox" name="portal" value="1"  <?php if(show_value('portal') == 1) { echo 'checked="checked"'; } ?> /> Send this property to Real Estate Portals and Domain Portals</label>
							  </td>
						  </tr>
						  <tr>
							<td>
							<label>
								<input type="checkbox" name="portal_rea" value="1" <?php echo (show_value('portal_rea') == 1) ? 'checked="checked"' : ''; ?> />
								Upload to <a href="http://www.realestate.com.au/" target="_blank">realestate.com.au</a>
							</label>
							</td>
							<td>
							<label>
								<input type="checkbox" name="portal_domain" value="1" <?php echo (show_value('portal_domain') == 1) ? 'checked="checked"' : ''; ?> />
								Upload to <a href="http://www.domain.com.au/" target="_blank">domain.com.au</a>
							</label>
							</td>
							<td colspan="2"></td>
						  </tr>
						  <tr>
							  <td colspan="3">
								  <label>Property Title (Portal sites only)</label><br />
								  <input type="text" name="portal_title" class="textfield width-100pct" value="<?php echo show_value('portal_title'); ?>" />
							  </td>
							  <td>
								  <label>Property ID (Do not edit)</label><br />
								  <input type="text" name="portal_id" class="textfield width-100pct" value="<?php echo show_value('portal_id'); ?>" />
							  </td>
						  </tr>

						  <tr>
							  <td>
								  <label>Property Category</label><br />
<?php
$options = array(
	'' => '',
	'House' => 'House',
	'Unit' => 'Unit',
	'Townhouse' => 'Townhouse',
	'Villa' => 'Villa',
	'Apartment' => 'Apartment',
	'Flat' => 'Flat',
	'Studio' => 'Studio',
	'Warehouse' => 'Warehouse',
	'DuplexSemi-detached' => 'Duplex Semi-detached',
	'Alpine' => 'Alpine',
	'AcreageSemi-rural' => 'Acreage Semi-rural',
	'BlockOfUnits' => 'BlockOfUnits',
	'Terrace' => 'Terrace',
	'Retirement' => 'Retirement',
	'ServicedApartment' => 'Serviced Apartment',
	'Other' => 'Other'
);
?>
								<select name="category" class="width-100pct textfield">
<?php
foreach($options as $k => $o) {
	if($_POST['categpry'] == $k || $record['category'] == $k) {
		$selected = ' selected="selected" ';
	} else {
		$selected = '';
	}
?>
<option value="<?php echo $k; ?>" <?php echo $selected; ?>><?php echo $o; ?></option>
<?php
}
?>
								</select>
							</td>
							<td>
								<label>Property Status</label><br />
<?php
$options = array(
	'',
	'current',
	'withdrawn',
	'offmarket',
	'sold'
);
?>
								<select name="status" class="width-100pct textfield">
<?php
foreach($options as $o) {
	if($_POST['status'] == $o || $record['status'] == $o) {
		$selected = ' selected="selected" ';
	} else {
		$selected = '';
	}
?>
<option value="<?php echo $o; ?>" <?php echo $selected; ?>><?php echo ucwords($o); ?></option>
<?php
}
?>
								</select>
							</td>
							<td>
								<label>Sold Date (DD-MM-YYYY)</label><br />
								<input type="text" name="sold_date" class="textfield width-100pct" value="<?php if(show_value('sold_date') != '' || show_value('sold_date') != 0) { echo date('d-m-Y', strtotime(show_value('sold_date'))); } ?>" />
							</td>
							<td>
								<label>Property Under Contract</label>
<?php
$options = array(
	'0' => 'No',
	'1' => 'Yes'
);
?>
								<select name="under_contract" class="width-100pct textfield">
<?php
foreach($options as $k => $o) {
	if($_POST['under_contract'] == $k || $record['under_contract'] == $k) {
		$selected = ' selected="selected" ';
	} else {
		$selected = '';
	}
?>
<option value="<?php echo $k; ?>" <?php echo $selected; ?>><?php echo $o; ?></option>
<?php
}
?>
								</select>

							</td>
							

						  </tr>

					  </table>
				  </fieldset>
			  </td>
		  </tr>		  
		  
	      <tr>
		<td>
		  <label>Address</label><br />
		  <input type="text" name="address" class="textfield width-100pct" value="<? if (isset ($_POST['address'])) echo htmlspecialchars ($_POST['address']); else echo htmlspecialchars ($record['address']); ?>" />
		</td>
                <td>
		  <label>Squares</label><br />
		  <input type="text" name="squares" class="textfield width-100pct" value="<? if (isset ($_POST['squares'])) echo htmlspecialchars ($_POST['squares']); else echo htmlspecialchars ($record['squares']); ?>" />
		</td>
		<td>
		  <label>Actual Price (Numeric)</label><br />
		  <input type="text" name="price" class="textfield width-100pct" value="<? if (isset ($_POST['price'])) echo htmlspecialchars ($_POST['price']); else echo htmlspecialchars ($record['price']); ?>" />
		</td>
		<td>
		  <label>Display Price</label><br />
		  <input type="text" name="display_price" class="textfield width-100pct" value="<? if (isset ($_POST['display_price'])) echo htmlspecialchars ($_POST['display_price']); else echo htmlspecialchars ($record['display_price']); ?>" />
		</td>
	      </tr>
		  <tr>
			  <?php
// Find which folder we need to search
if(strstr($record['viewRights'], '523') !== false) {
	$inclusion_parent = 1796;
} else if(strstr($record['viewRights'], '524') !== false) {
	$inclusion_parent = 1797;
} else if(strstr($record['viewRights'], '525') !== false) {
	$inclusion_parent = 1798;
}

$inclusions_sql = 'SELECT id, title, type FROM wp_structure WHERE online = 1 AND type = "image" AND parent = ' . $inclusion_parent;

// Root level articles
$fp_inclusions = dbq($inclusions_sql);
$count = count($fp_inclusions);
?>

		<td colspan="2">
			<label>H &amp; L Package Builder</label><br />
			<select name="builder_id" class="textfield width-100pct">
			  <option></option>
<?php
foreach($fp_inclusions as $i) {
	if($i['type'] == 'image') {
		if($record['builder_id'] == $i['id']) {
			$selected = ' selected="selected" ';
		} else {
			$selected = '';
		}
		echo '<option value="' . $i['id'] .'"' . $selected . '>' . $i['title'] .'</option>';
	}
}
?>
			</select>
			</td> 
			<td colspan="2"></td>
			<?php /* ?>
<?php
// Find which folder we need to search
if(strstr($record['viewRights'], '523') !== false) {
	$inclusion_parent = 1482;
} else if(strstr($record['viewRights'], '524') !== false) {
	$inclusion_parent = 1484;
} else if(strstr($record['viewRights'], '525') !== false) {
	$inclusion_parent = 1486;
}

$articles_sql = 'SELECT id, title, type FROM wp_structure WHERE online = 1 AND type = "article" AND parent = ';
$folder_sql = 'SELECT id, title, type FROM wp_structure WHERE online = 1 AND type = "folder" AND PARENT = ' . $inclusion_parent;

// Root level articles
$fp_inclusions = dbq($articles_sql . $inclusion_parent);
$fp_folders = dbq($folder_sql);
$count = count($fp_folders);
if(is_array($fp_inclusions) && $count > 0) {
	for($i = 0; $i < $count; $i++) {
		$fp_folders[$i]['children'] = dbq($articles_sql . $fp_inclusions[$i]['id']);
	}
}

if(is_array($fp_inclusions) && is_array($fp_folders)) {
	$fp_inclusions = array_merge($fp_inclusions, $fp_folders);
}
?>

		<td colspan="2">
			<label>Fine Print</label><br />
			<select name="fine_print_id" class="textfield width-100pct">
			  <option></option>
<?php
foreach($fp_inclusions as $i) {
	if($i['type'] == 'article') {
		if($record['fine_print_id'] == $i['id']) {
			$selected = ' selected="selected" ';
		} else {
			$selected = '';
		}
		echo '<option value="' . $i['id'] .'"' . $selected . '>' . $i['title'] .'</option>';
	} else if ($i['type'] == 'folder') {
		echo '<option disabled="disabled">' . $i['title'] . '</option>';
		foreach($i['children'] as $c) {
			if($record['fine_print_id'] == $c['id']) {
				$selected = ' selected="selected" ';
			} else {
				$selected = '';
			}
			echo '<option value="' . $c['id'] . '"' . $selected . '>' . $c['title'] . '</option>';
		}
	}
}
?>
			</select>
			</td> 
			<?php */ ?>
		  </tr>
	      
	      <tr> 
                <td colspan="4"> 
		  <label>Inclusions</label><br />
		  <textarea name="inclusions" cols="30" rows="10" class="textfield height-200 tinymce"><? if (isset ($_POST['inclusions'])) echo htmlspecialchars ($_POST['inclusions']); else echo htmlspecialchars (preg_replace('/src="/', 'src="../', $record['inclusions'])); ?></textarea>
                </td> 
              </tr>
	      
	      <tr> 
                <td colspan="4"> 
		  <label>Fine Print</label><br />
		  <textarea name="fine_print" cols="30" rows="10" class="textfield height-200 tinymce"><? if (isset ($_POST['fine_print'])) echo htmlspecialchars ($_POST['fine_print']); else echo htmlspecialchars (preg_replace('/src="/', 'src="../', $record['fine_print'])); ?></textarea>
                </td> 
              </tr>

<tr>
				<td colspan="2">
				  <label>Upload Images</label><br />
				  <input type="file" name="jq-images" id="jq-images" onChange="return ajaxFileUpload('jq-images', 'image-parent');" />
				  
                  <div id="image-parent">
					<ul id="image-sort">
					<?
                    $linked_images = dbq("SELECT * FROM `wp_image_gallery` WHERE `parent` = '{$id}' ORDER BY `position`");
                    if (is_array($linked_images)) {
                      foreach ($linked_images as $li) {
                        ?>
                        <li class="sort-li" id="<?= $li['id'] ?>">
                          <img src="js/handle.gif" alt="move" class="move" />
                          <img src="js/edit.gif" alt="edit" class="edit" onClick="$(this).siblings('.editor').css('display', 'inline'); $(this).siblings('.preview').css('display', 'none'); trapEnter('#edit-<?= $li['id'] ?>', <?= $li['id'] ?>, 'image');" />
                          <span class="editor">
                            <input type="text" id="edit-<?= $li['id'] ?>" value="<?= $li['title'] ?>" />
                            <input type="button" value="save" onClick="saveTitle('#edit-<?= $li['id'] ?>', <?= $li['id'] ?>, 'image');" />
                            <img src="js/loading.gif" alt="loading" class="edit-no-show" />
                            <input type="button" id="edit-cancel-<?= $li['id'] ?>" value="cancel" onClick="$(this).parent().siblings('.preview').css('display', 'inline'); $(this).parent().css('display', 'none'); releaseEnter();" /> or remove this image 
                            <img src="js/unlink.gif" alt="un-link" class="unlink" onClick="if (window.confirm ('Are you sure?')) { deleteFile('image', <?= $li['id'] ?>); $(this).parent().parent().hide('fast'); }" />
                          </span>
                          <a href="#" title="preview" class="preview" onClick="$('img.thumb:visible').slideUp(200); $(this).siblings('img.thumb:not(:visible)').slideDown(200); return false;"><span class="pic-title"><?= $li['title'] ?></span>
                          &nbsp;<img src="js/preview.gif" alt="preview" /></a>
                          <span class="preview">
                            <input type="checkbox" id="online-image-<?= $li['id'] ?>" onChange="updateOnline('image', <?= $li['id'] ?>);"<? if ($li['online'] == 1) echo ' checked="checked"'; ?> />
                            <img src="js/web_<? if ($li['online'] == 1) echo 'online'; else echo 'offline' ?>.gif" class="onoff" alt="online/offline" />
                          </span>
                            <img src="../wpdata/images/<?= $li['id'] ?>-s.jpg" class="thumb" onClick="$(this).slideUp(100); return false;" />
                        </li>
                        <?
                      }
                    }
                    ?>
					</ul>
                  <input type="button" id="image-sort-save" value="save order" onClick="return saveSort('image-sort');" />
                  <img src="js/loading.gif" alt="loading" id="image-sort-no-show" />
				  </div>
				</td>
				<td colspan="2">
				  <label>Upload Files</label><br />
				  <input type="file" id="jq-files" name="jq-files" onChange="return ajaxFileUpload('jq-files', 'file-parent');" />
				  <div id="file-parent">
					<ul id="file-sort">
					<?
                    $linked_files = dbq("SELECT * FROM `wp_file_gallery` WHERE `parent` = '{$id}' ORDER BY `position`");
                    if (is_array($linked_files)) {
                      foreach ($linked_files as $lf) {
                        ?>
                        <li class="sort-li" id="<?= $lf['id'] ?>">
                          <img src="js/handle.gif" alt="move" class="move" />
                          <img src="js/edit.gif" alt="edit" class="edit" onClick="$(this).siblings('.editor').css('display', 'inline'); $(this).siblings('.preview').css('display', 'none'); trapEnter('#edit-<?= $lf['id'] ?>', <?= $lf['id'] ?>, 'file');" />
                          <span class="editor">
                            <input type="text" id="edit-<?= $lf['id'] ?>" value="<?= $lf['title'] ?>" />
                            <input type="button" value="save" onClick="saveTitle('#edit-<?= $lf['id'] ?>', <?= $lf['id'] ?>, 'file');" />
                            <img src="js/loading.gif" alt="loading" class="edit-no-show" />
                            <input type="button" id="edit-cancel-<?= $lf['id'] ?>" value="cancel" onClick="$(this).parent().siblings('.preview').css('display', 'inline'); $(this).parent().css('display', 'none'); releaseEnter();" /> or remove this file 
                            <img src="js/unlink.gif" alt="un-link" class="unlink" onClick="if (window.confirm ('Are you sure?')) { deleteFile('file', <?= $lf['id'] ?>); $(this).parent().parent().hide('fast'); }" />
                          </span>
                          <span class="preview">
                          <?
                          if (is_file ('../wpdata/files/' . $lf['id'] . "." . $lf['extension'])) { ?> 
                  <img src="img/ico-file/<? if (is_file ("img/ico-file/" . $lf['extension'] . ".gif")) echo "{$lf['extension']}.gif"; else echo "unknown.gif"; ?>" alt="Preview" width="16" height="16" /> <a href="file-preview.php?file=files/<?=  $lf['id'] . '.' . $lf['extension'] ?>&amp;filename=<?= $lf['title'] . "." . $lf['extension'] ?>"><?= $lf['title'] ?></a>
                        <? } ?>
                        <input type="checkbox" id="online-file-<?= $lf['id'] ?>" onChange="updateOnline('file', <?= $lf['id'] ?>);"<? if ($lf['online'] == 1) echo ' checked="checked"'; ?> />
                        <img src="js/web_<? if ($lf['online'] == 1) echo 'online'; else echo 'offline' ?>.gif" class="onoff" alt="online/offline" />
                        </span>
                        </li>
                        <?
                      }
                    }
                    ?>
					</ul>
                  <input type="button" id="file-sort-save" value="save order" onClick="return saveSort('file-sort');" />
                  <img src="js/loading.gif" alt="loading" id="file-sort-no-show" />
				  </div>
				</td>
			  </tr>
	    <? require ("tpl/inc/rights.php"); ?> 
	    </table>
	
	<input type="hidden" name="cond" class="textfield width-100pct" value="<? if (isset ($_POST['cond'])) echo htmlspecialchars ($_POST['cond']); else echo htmlspecialchars ($record['cond']); ?>" />
	
  <script type="text/javascript">
    
    var loadImage = new Image();
	loadImage.src = 'js/loading.gif';
    var onlineImage = new Image();
	onlineImage.src = 'js/web_online.gif';
    var offlineImage = new Image();
	offlineImage.src = 'js/web_offline.gif';
    
    function change_state(state_id, display_centre_id, home_id) {
      $("#display_centre_id").children().remove();
      $("#home_id").children().remove();
      $("#facade_id").children().remove();
      var url = 'get_display_centre_data.php';
      $.post(
	url,
	{ 'state_id': state_id },
	function(data){
	  var aData = data.split('||');
	  if(aData[0] != 'no_data') {
	    $("#display_centre_id").append(aData[0]);
	    $("#display_centre_id").val(display_centre_id);
	  }
	  if(aData[1] != 'no_data') {
	    $("#home_id").append(aData[1]);
	    $("#home_id").val(home_id);
	  }
	}, "html");
    }
    
    function change_home(home_id, facade_id) {
	$("#facade_id").children().remove();
	var url = 'get_facade_data.php';
	$.post(
	  url,
	  { 'homes_id': home_id },
	  function(data){
	    //var aData = data.split('||');
		if (window.console) console.log(data);
	    if(data.options != 'no_data') {
	      $("#facade_id").append(data.options);
		  if ($.trim($('#package_bed').val()) == '') $('#package_bed').val(data.home_data.bedrooms);
		  if ($.trim($('#package_bath').val()) == '') $('#package_bath').val(data.home_data.bathrooms);
		  if ($.trim($('#package_cars').val()) == '') $('#package_cars').val(data.home_data.carspaces);
	      $("#facade_id").val(facade_id);
	    }
	  }, "json");
    }
    
    $(function () {
      
      var load_state_id = '<?php if(isset($_POST['state_id'])) echo $_POST['state_id']; else echo $record['state_id']; ?>';
      var load_display_centre_id = '<?php if(isset($_POST['display_centre_id'])) echo $_POST['display_centre_id']; else echo $record['display_centre_id']; ?>';
      var load_home_id = '<?php if(isset($_POST['home_id'])) echo $_POST['home_id']; else echo $record['home_id']; ?>';
      var load_facade_id = '<?php if(isset($_POST['facade_id'])) echo $_POST['facade_id']; else echo $record['facade_id']; ?>';
      
      change_state(load_state_id, load_display_centre_id, load_home_id);
      change_home(load_home_id, load_facade_id);
      
      $("#state_id").change(function(){
		change_state($(this).val(), '', '');
      });
      
      $("#home_id").change(function(){
		change_home($(this).val(), '');
      });
      
      $('#image-sort').Sortable({
	accept: 'sort-li',
        handle: 'img.move',
        opacity: 0.2,
        axis: 'vertically',
		onStop: function() {
          $('#image-sort-save:not(:visible)').show('fast', function(){
            $(this).css('display', 'inline');
          });
        }
	  });
      $('#file-sort').Sortable({
	accept: 'sort-li',
        handle: 'img.move',
        opacity: 0.2,
        axis: 'vertically',
	  onStop: function() {
          $('#file-sort-save:not(:visible)').show('fast', function(){
            $(this).css('display', 'inline');
          });
        }
      });
    });
    
    function updateOnline(type, id) {
      var isOnline = 1;
      if ($('#online-'+type+'-'+id).attr('checked')) {
        $('#online-'+type+'-'+id).siblings('img.onoff')[0].src = onlineImage.src;
      } else {
        $('#online-'+type+'-'+id).siblings('img.onoff')[0].src = offlineImage.src;
        isOnline = 0;
      }
      $.get(
        'ajaxonline.php?t=' + new Date().getTime(),
        {'type' : type, 'id': id, 'online': isOnline},
        function(data){
        }
      );
    }
    
    function saveSort(type) {
      serial = $.SortSerialize(type);
      $('#'+type+'-no-show').css('display', 'inline');
      $.post('savesortorder.php?'+serial.hash, {}, function(data){
        if (data == "SUCCESS") {  
          $('#'+type+'-no-show').hide('fast');
          $('#'+type+'-save').hide('fast');
        } else {
          alert('ERROR! debug info:\n\n' + data);
        }
      });
      return false;
    }
    
    function trapEnter(id, num, type){
      $(id).focus().select();
      document.onkeyup = function(e){
        if (e == null) { // ie
          keycode = event.keyCode;
        } else { // mozilla
          keycode = e.which;
        }
        if(keycode == 13){ // enter key
          saveTitle(id, num, type);
        }
      }
      return false;
    }
    
    function releaseEnter(){
      document.onkeyup = '';
      return false;
    }
    
    function saveTitle(id, num, type) {
      $(id).siblings('.edit-no-show').css('display', 'inline');
      var titleDetails;
      $.get(
        'saveimagetitle.php?t='+type,
        {'nt' : $(id).val(), 'id': num},
        function(data){
          eval(data);
          if(typeof(titleDetails) == 'object' && titleDetails.msg == 'SUCCESS') {
            $(id).parent().siblings('.preview').children('.pic-title').html(titleDetails.title);
            $(id).parent().siblings('.preview').css('display', 'inline');
            $(id).siblings('.edit-no-show').css('display', 'none');
            $(id).parent().css('display', 'none');
          } else {
            if (titleDetails.title) {
              alert('Update Error!\n'+titleDetails.title);
            } else {
              alert('Update Error!');
            }
          }
        }
      );
      document.onkeyup = '';
      return false;
    }
    
    function deleteFile(type, id) {
      $.get(
        'deleteajaxfiles.php?t=' + new Date().getTime(),
        {'type' : type, 'id': id},
        function(data){
        }
      );
      return false;
    }
    
	function ajaxFileUpload(elemID, parentID)
	{
		var tempID = new Date().getTime();
		$('#'+parentID+' ul').append('<li id="'+tempID+'" class="sort-li"><img src="js/loading.gif"> Upload in progress</li>');
		$('#'+tempID).slideDown(500);

		$.ajaxFileUpload
		(
			{
				url:'doajaxfileupload.php?element='+elemID+'&parent=<?= $id ?>',
				secureuri:false,
				fileElementId:elemID,
				iframeParent:parentID,
				dataType: 'json',
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.msg == 'SUCCESS') {
						  $('#'+tempID+' img').hide(300, function(){
                            var liHTML = '<li class="sort-li" id="' + data.insert_id + '"><img src="js/handle.gif" alt="move" class="move" /><img src="js/edit.gif" alt="edit" class="edit" onclick="$(this).siblings(\'.editor\').css(\'display\', \'inline\'); $(this).siblings(\'.preview\').css(\'display\', \'none\'); trapEnter(\'#edit-' + data.insert_id + '\', ' + data.insert_id + ', \'image\');" /><span class="editor"><input type="text" id="edit-' + data.insert_id + '" value="' + data.image_title + '" /><input type="button" value="save" onclick="saveTitle(\'#edit-' + data.insert_id + '\', ' + data.insert_id + ', \'image\');" /><img src="js/loading.gif" alt="loading" class="edit-no-show" /><input type="button" id="edit-cancel-' + data.insert_id + '" value="cancel" onclick="$(this).parent().siblings(\'.preview\').css(\'display\', \'inline\'); $(this).parent().css(\'display\', \'none\');" /> or remove this image <img src="js/unlink.gif" alt="un-link" class="unlink" onclick="if (window.confirm (\'Are you sure?\')) { deleteFile(\'image\', ' + data.insert_id + '); $(this).parent().parent().hide(\'fast\'); }" /></span><a href="#" title="preview" class="preview" onclick="$(\'img.thumb:visible\').slideUp(200); $(this).siblings(\'img.thumb:not(:visible)\').slideDown(200); return false;"><span class="pic-title">' + data.image_title + '</span>&nbsp;<img src="js/preview.gif" alt="preview" /></a><span class="preview"><input type="checkbox" id="online-image-' + data.insert_id + '" onchange="updateOnline(\'image\', ' + data.insert_id + ');" /><img src="js/web_offline.gif" class="onoff" alt="online/offline" /></span><img src="../wpdata/images/' + data.insert_id + '-s.jpg" class="thumb" onclick="$(this).slideUp(100); return false;" /></li>';
                            if (data.file_ext) {
                              liHTML = '<li class="sort-li" id="' + data.insert_id + '"><img src="js/handle.gif" alt="move" class="move" /> <img src="js/edit.gif" alt="edit" class="edit" onclick="$(this).siblings(\'.editor\').css(\'display\', \'inline\'); $(this).siblings(\'.preview\').css(\'display\', \'none\'); trapEnter(\'#edit-' + data.insert_id + '\', ' + data.insert_id + ', \'file\');" /><span class="editor"><input type="text" id="edit-' + data.insert_id + '" value="' + data.image_title + '" /><input type="button" value="save" onclick="saveTitle(\'#edit-' + data.insert_id + '\', ' + data.insert_id + ', \'file\');" /><img src="js/loading.gif" alt="loading" class="edit-no-show" /><input type="button" id="edit-cancel-' + data.insert_id + '" value="cancel" onclick="$(this).parent().siblings(\'.preview\').css(\'display\', \'inline\'); $(this).parent().css(\'display\', \'none\'); releaseEnter();" /> or remove this file <img src="js/unlink.gif" alt="un-link" class="unlink" onclick="if (window.confirm (\'Are you sure?\')) { deleteFile(\'file\', ' + data.insert_id + '); $(this).parent().parent().hide(\'fast\'); }" /></span><span class="preview"><img src="img/ico-file/' + data.file_ext + '.gif" alt="Preview" width="16" height="16" /> <a href="file-preview.php?file=files/' + data.insert_id + '.' + data.file_ext + '&filename=' + data.image_title + '.' + data.file_ext + '">' + data.image_title + '</a><input type="checkbox" id="online-file-' + data.insert_id + '" onchange="updateOnline(\'file\', ' + data.insert_id + ');" /><img src="js/web_offline.gif" class="onoff" alt="online/offline" /></span></li>';
                            }
                            $(this).parent().parent().append(liHTML).SortableAddItem(document.getElementById(data.insert_id));
                            $(this).parent().remove();
                          });
						} else {
                          alert(data.error);
						  $('#'+tempID).slideUp(500);
                        }
						$('#'+parentID+' ul').Sortable({
						  accept: 'sort-li',
						  helperclass: 'sortHelper',
						  activeclass : 	'sortActive',
						  hoverclass : 	'sortHover',
						  tolerance: 'pointer',
						  opacity: 0.9
						});
					} else {
                      alert(typeof(data));
					  $('#'+tempID).slideUp(500);
                    }
				},
				error: function (data, status, e)
				{
					//alert('ajax error\n' + e + '\n' + data + '\n' + status);
                    for (i in e) {
                      //alert(e[i]);
                    }
					$('#'+tempID).slideUp(500);
				}
			}
		);
		
		$('#'+elemID).val('');
		return false;
	}
	</script>
          </div> 
        </div> 
      </form> 
    </div> 
    <? require ("tpl/inc/footer.php"); ?> 
  </div> 
</div> 
</body>
</html>
