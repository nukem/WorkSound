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
      <h2 class="bar green"><span><?php echo  $lang[70] ?></span></h2> 
      <form action=".?id=<?php echo  $id ?>" method="post" enctype="multipart/form-data"> 
        <?php require ("tpl/inc/buttons.php"); ?> 
        <div class="right-col-padding1"> 
          <div class="width-99pct"> 
            <table class="rec-table"> 
              <?php require ("tpl/inc/record.php"); ?>
              <tr>
                <td colspan="4"><label>URL &bull; (Full site address with http://)</label><br />
                    <input type="text" name="url" class="textfield width-100pct" value="<?php if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['url']); else echo htmlspecialchars ($record['url']); ?>" />
                </td>
            </tr>
            <tr>
                <td colspan="4"><label>Content &bull;</label><br />
                    <textarea name="content" class="textfield width-100pct height-100"><?php if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['content']); else echo htmlspecialchars ($record['content']); ?></textarea>
                </td>
            </tr>
                
              <tr> 
                <td colspan="2"><label><?php echo  $lang[71] ?> &bull;</label><br /> 
                  <input type="file" name="fileId" /></td> 
                <td colspan="2"><label><?php echo  $lang[67] ?></label><br /> 
              <?php if (is_file ($cfg['data'] . $id . "-s.jpg")) { ?> 
                  <a href="image-preview.php?image=<?php echo  $cfg['data'] . $id ?>-l.jpg&amp;id=<?php echo  $id ?>&amp;title=<?php echo  urlencode ($record['title']) ?>" class="border" onClick="window.open (this.href, '', '<?php echo  get_js_size ($cfg['data'] . $id . "-l.jpg", 10) ?>'); return (false);"><img src="<?php echo  $cfg['data'] . $id ?>-s.jpg" alt="Preview" <?php echo  get_html_size ($cfg['data'] . $id . "-s.jpg") ?> /></a> 
              <?php } else { ?> 
                  <?php echo  $lang[72] ?>
              <?php } ?>
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
