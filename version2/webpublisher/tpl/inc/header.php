<div id="header"> 
  <div> 
    <div> 
      <div> 
        <div> 
          <div> 
            <h1><?php echo  $lang[0] ?></h1> 
<?php if (isset ($user)) { ?>
            <p><strong><a href="."><?php echo  $user['title'] ?></a></strong> (<?php echo  $user['group'] ?>) &nbsp;|&nbsp; <a href=".?signout=1"><?php echo  $lang[3] ?></a></p> 
<?php } else { ?>
            <p>&nbsp;</p> 
<?php } ?>
          </div> 
        </div> 
      </div> 
    </div> 
  </div> 
</div>
<hr /> 
