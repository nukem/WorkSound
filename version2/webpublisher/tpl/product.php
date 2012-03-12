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
      <h2 class="bar green"><span><?php echo  $lang[65] ?></span></h2> 
      <form action=".?id=<?php echo  $id ?>" method="post" enctype="multipart/form-data"> 
        <?php require ("tpl/inc/buttons.php"); ?> 
        <div class="right-col-padding1"> 
          <div class="width-99pct"> 
            <table class="rec-table"> 
              <?php require ("tpl/inc/record.php"); ?> 
			  <tr> 
                <td> <label>Product Code &bull;</label><br /> 
                  <input type="text" name="code" value="<?php if (isset ($_POST['title'])) echo $_POST['code']; else echo $record['code']; ?>" class="textfield width-100pct" />				</td> 
				<td><label>Price &bull;</label>
                  <br />
                  <input type="text" name="price" value="<?php if (isset ($_POST['title'])) echo $_POST['price']; else echo $record['price']; ?>" class="textfield width-100pct" /></td>
				<td><label>Available Quantity &bull;</label>
                  <br>
                  <input name="available" type="text" class="textfield width-100pct" id="available" value="<?php if (isset ($_POST['title'])) echo $_POST['available']; else echo $record['available']; ?>" maxlength="50" /></td>
			    <td><label>Weight(gms) &bull;</label>
                  <br>
                  <input type="text" name="weight" class="textfield width-100pct" value="<?php if (isset ($_POST['title'])) echo $_POST['weight']; else echo $record['weight']; ?>" maxlength="50" /></td>
			  </tr>
			  <tr>
                <td><label>Boy's Shoes </label>
                  <br />
				  <input name="boyshoe" type="checkbox" id="boyshoe" value="1"<?php if (isset ($_POST['boyshoe']) || (! isset ($_POST['title']) && $record['boyshoe'] == 1)) echo ' checked="checked"'; ?> />
				</td>
                <td><label>Girl's Shoes </label>
                  <br /> 
				  <input name="girlshoe" type="checkbox" id="girlshoe" value="1"<?php if (isset ($_POST['girlshoe']) || (! isset ($_POST['title']) && $record['girlshoe'] == 1)) echo ' checked="checked"'; ?> />
				</td>
				  <td><label>On Sale</label>
				    <br />
				  <input name="onsale" type="checkbox" id="onsale" value="1"<?php if (isset ($_POST['onsale']) || (! isset ($_POST['title']) && $record['onsale'] == 1)) echo ' checked="checked"'; ?> />
				  </td>
				  <td>&nbsp; </td>
			  </tr> 
			  <tr> 
                <td colspan="4"> 
				<label>Product Description</label><br />
         <textarea name="description" cols="30" rows="10" class="textfield width-100pct tinymce"><?php if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['description']); else echo htmlspecialchars (preg_replace('/src="/', 'src="../', $record['description'])); ?></textarea>                </td> 
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