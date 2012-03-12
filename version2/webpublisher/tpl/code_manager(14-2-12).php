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
		<h2 class="bar green"><span><?php echo  $lang[58] ?></span></h2> 
		<form action=".?id=<?php echo  $id ?>" method="post" enctype="multipart/form-data" > 

			<div class="right-col-padding1"> 
				<div class="width-99pct"> 
					<table class="rec-table"> 
						
<?php
# Using REQUEST_URI

$Current_page = "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI'];

?>
<?php
//$errorcount = 0;
//$uri_test = $this->uri->segment(1) . '/' . $this->uri->segment(2);
if(isset($_GET['baseid']) && !empty($_GET['baseid'])):
	$baseid =  $_GET['baseid'];	 
else:
	$baseid ="";
endif;

if((empty($_POST['manage_templates']) && empty($_POST['startinstall']) && !empty($_POST['manage_code'])) || (empty($_POST['startinstall']) && $_POST['installstep'] =='templates' && empty($_POST['manage_templates'])) ||   (empty($_POST['startinstall']) && !empty($baseid) && empty($_POST['manage_code'])) ||  (!empty($_POST['installstep']) &&  $_POST['installstep'] =='code')  ):	
		    $runmode = "templates";
			$installstep = "code";
endif;	

if ($installstep == 'code'):
	
	
	if($errorcount > 0):
		
	endif;
	if ($errorcount == 0 && !empty($bascode1) && empty($baseid)):		

/*				$query = sprintf("insert into xbasetypes set 
		`basepara` =  '$basepara', 
		`basgroup1` = '$basgroup1', 
		`active` = '$active', 
		`basgroup2` = '$basgroup2',
		bascode1 = '$bascode1',
		bascode2 ='$bascode2', 
		bascode3 ='$bascode3', 
		basdetails ='$basdetails', 
		bassystem = '$bassystem',
		basactive = '$basactive'
		");*/
					//$result = mysql_query($query); $varerror = mysql_error();
		 //echo "Code has beed added successfully";
	//	 unset($basepara,$basgroup1,$active,$basgroup2,$bascode1,$bascode2,$bascode3,$basdetails,$bassystem,$basactive);					
	elseif($errorcount == 0 && !empty($baseid)):

		 // echo "!!! checkbox is $deletestyle !!! ";
		if ($deletecode == "deletecode"):
			//$query = "delete from xbasetypes where baseid = $baseid";
		else:
/*						 $query = "update xbasetypes
				set 
			`basepara` =  '$basepara', 
			`basgroup1` = '$basgroup1',
			`active` = '$active', 
			`basgroup2` = '$basgroup2',
			bascode1 = '$bascode1',
			bascode2 ='$bascode2', 
			bascode3 ='$bascode3', 
			basdetails ='$basdetails', 
			bassystem = '$bassystem', 
			basactive = '$basactive'
			where baseid = $baseid ";
*/					endif;
		//$result = mysql_query($query); $varerror = mysql_error();
		//echo "code has beed updated successfully";
		//unset($basepara,$basgroup1,$active,$basgroup2,$bascode1,$bascode2,$bascode3,$basdetails,$bassystem,$basactive,$baseid,$deletecode);	
	endif;
	endif;
			if(!empty($baseid)){

			  	$query = "select *
				from xbasetypes
				where `basgroup1` = '$baseid'";				 
				$result_vt = mysql_query($query);
/*				while($row = mysql_fetch_assoc($result)):
				//print_r($row);
					extract($row);
				endwhile;
*/                
		}
		if($_POST['code'] or $installstep == 'code'){

				//extract($_POST['code']);
					//print_r($code);	
					//echo count($code);
					for($i=0;$i<count($_POST['code']['basepara']);$i++){
/*					echo $code['baseid'][$i].'<br>';
					echo $code['basepara'][$i].'<br>';
					echo $code['basgroup1'][$i].'<br>';
					echo $code['bascode1'][$i].'<br>';
					echo $code['bascode2'][$i].'<br>';
					echo $code['bascode3'][$i].'<br>';
					echo $code['active'][$i].'<br>';
					echo $code['deletecode'][$i].'<br>************<br>';
*/				$baseid =  $_POST['code']['baseid'][$i];
				$basepara = $_POST['code']['basepara'][$i];
				$basgroup1 = $_POST['code']['basgroup1'][$i];
				$active = $_POST['code']['active'][$i];
				$basgroup2 = '';
				$bascode1 = $_POST['code']['bascode1'][$i];
				//$bascode2 = $_POST['code']['bascode2'][$i];
				//$bascode3 = $_POST['code']['bascode3'][$i];
				$deletecode = $_POST['code']['deletecode'][$i];
				$basdetails = '';
				$bassystem = '';
				$basactive = '';
			    
				if ($basepara == ""): $baseparastyle = $default_errorstyle; ++$errorcount; endif;
				if ($basgroup1 == ""): $basgroup1style = $default_errorstyle; ++$errorcount; endif;
				if ($bascode1 == ""): $bascode1style = $default_errorstyle; ++$errorcount; endif;
				
				
				
/*				echo $errorcount.'err<br>'.$code['bascode1'][$i].'bas<br>'.$code['baseid'][$i];
*/				//$errorcount = 0;
					 // echo "!!! checkbox is $deletestyle !!! ";
				if ($errorcount == 0 && !empty($_POST['code']['bascode1'][$i]) && $_POST['code']['baseid'][$i]=="" and $_POST['nextstep']=="Add Code"){		 
				$query = sprintf("insert into xbasetypes set 
					`basepara` =  '$basepara', 
					`basgroup1` = '$basgroup1', 
					`active` = '$active', 
					`basgroup2` = '$basgroup2',
					bascode1 = '$bascode1',
					basdetails ='$basdetails', 
					bassystem = '$bassystem',
					basactive = '$basactive'
					");
					$result = mysql_query($query); $varerror = mysql_error();
					 echo "Code has beed added successfully";
					 unset($basepara,$basgroup1,$active,$basgroup2,$bascode1,$bascode2,$bascode3,$basdetails,$bassystem,$basactive);
					 }	
					  
				elseif($errorcount == 0 && !empty($baseid) and $_POST['nextstep']=="Update Code"){

					if ($deletecode == "deletecode"){
						$query = "delete from xbasetypes where baseid = $baseid";
						}
					else{
						 $query = "update xbasetypes
							set 
						`basepara` =  '$basepara', 
						`active` = '$active', 
						`basgroup2` = '$basgroup2',
						bascode1 = '$bascode1',
						basdetails ='$basdetails', 
						bassystem = '$bassystem', 
						basactive = '$basactive'
						where baseid = $baseid ";
					}
                    $result = mysql_query($query); $varerror = mysql_error();
					//echo "code has beed updated successfully";
					unset($basepara,$basgroup1,$active,$basgroup2,$bascode1,$bascode2,$bascode3,$basdetails,$bassystem,$basactive,$baseid,$deletecode);
					}						//echo '<br>'.$query;  
	
			 }
				if($_POST['nextstep']=="Update Code"){
			
			$path_u = $Current_page.'&baseid='.$_POST['code']['basgroup1'][0];
			//echo $path_u;

			?>
			<script>window.location="<?php echo $path_u;?>";</script>
<?php
			 }
			 
			 }
			 ?>
			 	<form id="installform" name="installform"  ENCTYPE='multipart/form-data'  METHOD='POST'>
	<tr width=100% style='color:black'>
					<td width='20%' align=left><strong>Manage Code</strong><br/></td>	
					<td width='20%' colspan=5 align=left>				
						<?php
						$xyz = "select distinct(basgroup1) from xbasetypes";
						$pqr = mysql_query($xyz);
						$stu = mysql_num_rows($pqr);
					    ?>
						<select name="grp" onchange="javascript: window.location = '<?php echo $Current_page.'&baseid=';?>'+this.value;">
						<option value="0">--Select Group--</option>
						<?php while($row_grp = mysql_fetch_assoc($pqr)){?>
							<option value="<?php echo $row_grp['basgroup1'];?>" <?php if($baseid==$row_grp['basgroup1']) echo 'selected="selected"';?> ><?php echo $row_grp['basgroup1'];?></option>
						<?php }?>
						</select>
					</td>
				</tr>
						<?php $num_rows_c =mysql_num_rows($result_vt);
				while($row = mysql_fetch_array($result_vt)){
						extract($row);
		echo 
		    $varactiveoption = "";
			 $varactiveoption .= "<option value=''>Please select status</option>";			 		 
				if($active==1):				 
					 $varactiveoption .= "<option value='1' selected='selected'>Active</option>";
				else:
					 $varactiveoption .= "<option value='1'>Active</option>";
				endif;		
				if($active==0):				 
					 $varactiveoption .= "<option value='0' selected='selected'>Inactive</option>";
				else:
					 $varactiveoption .= "<option value='0'>Inactive</option>";
				endif;
                                
                                if($active==1){
                                    $checked = 'checked';
                                }else {
                                    $checked = '';
                                }
				
						
						
						
			echo "
			  <tr width=100%>	
			  <td colspan=6><table width='100%' id='manage_code_class'><tr>
			  	<td width='17%'><label>Order  *</label><br/>
				  <input type='input' $baseparastyle value='$basepara' name='code[basepara][]' maxlength='250' class='textfield width-90pct' /></td>
				<td width='20%'><label>Group Name*</label><br/>
				 <input type='hidden' $basgroup1style value='$basgroup1' name='code[basgroup1][]' maxlength='250' class='textfield width-90pct'/>".$basgroup1."</td>
<!--				<td><label>Group 2*</label><br/>
				  <input type='input' $basgroup2style value='$basgroup2' name='code[basgroup2][]' maxlength='250' class='textfield width-90pct'/></td>
				</tr>
                 <tr>       
                 <td><label>Base System*</label><br/>
				  <input type='input' $bassystemstyle value='$bassystem' name='code[bassystem][]' maxlength='250' class='textfield width-90pct' /></td>
-->				<td><label>Alias Name*</label><br/>
				  <input type='input' $bascode1style value='$bascode1' name='code[bascode1][]' maxlength='250' class='textfield width-90pct'/></td>
				";?>
                 <?php
			if(!empty($baseid)):
			  	$querystylecount = "select bascode1 from xbasetypes where site_template = $baseid";
				$resultstylecount = mysql_query($querystylecount); $num_rows = mysql_num_rows($resultstylecount);
				echo " 
				<td><label>Active</label><br/>			 
				  <input type='hidden'  value='$baseid' name='code[baseid][]'/>";
                                echo "<div id='code_$baseid'>";
                                      if($checked == '') {
                                            echo "<input type='hidden' name='code[active][]' value='0' />";
                                        }
                                  echo "</div>";
                                  echo "<input type='checkbox' id='$baseid' name='code[active][]' value='1' $checked />
				</td>
				<td>
					$num_rows
				</td>";
				if ($num_rows == 0):
					echo "<td align='left'><br/>";
					//echo "<input type='checkbox' value='deletecode' name='code[deletecode][]' class='textfield width-90pct' />";
				else:
					echo "<td colspan=2><br/>";
					//echo "Cannot delete if sites using this Code";
				endif;
				echo "
				</td> ";
			endif;
			
			
			
				 ?>
                 </tr></table></td></tr>
			 <?php }
			 if($num_rows_c>0){
		//echo $num_rows_c;
			echo "<tr width=100%>
				<td><br>
				  <input class='button' name='nextstep' type='submit' value='Update Code'></input>	<br><br>
				</td>			
			  </tr>";	
		}		
	
	
	$active = 2;
		echo 
		    $varactiveoption = "";
			 $varactiveoption .= "<option value=''>Please select status</option>";			 		 
				if($active==1):				 
					 $varactiveoption .= "<option value='1' selected='selected'>Active</option>";
				else:
					 $varactiveoption .= "<option value='1'>Active</option>";
				endif;		
				if($active==0):				 
					 $varactiveoption .= "<option value='0' selected='selected'>Inactive</option>";
				else:
					 $varactiveoption .= "<option value='0'>Inactive</option>";
				endif;
                                
                                if($active==1){
                                    $checked = 'checked';
                                }else {
                                    $checked = '';
                                }
			?>	
						
						
						
			
			  <tr width=100%>	
			  <td colspan=6><table width='100%' id='manage_code_class'><tr>
			  	<td width='17%'><label>Order  *</label><br/>
				  <input type='input' $baseparastyle  name='code[basepara][]' maxlength='250' class='textfield width-90pct' /></td>
				<td width='20%'><label>Group Name*</label><br/>
				  <input type='input' $basgroup1style  name='code[basgroup1][]' maxlength='250' class='textfield width-90pct'/></td>
<!--				<td><label>Group 2*</label><br/>
				  <input type='input' $basgroup2style  name='code[basgroup2][]' maxlength='250' class='textfield width-90pct'/></td>
				</tr>
                 <tr>       
                 <td><label>Base System*</label><br/>
				  <input type='input' $bassystemstyle  name='code[bassystem][]' maxlength='250' class='textfield width-90pct' /></td>
-->				<td><label>Alias Name*</label><br/>
				  <input type='input' $bascode1style  name='code[bascode1][]' maxlength='250' class='textfield width-90pct'/></td>
				
				<td><label>Active</label><br/>			 
				  <input type='hidden'  value='' name='code[baseid][]'/>
                                  <div id="code">
                                      <? if($checked == '') { ?>
                                            <input type="hidden" name="code[active][]" value="0" />
                                        <? } ?>
                                  </div>
                                  <input type="checkbox" name="code[active][]" value="1" <?=$checked?> />
				
				</td>
				<td>
					
				</td>
			<td align="left">
				
			</td>

                 </tr></table></td></tr>
			 
	
		  <tr width=100%>
				<td><br>
				  <input class='button' name='nextstep' type='submit' value='Add Code'></input>	<br><br>
				</td>			
			  </tr>	
			
</table>	
</div> 
	
</div> 
</div>
<?php require ("tpl/inc/footer.php"); ?> 
    
    <script>
$(function() {
  $(":checkbox").change(function(){
      var id = this.id;
      if(this.checked == true){
          $('#code_'+id).html('');
      } else if(this.checked == false) {
          $('#code_'+id).html('<input type=\'hidden\' name=\'code[active][]\' value=\'0\' />');
      }
    //$.post("index.php", { id: this.id, checked: this.cheked });
  });    
});
    
</script>
</body>
</html>