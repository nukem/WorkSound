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
        <?php require ("tpl/inc/buttons.php"); ?> 
        <div class="right-col-padding1"> 
          <div class="width-99pct"> 
            <table class="rec-table"> 
              <?php require ("tpl/inc/record.php"); ?> 
          
              <tr> 
                <td colspan="4"> 
				<label><?php echo  $lang[59] ?></label><br />
         <textarea name="content" cols="30" rows="10" class="textfield height-200 tinymce"><?php if (isset ($_POST['title'])) echo htmlspecialchars ($_POST['content']); else echo htmlspecialchars (preg_replace('/src="/', 'src="../', $record['content'])); ?></textarea>
                </td> 
              </tr>
			  <tr>
				<td colspan="2">
				  <label>Upload Images</label><br />
				  <input type="file" name="jq-images" id="jq-images" onChange="return ajaxFileUpload('jq-images', 'image-parent');" />
				  
                  <div id="image-parent">
					<ul id="image-sort">
					<?php                     $linked_images = dbq("SELECT * FROM `wp_image_gallery` WHERE `parent` = '{$id}' ORDER BY `position`");
                    if (is_array($linked_images)) {
                      foreach ($linked_images as $li) {
                        ?>
                        <li class="sort-li" id="<?php echo  $li['id'] ?>">
                          <img src="js/handle.gif" alt="move" class="move" />
                          <img src="js/edit.gif" alt="edit" class="edit" onClick="$(this).siblings('.editor').css('display', 'inline'); $(this).siblings('.preview').css('display', 'none'); trapEnter('#edit-<?php echo  $li['id'] ?>', <?php echo  $li['id'] ?>, 'image');" />
                          <span class="editor">
                            <input type="text" id="edit-<?php echo  $li['id'] ?>" value="<?php echo  $li['title'] ?>" />
                            <input type="button" value="save" onClick="saveTitle('#edit-<?php echo  $li['id'] ?>', <?php echo  $li['id'] ?>, 'image');" />
                            <img src="js/loading.gif" alt="loading" class="edit-no-show" />
                            <input type="button" id="edit-cancel-<?php echo  $li['id'] ?>" value="cancel" onClick="$(this).parent().siblings('.preview').css('display', 'inline'); $(this).parent().css('display', 'none'); releaseEnter();" /> or remove this image 
                            <img src="js/unlink.gif" alt="un-link" class="unlink" onClick="if (window.confirm ('Are you sure?')) { deleteFile('image', <?php echo  $li['id'] ?>); $(this).parent().parent().hide('fast'); }" />
                          </span>
                          <a href="#" title="preview" class="preview" onClick="$('img.thumb:visible').slideUp(200); $(this).siblings('img.thumb:not(:visible)').slideDown(200); return false;"><span class="pic-title"><?php echo  $li['title'] ?></span>
                          &nbsp;<img src="js/preview.gif" alt="preview" /></a>
                          <span class="preview">
                            <input type="checkbox" id="online-image-<?php echo  $li['id'] ?>" onChange="updateOnline('image', <?php echo  $li['id'] ?>);"<?php if ($li['online'] == 1) echo ' checked="checked"'; ?> />
                            <img src="js/web_<?php if ($li['online'] == 1) echo 'online'; else echo 'offline' ?>.gif" class="onoff" alt="online/offline" />
                          </span>
                            <img src="../wpdata/images/<?php echo  $li['id'] ?>-s.jpg" class="thumb" onClick="$(this).slideUp(100); return false;" />
                        </li>
                        <?php                       }
                    }
                    ?>
					</ul>
                  <input type="button" id="image-sort-save" value="save order" onClick="return saveSort('image-sort');" />
                  <img src="js/loading.gif" alt="loading" id="image-sort-no-show" />
				  </div>
				</td>
				<td colspan="2">
				  <label>Upload Files</label><br />
				  <input type="file" id="jq-files" name="jq-files" onChange="return ajaxFileUpload('jq-files', 'file-parent');" />
				  <div id="file-parent">
					<ul id="file-sort">
					<?php                     $linked_files = dbq("SELECT * FROM `wp_file_gallery` WHERE `parent` = '{$id}' ORDER BY `position`");
                    if (is_array($linked_files)) {
                      foreach ($linked_files as $lf) {
                        ?>
                        <li class="sort-li" id="<?php echo  $lf['id'] ?>">
                          <img src="js/handle.gif" alt="move" class="move" />
                          <img src="js/edit.gif" alt="edit" class="edit" onClick="$(this).siblings('.editor').css('display', 'inline'); $(this).siblings('.preview').css('display', 'none'); trapEnter('#edit-<?php echo  $lf['id'] ?>', <?php echo  $lf['id'] ?>, 'file');" />
                          <span class="editor">
                            <input type="text" id="edit-<?php echo  $lf['id'] ?>" value="<?php echo  $lf['title'] ?>" />
                            <input type="button" value="save" onClick="saveTitle('#edit-<?php echo  $lf['id'] ?>', <?php echo  $lf['id'] ?>, 'file');" />
                            <img src="js/loading.gif" alt="loading" class="edit-no-show" />
                            <input type="button" id="edit-cancel-<?php echo  $lf['id'] ?>" value="cancel" onClick="$(this).parent().siblings('.preview').css('display', 'inline'); $(this).parent().css('display', 'none'); releaseEnter();" /> or remove this file 
                            <img src="js/unlink.gif" alt="un-link" class="unlink" onClick="if (window.confirm ('Are you sure?')) { deleteFile('file', <?php echo  $lf['id'] ?>); $(this).parent().parent().hide('fast'); }" />
                          </span>
                          <span class="preview">
                          <?php                           if (is_file ('../wpdata/files/' . $lf['id'] . "." . $lf['extension'])) { ?> 
                  <img src="img/ico-file/<?php if (is_file ("img/ico-file/" . $lf['extension'] . ".gif")) echo "{$lf['extension']}.gif"; else echo "unknown.gif"; ?>" alt="Preview" width="16" height="16" /> <a href="file-preview.php?file=files/<?php echo   $lf['id'] . '.' . $lf['extension'] ?>&amp;filename=<?php echo  $lf['title'] . "." . $lf['extension'] ?>"><?php echo  $lf['title'] ?></a>
                        <?php } ?>
                        <input type="checkbox" id="online-file-<?php echo  $lf['id'] ?>" onChange="updateOnline('file', <?php echo  $lf['id'] ?>);"<?php if ($lf['online'] == 1) echo ' checked="checked"'; ?> />
                        <img src="js/web_<?php if ($lf['online'] == 1) echo 'online'; else echo 'offline' ?>.gif" class="onoff" alt="online/offline" />
                        </span>
                        </li>
                        <?php                       }
                    }
                    ?>
					</ul>
                  <input type="button" id="file-sort-save" value="save order" onClick="return saveSort('file-sort');" />
                  <img src="js/loading.gif" alt="loading" id="file-sort-no-show" />
				  </div>
				</td>
			  </tr>
              <?php require ("tpl/inc/rights.php"); ?> 
            </table>
	
    <script type="text/javascript">
	
    var loadImage = new Image();
	loadImage.src = 'js/loading.gif';
    var onlineImage = new Image();
	onlineImage.src = 'js/web_online.gif';
    var offlineImage = new Image();
	offlineImage.src = 'js/web_offline.gif';
    
    $(document).ready(function () {
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
				url:'doajaxfileupload.php?element='+elemID+'&parent=<?php echo  $id ?>',
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
					alert('ajax error\n' + e + '\n' + data + '\n' + status);
                    for (i in e) {
                      alert(e[i]);
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
    <?php require ("tpl/inc/footer.php"); ?> 
  </div> 
</div> 
</body>
</html>
