<?php 
ini_set("display_errors",1);
$loadMCE=true;
?>
<?php require ("tpl/inc/head.php"); ?>
<body> 
<style>
#right-col table td{ padding: 5px 0 5px 0px; color:#333333;}
</style> 
<script>
$(function(){
	$('#create').click(function(){
		$('#frm').show();
		remover();
	});
	function remover(){
		$('#faq_id').val(0);
		tinyMCE.activeEditor.setContent('');
		$('#faq_title').val('');
	}
	$('.faqTitle').click(function(){
		$('#frm').show();
		$('#faq_id').val($(this).attr('id'));
		$t=$(this).parents('.faqs');
		$('#faq_title').val($t.find('.ftitle').text());
		$content=$t.find('.fdescription').html()
		tinyMCE.activeEditor.setContent($content);
	});
	$('#save').click(function(){
		$content=tinyMCE.activeEditor.getContent({format : 'raw'});
		
		$('#frm').hide();
		$('#load').html('Loading...');
		$.post('faq.php',{'faq_id':$('#faq_id').val(),'faq_title':$('#faq_title').val(),'description':$content},function(data){//alert(data);
				window.location.href=window.location.href;
		});
	});
});
</script>
<div id="page">
<?php
require ("tpl/PHPLiveX.php");
$ajax = new PHPLiveX();
class FAQ {
	function activate($id='',$value=''){
			mysql_query("update faq set active='$value' where faq_id='$id'");
	}
}
$faq = new FAQ();
$ajax->AjaxifyObjects(array("faq"));
$ajax->run('tpl/phplivex.js');
?>
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
			<h2 class="bar green"><span><?php echo  $record['title'] ?></span></h2> 
			<form action=".?id=<?php echo  $id ?>" method="post" enctype="multipart/form-data" id="faq"> 
        <?php //require ("tpl/inc/buttons.php"); ?> 
		<p class="buttons">
		<input type="button" name="save" value="<?= $lang[20] ?>" class="button" id="save" />
		<input type="button" name="create" id="create" value="<?= $lang[26] ?>" class="button" />
		</p>
			<div class="right-col-padding1"> 
				<div class="width-99pct"  id='load' style="display:none;" ></div>
				<a id="#"></a>
				<div class="width-99pct"  id='frm' style="display:none;" >
					<table>
							<tr>
								<td ><label>FAQ Title :</label></td>
								<td>
								<input type="hidden" value="0" id="faq_id" name="faq_id"/>
								<input style="width:400px;" class="textfield width-200px" id="faq_title" value="<?php echo $row['faq_title']?>" type="text" name="faq_title" maxlength="500" ></td>
							</tr>
							<tr>
								<td valign="top"><label>FAQ Description :</label></td>
								<td valign="top"><textarea class="textfield height-200 tinymce" id="description" name="description"><?php echo $row['description'];?></textarea></td>
							</tr>
							
							<tr>
								<td>&nbsp;</td>
								<td><a href="javascript: void(0);" onclick="$('#frm').hide();remover();">Cancel</td>
							</tr>
							
					</table>
				</div>				 
		  <div id="div_list">
			<table width="100%" >
			<tr ><td><h4>FAQ Title</h4></td><td><h4>FAQ Description</h4></td><td><h4>Active</h4></td></tr>
			<?php
			 $sql="select * from faq order by faq_id asc";
			 $result = mysql_query($sql);
 		 	 while($row=mysql_fetch_array($result))
			{	
			?>
			<tr class="faqs">
			<?php $id=$row['faq_id'];?>
			<td width="25%" class="ftitle"><a href="javascript:void(0);" id="<?php echo $id;?>" class="faqTitle <?php echo $id;?>"><?php echo $row['faq_title']; ?></a></td>
			<td width="50%" class="fdescription"><?php echo $row['description']; ?></td>
			<td width="25%"><input type="checkbox" <?php if($row[active]==1) echo 'checked="checked"'; ?>  onclick="if(this.checked) faq.activate(<?php echo $row['faq_id']; ?>,1,{});
																														else faq.activate(<?php echo $row['faq_id']; ?>,0,{});"/></td>
			</tr>
		  <?php }
		  ?>
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

