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
      <h2 class="bar green"><span><?php echo  $lang[69] ?></span></h2> 
      <form action=".?id=<?php echo  $id ?>" method="post"> 
        <?php require ("tpl/inc/buttons.php"); ?> 
        <div class="right-col-padding1"> 
          <div class="width-99pct"> 
            <table class="rec-table"> 
              <?php require ("tpl/inc/record.php"); ?>
              <tr>
				<td colspan="4">
					<label for="url">URL. Include "http://" if you wish this to be an external link.</label><br />
					<input type="text" name="url" id="url" class="textfield width-100pct" value="<?php if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['url']); else echo htmlspecialchars ($record['url']); ?>" />
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

