<tr>
<td colspan="4">&nbsp;</td>
</tr>
<tr> 
  <td>
  <label><?php echo  $lang[54] ?></label><br /> 
    <select name="viewRights[]" class="width-100pct textfield" size="3" multiple="multiple"> 
      <?php foreach ($groups as $row) { ?> 
      <option value="<?php echo  $row['id'] ?>"<?php if (isset ($_POST['viewRights'])) {if (in_array ($row['id'], $_POST['viewRights'])) echo ' selected="selected"';} elseif (! isset ($_POST['title']) && preg_match("({$row['id']})", $record['viewRights'])) echo ' selected="selected"'; ?>> 
      <?php echo  $row['title'] ?> 
      </option> 
      <?php } ?> 
    </select></td> 
  <td><label><?php echo  $lang[55] ?></label><br /> 
    <select name="createRights[]" class="width-100pct textfield" size="3" multiple="multiple"> 
      <?php foreach ($groups as $row) { ?> 
      <option value="<?php echo  $row['id'] ?>"<?php if (isset ($_POST['createRights'])) {if (in_array ($row['id'], $_POST['createRights'])) echo ' selected="selected"';} elseif (! isset ($_POST['title']) && preg_match("({$row['id']})", $record['createRights'])) echo ' selected="selected"'; ?>> 
      <?php echo  $row['title'] ?> 
      </option> 
      <?php } ?> 
    </select></td> 
  <td><label><?php echo  $lang[56] ?></label><br /> 
    <select name="editRights[]" class="width-100pct textfield" size="3" multiple="multiple"> 
      <?php foreach ($groups as $row) { ?> 
      <option value="<?php echo  $row['id'] ?>"<?php if (isset ($_POST['editRights'])) {if (in_array ($row['id'], $_POST['editRights'])) echo ' selected="selected"';} elseif (! isset ($_POST['title']) && preg_match("({$row['id']})", $record['editRights'])) echo ' selected="selected"'; ?>> 
      <?php echo  $row['title'] ?> 
      </option> 
      <?php } ?> 
    </select></td> 
  <td><label><?php echo  $lang[57] ?></label><br /> 
    <select name="deleteRights[]" class="width-100pct textfield" size="3" multiple="multiple"> 
      <?php foreach ($groups as $row) { ?> 
      <option value="<?php echo  $row['id'] ?>"<?php if (isset ($_POST['deleteRights'])) {if (in_array ($row['id'], $_POST['deleteRights'])) echo ' selected="selected"';} elseif (! isset ($_POST['title']) && preg_match("({$row['id']})", $record['deleteRights'])) echo ' selected="selected"'; ?>> 
      <?php echo  $row['title'] ?> 
      </option> 
      <?php } ?> 
    </select></td> 
</tr> 
