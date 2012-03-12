<div id="path">
  <p>
  <a href="."><?php echo  $lang[4] ?></a>
  <?php if (isset ($path)) foreach ($path as $row) if ($row[0] != 0) { ?>
  / <a href=".?id=<?php echo  $row[0] ?>"><?php if ($row[1] != '') echo htmlspecialchars ($row[1]); else echo $lang[5]; ?></a>
  <?php } ?>
  </p> 
</div>
<hr />
