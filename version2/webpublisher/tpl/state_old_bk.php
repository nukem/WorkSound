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
								<td valign="top"><input id="state_name" class="textfield" type="text" name="state_name" value="<?php echo $row['state'];?>" maxlength="255" style="width:200px;" ></td>
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
		mysql_query("update state set active='$value' where state_id='$state_id'");
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	function listState(){
		ob_start();
		?>
		<table width="100%" >
			<tr ><td><h4>Country</h4></td><td><h4>States</h4></td><td><h4>Actives</h4></td></tr>
			 <?php
			 $sql="select a.country_name,b.* from country as a,state as b where b.country_id=a.country_id order by a.country_name asc ";
			 //$sql="select a.*,b.type as artist_type from genre a, artist_type b where a.type=b.id order by a.genre_id asc";
			 $result = mysql_query($sql);
 		 	 while($row=mysql_fetch_array($result)){?>
			
				<tr>
                                <td valign="top"><?php echo $row['country_name']; ?></td>
				<td><a href="javascript: void(0);" 
							onclick="state.add_editState('local','<?php echo $row['state_id'];?>',{target:'frm'});"><?php echo $row['state']; ?></a>
				</td>				
				<td><input type="checkbox" <?php if($row[active]==1) echo 'checked="checked"'; ?>
									onchange="javascript: if(this.checked) 
															state.updateActive(<?php echo $row['state_id'];?>,1,{onUpdate: function(response,root){
																					state.listState({target:'div_list'});
																					}
																				});
														else 
															state.updateActive(<?php echo $row['state_id'];?>,0,{onUpdate: function(response,root){
																					state.listState({target:'div_list'});
																					}
																				});" /></td>
				</tr>
				<?php } ?>
		  <?php  ?>
		</table>
		<?php
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
		<input class="button" value="save" type="button" onClick="javascript: if(1){ state.add_editState('server',document.getElementById('state_id').value,
																		document.getElementById('state_name').value,
																			document.getElementById('country').value,
																			{ onUpdate: function(response,root){
																					document.getElementById('frm').innerHTML= response;
																					state.listState({target:'div_list'});
																				}});
																			}" />
                <input type="button" name="create" value="<?= $lang[26] ?>" onClick="state.add_editState('local',{target:'frm'});" class="button" />
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