<?php
    $states = dbq ("SELECT id, state FROM {$cfg['db']['prefix']}_states WHERE enabled = '1'");
    $inclusions = dbq ("SELECT id, title FROM {$cfg['db']['prefix']}_structure WHERE type = 'inclusion' AND online = '1'");
    
    $homes_states = dbq ("SELECT state_id FROM {$cfg['db']['prefix']}_homes_states WHERE homes_id = '$id'");
    $homes_inclusions = dbq ("SELECT inclusion_id FROM {$cfg['db']['prefix']}_homes_inclusions WHERE homes_id = '$id'");
?>

<? require ("tpl/inc/head.php"); ?>
<body> 
<div id="page"> 
  <? require ("tpl/inc/header.php"); ?> 
  <? require ("tpl/inc/path.php"); ?> 
  <div id="content"> 
    <div id="left-col"> 
      <div id="left-col-border"> 
        <? if (isset ($errors)) require ("tpl/inc/error.php"); ?> 
        <? if (isset ($messages)) require ("tpl/inc/message.php"); ?> 
        <? if (isset ($_SESSION['epClipboard'])) require ("tpl/inc/clipboard.php"); ?> 
        <? require ("tpl/inc/structure.php"); ?> 
      </div> 
    </div> 
    <div id="right-col"> 
      <h2 class="bar green"><span>Homes</span></h2> 
      <form action=".?id=<?= $id ?>" method="post" enctype="multipart/form-data" > 
        <? require ("tpl/inc/buttons.php"); ?> 
        <div class="right-col-padding1"> 
          <div class="width-99pct"> 
            <table class="rec-table">
	      
	      <tr>
                <td colspan="4">
		  <label>Home Details</label>
		</td>
	      </tr>
	      
              <? require ("tpl/inc/record.php"); ?> 
	      
	      <tr> 
		<td>
		  <label>Featured</label><br />
		  <select id="featured" name="featured" class="textfield width-100pct">
		    <option value="0" <?php if((isset($_POST['featured']) && $_POST['featured'] == '0') || $record['featured'] == '0') echo 'selected="selected"'; ?>>No</option>
		    <option value="1" <?php if((isset($_POST['featured']) && $_POST['featured'] == '1') || $record['featured'] == '1') echo 'selected="selected"'; ?>>Yes</option>
		  </select>
		</td>
		<td>
		  <label>New</label><br />
		  <select id="new" name="new" class="textfield width-100pct">
		    <option value="0" <?php if((isset($_POST['new']) && $_POST['new'] == '0') || $record['new'] == '0') echo 'selected="selected"'; ?>>No</option>
		    <option value="1" <?php if((isset($_POST['new']) && $_POST['new'] == '1') || $record['new'] == '1') echo 'selected="selected"'; ?>>Yes</option>
		  </select>
		</td>
		<td>
		  <label>Part of House and Land package</label><br />
		  <select id="houseland" name="houseland" class="textfield width-100pct">
		    <option value="0" <?php if((isset($_POST['houseland']) && $_POST['houseland'] == '0') || $record['houseland'] == '0') echo 'selected="selected"'; ?>>No</option>
		    <option value="1" <?php if((isset($_POST['houseland']) && $_POST['houseland'] == '1') || $record['houseland'] == '1') echo 'selected="selected"'; ?>>Yes</option>
		  </select>
		</td>
		<td></td>
		<td></td>
	      </tr>
	      
	      <tr> 
                <td colspan="4"> 
		  <label>Description</label><br />
		  <textarea name="description" cols="30" rows="10" class="textfield height-200 tinymce"><? if (isset ($_POST['description'])) echo htmlspecialchars ($_POST['description']); else echo htmlspecialchars (preg_replace('/src="/', 'src="../', $record['description'])); ?></textarea>
                </td> 
              </tr>
	      
	      <tr> 
                <td>
		  <label>Storeys</label><br />
		  <select id="storeys" name="storeys" class="textfield width-100pct">
		    <option value="1" <?php if((isset($_POST['storeys']) && $_POST['storeys'] == '1') || $record['storeys'] == '1') echo 'selected="selected"'; ?>>Single</option>
		    <option value="2" <?php if((isset($_POST['storeys']) && $_POST['storeys'] == '2') || $record['storeys'] == '2') echo 'selected="selected"'; ?>>Double</option>
		    <option value="0" <?php if((isset($_POST['storeys']) && $_POST['storeys'] == '0') || $record['storeys'] == '0') echo 'selected="selected"'; ?>>Split</option>
		  </select>
		</td>
		<td>
		  <label>Bedrooms</label><br />
		  <input type="text" name="bedrooms" class="textfield width-100pct" value="<? if (isset ($_POST['bedrooms'])) echo htmlspecialchars ($_POST['bedrooms']); else echo htmlspecialchars ($record['bedrooms']); ?>" />
		</td>
		<td>
		  <label>Bathrooms</label><br />
		  <input type="text" name="bathrooms" class="textfield width-100pct" value="<? if (isset ($_POST['bathrooms'])) echo htmlspecialchars ($_POST['bathrooms']); else echo htmlspecialchars ($record['bathrooms']); ?>" />
		</td>
                <td>
		  <label>Carspaces</label><br />
		  <input type="text" name="carspaces" class="textfield width-100pct" value="<? if (isset ($_POST['carspaces'])) echo htmlspecialchars ($_POST['carspaces']); else echo htmlspecialchars ($record['carspaces']); ?>" />
		</td>
	      </tr>
		
	      <tr>
		<td>
		  <label>Squares</label><br />
		  <input type="text" name="squares" class="textfield width-100pct" value="<? if (isset ($_POST['squares'])) echo htmlspecialchars ($_POST['squares']); else echo htmlspecialchars ($record['squares']); ?>" />
		</td>
                <td>
		  <label>Overall width</label><br />
		  <input type="text" name="overall_width" class="textfield width-100pct" value="<? if (isset ($_POST['overall_width'])) echo htmlspecialchars ($_POST['overall_width']); else echo htmlspecialchars ($record['overall_width']); ?>" />
		</td>
		<td>
		  <label>Overall depth</label><br />
		  <input type="text" name="overall_depth" class="textfield width-100pct" value="<? if (isset ($_POST['overall_depth'])) echo htmlspecialchars ($_POST['overall_depth']); else echo htmlspecialchars ($record['overall_depth']); ?>" />
		</td>
		<td>
		  <label>Total Size</label><br />
		  <input type="text" name="total_size" class="textfield width-100pct" value="<? if (isset ($_POST['total_size'])) echo htmlspecialchars ($_POST['total_size']); else echo htmlspecialchars ($record['total_size']); ?>" />
		</td>
	      </tr>
	      <tr>
		<td>
		  <label>Frontage</label><br />
		  <input type="text" name="frontage" class="textfield width-100pct" value="<? if (isset ($_POST['frontage'])) echo htmlspecialchars ($_POST['frontage']); else echo htmlspecialchars ($record['frontage']); ?>" />
		</td>
<td>
		  <label>Lot Size</label><br />
		  <input type="text" name="lot_size" class="textfield width-100pct" value="<? if (isset ($_POST['lot_size'])) echo htmlspecialchars ($_POST['lot_size']); else echo htmlspecialchars ($record['lot_size']); ?>" />
		</td>
		
		<td colspan="2"></td>
	      </tr>
	      
	      <tr>
                <td colspan="4">
		  &nbsp;
		</td>
	      </tr>
	      
	      <tr>
		<td>
		  <label>Price Displayed</label><br />
		  <select id="display_range" name="display_range" class="textfield width-100pct">
		    <option value="from" <?php if((isset($_POST['display_range']) && $_POST['display_range'] == 'from') || $record['display_range'] == 'from') echo 'selected="selected"'; ?>>From</option>
		    <option value="range" <?php if((isset($_POST['display_range']) && $_POST['display_range'] == 'range') || $record['display_range'] == 'range') echo 'selected="selected"'; ?>>From - To</option>
		    <option value="custom" <?php if((isset($_POST['display_range']) && $_POST['display_range'] == 'current') || $record['display_range'] == 'custom') echo 'selected="selected"'; ?>>Custom</option>
		  </select>
		</td>
                <td>
		  <label>Price range from</label><br />
		  <input type="text" name="price_range_from" class="textfield width-100pct" value="<? if (isset ($_POST['price_range_from'])) echo htmlspecialchars ($_POST['price_range_from']); else echo htmlspecialchars ($record['price_range_from']); ?>" />
		</td>
		<td>
		  <label>Price range to</label><br />
		  <input type="text" name="price_range_to" class="textfield width-100pct" value="<? if (isset ($_POST['price_range_to'])) echo htmlspecialchars ($_POST['price_range_to']); else echo htmlspecialchars ($record['price_range_to']); ?>" />
		</td>
                <td>
		  <label>Custom price</label><br />
		  <input type="text" name="custom_price" class="textfield width-100pct" value="<? if (isset ($_POST['custom_price'])) echo htmlspecialchars ($_POST['custom_price']); else echo htmlspecialchars ($record['custom_price']); ?>" />
		</td>
	      </tr>
	      
	      <tr>
		<td>
		  <label>Show Price</label><br />
		  <select id="show_price" name="show_price" class="textfield width-100pct">
		    <option value="0" <?php if((isset($_POST['show_price']) && $_POST['show_price'] == '0') || $record['show_price'] == '0') echo 'selected="selected"'; ?>>No</option>
		    <option value="1" <?php if((isset($_POST['show_price']) && $_POST['show_price'] == '1') || $record['show_price'] == '1') echo 'selected="selected"'; ?>>Yes</option>
		  </select>
		</td>
                <td colspan="3">
		  <label>Virtual Tour URL</label><br />
		  <input type="text" name="virtual_tour" class="textfield width-100pct" value="<? if (isset ($_POST['virtual_tour'])) echo htmlspecialchars ($_POST['virtual_tour']); else echo htmlspecialchars ($record['virtual_tour']); ?>" />
		</td>
	      </tr>
	      
	      <tr>
		<td colspan="2">
		  <label>Upload Facade Images (jpg, gif or png only)</label><br />
		  <input type="file" name="jq-images" id="jq-images" onChange="return ajaxFileUpload('jq-images', 'image-parent');" />
		  
                  <div id="image-parent">
		    <ul id="image-sort">
		    <?
                    $linked_images = dbq("SELECT * FROM `wp_image_gallery` WHERE `parent` = '{$id}' ORDER BY `position`");
                    if (is_array($linked_images)) {
                      foreach ($linked_images as $li) {
                        ?>
                        <li class="sort-li" id="<?= $li['id'] ?>">
                          <img src="js/handle.gif" alt="move" class="move" />
                          <img src="js/edit.gif" alt="edit" class="edit" onClick="$(this).siblings('.editor').css('display', 'inline'); $(this).siblings('.preview').css('display', 'none'); trapEnter('#edit-<?= $li['id'] ?>', <?= $li['id'] ?>, 'image');" />
                          <span class="editor">
                            <input type="text" id="edit-<?= $li['id'] ?>" value="<?= $li['title'] ?>" />
                            <input type="button" value="save" onClick="saveTitle('#edit-<?= $li['id'] ?>', <?= $li['id'] ?>, 'image');" />
                            <img src="js/loading.gif" alt="loading" class="edit-no-show" />
                            <input type="button" id="edit-cancel-<?= $li['id'] ?>" value="cancel" onClick="$(this).parent().siblings('.preview').css('display', 'inline'); $(this).parent().css('display', 'none'); releaseEnter();" /> or remove this image 
                            <img src="js/unlink.gif" alt="un-link" class="unlink" onClick="if (window.confirm ('Are you sure?')) { deleteFile('image', <?= $li['id'] ?>); $(this).parent().parent().hide('fast'); }" />
                          </span>
                          <a href="#" title="preview" class="preview" onClick="$('img.thumb:visible').slideUp(200); $(this).siblings('img.thumb:not(:visible)').slideDown(200); return false;"><span class="pic-title"><?= $li['title'] ?></span>
                          &nbsp;<img src="js/preview.gif" alt="preview" /></a>
                          <span class="preview">
                            <input type="checkbox" id="online-image-<?= $li['id'] ?>" onChange="updateOnline('image', <?= $li['id'] ?>);"<? if ($li['online'] == 1) echo ' checked="checked"'; ?> />
                            <img src="js/web_<? if ($li['online'] == 1) echo 'online'; else echo 'offline' ?>.gif" class="onoff" alt="online/offline" />
                          </span>
                            <img src="../wpdata/images/<?= $li['id'] ?>-s.jpg" class="thumb" onClick="$(this).slideUp(100); return false;" />
                        </li>
                        <?
                      }
                    }
                    ?>
		    </ul>
                  <input type="button" id="image-sort-save" value="save order" onClick="return saveSort('image-sort');" />
                  <img src="js/loading.gif" alt="loading" id="image-sort-no-show" />
		</div>
	      </td>
	      <td colspan="2">
		<label>Upload Floorplan Files (jpg, gif or png only)</label><br />
		<input type="file" id="jq-files" name="jq-files" onChange="return ajaxFileUpload('jq-files', 'file-parent');" />
		<div id="file-parent">
		  <ul id="file-sort">
		  <?
                    $linked_files = dbq("SELECT * FROM `wp_file_gallery` WHERE `parent` = '{$id}' ORDER BY `position`");
                    if (is_array($linked_files)) {
                      foreach ($linked_files as $lf) {
                        ?>
                        <li class="sort-li" id="<?= $lf['id'] ?>">
                          <img src="js/handle.gif" alt="move" class="move" />
                          <img src="js/edit.gif" alt="edit" class="edit" onClick="$(this).siblings('.editor').css('display', 'inline'); $(this).siblings('.preview').css('display', 'none'); trapEnter('#edit-<?= $lf['id'] ?>', <?= $lf['id'] ?>, 'file');" />
                          <span class="editor">
                            <input type="text" id="edit-<?= $lf['id'] ?>" value="<?= $lf['title'] ?>" />
                            <input type="button" value="save" onClick="saveTitle('#edit-<?= $lf['id'] ?>', <?= $lf['id'] ?>, 'file');" />
                            <img src="js/loading.gif" alt="loading" class="edit-no-show" />
                            <input type="button" id="edit-cancel-<?= $lf['id'] ?>" value="cancel" onClick="$(this).parent().siblings('.preview').css('display', 'inline'); $(this).parent().css('display', 'none'); releaseEnter();" /> or remove this file 
                            <img src="js/unlink.gif" alt="un-link" class="unlink" onClick="if (window.confirm ('Are you sure?')) { deleteFile('file', <?= $lf['id'] ?>); $(this).parent().parent().hide('fast'); }" />
                          </span>
                          <span class="preview">
                          <?
                          if (is_file ('../wpdata/files/' . $lf['id'] . "." . $lf['extension'])) { ?> 
			    <img src="img/ico-file/<? if (is_file ("img/ico-file/" . $lf['extension'] . ".gif")) echo "{$lf['extension']}.gif"; else echo "unknown.gif"; ?>" alt="Preview" width="16" height="16" /> <a href="file-preview.php?file=files/<?=  $lf['id'] . '.' . $lf['extension'] ?>&amp;filename=<?= $lf['title'] . "." . $lf['extension'] ?>"><?= $lf['title'] ?></a>
                        <? } ?>
                        <input type="checkbox" id="online-file-<?= $lf['id'] ?>" onChange="updateOnline('file', <?= $lf['id'] ?>);"<? if ($lf['online'] == 1) echo ' checked="checked"'; ?> />
                        <img src="js/web_<? if ($lf['online'] == 1) echo 'online'; else echo 'offline' ?>.gif" class="onoff" alt="online/offline" />
                        </span>
                        </li>
                        <?
                      }
                    }
                    ?>
		  </ul>
                  <input type="button" id="file-sort-save" value="save order" onClick="return saveSort('file-sort');" />
                  <img src="js/loading.gif" alt="loading" id="file-sort-no-show" />
		</div>
		<hr />
<?php

$sql = 'SELECT * FROM floorplan_dimensions WHERE wp_id = ' . $id . ' ORDER BY `position`';
$fpd = dbq($sql);

?>
				<label>Floorplan Dimensions</label><br />
				<label>Name - Value (sqm)</label><br />
				<div id="fpd-parent">
					<ul class="fpd-list">
<?php
if(is_array($fpd) && count($fpd) > 0){
	foreach($fpd as $r) {
?>
<li id="<?php echo $r['id']; ?>" class="sort-li">
	<img src="js/handle.gif" alt="move" class="move" />
	<input type="hidden" name="fpd_id[]" value="<?php echo $r['id']; ?>" />
	<input type="text" name="fpd_label[]" value="<?php echo $r['label']; ?>" />
	- 
	<input type="text" name="fpd_value[]" value="<?php echo $r['value']; ?>" />
	- 
	<a href="#" onclick="delete_fpd(<?php echo $r['id']; ?>); return false;">DELETE</a>
</li>
<?php
	}
}
?>
					</ul>
				</div>
				<p><a href="#" onclick="add_fpd(); return false;">Add another dimension</a></p>
		
	      </td>
	    </tr>
	  <? require ("tpl/inc/rights.php"); ?> 
	</table>
	
	<div style="display:none;">
	  <label>Locations &bull;</label><br />
	  <div id="locations_list" class="textfield checkbox_list">
	    <?php if(!empty($states)): ?>
	      <?php foreach($states as $state): ?>
		<label>
		  <input id="state_checkbox_<?php echo $state['id']; ?>" class="state_checkbox" type="checkbox" name="states[]" value="<?php echo $state['id']; ?>"/>
		  <?php echo $state['state']; ?>
		</label><br />
	      <?php endforeach; ?>
	    <?php endif; ?>
	  </div>
	</div>
	
	<div style="display:none;">
	  <label>Inclusions</label><br />
	  <div id="inclusions_list" class="textfield checkbox_list">
	    <?php if(!empty($inclusions)): ?>
	      <?php foreach($inclusions as $inclusion): ?>
		<label>
		  <input id="inclusion_checkbox_<?php echo $inclusion['id']; ?>" class="inclusion_checkbox" type="checkbox" name="inclusions[]" value="<?php echo $inclusion['id']; ?>"/>
		  <?php echo $inclusion['title']; ?>
		</label><br />
	      <?php endforeach; ?>
	    <?php endif; ?>
	  </div>
	</div>
	
    <script type="text/javascript">
function add_fpd() {
	$('.fpd-list').append('<li id="new-item" class="sort-li"><img src="js/handle.gif" alt="move" class="move" /> <input type="text" name="fpd_label[]" /> - <input type="text" name="fpd_value[]" /></li>');
	$('.fpd-list').SortableAddItem(document.getElementById('new-item'));
	$('#new-item').attr('id', '');
}

function delete_fpd(deleteId) {
	$.post(
		"delete_dimension.php", 
		{ id: deleteId },
		function(data) {
			$('.fpd-list #' + deleteId).remove();
		}
	);
}

    <?php if(!empty($homes_states)): ?>
      <?php foreach($homes_states as $h_state): ?>
	$("#state_checkbox_<?php echo $h_state['state_id']; ?>").attr('checked', 'checked');
      <?php endforeach; ?>
    <?php else: ?>
      <?php if($path[1][0] == 118): ?>
	$("#state_checkbox_1").attr('checked', 'checked');
      <?php elseif($path[1][0] == 119): ?>
	$("#state_checkbox_2").attr('checked', 'checked');
      <?php elseif($path[1][0] == 120): ?>
	$("#state_checkbox_3").attr('checked', 'checked');
      <?php endif; ?>
    <?php endif; ?>
    
    <?php /*if(!empty($homes_inclusions)): ?>
      <?php foreach($homes_inclusions as $h_inclusion): ?>
	$("#inclusion_checkbox_<?php echo $h_inclusion['inclusion_id']; ?>").attr('checked', 'checked');
      <?php endforeach; ?>
    <?php endif;*/ ?>
    
    var loadImage = new Image();
	loadImage.src = 'js/loading.gif';
    var onlineImage = new Image();
	onlineImage.src = 'js/web_online.gif';
    var offlineImage = new Image();
	offlineImage.src = 'js/web_offline.gif';
    
    $(function () {
      $('#image-sort').Sortable({
		accept: 'sort-li',
        handle: 'img.move',
        opacity: 0.2,
        axis: 'vertically',
		onStop: function() {
          $('#image-sort-save:not(:visible)').show('fast', function(){
            $(this).css('display', 'inline');
          });
        }
	  });
      $('#file-sort').Sortable({
		accept: 'sort-li',
        handle: 'img.move',
        opacity: 0.2,
        axis: 'vertically',
		onStop: function() {
          $('#file-sort-save:not(:visible)').show('fast', function(){
            $(this).css('display', 'inline');
          });
        }

	  });
	  $('.fpd-list').Sortable({
		accept: 'sort-li',
        handle: 'img.move',
        opacity: 0.2,
        axis: 'vertically'
	  });
	  
	  $('input[name^=fpd_label]').focus( function () {
	  });
      
    });
    
    function updateOnline(type, id) {
      var isOnline = 1;
      if ($('#online-'+type+'-'+id).attr('checked')) {
        $('#online-'+type+'-'+id).siblings('img.onoff')[0].src = onlineImage.src;
      } else {
        $('#online-'+type+'-'+id).siblings('img.onoff')[0].src = offlineImage.src;
        isOnline = 0;
      }
      $.get(
        'ajaxonline.php?t=' + new Date().getTime(),
        {'type' : type, 'id': id, 'online': isOnline},
        function(data){
        }
      );
    }
    
    function saveSort(type) {
      serial = $.SortSerialize(type);
      $('#'+type+'-no-show').css('display', 'inline');
      $.post('savesortorder.php?'+serial.hash, {}, function(data){
        if (data == "SUCCESS") {  
          $('#'+type+'-no-show').hide('fast');
          $('#'+type+'-save').hide('fast');
        } else {
          alert('ERROR! debug info:\n\n' + data);
        }
      });
      return false;
    }
    
    function trapEnter(id, num, type){
      $(id).focus().select();
      document.onkeyup = function(e){
        if (e == null) { // ie
          keycode = event.keyCode;
        } else { // mozilla
          keycode = e.which;
        }
        if(keycode == 13){ // enter key
          saveTitle(id, num, type);
        }
      }
      return false;
    }
    
    function releaseEnter(){
      document.onkeyup = '';
      return false;
    }
    
    function saveTitle(id, num, type) {
      $(id).siblings('.edit-no-show').css('display', 'inline');
      var titleDetails;
      $.get(
        'saveimagetitle.php?t='+type,
        {'nt' : $(id).val(), 'id': num},
        function(data){
          eval(data);
          if(typeof(titleDetails) == 'object' && titleDetails.msg == 'SUCCESS') {
            $(id).parent().siblings('.preview').children('.pic-title').html(titleDetails.title);
            $(id).parent().siblings('.preview').css('display', 'inline');
            $(id).siblings('.edit-no-show').css('display', 'none');
            $(id).parent().css('display', 'none');
          } else {
            if (titleDetails.title) {
              alert('Update Error!\n'+titleDetails.title);
            } else {
              alert('Update Error!');
            }
          }
        }
      );
      document.onkeyup = '';
      return false;
    }
    
    function deleteFile(type, id) {
      $.get(
        'deleteajaxfiles.php?t=' + new Date().getTime(),
        {'type' : type, 'id': id},
        function(data){
        }
      );
      return false;
    }
    
	function ajaxFileUpload(elemID, parentID)
	{
		var tempID = new Date().getTime();
		$('#'+parentID+' ul').append('<li id="'+tempID+'" class="sort-li"><img src="js/loading.gif"> Upload in progress</li>');
		$('#'+tempID).slideDown(500);

		$.ajaxFileUpload
		(
			{
				url:'doajaxfileupload.php?element='+elemID+'&parent=<?= $id ?>',
				secureuri:false,
				fileElementId:elemID,
				iframeParent:parentID,
				dataType: 'json',
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.msg == 'SUCCESS') {
						  $('#'+tempID+' img').hide(300, function(){
                            var liHTML = '<li class="sort-li" id="' + data.insert_id + '"><img src="js/handle.gif" alt="move" class="move" /><img src="js/edit.gif" alt="edit" class="edit" onclick="$(this).siblings(\'.editor\').css(\'display\', \'inline\'); $(this).siblings(\'.preview\').css(\'display\', \'none\'); trapEnter(\'#edit-' + data.insert_id + '\', ' + data.insert_id + ', \'image\');" /><span class="editor"><input type="text" id="edit-' + data.insert_id + '" value="' + data.image_title + '" /><input type="button" value="save" onclick="saveTitle(\'#edit-' + data.insert_id + '\', ' + data.insert_id + ', \'image\');" /><img src="js/loading.gif" alt="loading" class="edit-no-show" /><input type="button" id="edit-cancel-' + data.insert_id + '" value="cancel" onclick="$(this).parent().siblings(\'.preview\').css(\'display\', \'inline\'); $(this).parent().css(\'display\', \'none\');" /> or remove this image <img src="js/unlink.gif" alt="un-link" class="unlink" onclick="if (window.confirm (\'Are you sure?\')) { deleteFile(\'image\', ' + data.insert_id + '); $(this).parent().parent().hide(\'fast\'); }" /></span><a href="#" title="preview" class="preview" onclick="$(\'img.thumb:visible\').slideUp(200); $(this).siblings(\'img.thumb:not(:visible)\').slideDown(200); return false;"><span class="pic-title">' + data.image_title + '</span>&nbsp;<img src="js/preview.gif" alt="preview" /></a><span class="preview"><input type="checkbox" id="online-image-' + data.insert_id + '" onchange="updateOnline(\'image\', ' + data.insert_id + ');" /><img src="js/web_offline.gif" class="onoff" alt="online/offline" /></span><img src="../wpdata/images/' + data.insert_id + '-s.jpg" class="thumb" onclick="$(this).slideUp(100); return false;" /></li>';
                            if (data.file_ext) {
                              liHTML = '<li class="sort-li" id="' + data.insert_id + '"><img src="js/handle.gif" alt="move" class="move" /> <img src="js/edit.gif" alt="edit" class="edit" onclick="$(this).siblings(\'.editor\').css(\'display\', \'inline\'); $(this).siblings(\'.preview\').css(\'display\', \'none\'); trapEnter(\'#edit-' + data.insert_id + '\', ' + data.insert_id + ', \'file\');" /><span class="editor"><input type="text" id="edit-' + data.insert_id + '" value="' + data.image_title + '" /><input type="button" value="save" onclick="saveTitle(\'#edit-' + data.insert_id + '\', ' + data.insert_id + ', \'file\');" /><img src="js/loading.gif" alt="loading" class="edit-no-show" /><input type="button" id="edit-cancel-' + data.insert_id + '" value="cancel" onclick="$(this).parent().siblings(\'.preview\').css(\'display\', \'inline\'); $(this).parent().css(\'display\', \'none\'); releaseEnter();" /> or remove this file <img src="js/unlink.gif" alt="un-link" class="unlink" onclick="if (window.confirm (\'Are you sure?\')) { deleteFile(\'file\', ' + data.insert_id + '); $(this).parent().parent().hide(\'fast\'); }" /></span><span class="preview"><img src="img/ico-file/' + data.file_ext + '.gif" alt="Preview" width="16" height="16" /> <a href="file-preview.php?file=files/' + data.insert_id + '.' + data.file_ext + '&filename=' + data.image_title + '.' + data.file_ext + '">' + data.image_title + '</a><input type="checkbox" id="online-file-' + data.insert_id + '" onchange="updateOnline(\'file\', ' + data.insert_id + ');" /><img src="js/web_offline.gif" class="onoff" alt="online/offline" /></span></li>';
                            }
                            $(this).parent().parent().append(liHTML).SortableAddItem(document.getElementById(data.insert_id));
                            $(this).parent().remove();
                          });
						} else {
                          alert(data.error);
						  $('#'+tempID).slideUp(500);
                        }
						$('#'+parentID+' ul').Sortable({
						  accept: 'sort-li',
						  helperclass: 'sortHelper',
						  activeclass : 	'sortActive',
						  hoverclass : 	'sortHover',
						  tolerance: 'pointer',
						  opacity: 0.9
						});
					} else {
                      alert(typeof(data));
					  $('#'+tempID).slideUp(500);
                    }
				},
				error: function (data, status, e)
				{
					//alert('ajax error\n' + e + '\n' + data + '\n' + status);
                    for (i in e) {
                      //alert(e[i]);
                    }
					$('#'+tempID).slideUp(500);
				}
			}
		);
		
		$('#'+elemID).val('');
		return false;
	}
	</script>
          </div> 
        </div> 
      </form> 
    </div> 
    <? require ("tpl/inc/footer.php"); ?> 
  </div> 
</div> 
</body>
</html>
