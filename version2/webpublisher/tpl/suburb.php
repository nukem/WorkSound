<?php
  $states = dbq ("SELECT id, state FROM {$cfg['db']['prefix']}_states WHERE enabled = '1'");

function show_value($key) {
	global $record;
	if(isset($_POST[$key]) && trim($_POST[$key]) != '') {
		return $_POST[$key];
	} else if(isset($record[$key]) && trim($record[$key]) != '') {
		return $record[$key];
	} else {
		return '';
	}
}
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
      <h2 class="bar green"><span>Suburb</span></h2> 
      <form action=".?id=<?= $id ?>" method="post" enctype="multipart/form-data" > 
        <? require ("tpl/inc/buttons.php"); ?> 
        <div class="right-col-padding1"> 
          <div class="width-99pct"> 
            <table class="rec-table">
	      
              <? require ("tpl/inc/record.php"); ?> 
	      
	      <!--tr> 
		<td colspan="4">
		  <label>Featured</label><br />
		  <select id="featured" name="featured" class="textfield width-100pct">
		    <option value="0" <?php //if((isset($_POST['featured']) && $_POST['featured'] == '0') || $record['featured'] == '0') echo 'selected="selected"'; ?>>No</option>
		    <option value="1" <?php //if((isset($_POST['featured']) && $_POST['featured'] == '1') || $record['featured'] == '1') echo 'selected="selected"'; ?>>Yes</option>
		  </select>
		</td>
	      </tr-->
	      
	      <tr> 
                <td colspan="4"> 
		  <label>Description</label><br />
		  <textarea name="description" cols="30" rows="10" class="textfield width-100pct height-200 tinymce"><? if (isset ($_POST['description'])) echo htmlspecialchars ($_POST['description']); else echo htmlspecialchars (preg_replace('/src="/', 'src="../', $record['description'])); ?></textarea>
                </td> 
              </tr>
	      
	      <tr> 
                <td colspan="2">
		  <label>State &bull;</label><br />
		  <select id="state_id" name="state_id" class="textfield width-100pct">
		    <option value=""></option>
		    <?php if(!empty($states)): ?>
		      <?php foreach($states as $state): ?>
			<option value="<?php echo $state['id']; ?>" <?php if((isset($_POST['state_id']) && $_POST['state_id'] == $state['id']) || $record['state_id'] == $state['id']) echo 'selected="selected"'; ?>><?php echo $state['state']; ?></option>
		      <?php endforeach; ?>
		    <?php endif; ?>
		  </select>
		</td>
		<td colspan="2">
		  <label>Postcode &bull;</label><br />
		  <input type="text" name="postcode" class="textfield width-100pct" value="<? if (isset ($_POST['postcode'])) echo htmlspecialchars ($_POST['postcode']); else echo htmlspecialchars ($record['postcode']); ?>" />
		</td>
	      </tr>
		  <tr>
			  <td colspan="2">
				  <label>If this property doesn't have any H+L Packages</label><br />
									<select name="hide_empty" class="textfield width-100pct">
<?php
$hide_empty = array(
	'1' => 'Hide this property from the search results',
	'0' => 'Show an enquiry form to collect user\'s interest in the suburb'
);
foreach($hide_empty as $mu => $label) {
	$selected = '';
	if($mu == show_value('hide_empty')) {
		$selected = ' selected="selected" ';
	}
	?>
										<option<?php echo $selected; ?> value="<?php echo $mu; ?>"><?php echo $label; ?></option>
<?php
}
?>
									</select>
								</td>
							</tr>

	      
	      <tr> 
                <td colspan="4"> 
		  <label>Map</label><br />
		  <div id="map_canvas" style="width: 500px; height: 500px"></div>
		  <input type="hidden" id="map_latitude" name="map_latitude" class="textfield" value="<? if(isset($_POST['map_latitude'])) echo $_POST['map_latitude']; else if($record['map_latitude'] != '') echo $record['map_latitude']; else echo '-28.149503'; ?>" />
		  <input type="hidden" id="map_longitude" name="map_longitude" class="textfield" value="<? if(isset($_POST['map_longitude'])) echo $_POST['map_longitude']; else if($record['map_longitude'] != '') echo $record['map_longitude']; else echo '133.505859'; ?>" />
		  <input type="hidden" id="map_zoom" name="map_zoom" class="textfield" value="<? if(isset($_POST['map_zoom'])) echo $_POST['map_zoom']; else if($record['map_zoom'] != '') echo $record['map_zoom']; else echo '4'; ?>" />
		  Locate Address: 
		  <input type="text" id="maps_address" class="textfield" value="" />
		  <input type="button" onclick="locate_address();" value="Go" />
                </td> 
              </tr>
	      
	      <tr>
		<td colspan="4">
		  <label>Upload Images</label><br />
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
	    </tr>
	  <? require ("tpl/inc/rights.php"); ?> 
	</table>
	
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $cfg['gmaps_api_key']; ?>&sensor=true" type="text/javascript"></script>
    
    <script type="text/javascript">
    
    $(function () {
      init_map("map_canvas", $("#map_latitude").val(), $("#map_longitude").val(), parseInt($("#map_zoom").val()));
    });
    
    function init_map(divId, latitude, longitude, zoom) {
      if (GBrowserIsCompatible()) {
	var map = new GMap2(document.getElementById(divId));
	map.setCenter(new GLatLng(latitude, longitude), zoom);
	map.setUIToDefault();
	map.disableScrollWheelZoom();
	
	gpoint = new GMarker(new GLatLng(latitude, longitude), {draggable: true});
	map.addOverlay(gpoint);
	
	var clickEventListener = GEvent.bind(map, "click", this, function(overlay, latlng) {
	    if (latlng) {
	      gpoint.setLatLng(latlng);
	      $("#map_latitude").val(latlng.y);
	      $("#map_longitude").val(latlng.x);
	    }
	});
	
	GEvent.addListener(gpoint, "dragend", function() {
	  var latlng = gpoint.getLatLng();
	  
	  $("#map_latitude").val(latlng.y);
	  $("#map_longitude").val(latlng.x);
	});
	
	var zoomEventListener = GEvent.bind(map, "zoomend", this, function(oldzoom, newzoom) {
	    $("#map_zoom").val(newzoom);
	});
	
      }
    }
    
    function locate_address() {
      if (GBrowserIsCompatible()) {
	var address = $("#maps_address").val();
	var geocoder = new GClientGeocoder();
	
	geocoder.getLatLng(address, function(point) {
	  if (!point) {
	    alert(address + ' not found');
	  }
	  else {
	    $("#map_latitude").val(point.y);
	    $("#map_longitude").val(point.x);
	    $("#map_zoom").val('16');
	    init_map("map_canvas", point.y, point.x, 16);
	  }
	});
      }
    }
    
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
