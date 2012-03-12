<? require ("tpl/inc/head.php"); ?>
<body onload="document.forms[0].username.focus();"> 
<div id="page"> 
<? require ("tpl/inc/header.php"); ?>
<? require ("tpl/inc/path.php"); ?>
  <div id="content"> 
    <div id="left-col"> 
      <div id="left-col-border"> 
<? if (isset ($errors)) require ("tpl/inc/error.php"); ?>
<? if (isset ($messages)) require ("tpl/inc/message.php"); ?>
      </div> 
    </div> 
    <div id="right-col"> 
      <h2 class="bar green"><span><?= $lang[6] ?></span></h2> 
      <form action="." method="post"> 
        <div class="right-col-padding2"> 
          <div class="width-99pct"> 
            <p class="spec"><img src="img/logo-large.gif" alt="<?= $lang[0] ?>" /></p> 
            <p><label><?= $lang[7] ?> &bull;</label><br /> 
              <input type="text" name="username" value="<? if (isset ($_POST['username'])) echo htmlspecialchars ($_POST['username']); ?>" maxlength="50" class="textfield width-200" /> 
            </p> 
            <p class="spec"><label><?= $lang[8] ?> &bull;</label><br /> 
              <input type="password" name="password" maxlength="20" class="textfield width-200" /> 
            </p> 
            <p> 
              <input type="submit" name="signin" value="<?= $lang[9] ?>" class="button" /> 
            </p> 
            <p><a href=".?newpassword=1"><?= $lang[10] ?></a></p><br />
          </div> 
        </div> 
      </form> 
    </div> 
<? require ("tpl/inc/footer.php"); ?>
  </div> 
</div> 
</body>
</html>
