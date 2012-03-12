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
      <h2 class="bar green"><span><?php echo  $lang[65] ?></span></h2> 
      <form action=".?id=<?php echo  $id ?>" method="post" enctype="multipart/form-data"> 
        <?php require ("tpl/inc/buttons.php"); ?> 
        <div class="right-col-padding1"> 
          <div class="width-99pct"> 
            <table class="rec-table"> 
              <?php require ("tpl/inc/record.php"); ?> 
			  <?php if(isset($path)){   //get the category to be filled automatically in hidden filled
		               if(is_array($path)){
					     $catSize = sizeof($path);
					     $i = 1;
						 $category = '';
					     foreach($path as $locs){
						   if($i > 3 && $i < $catSize){
					         $category.= htmlspecialchars($locs[1]);
						     if($i < ($catSize-1) )
						       $category.= ":";
						   }
						   $i++;
						 }
					   }
		             }
					 
		      ?>
              <tr> 
                <td><label>Job ID &bull;</label><br /> 
                  <input type="text" name="jobId" value="<?php echo $_GET['id']; ?>" class="textfield width-100pct" readonly="readonly" /></td> 
			    <td><label>Job Location 1 (State)</label><br />
                  <input name="location" type="text" class="textfield width-100pct" value="<?php if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['location']); else echo $record['location']; ?>" size="25"></td>
		        <td><label>Job Location 2 (City)</label><br />
                  <input name="location2" type="text" class="textfield width-100pct" value="<?php if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['location2']); else echo $record['location2']; ?>" size="25"></td>

				<td><label>Job Position</label><br /> 
                  <input type="text" name="jPosition" value="<?php if (isset ($_POST['title'])) echo $_POST['jPosition']; else echo $record['jPosition']; ?>" class="textfield width-100pct" /></td>
              </tr>  
			  <tr>
			    <td>
					<label>Contact Name</label><br /> 
                  <input type="text" name="contName" value="<?php if (isset ($_POST['title'])) echo $_POST['contName']; else echo $record['contName']; ?>" class="textfield width-100pct" />				</td>
				<td>
					<label>Contact Phone</label><br /> 
                  <input type="text" name="contPhone" value="<?php if (isset ($_POST['title'])) echo $_POST['contPhone']; else echo $record['contPhone']; ?>" class="textfield width-100pct" />				</td>
				<td>
					<label>Organisation Name</label><br /> 
                  <input type="text" name="orgName" value="<?php if (isset ($_POST['title'])) echo $_POST['orgName']; else echo $record['orgName']; ?>" class="textfield width-100pct" />				</td>
			    <td><!--<label>Organisation Number</label>
			      <br /> -->
                  <input type="hidden" name="orgNumber" value="<?php if (isset ($_POST['title'])) echo $_POST['orgNumber']; else echo $record['orgNumber']; ?>" class="textfield width-100pct" />				
				  &nbsp;
				  </td>
			  </tr>
			  <tr> 
                <td> 
				<label>Start date</label>
				<br />
                <input name="startDate" type="text" class="textfield width-100pct date-pick" value="<?php if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['startDate']); else echo $record['startDate']; ?>" size="25">                </td>
				<td> 
				<label>Finish date</label>
				<br />
                <input name="finishDate" type="text" class="textfield width-100pct date-pick" value="<?php if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['finishDate']); else echo $record['finishDate']; ?>" size="35">                </td>
                <td>
				<label>Job Duration</label>
				<br />
                <input name="duration" type="text" class="textfield width-100pct" value="<?php if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['duration']); else echo $record['duration']; ?>" size="20"></td>
			    <td align="left" valign="bottom">&nbsp;</td>
			  </tr>
			  <tr>
			  	<td>
					<input name="jobCategory" type="hidden" value="<?php echo $category ?>" />
						<label>Date Job Listed </label>
						<br /> 
					  <input type="text" name="djListed" value="<?php if (isset ($_POST['title'])) echo $_POST['djListed']; else echo $record['djListed']; ?>" class="textfield width-100pct date-pick" />	
				</td>
				<td><label>Pay Rate</label>
                  <br /> 
                  <input type="text" name="payRate" value="<?php if (isset ($_POST['title'])) echo $_POST['payRate']; else echo $record['payRate']; ?>" class="textfield width-100pct" /></td>
				<td>&nbsp;<!--<label>Pay Rate 2</label>
                  <br />
				  <select name="payRate2" class="textfield width-100pct">
				  	<option<?php if ( (isset($_POST['payRate2']) && $_POST['payRate2'] == 'Hourly') || (!isset($_POST['payRate2']) && $record['payRate2'] == 'Hourly') || (!isset($_POST['payRate2']) && $record['payRate2'] != 'Hourly' && strstr($category, 'Hospital')) ) echo ' selected="selected"' ?>>Hourly</option>
					<option<?php if ( (isset($_POST['payRate2']) && $_POST['payRate2'] == 'Weekly') || (!isset($_POST['payRate2']) && $record['payRate2'] == 'Weekly') || (!isset($_POST['payRate2']) && $record['payRate2'] != 'Weekly' && strstr($category, 'GP Locum')) ) echo ' selected="selected"' ?>>Weekly</option>
					<option<?php if ( (isset($_POST['payRate2']) && $_POST['payRate2'] == 'Weekly') || (!isset($_POST['payRate2']) && $record['payRate2'] == 'Annualy') || (!isset($_POST['payRate2']) && $record['payRate2'] != 'Annualy' && (strstr($category, 'GP Permanent') || strstr($category, 'Allied Health'))) ) echo ' selected="selected"' ?>>Annualy</option>
				  </select>-->
                  </td>
				  <td>&nbsp;</td>
			      
			  </tr>
			  <tr> 
                <td colspan="4"> 
				<label>Job Description</label>
				<br />
         <textarea name="description" cols="30" rows="10" class="textfield tinymce"><?php if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['description']); else echo htmlspecialchars (preg_replace('/src="/', 'src="../', $record['description'])); ?></textarea>                </td> 
              </tr>
			  <tr>
				<td>
					<label>Job Filled By (Ochre Employee) </label>
					<br /> 
                  <input type="text" name="jfBY" value="<?php if (isset ($_POST['title'])) echo $_POST['jfBY']; else echo $record['jfBY']; ?>" class="textfield width-100pct" />				</td>
				<td>
				<label>Job Filled With (Doctor)</label>
					<br /> 
                  <input type="text" name="jfDOC" value="<?php if (isset ($_POST['title'])) echo $_POST['jfDOC']; else echo $record['jfDOC']; ?>" class="textfield width-100pct" />
				</td>
				<td colspan="2">&nbsp;</td>
			  </tr>
			  <tr>
			  <td>
					<label>Date Action Taken </label>
					<br /> 
                  <input type="text" name="djFilled" value="<?php if (isset ($_POST['title'])) echo $_POST['djFilled']; else echo $record['djFilled']; ?>" class="textfield width-100pct date-pick" />
				</td>
				<td colspan="3"><br />
				<a href="#" onClick="markWithAction(<?php echo $_GET['id']?>, 'Filled'); return false;">Mark as Filled</a> &nbsp;&nbsp;&nbsp; 
				<a href="#" onClick="markWithAction(<?php echo $_GET['id']?>, 'Withdrawn'); return false;">Mark as Withdrawn</a> &nbsp;&nbsp;&nbsp; 
				<a href="#" onClick="markWithAction(<?php echo $_GET['id']?>, 'Un-Filled'); return false;">Mark as Un-Filled</a></td>
			  </tr>
              <?php require ("tpl/inc/rights.php"); ?> 
            </table> 
			<script type="text/javascript">
			function markWithAction(id, action){
				if($.trim($('input[@name="djFilled"]').val()) == ''){
					alert('The "Date Action Taken" needs to be selected.');
					$('input[@name="djFileld"]').focus();
					return false;
				}
				if( action == 'Filled' && ($.trim($('input[@name="jfBY"]').val()) == '' || $.trim($('input[@name="jfDOC"]').val()) == '') ){
					alert('When filling a job\nBoth "Filled By" and "Filled With" fields are required.');
					return false;
				}
				djf = $.trim($('input[@name="djFilled"]').val());
				jfb = $.trim($('input[@name="jfBY"]').val()) || ' ';
				jfd = $.trim($('input[@name="jfDOC"]').val()) || ' ';
				var msg;
				
				$.get(
					'setaction.php',
					{'id':id, 'action':action, 'path': '<?php echo $category?>', 'djFilled': djf, 'jfBY': jfb, 'jfDOC': jfd},
					function (data){
						eval(data);
						if(typeof(msg) == 'object'){
							if(msg['success']){
								alert(msg['success']);
								document.location = 'http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>';
							}else if(msg['error']){
								alert('There was an error processing your request\nFollowing is a debug notice\n***\n'+msg['error']);
							}
						}else{
							alert('There was a problem setting this action, Please try cutting/copying and pasting the record.');
						}
					}
				);
				return false;				
			}
			</script>
          </div> 
        </div> 
      </form> 
    </div> 
    <?php require ("tpl/inc/footer.php"); ?> 
  </div> 
</div>
<script type="text/javascript">
$(document).ready(function(){
	Date.format = 'dd mmm yyyy';
	if($.browser.msie){
		$('.date-pick').datePicker({startDate:'<?php echo  date('Y-m-d', (time() - 60*60*24*30)) ?>'}).dpSetOffset(0, -275);
	}else{
		$('.date-pick').datePicker({startDate:'<?php echo  date('Y-m-d', (time() - 60*60*24*30)) ?>'});
	}
});
</script> 
</body>
</html>