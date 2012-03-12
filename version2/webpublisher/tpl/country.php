<?php require ("tpl/PHPLiveX.php"); ?>



<?php 
ini_set("display_errors",1);
class Country { 
	function add_editCountry($runat,$country_id=0,$c_name=''){
		ob_start();
		switch($runat){
		case 'local':
				$sql="select * from country where country_id=$country_id";
				$result = mysql_query($sql);
				$row=mysql_fetch_array($result);
					?>
					<input id="country_id" value="<?php echo $row['country_id']?>"  name="c_name" type="hidden">
					<table>
							<tr>
								<td ><label>Country :</label></td>
								<td><input class="textfield width-200px" id="c_name" value="<?php echo $row['country_name']?>" type="text" name="c_name" maxlength="255" ></td>
							</tr>
							
							<tr>
								<td>&nbsp;</td>
								<td><a href="javascript: void(0);" onclick="document.getElementById('frm').innerHTML='' ">Cancel</td>
							</tr>
							
					</table>
					<?php
					break;
		case 'server': 
		//echo 'aman'.$country_id;
					if($country_id > 0)
						$sql="update country set country_name='$c_name'  where country_id='$country_id'";
					else 
						$sql="INSERT INTO country(country_name) VALUES('$c_name')";
					
					if(trim($c_name) !='') 
					mysql_query($sql);
					break;
		}
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
		
	}
	
	function updateActive($country_id,$value){
		ob_start();
		mysql_query("update country set active='$value' where country_id='$country_id'");
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	function listCountry(){
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
			<thead><tr ><td><h4>Country</h4></td><td><h4>Active</h4></td></tr></thead>
			 <tbody>
			 <?php
			 $sql="select * from country order by `order`";
			 $result = mysql_query($sql);
 		 	 while($row=mysql_fetch_array($result))
			{	
			?>
			<tr id="order_<?php echo $row['country_id']; ?>"> 
			<?php $id=$row['country_id'];?>
			
			<td width="25%"><a href="javascript: void(0);" 
						onclick="country.add_editCountry('local','<?php echo $row['country_id'];?>',{target:'frm'});"><?php echo $row['country_name']; ?></a></td>
			<td width="25%"><input type="checkbox" <?php if($row[active]==1) echo 'checked="checked"'; ?>
									onchange="javascript: if(this.checked) 
															country.updateActive(<?php echo $row['country_id'];?>,1,{onUpdate: function(response,root){
																					country.listCountry({onUpdate:
																						function(response,root){
																							
																							draggable_control();
																						}});
																					}
																				});
														else 
															country.updateActive(<?php echo $row['country_id'];?>,0,{onUpdate: function(response,root){
																					country.listCountry({onUpdate:
																						function(response,root){
																							
																							draggable_control();
																						}});
																					}
																				});" /></td>
			</tr>
		  <?php }
		  ?></tbody>
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
			$sql = "UPDATE `country` 
				   SET `order` = '$key'
				   WHERE `country_id` = '$value'";
			mysql_query($sql);
			//$objDb->prepare($sql)->execute(array($key, $value));		
		}
		 $html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}

$country = new Country();
require ("tpl/inc/head.php");
$ajax = new PHPLiveX();
$ajax->AjaxifyObjects(array("country")); 
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
		<input type="button" name="save" value="<?= $lang[20] ?>" class="button" onClick="javascript:country.updateorder(	document.getElementById('ama').value,{});
																								 if(1){
																			country.add_editCountry('server',document.getElementById('country_id').value,document.getElementById('c_name').value,
																				{ onUpdate: function(response,root){
																					document.getElementById('frm').innerHTML= response;
																					country.listCountry({onUpdate:
																						function(response,root){
																							document.getElementById('div_list').innerHTML = response;
																							draggable_control();
																						}});
																				}});
																			}" />
		<input type="button" name="create" value="<?= $lang[26] ?>" onClick="country.add_editCountry('local',{target:'frm'});" class="button" />
		<input type="hidden" name="aman" id="ama">
		</p>
			<div class="right-col-padding1"> 
				<div class="width-99pct"  id='frm' > </div>				 
		  <div id="div_list">
			<?php echo $country->listCountry();?>
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




