<?php
  $dc_details = dbq ("SELECT wp_display_centre.state_id FROM wp_display_centre WHERE link = '".$record['parent']."'");
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
      <h2 class="bar green"><span>Home on Display</span></h2> 
      <form action=".?id=<?= $id ?>" method="post" enctype="multipart/form-data" > 
        <? require ("tpl/inc/buttons.php"); ?> 
        <div class="right-col-padding1"> 
          <div class="width-99pct">
	    
	    <table class="rec-table">
	      
              <? require ("tpl/inc/record_no_title.php"); ?> 
	      
	      <tr>
		<td>
		  <label>Home &bull;</label><br />
		  <input id="home_name" name="home_name" type="hidden" value="" />
		  <select id="home_id" name="home_id" class="textfield width-100pct">
		    <option value="0" selected="selected"></option>
		  </select>
		</td>
		<td>
		  <label>Facade &bull;</label><br />
		  <input id="facade_name" name="facade_name" type="hidden" value="" />
		  <select id="facade_id" name="facade_id" class="textfield width-100pct">
		    <option value="0" selected="selected"></option>
		  </select>
		</td>
		<td colspan="2"></td>
	      </tr>
	      
              <? require ("tpl/inc/rights.php"); ?> 
            </table>
	
    <script type="text/javascript">
	
    var loadImage = new Image();
	loadImage.src = 'js/loading.gif';
    var onlineImage = new Image();
	onlineImage.src = 'js/web_online.gif';
    var offlineImage = new Image();
	offlineImage.src = 'js/web_offline.gif';
    
    $("#state_id").change(function(){
      change_state($(this).val(), '', '');
    });
    
    $("#home_id").change(function(){
      change_home($(this).val(), '');
    });
    
    function change_state(state_id, home_id) {
      $("#home_id").children().remove();
      $("#facade_id").children().remove();
      var url = 'get_suburb_data.php';
      $.post(
	url,
	{ 'state_id': state_id },
	function(data){
	  var aData = data.split('||');
	  if(aData[0] != 'no_data') {
	    
	  }
	  if(aData[1] != 'no_data') {
	    $("#home_id").append(aData[1]);
	    $("#home_id").val(home_id);
	    
	    $("#home_name").val($("#home_id option:selected").text());
	    $("#facade_name").val($("#facade_id option:selected").text());
	  }
	}, "html");
    }
    
    function change_home(home_id, facade_id) {
	$("#facade_id").children().remove();
	var url = 'get_facade_data.php';
	
	$.post(
	  url,
	  { 'homes_id': home_id },
	  function(data){
	    //var aData = data.split('||');
	    if(data.options != 'no_data') {
	      $("#facade_id").append(data.options);
	      $("#facade_id").val(facade_id);
	      
	      $("#home_name").val($("#home_id option:selected").text());
	      $("#facade_name").val($("#facade_id option:selected").text());
	    }
	  }, "json");
    }
    
    $(function () {
      
      var load_state_id = '<?php echo $dc_details[0]['state_id']; ?>';
      var load_home_id = '<?php if(isset($_POST['homes_id'])) echo $_POST['homes_id']; else echo $record['homes_id']; ?>';
      var load_facade_id = '<?php if(isset($_POST['facade_id'])) echo $_POST['facade_id']; else echo $record['facade_id']; ?>';
      
      change_state(load_state_id, load_home_id);
      change_home(load_home_id, load_facade_id);
      
      $("#facade_id").change(function() {
	$("#facade_name").val($("#facade_id option:selected").text());
      });
      
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
