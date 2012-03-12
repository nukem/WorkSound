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
      <h2 class="bar green"><span><?= $lang[4] ?></span></h2> 
      <form action="." method="post"> 
        <? require ("tpl/inc/buttons.php"); ?> 
        <div class="right-col-padding2"> 
          <div class="width-99pct"> 
            <p><img src="img/logo-large.gif" alt="<?= $lang[0] ?>" /></p> 
            <p class="spec"><?= $lang[16] ?></p>
   <p><strong><?= $lang[17] ?></strong></p>
            <p><label><?= $lang[7] ?> &bull;</label><br /> 
                  <input type="text" name="title" value="<? if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['title']); else echo $user['title']; ?>" maxlength="20" class="textfield width-200" /> &nbsp; <?= $lang[18] ?> <strong><?= $user['group'] ?></strong>
            </p> 
            <p><label><?= $lang[19] ?></label><br /> 
              <input type="password" name="password1" maxlength="20" class="textfield width-200" /> &nbsp; <input type="password" name="password2" maxlength="20" class="textfield width-200" />
            </p> 
            <p class="spec"><label><?= $lang[13] ?> &bull;</label><br /> 
                  <input type="text" name="email" value="<? if (isset ($_POST['email'])) echo htmlspecialchars ($_POST['email']); else echo $user['email']; ?>" maxlength="255" class="textfield width-200" />
            </p>
			<? if ($user['group'] == 'Developers') { ?>
           <p><a href="log.txt"><?= $lang[116] ?></a></p>
		   <? } ?>

          </div> 
        </div> 
      </form> 
    </div> 
    <? require ("tpl/inc/footer.php"); ?> 
  </div> 
</div> 
</body>
</html>
