<?php require ("tpl/inc/head.php"); ?>
<body> 
<div id="page"> 
<?php require ("tpl/inc/header.php"); ?> 
<?php require ("tpl/inc/path.php"); ?> 
  <div id="content"> 
	  <div id="left-col"> 
		  <div id="left-col-border"> 
<?php if (isset ($errors)) require ("tpl/inc/error.php"); ?> 
<?php if (isset ($messages)) require ("tpl/inc/message.php"); ?> 
<?php if (isset ($_SESSION['epClipboard'])) require ("tpl/inc/clipboard.php"); ?> 
<?php require ("tpl/inc/structure.php"); ?> 
			</div> 
		</div> 
		<div id="right-col"> 
			<h2 class="bar green"><span><?php echo  $lang[58] ?></span></h2> 
			<form action=".?id=<?php echo  $id ?>" method="post" enctype="multipart/form-data" > 
        <?php require ("tpl/inc/buttons.php"); ?> 
			<div class="right-col-padding1"> 
				<div class="width-99pct"> 
					<table class="rec-table"> 
				<?php require ("tpl/inc/record.php"); ?>
				<tr>
					<td colspan="4">
						<label>Select Feature Property</label>
						<select name="property" class="textfield width-100pct">
							<option></option>
					<?php                     $properties = dbq("SELECT * FROM `prop_details` WHERE `online` = 1");
                    if (is_array($properties)) {
						foreach ($properties as $p) {
							if ((isset ($_POST['property']) && $_POST['position'] == $p['propid']) || (isset ($record['property']) && $record['property'] == $p['propid'])) {
					   		$selected = ' selected="selected"';
							} else {
								$selected = '';
							}
                        ?>
						<option value="<?php echo $p['propid']; ?>" <?php echo $selected; ?>><?php echo $p['hidden_number']; ?> <?php echo $p['hidden_street']; ?>, <?php echo $p['suburb']; ?></option>
                        <?php                       }
                    }
                    ?>
						</select>
					</td>
				</tr>
              <?php require ("tpl/inc/rights.php"); ?> 
            </table>
	
          </div> 
        </div> 
      </form> 
    </div> 
    <?php require ("tpl/inc/footer.php"); ?> 
  </div> 
</div> 
</body>
</html>
