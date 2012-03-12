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
      <h2 class="bar green"><span>Agency Blog</span></h2> 
      <!--<form action=".?id=<?php echo  $id ?>" method="post" enctype="multipart/form-data">-->  
        <div class="right-col-padding1"> 
          <div class="width-99pct"> 
            <!--table class="rec-table"> 
              <tr>
				<td-->
				  <div class="blog-main">
					<?php
						if (isset($blog_errors)) foreach ($blog_errors as $err)
						{
							echo $err, '<br />';	
						}
					?>
					<form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
						<table class="blog-rec-table">
						  <tr>
							<td colspan="3">
							  <label>Title*</label><br />
							  <input type="text" class="textfield width-100pct" name="title" value="<?php if (isset($_POST['create_blog'])) echo htmlentities($_POST['title'], ENT_QUOTES); else if (isset ($edit_blog['0']['title'])) echo htmlentities($edit_blog['0']['title'], ENT_QUOTES); ?>" />
							</td>
						  </tr>
						  <tr>
							<td>
							  <label>Online</label><br />
							  <input type="checkbox" name="online" value="1"<?php if (isset($_POST['online']) && $_POST['online'] == 1) echo ' checked="checked"'; elseif (isset($edit_blog['0']['online']) && $edit_blog['0']['online'] == 1) echo ' checked="checked"'; ?> />
							</td>
							<td>
							  <label>Author*</label><br />
							  <select class="textfield width-100pct" name="author">
							    <?php
							    foreach($agents as $agent){
							    ?>
							     <option value = "<?php echo $agent['id']; ?>" <?php if(isset($_POST['create_blog']) && $_POST['author'] == $agent['id']) echo 'selected="selected"'; elseif(isset ($edit_blog['0']['tags']) && $edit_blog['0']['author'] == $agent['id']) echo 'selected="selected"'; ?>><?php echo $agent['title']; ?></option>
							    <?php
							    }							    
							    ?>
							  </select>
							</td>
							<td>
							  <label>Tags</label><br />
							  <input type="text" class="textfield width-100pct" name="tags" value="<?php if (isset($_POST['create_blog'])) echo htmlentities($_POST['tags'], ENT_QUOTES); else if (isset ($edit_blog['0']['tags'])) echo htmlspecialchars ($edit_blog['0']['tags']); ?>" />
							</td>
						  </tr>
			              <tr> 
			                <td colspan="3"> 
							<label><?php echo  $lang[59] ?></label><br />
			         		<textarea name="content" cols="30" rows="10" class="textfield height-200 tinymce"><?php if (isset($_POST['create_blog'])) echo htmlentities($_POST['content'], ENT_QUOTES); else if (isset($edit_blog['0']['content'])) echo htmlspecialchars ($edit_blog['0']['content']); ?></textarea>
			                </td> 
			              </tr>
			              <tr>
			              	<td></td><td></td><td><input style="float: right;" class="button" type="submit" value="<?php echo (isset($_GET['blog'])) ? 'Save' : 'Create' ?>" name="create_blog" /></td>
	              		  </tr>
						</table>
					</form>
					
					<table class="blog-rec-table">
					<?php
						if(isset($blog_comments) && is_array($blog_comments) && $blog_comments !== ''){
					?>
					<?php
							foreach($blog_comments as $comment){
								echo '<tr class="border-bottom"><td><label>Date</label></td><td><label>User</label></td><td><label>Website</label></td><td><a href="?id=599&action=comdelete&blog=' . $_GET['blog'] . '&comment=' . $comment['recId'] . '"><img src="images/comments_delete.gif" title="Delete Comment" /></a></td></tr>
								<tr class="blog-bg"><td>' . $comment['date'] . '</td><td>' . $comment['user'] . '</td><td>' . $comment['website'] . '</td><td></td></tr>
								<tr class="blog-bg"><td colspan="4"><label>Content</label><br />' . $comment['content'] . '</td></tr>
								<tr><td colspan="4">&nbsp;</td></tr>';
							}
						}
					?>
					</table>
				  </div>
				<!--/td>
			  </tr>
            </table--> 
          </div> 
        </div> 
      <!--</form>--> 
    </div> 
    <?php require ("tpl/inc/footer.php"); ?> 
  </div> 
</div> 
</body>
</html>
