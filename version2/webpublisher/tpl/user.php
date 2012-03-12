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
      <h2 class="bar green"><span><?= $lang[73] ?></span></h2> 
      <form action=".?id=<?= $id ?>" method="post"> 
        <? require ("tpl/inc/buttons.php"); ?> 
        <div class="right-col-padding1"> 
          <div class="width-99pct"> 
            <table class="rec-table"> 
              <tr> 
                <td><label><?= $lang[7] ?> &bull;</label><br /> 
                  <input type="text" name="title" value="<? if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['title']); else echo $record['title']; ?>" maxlength="50" class="textfield width-100pct" /></td> 
                <td><label><?= $lang[19] ?></label><br /> 
                  <input type="password" name="password1" maxlength="20" class="textfield width-100pct" /></td> 
                <td>&nbsp;<br /> 
                  <input type="password" name="password2" maxlength="20" class="textfield width-100pct" /></td> 
                <td>&nbsp;</td> 
              </tr> 
              <tr> 
                <td><label><?= $lang[47] ?></label><br /> 
                  <input type="checkbox" name="online" value="1"<? if (isset ($_POST['online']) || (! isset ($_POST['title']) && $record['online'] == 1)) echo ' checked="checked"'; ?> /></td> 
  <td><label><?= $lang[49] ?></label><br />
  <?= preg_replace ('/^(.*)-(.*)-(.*) (.*):(.*):(.*)$/', '\\3/\\2/2006 \\4:\\5', $record['created']) ?></td> 
  <td><label><?= $lang[50] ?></label><br />
  <?= preg_replace ('/^(.*)-(.*)-(.*) (.*):(.*):(.*)$/', '\\3/\\2/2006 \\4:\\5', $record['modified']) ?></td> 
                <td><label><?= $lang[51] ?></label><br /> 
                  <select name="position" class="textfield width-100pct"> 
                    <option value="<?= $positions[0]['position'] ?>"<? if ((isset ($_POST['title']) && $_POST['position'] == $positions[0]['position']) || (! isset ($_POST['title']) && $positions[0]['id'] == $id)) echo ' selected="selected"'; ?>><?= $lang[52] ?></option> 
                    <? for ($i = 0; $i < count ($positions); $i ++) if ($positions[$i]['id'] != $id) { ?> 
                    <option value="<?= $positions[$i]['position'] + 1 ?>"<? if ((isset ($_POST['title']) && $_POST['position'] == $positions[$i]['position'] + 1) || (! isset ($_POST['title']) && isset ($positions[$i + 1]['id']) && $positions[$i + 1]['id'] == $id)) echo ' selected="selected"'; ?>><?= $lang[53] ?>
                    <? if ($positions[$i]['title'] != '') echo $positions[$i]['title']; else echo $lang[5]; ?> 
                    </option> 
                    <? } ?> 
                  </select></td> 
              </tr> 
              <tr> 
                <td colspan="2"><label><?= $lang[13] ?> &bull;</label><br /> 
                  <input type="text" name="email" value="<? if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['email']); else echo $record['email']; ?>" maxlength="255" class="textfield width-100pct" /></td> 
                <td colspan="2"><label><?= $lang[74] ?></label><br /> 
                  <input type="text" name="name" value="<? if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['name']); else echo htmlspecialchars ($record['name']); ?>" maxlength="255" class="textfield width-100pct" /></td> 
              </tr> 
              <? require ("tpl/inc/rights.php"); ?> 
            </table> 
          </div> 
        </div> 
      </form> 
    </div> 
    <? require ("tpl/inc/footer.php"); ?> 
  </div> 
</div> 
</body>
</html>
