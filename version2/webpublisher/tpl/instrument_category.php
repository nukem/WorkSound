 <?php require ("tpl/PHPLiveX.php"); ?>
<?php 
ini_set("display_errors",1);
class Instrument { 
	function add_edititInstrumentCategory($runat,$instrument_category_id=0,$instrument_category='',$description=''){
		ob_start();
		switch($runat){
		case 'local':
				$sql="select * from instrument_category where instrument_category_id=$instrument_category_id";
				$result = mysql_query($sql);
				$row=mysql_fetch_array($result);
					?>
					<input id="instrument_category_id" value="<?php echo $row['instrument_category_id']?>"  name="instrument_category" type="hidden">
					<table>
							<tr>
								<td ><label>Instrument Category :</label></td>
								<td><input class="textfield width-200px" id="instrument_category" value="<?php echo $row['instrument_category']?>" instrument_category="text" name="instrument_category" maxlength="255" ></td>
							</tr>
							<tr>
								<td valign="top"><label>Description :</label></td>
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
					if($instrument_category_id > 0)
						$sql="update instrument_category set instrument_category='$instrument_category', description='$description' where instrument_category_id='$instrument_category_id'";
					else 
						$sql="INSERT INTO instrument_category(instrument_category,description) VALUES('$instrument_category','$description')";
					
					
					if(trim($instrument_category) !='') mysql_query($sql);
					break;
		}
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
		
	}
	
	function updateActive($instrument_category_id,$value){
		ob_start();
		mysql_query("update instrument_category set active='$value' where instrument_category_id='$instrument_category_id'");
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	function listInstrumentCategory(){ 
		ob_start();
		?>
		<script type="text/javascript">
		function draggable_control(){
			$(document).ready(function(){
			
				$("#tb_repeat tbody").tableDnD({
					onDrop: function(table, row) {
						var orders = $.tableDnD.serialize();
						document.getElementById('ama').value=orders;
						return orders;
						//$.post('artist_type.php', { orders : orders });
						//alert($.post('artist_type.php'));
						
					}
			
			})
			});
		}
		draggable_control();
		</script>		
		<table width="100%" id="tb_repeat">
			<thead><tr ><td><h4>Instrument Category</h4></td><td><h4>Description</h4></td><td><h4>Active</h4></td></tr></thead>
			<tbody> <?php
			 $sql="select * from instrument_category order by `order`";
			 $result = mysql_query($sql);
 		 	 while($row=mysql_fetch_array($result))
			{	
			?>
			<tr id="order_<?php echo $row['instrument_category_id']; ?>">
			<?php $id=$row['instrument_category_id'];?>
			<td width="25%"><a href="javascript: void(0);" 
						onclick="instrument.add_edititInstrumentCategory('local','<?php echo $row['instrument_category_id'];?>',{target:'frm'});"><?php echo $row['instrument_category']; ?></a></td>
			<td width="50%"><?php echo $row['description']; ?></td>
			<td width="25%"><input type="checkbox" <?php if($row[active]==1) echo 'checked="checked"'; ?>
									onchange="javascript: if(this.checked) 
															instrument.updateActive(<?php echo $row['instrument_category_id'];?>,1,{onUpdate: function(response,root){
																					instrument.listInstrumentCategory({onUpdate:
																						function(response,root){
																							
																							draggable_control();
																						}});
																					}
																				});
														else 
															instrument.updateActive(<?php echo $row['instrument_category_id'];?>,0,{onUpdate: function(response,root){
																					instrument.listInstrumentCategory({onUpdate:
																						function(response,root){
																							
																							draggable_control();
																						}});
																					}
																				});" /></td>
			</tr>
		  <?php }
		  ?>
		  </tbody>
		</table>
		<?php
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	function updateorder($roworder){
	
	ob_start();
	//print_r('aman'.$roworder) ;
	$orders = explode('&', $roworder);
	//print_r($orders);
	$array = array();
	
		foreach($orders as $item) {
			$item = explode('=', $item);
			$item = explode('_', $item[1]);
			$array[] = $item[1];
			
		}
	
		foreach($array as $key => $value) {
			$key = $key + 1;
			//print_r($value);
			$sql = "UPDATE `instrument_category` 
				   SET `order` = '$key'
				   WHERE `instrument_category_id` = '$value'";
			mysql_query($sql);
			//$objDb->prepare($sql)->execute(array($key, $value));		
		}
		 $html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}

$instrument = new Instrument();
require ("tpl/inc/head.php");
$ajax = new PHPLiveX();
$ajax->AjaxifyObjects(array("instrument")); 
$ajax->Run("tpl/phplivex.js"); // Must be called inside the 'html' or 'body' tags  
?>
<body> 
<style>
#right-col table td{ padding: 5px 0 5px 0px; color:#333333;}
</style> 
<div id="page"> 
<?php require ("tpl/inc/header.php"); ?> 
<script src="js/jquery-1.6.2.min.js" type="text/javascript"></script>
<script src="js/jquery.tablednd_0_5.js" type="text/javascript"></script>
<link href="css/core.css" rel="stylesheet" type="text/css" />
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
		<input type="button" name="save" value="<?= $lang[20] ?>" class="button" onClick="javascript: instrument.updateorder(document.getElementById('ama').value,{});	if(1){
																			instrument.add_edititInstrumentCategory('server',document.getElementById('instrument_category_id').value,document.getElementById('instrument_category').value,
																				document.getElementById('description').value,
																				{ onUpdate: function(response,root){
																					document.getElementById('frm').innerHTML= response;
																					instrument.listInstrumentCategory({onUpdate:
																						function(response,root){
																							document.getElementById('div_list').innerHTML = response;
																							draggable_control();
																						}});
																				}});
																			}" />
		<input type="button" name="create" value="<?= $lang[26] ?>" onClick="instrument.add_edititInstrumentCategory('local',{target:'frm'});" class="button" />
		<input type="hidden" name="aman" id="ama">
		</p>
			<div class="right-col-padding1"> 
				<div class="width-99pct"  id='frm' > </div>				 
		  <div id="div_list">
			<?php echo $instrument->listInstrumentCategory();?>
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

