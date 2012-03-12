 <p class="buttons">
  <?php if (preg_match("({$user['parent']})", $record['editRights']) || $id == 0) { ?> 
	  <?php if ($id != 0) { ?>
	  <input type="checkbox" id="online" name="online" value="1"<?php if (isset ($_POST['online']) || (! isset ($_POST['title']) && $record['online'] == 1)) echo ' checked="checked"'; ?> /> &nbsp;<label for="online"><?php echo  $lang[47] ?></label>&nbsp;
	  <?php } ?>
  <input type="submit" name="save" value="<?php echo  $lang[20] ?>" class="button" /> &nbsp;
  <?php } ?> 
  <?php if (preg_match("({$user['parent']})", $record['createRights']) && $record['type'] != 'user' && $record['type'] != 'webuser') { ?> 
  <select name="createType" class="textfield"> 
    <?php if ($record['parent'] == 1) { ?> 
    <option value="user"><?php echo  $lang[21] ?></option> 
    <?php } ?> 
    <?php if ($record['parent'] != 1 && $id != 571) { ?> 
    <option value="folder"><?php echo  $lang[22] ?></option> 
    <?php } ?> 
    <?php if ($record['parent'] != 1 && $id != 1 && $id != 0) { ?> 
	<option value="menu">New Menu Item</option>
    <option value="article"><?php echo  $lang[23] ?></option> 
    <option value="image"><?php echo  $lang[24] ?></option> 
	<option value="office">New Office</option>
	<option value="agent">New Agent</option>
	<option value="video">New Video</option>
	<?php if ($record['id'] == 194219) { ?> 
	<!--<option value="email_template">New Email Template</option>-->
	
    <?php } ?>
    <?php } ?>
  </select>
  <?php if($record['type'] != 'webuser'){ ?>
  <select name="times" class="textfield">
  	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
  </select>
  <input type="hidden" name="currid" value="<?php if( isset($record['id']) ) { echo $record['id']; }else{ echo '0'; } ?>" />
  <input type="submit" name="create" value="<?php echo  $lang[26] ?>" class="button" /> 
  <?php } ?>
  <?php if (isset ($_SESSION['epClipboard']) && $record['parent'] != 1 && $id != 1 && $id != 0) { ?>
  <input type="submit" name="paste<?php if (isset($_SESSION['clipboardCopy']) && $_SESSION['clipboardCopy'] === true) echo 'Copy' ?>" value="<?php echo  $lang[27] ?>" class="button" /> 
  <?php } ?>
  <?php } ?> 
  <?php if (preg_match("({$user['parent']})", $record['deleteRights'])) { ?> 
  <?php if (! isset ($_SESSION['epClipboard']) && $record['type'] != 'user' && $record['parent'] != 1 && $id != 1) { ?>
  <input type="submit" name="cut" value="<?php echo  $lang[28] ?>" class="button" /> 
  	<?php if ($record['type'] == 'article') { ?>
	<input type="submit" name="copy" value="Copy" class="button" /> 
	<?php } ?>
  <?php } ?>
  <input type="submit" name="delete" value="<?php echo  $lang[29] ?>" class="button" onclick="if (! window.confirm ('<?php echo  $lang[31] ?>')) return (false);" /> 
  <?php } ?> 
</p>
