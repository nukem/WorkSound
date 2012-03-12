<h2 class="bar yellow"><span><?= $lang[37] ?></span></h2>
<div id="structure"> 
  <div id="structure-padding"> 
    <table> 
      <tr> 
        <td><table> 
            <tr> 
              <td class="thread b"><img src="img/ico-rec/home.gif" alt="Home" width="16" height="14" /></td> 
              <td><? if ($id == 0) echo '<strong>'; ?><a href="."><?= $lang[4] ?></a><? if ($id == 0) echo '</strong>'; ?></td> 
            </tr> 
          </table></td> 
      </tr> 
<? 

function makeStructure ($parent, $prefix, $sort) {
 global $user, $id, $path, $cfg, $lang;
 
 $db = dbq ("SELECT id, title, type, online, sort FROM {$cfg['db']['prefix']}_structure WHERE parent = $parent AND viewRights LIKE '%({$user['parent']})%' ORDER BY $sort");
 
 if (is_array ($db))
  for ($i = 0; $i < count ($db); $i ++) {
           echo '<tr><td><table><tr>';
           echo $prefix;
   if (isset ($db[$i + 1]))  echo '<td class="thread trb">&nbsp;&nbsp;</td>';
   else       echo '<td class="thread tr">&nbsp;&nbsp;</td>';
   if (in_array (array ($db[$i]['id'], $db[$i]['title']), $path) && dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$db[$i]['id']}"))
           echo '<td class="thread bl">';
   else       echo '<td class="thread l">';
   
   if (file_exists('img/ico-rec/' . $db[$i]['type'] . '.gif'))  
		echo '<img src="img/ico-rec/' . $db[$i]['type'] . '.gif" alt="' . ucfirst ($db[$i]['type']) . '" /></td><td>';
	else echo '<img src="img/ico-rec/folder.gif" alt="' . ucfirst ($db[$i]['type']) . '" /></td><td>';
   
   if ($db[$i]['id'] == $id)  echo '<strong>';
   if ($db[$i]['online'] == 0)  echo '<em>';
   if($user['parent'] == '970'){
   $sql = "SELECT * FROM user WHERE email = '".$_SESSION['epUser']['title']."'";
   $test = dbq ($sql);
   echo '<a href=".?id=' . $db[$i]['id'] . '&aid='.$test[0]['id'].'">' . htmlspecialchars ($db[$i]['title']) . '</a>';
   }
   else if ($db[$i]['title'] != '')  echo '<a href=".?id=' . $db[$i]['id'] . '">' . htmlspecialchars ($db[$i]['title']) . '</a>';
   else       echo '<a href=".?id=' . $db[$i]['id'] . '">' . $lang[5] . '</a>';
   if ($db[$i]['online'] == 0)  echo '</em>';
   if ($db[$i]['id'] == $id)  echo '</strong>';
           echo '</td></tr></table></td></tr>';
   if (in_array (array ($db[$i]['id'], $db[$i]['title']), $path) && dbq ("SELECT * FROM {$cfg['db']['prefix']}_structure WHERE parent = {$db[$i]['id']}"))
    if (isset ($db[$i + 1])) makeStructure ($db[$i]['id'], $prefix . '<td class="thread tb">&nbsp;&nbsp;</td>', $db[$i]['sort']);
    else      makeStructure ($db[$i]['id'], $prefix . '<td class="thread">&nbsp;&nbsp;</td>', $db[$i]['sort']);
  }
}

makeStructure (0, "", "position");
  
?> 
    </table> 
  </div> 
</div>
<hr /> 
