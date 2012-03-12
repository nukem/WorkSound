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
      </div> 
    </div> 
    <div id="right-col"> 
      <h2 class="bar green"><span><?= $lang[11] ?></span></h2> 
      <form action=".?newpassword=1" method="post"> 
        <div class="right-col-padding2"> 
          <div class="width-99pct"> 
            <p class="spec"><?= $lang[12] ?></p> 
            <p><label><?= $lang[7] ?> &bull;</label><br /> 
              <input type="text" name="username" value="<? if (isset ($_POST['username'])) echo htmlspecialchars ($_POST['username']); ?>" maxlength="20" class="textfield width-200" /> 
            <p class="spec"><label><?= $lang[13] ?> &bull;</label><br /> 
              <input type="text" name="email" value="<? if (isset ($_POST['email'])) echo htmlspecialchars ($_POST['email']); ?>" maxlength="255" class="textfield width-200" /> 
            </p> 
            <p> 
              <input type="submit" name="send" value="<?= $lang[14] ?>" class="button" /> 
            </p> 
            <p><a href="."><?= $lang[15] ?></a></p>
          </div> 
        </div> 
      </form> 
    </div> 
<? require ("tpl/inc/footer.php"); ?>
  </div> 
</div> 
</body>
</html>
