<?php require ("tpl/PHPLiveX.php"); ?>
<?php 
ini_set("display_errors",1);
class Instrument { 
	function add_editInstrument($runat,$instrument_id=0,$instrument='',$description='',$instrument_category='', $active = "1"){
		ob_start();
		switch($runat){
		case 'local':
				$sql="select * from instrument_category a,instrument b where b.instrument_category=a.instrument_category_id and b.instrument_id='$instrument_id'";
				$result = mysql_query($sql);
				$row=mysql_fetch_array($result);
					?>
					<input id="instrument_id" value="<?php echo $row['instrument_id']?>"   name="instrument_id" type="hidden">
					<table>
							<tr>
								<td valign="top"><label>Instrument :</label></td>
								<td valign="top"><input id="instrument_name" class="textfield" type="text" name="instrument_name" value="<?php echo $row['instrument'];?>" maxlength="255" style="width:200px;" ></td>
							</tr>
							<tr>
								<td ><label>Instrument Category :</label></td>
								<td><select name="instrument_category" id="instrument_category" style="width:200px;" class="textfield">
									<?php	
									$sql="select * from instrument_category";
									$result = mysql_query($sql);
									while($row1=mysql_fetch_array($result))
									{ ?><option value="<?php echo $row1['instrument_category_id']; ?>" <?php if($row1['instrument_category_id']==$row['instrument_category_id']) echo 'selected="selected"';?>> 
										<?php  echo $row1['instrument_category'];  ?></option>
									<?php } ?>  
								</select></td>
							</tr>
							<tr>
								<td valign="top"><label>Description :</label></td>
								<td valign="top"><textarea class="textfield" id="description" name="description"  style="width:300px;"><?php echo $row['description'];?></textarea></td>
							</tr>
							<tr>
								<td valign="top"><label>Active :</label></td>
								<td valign="top"><input type="checkbox" id="active" name="active" <?php $row['active'] and print 'checked="checked"';?> /></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td><a href="javascript: void(0);" onclick="document.getElementById('frm').innerHTML='' ">Cancel</td>
							</tr>
							
					</table>
					<?php
					break;
		case 'server': 
					if($instrument_id > 0)
						$sql="update instrument set instrument_category='$instrument_category', instrument='$instrument', active='$active',description='$description' where instrument_id='$instrument_id'";
					else 
						$sql="INSERT INTO instrument(instrument,description,instrument_category, active) VALUES('$instrument','$description','$instrument_category', '$active')";
					if(trim($instrument) !='') mysql_query($sql);
					break;
		}
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
		
	}
	
	function updateActive($instrument_id,$value){
		ob_start();
		mysql_query("update instrument set active='$value' where instrument_id='$instrument_id'");
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	function listInstrument(){
		ob_start();
		?>
		<table width="100%" >
			<tr ><td><h4>Instrument Category</h4></td><td><h4>Instruments</h4></td></tr>
			 <?php
			 $sql="select * from instrument a, instrument_category b where a.instrument_category=b.instrument_category_id group by b.instrument_category_id asc";
			 $result = mysql_query($sql);
 		 	 while($row=mysql_fetch_array($result)){?>
				<tr>
				<td valign="top"><?php echo $row['instrument_category']; ?></td>
				<td ><?php 
				 $sql="select * from instrument where instrument_category='$row[instrument_category_id]' group by instrument asc";
				 $result1 = mysql_query($sql);
                                 $count = mysql_num_rows($result1);
                                 $i=1;
				 while($row1=mysql_fetch_array($result1)){
                                     ?>
				<a href="javascript: void(0);" 
							onclick="instrument.add_editInstrument('local','<?php echo $row1['instrument_id'];?>',{target:'frm'});"><?php echo $row1['instrument']; ?></a>
                                    <? if($count > $i){ ?>
                                    ,
                                    <? } ?>
                                    &nbsp;
                                    
				<?php $i++; } ?>
				</td>
				</tr>
		  <?php } ?>
		</table>
		<?php
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
		<input type="button" name="save" value="<?= $lang[20] ?>" class="button" onclick="javascript: if(1){
																			instrument.add_editInstrument('server',
																			document.getElementById('instrument_id').value,
																			document.getElementById('instrument_name').value,
																			document.getElementById('description').value,
																			document.getElementById('instrument_category').value,
																			document.getElementById('active').checked,
																			{ onUpdate: function(response,root){
																					document.getElementById('frm').innerHTML= response;
																					instrument.listInstrument({target:'div_list'});
																				}});
																			}" />
		<input type="button" name="create" value="<?= $lang[26] ?>" onclick="instrument.add_editInstrument('local',{target:'frm'});" class="button" />
		</p>
			<div class="right-col-padding1"> 
				<div class="width-99pct"  id='frm' > </div>				 
		  <div id="div_list">
			<?php echo $instrument->listInstrument();?>
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

