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
      <form action=".?id=<?php echo  $id ?>" method="post" enctype="multipart/form-data">  
        <div class="right-col-padding1"> 
          <div class="width-99pct"> 
            <table class="rec-table"> 
              <tr>
				<td>
				  <div class="blog-main">
					<table class="blog-rec-table">
						<tr>
							<td></td><td></td><td></td><td></td><td><a href="?id=599&entry=1"><h3><img src="images/comment_add.gif" title="New Blog" />&nbsp;New Entry</h3></a></td>
						</tr>
					<?php
						if(isset($blog_list) && $blog_list !== ''){
					?>
						<tr>
							<td><label>Title</label></td><td><label>Author</label></td><td><label>Tags</label></td><td><label>Date</label></td><td style="width: 80px;"><label>Actions</label></td>
						</tr>
					<?php
							$i = 2;
							foreach($blog_list as $blog){
								if(($i % 2)==0)
							    {
							     $bg_color = ' class="blog-bg"';
							    }
							    else
							    {
							     $bg_color = '';
							    }
							    $i++;

								echo '<tr'. $bg_color . '><td><a href="?id=599&action=edit&blog=' . $blog['id'] . '">' . $blog['title'] . '</a></td><td>' . $author[$blog['author']] . '</td><td>' . $blog['tags'] . '</td><td>' . $blog['date'] . '</td><td style="width: 80px;"><a href="?id=599&action=edit&blog=' . $blog['id'] . '"><img src="images/comment_edit.gif" title="Edit Blog" /></a>&nbsp;&nbsp;&nbsp;<a href="?id=599&action=delete&blog=' . $blog['id'] . '"><img src="images/comment_delete.gif" title="Delete Blog" /></a></td></tr>';
							}
						}
					?>
					</table>
				  </div>
				</td>
			  </tr>
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
