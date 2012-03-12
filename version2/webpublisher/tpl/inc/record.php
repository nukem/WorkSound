<tr>
	<td colspan="3"><label><?php echo  $lang[38] ?> &bull;</label><br /> 
		<input type="text" name="title" id="title" value="<?php if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['title']); else echo htmlspecialchars ($record['title']); ?>" maxlength="255" class="textfield width-100pct" /></td> 
	<td><input type="hidden" name="sort" value="position" />
		<label><?php echo  $lang[51] ?></label><br />
		<select name="position" class="width-100pct textfield"> 
			<option value="<?php echo  $positions[0]['position'] ?>"<?php if ((isset ($_POST['title']) && $_POST['position'] == $positions[0]['position']) || (! isset ($_POST['title']) && $positions[0]['id'] == $id)) echo ' selected="selected"'; ?>><?php echo  $lang[52] ?></option> 
			<?php for ($i = 0; $i < count ($positions); $i ++) if ($positions[$i]['id'] != $id) { ?> 
			<option value="<?php echo  $positions[$i]['position'] + 1 ?>"<?php if ((isset ($_POST['title']) && $_POST['position'] == $positions[$i]['position'] + 1) || (! isset ($_POST['title']) && isset ($positions[$i + 1]['id']) && $positions[$i + 1]['id'] == $id)) echo ' selected="selected"'; ?>><?php echo  $lang[53] ?>
			<?php if ($positions[$i]['title'] != '') echo $positions[$i]['title']; else echo $lang[5]; ?> 
			</option> 
			<?php } ?> 
	</select></td> 
</tr>
<!-- 
<tr>
	<td></td> 
	<td><label><?php echo  $lang[49] ?></label><br />
		<?php echo  preg_replace('^(.*)-(.*)-(.*) (.*):(.*):(.*)$', '\\3/\\2/\\1 \\4:\\5', $record['created']) ?></td> 
	<td><label><?php echo  $lang[50] ?></label><br />
		<?php echo  preg_replace('^(.*)-(.*)-(.*) (.*):(.*):(.*)$', '\\3/\\2/\\1 \\4:\\5', $record['modified']) ?></td> 
	<td></td> 
</tr>
-->
