<?php require ("tpl/PHPLiveX.php"); ?>

<?php 
ini_set("display_errors",1);
class Artist { 
	function add_editGenre($runat,$genre_id=0,$genre='',$description='',$artist_type='', $active = 0){
		ob_start();
		switch($runat){
		case 'local':
				$sql="select * from artist_type a,genre b where b.artist_type=a.artist_id and b.genre_id='$genre_id'"; 
				$result = mysql_query($sql);
				$row=mysql_fetch_array($result);
					?>
					<input id="genre_id" value="<?php echo $row['genre_id']?>"   name="genre_id" type="hidden">
					<table>
							<tr>
								<td valign="top"><label>Genre :</label></td>
								<td valign="top"><input id="genre" class="textfield" type="text" name="genre" value="<?php echo $row['genre'];?>" maxlength="255" style="width:200px;" ></td>
							</tr>
							<tr>
								<td ><label>Artist Type :</label></td>
								<td><select name="artist_type" id="artist_type" style="width:200px;" class="textfield">
									<?php	
									$sql="select * from artist_type";
									$result = mysql_query($sql);
									while($row1=mysql_fetch_array($result))
									{ ?><option value="<?php echo $row1['artist_id']; ?>" <?php if($row1['artist_id']==$row['artist_id']) echo 'selected="selected"';?>> 
										<?php  echo $row1['type'];  ?></option>
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
					if($genre_id > 0)
						$sql="update genre set artist_type='$artist_type', genre='$genre', description='$description', active = $active where genre_id='$genre_id'";
					else 
						$sql="INSERT INTO genre(genre,description,artist_type) VALUES('$genre','$description','$artist_type')";
					if(trim($genre) !='') mysql_query($sql);
					break;
		}
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
		
	}
	
	function updateActive($genre_id,$value){
		ob_start();
		mysql_query("update genre set active='$value' where genre_id='$genre_id'");
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	function deleteGenre($genre_id){
		ob_start();
		mysql_query("delete from  genre where genre_id='$genre_id'");
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	function listGenre(){
		ob_start();
		/*if(isset($_POST['save'])){
			mysql_query("UPDATE genre SET active = 1 where genre_id IN (".implode(',', $_POST['active']).")");
			mysql_query("UPDATE genre SET active = 0 where genre_id NOT IN (".implode(',', $_POST['active']).")");
		}*/
		?>
		<table width="100%" >
			<tr ><td><h4>Artist Type</h4></td><td><h4>Genres</h4></td></tr>
			 <?php
			 $sql="select * from genre a, artist_type b where a.artist_type=b.artist_id group by b.artist_id asc";
			 $result = mysql_query($sql);
 		 	 while($row=mysql_fetch_array($result)){?>
				<tr>
				<td valign="top"><?php echo $row['type']; ?></td>
				<td ><table border="1" class="genre" style="float:left;margin-right: 10px;" BORDERCOLOR ="#DDDDDD"><tr><th>Genre</th><th>Active</th><!--<th>Action</th>--></tr><?php 
				 $sql="select * from genre where artist_type='$row[artist_id]' group by genre asc";
				 $result1 = mysql_query($sql);
                                 $count = mysql_num_rows($result1);
                                 $i=1;
				 while($row1=mysql_fetch_array($result1)){
                                     ?>
							<tr><td width="300">
							<a href="javascript: void(0);" 
							onclick="artist.add_editGenre('local','<?php echo $row1['genre_id'];?>',{target:'frm'});"><?php echo $row1['genre']; ?></a></td><td align="center"><input type="checkbox" name="active[]" value="<?php echo $row1['genre_id'];?>" <?php $row1['active'] and print 'checked="checked"'; ?> onclick="artist.updateActive(<?php echo $row1['genre_id'];?>,this.checked,
																				{onUpdate: function(response,root){
																					artist.listGenre({target:'div_list'});
																				}
																				});" /></td></tr>
																				<!--<td align="center">
							<a href="javascript: void(0);" onclick="artist.deleteGenre(<?php echo $row1['genre_id'];?>,
																				{onUpdate: function(response,root){
																					artist.listGenre({target:'div_list'});
																				}
																				});" ><img src="img/trash.gif"/></a>-->
                                    <? //if($count > $i) echo ",&nbsp;";?>
                                   
                                    <? if(ceil($count/2) == $i) echo '</table><table BORDERCOLOR ="#DDDDDD" style="float:left;" border="1" class="genre"><tr><th>Genre</th><th>Active</th></tr>'; ?>
                                    
				<?php $i++; } ?><!--</td>-->
				</table>
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

$artist = new Artist();
require ("tpl/inc/head.php");
$ajax = new PHPLiveX();
$ajax->AjaxifyObjects(array("artist")); 
$ajax->Run("tpl/phplivex.js"); // Must be called inside the 'html' or 'body' tags  
?>
<body> 
<style>
#right-col table td{ padding: 5px 0 5px 0px; color:#333333;}
table.genre td{ padding:5px !important;}
table.genre th{ padding:5px !important;}
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
																			artist.add_editGenre('server',document.getElementById('genre_id').value,
																			document.getElementById('genre').value,
																			document.getElementById('description').value,
																			document.getElementById('artist_type').value,
																			document.getElementById('active').checked,
																			{ onUpdate: function(response,root){
																					document.getElementById('frm').innerHTML= response;
																					artist.listGenre({target:'div_list'});
																				}});
																			}" />
		<input type="button" name="create" value="<?= $lang[26] ?>" onClick="artist.add_editGenre('local',{target:'frm'});" class="button" />
		</p>
			<div class="right-col-padding1"> 
				<div class="width-99pct"  id='frm' > </div>				 
		  <div id="div_list">
			<?php echo $artist->listGenre();?>
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

