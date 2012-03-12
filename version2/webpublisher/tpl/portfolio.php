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
                <td> 
				  <label>Value</label><br />
				  <input type="text" name="value" value="<?php if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['value']); else echo htmlspecialchars ($record['value']); ?>" class="textfield width-100pct" />
                </td>
				<td> 
				  <label>Architect</label><br />
				  <input type="text" name="architect" value="<?php if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['architect']); else echo htmlspecialchars ($record['architect']); ?>" class="textfield width-100pct" />
                </td>
				<td> 
				  <label>Engineer</label><br />
				  <input type="text" name="engineer" value="<?php if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['engineer']); else echo htmlspecialchars ($record['engineer']); ?>" class="textfield width-100pct" />
                </td>
				<td>&nbsp;</td>
              </tr>
              <tr> 
                <td colspan="2"> 
				<label>Details</label><br />
         <textarea name="details" cols="30" rows="8" class="textfield tinymce width-100pct"><?php if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['details']); else echo htmlspecialchars ($record['details']) ?></textarea>
                </td>
				<td colspan="2"> 
				<label>Construction</label><br />
         <textarea name="construction" cols="30" rows="8" class="textfield tinymce width-100pct"><?php if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['construction']); else echo htmlspecialchars ($record['construction']) ?></textarea>
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
