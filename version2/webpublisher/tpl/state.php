<?php require ("tpl/PHPLiveX.php"); ?>

<?php 
ini_set("display_errors",1);
class State { 
	function add_editState($runat,$state_id=0,$state='',$country=''){
		ob_start();
		switch($runat){
		case 'local':
				$sql="select * from country a,state b where b.country_id=a.country_id and b.state_id='$state_id'";
				$result = mysql_query($sql);
				$row=mysql_fetch_array($result);
					?>
					<input id="state_id" value="<?php echo $row['state_id']?>"   name="state_id" type="hidden">
					<table>
							<tr>
								<td valign="top"><label>State :</label></td>
								<td valign="top"><input id="state" class="textfield" type="text" name="state" value="<?php echo $row['state'];?>" maxlength="255" style="width:200px;" ></td>
							</tr>
							<tr>
								<td ><label>Country :</label></td>
								<td><select name="country" id="country" style="width:200px;" class="textfield">
									<?php	
									$sql="select * from country";
									$result = mysql_query($sql);
									while($row1=mysql_fetch_array($result))
									{ ?><option value="<?php echo $row1['country_id']; ?>" <?php if($row1['country_id']==$row['country_id']) echo 'selected="selected"';?>> 
										<?php  echo $row1['country_name'];  ?></option>
									<?php } ?>  
								</select></td>
							</tr>
							
							
							<tr>
								<td>&nbsp;</td>
								<td><a href="javascript: void(0);" onclick="document.getElementById('frm').innerHTML='' ">Cancel</td>
							</tr>
							
					</table>
					<?php
					break;
		case 'server': 
					if($state_id > 0)
						$sql="update state set country_id='$country', state='$state' where state_id='$state_id'";
					else 
						$sql="INSERT INTO state(state,country_id) VALUES('$state','$country')";
					if(trim($state) !='')
					mysql_query($sql);
					break;
		}
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
		
	}
	
	function updateActive($state_id,$value){
		ob_start();
		mysql_query("update state set active='$value' where country_id='$state_id'");
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	function listState(){
		ob_start();
		?><script type="text/javascript">
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
			<thead><tr ><td><h4>States</h4></td><td><h4>Country</h4></td><td><h4>Actives</h4></td></tr></thead>
			<tbody> <?php
			 $sql="select a.country_name,b.* from country as a,state as b where b.country_id=a.country_id order by `order` ";
			 //$sql="select a.*,b.type as artist_type from genre a, artist_type b where a.type=b.id order by a.genre_id asc";
			 $result = mysql_query($sql);
 		 	 while($row=mysql_fetch_array($result)){?>
			
				<tr id="order_<?php echo $row['state_id']; ?>">
				<td><a href="javascript: void(0);" 
							onclick="state.add_editState('local','<?php echo $row['state_id'];?>',{target:'frm'});"><?php echo $row['state']; ?></a>
				</td>
				<td valign="top"><?php echo $row['country_name']; ?></td>
				<td><input type="checkbox" <?php if($row[active]==1) echo 'checked="checked"'; ?>
									onchange="javascript: if(this.checked) 
															state.updateActive(<?php echo $row['state_id'];?>,1,{onUpdate: function(response,root){
																					state.listState({onUpdate:
																						function(response,root){
																							
																							draggable_control();
																						}});
																					}
																				});
														else 
															state.updateActive(<?php echo $row['state_id'];?>,0,{onUpdate: function(response,root){
																					state.listState({onUpdate:
																						function(response,root){
																							
																							draggable_control();
																						}});
																					}
																				});" /></td>
				</tr>
				<?php } ?>
		  <?php  ?>
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
			 $sql = "UPDATE `state` 
				   SET `order` = '$key'
				   WHERE `state_id` = '$value'";
			mysql_query($sql);
			//$objDb->prepare($sql)->execute(array($key, $value));		
		}
		 $html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}

$state = new State();
require ("tpl/inc/head.php");
$ajax = new PHPLiveX();
$ajax->AjaxifyObjects(array("state")); 
$ajax->Run("tpl/phplivex.js"); // Must be called inside the 'html' or 'body' tags  
?>
<body> 
<div id="page"> 
<?php require ("tpl/inc/header.php"); ?> <script src="js/jquery-1.6.2.min.js" type="text/javascript"></script>
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
		<input class="button" value="Save" type="button" onClick="javascript: state.updateorder(	document.getElementById('ama').value,{});
																		 if(1){ 
																		 state.add_editState('server',document.getElementById('state_id').value,
																		document.getElementById('state').value,
																			document.getElementById('country').value,
																			{ onUpdate: function(response,root){
																					document.getElementById('frm').innerHTML= response;
																					state.listState({onUpdate:
																						function(response,root){
																							document.getElementById('div_list').innerHTML = response;
																							draggable_control();
																						}});
																				}});
																			}" />
		<input type="button" name="create" value="<?= $lang[26] ?>" onClick="state.add_editState('local',{target:'frm'});" class="button" />
		<input type="hidden" name="aman" id="ama">
		</p>
			<div class="right-col-padding1"> 
				<div class="width-99pct"  id='frm' > </div>				 
		  <div id="div_list">
			<?php echo $state->listState();?>
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