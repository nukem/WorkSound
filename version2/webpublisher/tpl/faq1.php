<?php require ("tpl/PHPLiveX.php"); ?>
<?php 
ini_set("display_errors",1);
class FAQ { 
	function add_edititFAQ($runat,$faq_id=0,$faq_title='',$description=''){
		ob_start();
		switch($runat){
		case 'local':
				$sql="select * from faq  where faq_id=$faq_id";
				$result = mysql_query($sql);
				$row=mysql_fetch_array($result);
					?>
					<input id="faq_id" value="<?php echo $row['faq_id']?>"  name="faq_id" type="hidden">
					<table>
							<tr>
								<td ><label>FAQ Title :</label></td>
								<td><input class="textfield width-200px" id="faq_title" value="<?php echo $row['faq_title']?>" type="text" name="faq_title" maxlength="500" ></td>
							</tr>
							<tr>
								<td valign="top"><label>FAQ Description :</label></td>
								<td valign="top"><textarea class="textfield" id="description" name="description" style="width:300px;"><?php echo $row['description'];?></textarea></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td><a href="javascript: void(0);" onclick="document.getElementById('frm').innerHTML='' ">Cancel</td>
							</tr>
							
					</table>
					<?php
					break;
		case 'server': 
					if($faq_id > 0)
						$sql="update faq set faq_title='$faq_title', description='$description' where faq_id='$faq_id'";
					else 
						$sql="INSERT INTO faq (faq_title,description) VALUES('$faq_title','$description')";
					
					if(trim($faq_title) !='') mysql_query($sql);
					break;
		}
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
		
	}
	
	function updateActive($faq_id,$value){
		ob_start();
		mysql_query("update faq set active='$value' where faq_id='$faq_id'");
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	function listFAQ(){
		ob_start();
		?>
		<table width="100%" >
			<tr ><td><h4>FAQ Title</h4></td><td><h4>FAQ Description</h4></td><td><h4>Active</h4></td></tr>
			 <?php
			 $sql="select * from faq order by faq_id asc";
			 $result = mysql_query($sql);
 		 	 while($row=mysql_fetch_array($result))
			{	
			?>
			<tr>
			<?php $id=$row['faq_id'];?>
			<td width="25%"><a href="javascript: void(0);" 
						onclick="faq.add_edititFAQ('local','<?php echo $row['faq_id'];?>',{target:'frm'});"><?php echo $row['faq_title']; ?></a></td>
			<td width="50%"><?php echo $row['description']; ?></td>
			<td width="25%"><input type="checkbox" <?php if($row[active]==1) echo 'checked="checked"'; ?>
									onchange="javascript: if(this.checked) 
															faq.updateActive(<?php echo $row['faq_id'];?>,1,{onUpdate: function(response,root){
																					faq.listFAQ({target:'div_list'});
																					}
																				});
														else 
															faq.updateActive(<?php echo $row['faq_id'];?>,0,{onUpdate: function(response,root){
																					faq.listFAQ({target:'div_list'});
																					}
																				});" /></td>
			</tr>
		  <?php }
		  ?>
		</table>
		<?php
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}

$faq = new FAQ();
require ("tpl/inc/head.php");
$ajax = new PHPLiveX();
$ajax->AjaxifyObjects(array("faq")); 
$ajax->Run("tpl/phplivex.js"); // Must be called inside the 'html' or 'body' tags  
?>
<body> 
<style>
#right-col table td{ padding: 5px 0 5px 0px; color:#333333;}
</style> 
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
			<h2 class="bar green"><span><?php echo  $record['title'] ?></span></h2> 
			<form action=".?id=<?php echo  $id ?>" method="post" enctype="multipart/form-data" > 
        <?php //require ("tpl/inc/buttons.php"); ?> 
		<p class="buttons">
		<input type="button" name="save" value="<?= $lang[20] ?>" class="button" onClick="javascript: if(1){
																			faq.add_edititFAQ('server',document.getElementById('faq_id').value,document.getElementById('faq_title').value,
																				document.getElementById('description').value,
																				{ onUpdate: function(response,root){
																					document.getElementById('frm').innerHTML= response;
																					faq.listFAQ({target:'div_list'});
																				}});
																			}" />
		<input type="button" name="create" value="<?= $lang[26] ?>" onClick="faq.add_edititFAQ('local',{target:'frm'});" class="button" />
		</p>
			<div class="right-col-padding1"> 
				<div class="width-99pct"  id='frm' > </div>				 
		  <div id="div_list">
			<?php echo $faq->listFAQ();?>
		  </div> 
        </div> 
      </form> 
	  
    </div> 
    <?php require ("tpl/inc/footer.php"); ?> 
  </div> 
</div> 
<script>
$(function(){
	remover();
	$('#add_row').click(function(){
		$('.this').removeClass('this');
		$tr=$('.add').clone();
		var tr='<tr class="empty"><td>&nbsp;</td></tr><tr class="additional this">'+$tr.html()+'</tr>';
		$('#featured_properties').append(tr);
		$('.this').find('select option').removeAttr('selected');
		$('.this').find('input:text').val('');
		remover();
	});
});
function remover(){
	$('#featured_properties a').click(function(){
		if($('#featured_properties .additional').size()<=1) return false;
		$(this).parents('.additional').remove();
	});
}
</script>
</body>
</html>

