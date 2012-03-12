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
      <h2 class="bar green"><span><?= $lang[70] ?></span></h2> 
      <form action=".?id=<?= $id ?>" method="post" enctype="multipart/form-data"> 
        <? require ("tpl/inc/buttons.php"); ?> 
        <div class="right-col-padding1"> 
          <div class="width-99pct"> 
            <table class="rec-table"> 
              <? require ("tpl/inc/record.php"); ?> 
              <tr> 
                <td colspan="2"><label><?= $lang[71] ?> &bull;</label><br /> 
                  <input type="file" name="fileId" /></td> 
                <td colspan="2"><label><?= $lang[67] ?></label><br /> 
              <? if (is_file ($cfg['data'] . $id . "-s.jpg")) { ?> 
                  <a href="image-preview.php?image=<?= $cfg['data'] . $id ?>-l.jpg&amp;id=<?= $id ?>&amp;title=<?= urlencode ($record['title']) ?>" class="border" onClick="window.open (this.href, '', '<?= get_js_size ($cfg['data'] . $id . "-l.jpg", 10) ?>'); return (false);"><img src="<?= $cfg['data'] . $id ?>-s.jpg" alt="Preview" <?= get_html_size ($cfg['data'] . $id . "-s.jpg") ?> /></a> 
              <? } else { ?> 
                  <?= $lang[72] ?>
              <? } ?>
			    </td>
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
